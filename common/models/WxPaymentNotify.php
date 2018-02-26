<?php

namespace common\models;

use Yii;
use yii\base\Exception;
use yii\log\Logger;

/**
 * This is the model class for table "wx_payment_notify".
 *
 * @property integer $id
 * @property string $openid
 * @property integer $total_fee
 * @property string $transaction_id
 * @property string $out_trade_no
 * @property string $result_code
 * @property string $time_end
 * @property string $attach
 * @property string $response
 * @property integer $created_at
 * @property string $err_code
 * @property string $err_code_des
 * @property string $handle_status
 * @property string $handle_error
 */
class WxPaymentNotify extends \yii\db\ActiveRecord
{
    const HANDLE_SUCCESS = 'SUCCESS';
    const HANDLE_FAIL = 'FAIL';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wx_payment_notify';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid', 'total_fee', 'transaction_id', 'out_trade_no', 'result_code', 'response'], 'required'],
            [['total_fee', 'created_at'], 'integer'],
            [['response'], 'string'],
            [['openid','handle_error'], 'string', 'max' => 255],
            [['transaction_id', 'out_trade_no', 'err_code'], 'string', 'max' => 32],
            [['result_code','handle_status'], 'string', 'max' => 16],
            [['time_end'], 'string', 'max' => 14],
            [['attach', 'err_code_des'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => 'Openid',
            'total_fee' => 'Total Fee',
            'transaction_id' => 'Transaction ID',
            'out_trade_no' => 'Out Trade No',
            'result_code' => 'Result Code',
            'time_end' => 'Time End',
            'attach' => 'Attach',
            'response' => 'Response',
            'created_at' => 'Created At',
            'err_code' => 'Err Code',
            'err_code_des' => 'Err Code Des',
            'handle_status' => 'Handle Status',
            'handle_error' => 'Handle Error',
        ];
    }

    public static function handleOrder($data,$appid,$mch_id){
        // todo insert payment
        $record = WxPaymentNotify::findOne(['transaction_id' => $data['transaction_id'],'handle_status'=>self::HANDLE_SUCCESS]);
        if(!empty($record)){
            \Yii::getLogger()->log('回调重复请求transaction_id:'.$data['transaction_id'],Logger::LEVEL_ERROR);
            return true;
        }

        $model = new WxPaymentNotify();
        $data['created_at'] = time();
        $data['response'] = json_encode($data);
        if(!$model->load($data,'') || !$model->save()){
            throw new Exception('新增支付信息失败'.var_export($model->getErrors(),true));
        }
        $transaction = Yii::$app->db->beginTransaction();
        try{
            if($data['appid'] != $appid){
                throw new Exception('appid 错误');
            }
            if($data['mch_id'] != $mch_id){
                throw new Exception('mch_id 错误');
            }
            if($data['result_code'] != 'SUCCESS' || $data['return_code'] != 'SUCCESS'){
                throw new Exception('result_code或者return_code fail');
            }

            // todo 处理订单
            $user = UserWechat::findOne(['openid'=>$data['openid']]);
            if(empty($user)){
                throw new Exception('用户不存在');
            }
            $order = Order::findOne(['code'=>$data['out_trade_no']]);
            if(empty($order)){
                throw new Exception('订单不存在');
            }
            if($order['user_id'] != $user['user_id']){
                throw new Exception('订单的用户不匹配');
            }
            if($order['payment_status'] != Order::PAYMENT_STATUS_NO){
                throw new Exception('订单的支付状态不匹配');
            }
            if($data['total_fee'] != ($order['payment_price']*100)){
                throw new Exception('订单的支付金额不匹配');
            }
            $order->payment_type = Order::PAYMENT_TYPE_WX;
            $order->payment_status = Order::PAYMENT_STATUS_YES;
            $order->updated_at = time();
            if(!$order->save()){
                throw new Exception('订单处理失败'.var_export($order->getErrors(),true));
            }
            // todo update payment
            $model->handle_status = self::HANDLE_SUCCESS;
            if(!$model->save()){
                throw new Exception('支付信息更新失败'.var_export($model->getErrors(),true));
            }
            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            $model->handle_status = self::HANDLE_FAIL;
            $model->handle_error = $e->getMessage();
            if(!$model->save()){
                throw new Exception('支付信息更新失败-'.var_export($model->getErrors(),true));
            }
            return false;
        }
        return true;
    }
}
