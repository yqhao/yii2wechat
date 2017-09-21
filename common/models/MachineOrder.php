<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "machine_order".
 *
 * @property integer $id
 * @property integer $franchisee_id
 * @property integer $member_id
 * @property integer $status
 * @property integer $is_distributed
 * @property string $entered_money
 * @property string $spend_money
 * @property string $point_money
 * @property integer $gai_discount
 * @property integer $member_discount
 * @property string $distribute_money
 * @property integer $create_time
 * @property string $remark
 * @property integer $machine_id
 * @property string $symbol
 * @property string $distribute_config
 * @property string $auto_check_fail
 * @property integer $is_auto
 * @property integer $distributed_time
 * @property integer $pay_type
 * @property string $gai_number
 * @property string $order_key_id_str
 * @property string $gcp_order_code
 *
 * @property Machine $machine
 */
class MachineOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'machine_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'franchisee_id', 'member_id', 'entered_money', 'spend_money', 'point_money', 'gai_discount', 'member_discount', 'distribute_money', 'create_time', 'remark', 'machine_id', 'distribute_config', 'auto_check_fail', 'distributed_time', 'gai_number', 'order_key_id_str', 'gcp_order_code'], 'required'],
            [['id', 'franchisee_id', 'member_id', 'status', 'is_distributed', 'gai_discount', 'member_discount', 'create_time', 'machine_id', 'is_auto', 'distributed_time', 'pay_type'], 'integer'],
            [['entered_money', 'spend_money', 'point_money', 'distribute_money'], 'number'],
            [['remark'], 'string', 'max' => 255],
            [['symbol'], 'string', 'max' => 20],
            [['distribute_config'], 'string', 'max' => 1024],
            [['auto_check_fail'], 'string', 'max' => 256],
            [['gai_number'], 'string', 'max' => 32],
            [['order_key_id_str', 'gcp_order_code'], 'string', 'max' => 48],
            [['machine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machine_id' => 'm_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'franchisee_id' => Yii::t('common', 'Franchisee ID'),
            'member_id' => Yii::t('common', 'Member ID'),
            'status' => Yii::t('common', 'Status'),
            'is_distributed' => Yii::t('common', 'Is Distributed'),
            'entered_money' => Yii::t('common', 'Entered Money'),
            'spend_money' => Yii::t('common', 'Spend Money'),
            'point_money' => Yii::t('common', 'Point Money'),
            'gai_discount' => Yii::t('common', 'Gai Discount'),
            'member_discount' => Yii::t('common', 'Member Discount'),
            'distribute_money' => Yii::t('common', 'Distribute Money'),
            'create_time' => Yii::t('common', 'Create Time'),
            'remark' => Yii::t('common', 'Remark'),
            'machine_id' => Yii::t('common', 'Machine ID'),
            'symbol' => Yii::t('common', 'Symbol'),
            'distribute_config' => Yii::t('common', 'Distribute Config'),
            'auto_check_fail' => Yii::t('common', 'Auto Check Fail'),
            'is_auto' => Yii::t('common', 'Is Auto'),
            'distributed_time' => Yii::t('common', 'Distributed Time'),
            'pay_type' => Yii::t('common', 'Pay Type'),
            'gai_number' => Yii::t('common', 'Gai Number'),
            'order_key_id_str' => Yii::t('common', 'Order Key Id Str'),
            'gcp_order_code' => Yii::t('common', 'Gcp Order Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMachine()
    {
        return $this->hasOne(Machine::className(), ['m_id' => 'machine_id']);
    }
}
