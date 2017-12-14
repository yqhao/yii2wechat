<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\modules\api\v1\filters;
use yii\filters\auth\AuthMethod;
use yii\web\UnauthorizedHttpException;

/**
 * HttpBearerAuth is an action filter that supports the authentication method based on HTTP Bearer token.
 *
 * You may use HttpBearerAuth by attaching it as a behavior to a controller or module, like the following:
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'bearerAuth' => [
 *             'class' => \yii\filters\auth\HttpBearerAuth::className(),
 *         ],
 *     ];
 * }
 * ```
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BearerAuth extends AuthMethod
{
    /**
     * @var string the HTTP authentication realm
     */
    public $realm = 'api';


    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get('Authorization');
        $authKey = $request->getHeaders()->get('Auth-Key');
        if ($authHeader !== null && $authKey !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $identity = $user->loginByAccessToken($matches[1], get_class($this));
            if ($identity === null) {
                throw new UnauthorizedHttpException('Your request was made with invalid credentials.');
            }
            if($identity->validateAuthKey($authKey)){
                throw new UnauthorizedHttpException('Your Auth-Key is invalid.');
            }
            if(!$identity->validateExpire()){
                throw new UnauthorizedHttpException('Your Token is timeout.');
            }

            return $identity;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function challenge($response)
    {
        $response->getHeaders()->set('WWW-Authenticate', "Bearer realm=\"{$this->realm}\"");
    }
}
