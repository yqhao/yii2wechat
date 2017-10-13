<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 * @property \yii\db\Connection $db_to The database connection. This property is read-only.
 * @property \yii\db\Connection $db_from The database connection. This property is read-only.
 */
class SyncController extends Controller
{

    public $sync_order_start_date;
    public $sync_order_start_time;
    public $this_month;
    public $last_month;

    public $db_to;
    public $db_from;

    public $range_day = 60;

    public function beforeAction($action)
    {
        $this->db_to = Yii::$app->db;
        $this->db_from = Yii::$app->db_bi;

        $this->sync_order_start_time = strtotime("-".$this->range_day." day",time());//用于同步订单,开始时间
        $this->sync_order_start_date = date('Y-m-d',$this->sync_order_start_time);//用于同步订单,开始时间

        $this->this_month = date('Ym',time());//用于统计
        $this->last_month = date('Ym',strtotime("-1 month",time()));//用于统计

        return parent::beforeAction($action);
    }
    public function actionRun()
    {

        set_time_limit(0);
        echo "START ".$this->db_to->dsn.PHP_EOL;
        $t = time();
        $this->db_to->createCommand()->update('machine',[
            'order_count'=>0,
            'order_amount'=>0,
            'last_order_count'=>0,
            'last_order_amount'=>0
        ])->execute();
        echo "CLEAN amount".PHP_EOL;

        $last_order_id = $this->db_to->createCommand("SELECT max(id) FROM machine_order")->queryScalar();
        echo "last_order_id ".$last_order_id.PHP_EOL;

        $sql = "SELECT
                m.id as m_id,
                m.machine_code as m_code,
                m.`name` as m_name,
                c.`name` AS city_name,
                d.`name` AS dist_name,
                m.address as street,
                FROM_UNIXTIME(m.last_open_time) AS last_time,
                m.max_amount,
                m.city_id,
                m.district_id as dist_id
            FROM
                gaitong.gt_machine AS m
            LEFT JOIN gaiwang.gw_region AS c ON c.id = m.city_id
            LEFT JOIN gaiwang.gw_region AS d ON d.id = m.district_id
            WHERE
                m.`status` = 1
            AND m.city_id IN (237, 242)
            ORDER BY m.id ASC";

        $insertSql = "INSERT INTO machine(
                    m_id,
                    m_code,
                    m_name,
                    city_name,
                    dist_name,
                    street,
                    last_time,
                    max_amount,
                    city_id,
                    dist_id
                ) VALUES(
                    :m_id,
                    :m_code,
                    :m_name,
                    :city_name,
                    :dist_name,
                    :street,
                    :last_time,
                    :max_amount,
                    :city_id,
                    :dist_id
                ) ON DUPLICATE KEY UPDATE 
                    m_code = VALUES(m_code),
                    m_name = VALUES(m_name),
                    city_name = VALUES(city_name),
                    dist_name = VALUES(dist_name),
                    street = VALUES(street),
                    last_time = VALUES(last_time),
                    max_amount = VALUES(max_amount),
                    city_id = VALUES(city_id),
                    dist_id = VALUES(dist_id)";

        $command = $this->db_from->createCommand($sql);
        $command->execute();
        $reader = $command->query();
        foreach ($reader as $key => $val) {
            if(!empty($val)){
                echo $key." ";
                $status = $this->db_to->createCommand($insertSql,$val)->execute();
                if($status) echo "UPDATE ".$val['m_id'].'-'.$status.PHP_EOL;
                $this->syncOrder((int)$last_order_id,$val['m_id']);
            }
            unset($reader->$key);
        }

