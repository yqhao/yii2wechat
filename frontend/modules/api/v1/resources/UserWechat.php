<?php

namespace frontend\modules\api\v1\resources;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class UserWechat extends \common\models\UserWechat
{
    public function fields()
    {
        return ['user_id', 'token', 'auth_key', 'expire_at'];
    }


}
