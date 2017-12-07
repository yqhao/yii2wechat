<?php

namespace common\models;

use common\models\query\PackageItemQuery;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "wx_package_item".
 *
 * @property integer $id
 * @property integer $package_id
 * @property string $title
 * @property string $cover
 * @property string $price
 * @property string $market_price
 * @property string $price_rise_at_weekend
 * @property string $price_rise_at_holiday
 * @property string $weekend_price
 * @property string $holiday_price
 * @property integer $sales
 * @property integer $stock
 * @property integer $weight
 * @property string $max_can_use_integral
 * @property string $integral
 * @property integer $is_published
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $last_update
 * @property string $content
 * @property string $detail
 * @property string $special_description
 * @property string $unsubscribe_rules
 * @property string $change_rules
 * @property string $important_clause
 * @property string $description
 * @property string $booking_advance
 * @property string $base_url
 *
 * @property WxPackage $package
 */
class PackageItem extends \yii\db\ActiveRecord
{
    public $coverUpload;
    public $select_date;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wx_package_item';
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'coverUpload',
                'pathAttribute' => 'cover',
                'baseUrlAttribute' => 'base_url',
                'typeAttribute' => 'type'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_id', 'sales', 'stock', 'weight', 'is_published', 'created_at', 'updated_at', 'last_update'], 'integer'],
            [['title','package_id','price'], 'required'],
            [['price','market_price','weekend_price','holiday_price', 'max_can_use_integral', 'integral'], 'number'],
            [['content', 'detail', 'special_description', 'unsubscribe_rules', 'change_rules', 'important_clause'], 'string'],
            [['title', 'cover', 'description', 'base_url'], 'string', 'max' => 255],
            [['price_rise_at_weekend', 'price_rise_at_holiday'], 'string', 'max' => 16],
            [['booking_advance'], 'string', 'max' => 8],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Package::className(), 'targetAttribute' => ['package_id' => 'id']],
            [['coverUpload'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'package_id' => Yii::t('common', 'Package ID'),
            'title' => Yii::t('common', 'Title'),
            'cover' => Yii::t('common', 'Cover'),
            'price' => Yii::t('common', 'Price'),
            'market_price' => Yii::t('common', 'Market Price'),
            'price_rise_at_weekend' => Yii::t('common', 'Price Rise At Weekend'),
            'price_rise_at_holiday' => Yii::t('common', 'Price Rise At Holiday'),
            'weekend_price' => Yii::t('common', 'Weekend Price'),
            'holiday_price' => Yii::t('common', 'Holiday Price'),
            'sales' => Yii::t('common', 'Sales'),
            'stock' => Yii::t('common', 'Stock'),
            'weight' => Yii::t('common', 'Weight'),
            'max_can_use_integral' => Yii::t('common', 'Max Can Use Integral'),
            'integral' => Yii::t('common', 'Integral'),
            'is_published' => Yii::t('common', 'Is Published'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'last_update' => Yii::t('common', 'Last Update'),
            'content' => Yii::t('common', 'Content'),
            'detail' => Yii::t('common', 'Detail'),
            'special_description' => Yii::t('common', 'Special Description'),
            'unsubscribe_rules' => Yii::t('common', 'Unsubscribe Rules'),
            'change_rules' => Yii::t('common', 'Change Rules'),
            'important_clause' => Yii::t('common', 'Important Clause'),
            'description' => Yii::t('common', 'Description'),
            'booking_advance' => Yii::t('common', 'Booking Advance'),
            'base_url' => Yii::t('common', 'Base Url'),
            'coverUpload' => Yii::t('common', 'Cover Upload'),
        ];
    }
    /**
     * @return PackageItemQuery
     */
    public static function find()
    {
        return new PackageItemQuery(get_called_class());
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Package::className(), ['id' => 'package_id']);
    }

    public $_weekend = [0,6];
    public function getPriceByDate($time){
        $price = $this->price;
        if(in_array(date('w',$time),$this->_weekend) && $this->price_rise_at_weekend){
            $price = PackageItem::getPriceByFormula($price,$this->price_rise_at_weekend);
        }
        return ['full_date'=>date('Y-m-d',$time),'date'=>date('m-d',$time),'price'=>$price];
    }
    /**
     * @return string
     */
    public function getCover()
    {
        return rtrim($this->base_url, '/') . '/' . ltrim($this->cover, '/');
    }

    public static function getPriceByFormula($price,$formula){
        $formula = trim($formula);
        $operator = $formula[0];
        $value = substr($formula,1);
        $res = $price;
        switch ($operator) {
            case '+':
                $res = $price + $value;
                break;
            case '-':
                $res = $price - $value;
                break;
            case '*':
                $res = $price * $value;
                break;
            case '/':
                $res = $price / $value;
                break;
        }
        return number_format(ceil($res*100)/100,2);
    }
}
