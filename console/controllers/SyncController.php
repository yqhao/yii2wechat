<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class SyncController extends Controller
{

    public function actionRun()
    {
        set_time_limit(0);
        echo "START".PHP_EOL;
        $t = time();
        $order_start_time = strtotime("2017-09-01");
        $last_order_id = Yii::$app->db_online->createCommand("SELECT max(id) FROM machine_order")->queryScalar();

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

        $command = Yii::$app->db_bi->createCommand($sql);
        $command->execute();
        $reader = $command->query();
        foreach ($reader as $key => $val) {
            if(!empty($val)){
                echo $key." ";
                $status = Yii::$app->db_online->createCommand($insertSql,$val)->execute();
                if($status) echo "UPDATE ".$val['m_id'].'-'.$status.PHP_EOL;
                $this->syncOrder((int)$last_order_id,$val['m_id'],$order_start_time);
            }
            unset($reader->$key);
        }


        echo PHP_EOL."END used times ".(time()-$t).PHP_EOL;
    }

    public function syncOrder($o_id,$m_id,$c_time)
    {
        $t = time();
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

        $command = Yii::$app->db_bi->createCommand($sql,[":o_id"=>$o_id,":m_id"=>$m_id,":c_time"=>$c_time]);
        $command->execute();
        $reader = $command->query();
        $i = 0;
        foreach ($reader as $key => $val) {
            if(!empty($val)){
                $status = Yii::$app->db_online->createCommand($insertSql,$val)->execute();
                if($status) $i++;
            }
            //unset($reader->$key);
        }


        echo "INSERT ORDERS ".$i." END. Used times ".(time()-$t).PHP_EOL;
    }
}
