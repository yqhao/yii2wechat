<?php
/**
 * Created by PhpStorm.
 * User: HowardPC
 * Date: 2017/12/2
 * Time: 22:01
 */

namespace backend\components;


class Tool
{

    public static function random($length, $chars = '0123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ') {
        $hash = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }
}