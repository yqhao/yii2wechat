<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "machine".
 *
 * @property integer $m_id
 * @property string $m_code
 * @property string $m_name
 * @property string $city_name
 * @property string $dist_name
 * @property string $street
 * @property string $last_time
 * @property string $max_amount
 * @property integer $city_id
 * @property integer $dist_id
 * @property integer $order_count
 * @property string $order_amount
 *
 * @property MachineOrder[] $machineOrders
 */
class Machine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'machine';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m_id', 'm_code', 'm_name'], 'required'],
            [['m_id', 'city_id', 'dist_id', 'order_count'], 'integer'],
            [['last_time'], 'safe'],
            [['max_amount', 'order_amount'], 'number'],
            [['m_code'], 'string', 'max' => 64],
            [['m_name', 'street'], 'string', 'max' => 255],
            [['city_name', 'dist_name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'm_id' => Yii::t('common', 'M ID'),
            'm_code' => Yii::t('common', 'M Code'),
            'm_name' => Yii::t('common', 'M Name'),
            'city_name' => Yii::t('common', 'City Name'),
            'dist_name' => Yii::t('common', 'Dist Name'),
            'street' => Yii::t('common', 'Street'),
            'last_time' => Yii::t('common', 'Last Time'),
            'max_amount' => Yii::t('common', 'Max Amount'),
            'city_id' => Yii::t('common', 'City ID'),
            'dist_id' => Yii::t('common', 'Dist ID'),
            'order_count' => Yii::t('common', 'Order Count'),
            'order_amount' => Yii::t('common', 'Order Amount'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMachineOrders()
    {
        return $this->hasMany(MachineOrder::className(), ['machine_id' => 'm_id']);
    }
    public function getMachineOrderAmount()
    {
        $mid = $this->m_id;
        $order_amount = Yii::$app->db->createCommand("SELECT SUM(spend_money) as order_amount FROM machine_order WHERE machine_id=:m_id GROUP BY machine_id")
            ->bindParam(":m_id",$mid)
            ->queryScalar();
        return (float)$order_amount;
    }
}
