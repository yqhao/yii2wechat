<?php

namespace common\models;

use common\models\query\PackageQuery;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "wx_package".
 *
 * @property integer $id
 * @property string $app_id
 * @property integer $category_id
 * @property string $title
 * @property string $cover
 * @property string $price
 * @property string $market_price
 * @property integer $sales
 * @property integer $is_recommend
 * @property integer $stock
 * @property integer $weight
 * @property integer $goods_type
 * @property string $max_can_use_integral
 * @property string $integral
 * @property integer $express_rule_id
 * @property integer $is_seckill
 * @property integer $seckill_status
 * @property integer $is_group_buy
 * @property integer $is_published
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $last_update
 * @property string $description
 * @property string $content
 * @property string $detail
 * @property string $images
 * @property string $purchase_notice
 * @property string $traffic_guide
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $county_id
 * @property string $address
 * @property string $base_url
 *
 * @property WxPackageItem[] $wxPackageItems
 */
class Package extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    public $coverUpload;
    public $imagesUpload;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wx_package';
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
            ],
            TimestampBehavior::className(),
            [
                'class' => UploadBehavior::className(),
                'uploadRelation' => 'packageImages',
                'attribute' => 'imagesUpload',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
                'typeAttribute' => 'type',
                'multiple'=>true
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'category_id','price'], 'required'],
            [['category_id', 'sales', 'is_recommend', 'stock', 'weight', 'goods_type', 'express_rule_id', 'is_seckill', 'seckill_status', 'is_group_buy', 'is_published', 'created_at', 'updated_at', 'last_update', 'province_id', 'city_id', 'county_id'], 'integer'],
            [['price', 'market_price', 'max_can_use_integral', 'integral'], 'number'],
            [['content', 'detail', 'images', 'purchase_notice', 'traffic_guide'], 'string'],
            [['app_id'], 'string', 'max' => 64],
            [['title', 'cover', 'description', 'address', 'base_url'], 'string', 'max' => 255],
            [['coverUpload','imagesUpload'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'app_id' => Yii::t('common', 'App ID'),
            'category_id' => Yii::t('common', 'Category'),
            'title' => Yii::t('common', 'Title'),
            'cover' => Yii::t('common', 'Cover'),
            'price' => Yii::t('common', 'Price'),
            'market_price' => Yii::t('common', 'Market Price'),
            'sales' => Yii::t('common', 'Sales'),
            'is_recommend' => Yii::t('common', 'Is Recommend'),
            'stock' => Yii::t('common', 'Stock'),
            'weight' => Yii::t('common', 'Weight'),
            'goods_type' => Yii::t('common', 'Goods Type'),
            'max_can_use_integral' => Yii::t('common', 'Max Can Use Integral'),
            'integral' => Yii::t('common', 'Integral'),
            'express_rule_id' => Yii::t('common', 'Express Rule ID'),
            'is_seckill' => Yii::t('common', 'Is Seckill'),
            'seckill_status' => Yii::t('common', 'Seckill Status'),
            'is_group_buy' => Yii::t('common', 'Is Group Buy'),
            'is_published' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'last_update' => Yii::t('common', 'Last Update'),
            'description' => Yii::t('common', 'Description'),
            'content' => Yii::t('common', 'Content'),
            'detail' => Yii::t('common', 'Detail'),
            'images' => Yii::t('common', 'Images'),
            'purchase_notice' => Yii::t('common', 'Purchase Notice'),
            'traffic_guide' => Yii::t('common', 'Traffic Guide'),
            'province_id' => Yii::t('common', 'Province ID'),
            'city_id' => Yii::t('common', 'City ID'),
            'county_id' => Yii::t('common', 'County ID'),
            'address' => Yii::t('common', 'Address'),
            'base_url' => Yii::t('common', 'Base Url'),
            'coverUpload' => Yii::t('common', 'Cover Upload'),
            'imageUpload' => Yii::t('common', 'Image Upload'),
        ];
    }
    /**
     * @return PackageQuery
     */
    public static function find()
    {
        return new PackageQuery(get_called_class());
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackageItems()
    {
        return $this->hasMany(PackageItem::className(), ['package_id' => 'id']);
    }

    public function getPackageCategory()
    {
        return $this->hasOne(PackageCategory::className(), ['id' => 'category_id']);
    }

    public function getPackageImages()
    {
        return $this->hasMany(PackageImage::className(), ['package_id' => 'id']);
    }
    /**
     * @return string
     */
    public function getCover()
    {
        return rtrim($this->base_url, '/') . '/' . ltrim($this->cover, '/');
    }
    public function getFullAddress()
    {
        $prefix = '';
        if($this->county_id){
            $region = Region::findOne(['id'=>$this->county_id]);
            if(!empty($region)){
                $prefix = $region->province.$region->city.$region->county;
            }
        }

        return $prefix.$this->address;
    }

//    public function getCityList($pid)
//    {
//        $model = Region::findAll(array('parent_id'=>$pid));
//        return ArrayHelper::map($model, 'id', 'name');
//    }
}