        $this->sumOrderTotalAmountThisMonth();
        $this->sumOrderTotalAmountLastMonth();
        echo PHP_EOL."END used times ".(time()-$t).PHP_EOL;
    }

    public function syncOrder($o_id,$m_id)
    {
        $t = time();
        $c_time = $this->sync_order_start_time;
        $order_count = 0;
        $order_total_amount = 0;
        $last_order_count = 0;
        $last_order_total_amount = 0;



        $sql = "SELECT
                `id`,
                `franchisee_id`,
                `member_id`,
                `status`,
                `is_distributed`,
                `entered_money`,
                `spend_money`,
                `point_money`,
                `gai_discount`,
                `member_discount`,
                `distribute_money`,
                `create_time`,
                `machine_id`,
                `symbol`,
                `distribute_config`,
                `auto_check_fail`,
                `is_auto`,
                `distributed_time`,
                `pay_type`,
                `gai_number`,
                `order_key_id_str`,
                `gcp_order_code`
            FROM gaiwang.gw_franchisee_consumption_record
            WHERE id>:o_id AND machine_id=:m_id AND create_time>=:c_time
            ORDER BY id ASC";

        $insertSql = "INSERT INTO machine_order(
                `id`,
                `franchisee_id`,
                `member_id`,
                `status`,
                `is_distributed`,
                `entered_money`,
                `spend_money`,
                `point_money`,
                `gai_discount`,
                `member_discount`,
                `distribute_money`,
                `create_time`,
                `machine_id`,
                `symbol`,
                `distribute_config`,
                `auto_check_fail`,
                `is_auto`,
                `distributed_time`,
                `pay_type`,
                `gai_number`,
                `order_key_id_str`,
                `gcp_order_code`
                ) VALUES(
                :id,
                :franchisee_id,
                :member_id,
                :status,
                :is_distributed,
                :entered_money,
                :spend_money,
                :point_money,
                :gai_discount,
                :member_discount,
                :distribute_money,
                :create_time,
                :machine_id,
                :symbol,
                :distribute_config,
                :auto_check_fail,
                :is_auto,
                :distributed_time,
                :pay_type,
                :gai_number,
                :order_key_id_str,
                :gcp_order_code
                )";

        $command = $this->db_from->createCommand($sql,[":o_id"=>$o_id,":m_id"=>$m_id,":c_time"=>$c_time]);
        $command->execute();
        $reader = $command->query();
        $i = 0;
        foreach ($reader as $key => $val) {
            if(!empty($val)){
//                if($this->this_month == date('Ym',$val['create_time'])){
//                    $order_count++;
//                    $order_total_amount += $val['spend_money'];
//                }else{
//                    $last_order_count++;
//                    $last_order_total_amount += $val['spend_money'];
//                }

                $status = $this->db_to->createCommand($insertSql,$val)->execute();
                if($status) $i++;
            }
            //unset($reader->$key);
        }

//        if($order_count>0 || $last_order_count>0){
//            $this->db_to->createCommand()->update('machine',
//                [
//                    'order_count'=>$order_count,
//                    'order_amount'=>$order_total_amount,
//                    'last_order_count'=>$last_order_count,
//                    'last_order_amount'=>$last_order_total_amount
//                ],
//                'm_id=:m_id',[':m_id'=>$m_id])->execute();
//        }

        echo "    INSERT ORDERS ".$i." END. Used times ".(time()-$t).PHP_EOL;
    }

    public function sumOrderTotalAmountThisMonth(){
        $this_month_start = strtotime($this->this_month.'01');
        $last_month_start = strtotime($this->last_month.'01');

        $sql = "SELECT 	machine_id,COUNT(machine_id) AS order_count,SUM(spend_money) AS order_amount 
                FROM machine_order WHERE create_time BETWEEN :st AND :ed 
                GROUP BY machine_id";
        //$update = "UPDATE machine SET order_count=:oc,order_amount=:oa WHERE m_id=:mid";
        //this month
        $command = $this->db_to->createCommand($sql,[":st"=>$this_month_start,":ed"=>(time()+864000)]);
        $command->execute();
        $reader = $command->query();
        $this_updates = 0;
        foreach ($reader as $key => $val) {
            if(!empty($val)){
                $this->db_to->createCommand()->update('machine',
                    [
                        'order_count'=>$val['order_count'],
                        'order_amount'=>$val['order_amount']
                    ],
                    'm_id=:m_id',[':m_id'=>$val['machine_id']])->execute();
                $this_updates++;
            }
        }
        echo PHP_EOL." UPDATE THIS MONTH ".$this_updates;

    }
    public function sumOrderTotalAmountLastMonth(){
        $this_month_start = strtotime($this->this_month.'01');
        $last_month_start = strtotime($this->last_month.'01');

        $sql = "SELECT 	machine_id,COUNT(machine_id) AS order_count,SUM(spend_money) AS order_amount 
                FROM machine_order WHERE create_time BETWEEN :st AND :ed 
                GROUP BY machine_id";

        // last month
        $command = $this->db_to->createCommand($sql,[":st"=>$last_month_start,":ed"=>($this_month_start-1)]);
        $command->execute();
        $reader = $command->query();
        $this_updates = 0;
        foreach ($reader as $key => $val) {
            if(!empty($val)){
                $this->db_to->createCommand()->update('machine',
                    [
                        'last_order_count'=>$val['order_count'],
                        'last_order_amount'=>$val['order_amount']
                    ],
                    'm_id=:m_id',[':m_id'=>$val['machine_id']])->execute();
                $this_updates++;
            }
        }
        echo PHP_EOL." UPDATE THIS MONTH ".$this_updates;
    }

    public function actionSum(){
        $this->sumOrderTotalAmountThisMonth();
        $this->sumOrderTotalAmountLastMonth();

    }
}
