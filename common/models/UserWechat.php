<?php

namespace common\models;

use frontend\modules\api\v1\components\Wechat;
use Yii;
use yii\base\Exception;
use yii\base\InvalidCallException;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user_wechat".
 *
 * @property integer $user_id
 * @property string $nickname
 * @property string $code
 * @property string $openid
 * @property string $session_key
 * @property string $unionid
 * @property string $user_info
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $token
 * @property integer $expire_at
 * @property integer $auth_key
 * @property integer $logged_at
 * @property integer $remark
 *
 * @property User $user
 */
class UserWechat extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    const TOKEN_LENGTH = 40;//长度
    const DURATION = 86400;//有效时间

    public $time;
    public $random_number;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_wechat';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
//            'code' => [
//                'class' => AttributeBehavior::className(),
//                'attributes' => [
//                    ActiveRecord::EVENT_BEFORE_INSERT => 'code'
//                ],
//                'value' => function () {
//                    var_dump($this);exit;
//
//                    return '';
//                }
//            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid'], 'required'],
            [['openid', 'code'], 'required','on' => 'code2session'],
            [['user_id', 'created_at', 'updated_at','expire_at','logged_at','status'], 'integer'],
            [['user_info'], 'string'],
            [['nickname', 'code', 'openid', 'unionid'], 'string', 'max' => 64],
            [['auth_key'], 'string', 'max' => 32],
            [['token'], 'string', 'max' => 40],
            [['session_key'], 'string', 'max' => 128],
            [['remark'], 'string', 'max' => 255],
//            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('common', 'User ID'),
            'nickname' => Yii::t('common', 'Nickname'),
            'code' => Yii::t('common', 'Code'),
            'openid' => Yii::t('common', 'Openid'),
            'session_key' => Yii::t('common', 'Session Key'),
            'unionid' => Yii::t('common', 'Unionid'),
            'user_info' => Yii::t('common', 'User Info'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'expire_at' => Yii::t('common', 'Expire At'),
            'logged_at' => Yii::t('common', 'Logged At'),
            'token' => Yii::t('common', 'Token'),
            'auth_key' => Yii::t('common', 'Auth Key'),
            'remark' => Yii::t('common', 'Remark'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    /**
     * 生成access_token
     */
    public function refreshToken()
    {
        $this->token = Yii::$app->getSecurity()->generateRandomString(self::TOKEN_LENGTH);
        $this->expire_at = (time() + self::DURATION);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($openid)
    {
        return static::find()
            ->andWhere(['openid' => $openid])
            ->andWhere(['status' => static::STATUS_ACTIVE])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['token' => $token]);
    }

    //这个就是我们进行yii\filters\auth\QueryParamAuth调用认证的函数
    public function loginByAccessToken($token, $type) {
        return static::findIdentityByAccessToken($token, $type);
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->encodeAuthKey($this->getAuthKey()) === $this->encodeAuthKey($authKey);
    }

    public function encodeAuthKey($authKey){
        $array = [
            $authKey,$this->code,
//            $this->time,$this->random_number
        ];
        asort($array);
        return sha1(implode('',$array));
    }
    public function validateExpire()
    {
        return $this->expire_at > time();
    }
    /**
     * Returns user statuses list
     * @return array|mixed
     */
    public static function statuses()
    {
        return [
            self::STATUS_NOT_ACTIVE => Yii::t('common', 'Not Active'),
            self::STATUS_ACTIVE => Yii::t('common', 'Active'),
            self::STATUS_DELETED => Yii::t('common', 'Deleted')
        ];
    }

    public function generateUserPassword()
    {
        return Yii::$app->getSecurity()->generateRandomString(8);
    }
    public function signUp($password)
    {
        $username = 'wx_'.substr(md5(date('ymd')),0,2).(Yii::$app->getSecurity()->generateRandomString(6));
        $user = new User();
        $user->username = $username;
        $user->email = 'default';
        $user->status = User::STATUS_ACTIVE;
        $user->setPassword($password);
        if(!$user->save()) {
            throw new Exception("User couldn't be  saved");
        };
        $user->afterSignup();

        return $user;

    }
}
