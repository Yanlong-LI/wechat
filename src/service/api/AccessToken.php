<?php
/**
 * Copyright (c) [2020] [Yanlongli <jobs@yanlongli.com>]
 * [Wechat] is licensed under Mulan PSL v2.
 * You can use this software according to the terms and conditions of the Mulan PSL v2.
 * You may obtain a copy of Mulan PSL v2 at:
 * http://license.coscl.org.cn/MulanPSL2
 * THIS SOFTWARE IS PROVIDED ON AN "AS IS" BASIS, WITHOUT WARRANTIES OF ANY KIND,
 * EITHER EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO NON-INFRINGEMENT,
 * MERCHANTABILITY OR FIT FOR A PARTICULAR PURPOSE.
 * See the Mulan PSL v2 for more details.
 */
declare(strict_types=1);

namespace yanlongli\wechat\service\api;


use yanlongli\wechat\App;
use yanlongli\wechat\WechatException;

/**
 * Class BasicSupport 接口调用凭证
 * @package yanlongli\wechat\service
 */
class AccessToken extends Api
{

    /**
     * @param App $app
     * @param bool $useCache
     * @return false|string
     * @throws WechatException
     */
    public static function getAccessToken(App $app, bool $useCache = true)
    {

        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET';
        $response = self::request($app, $url);
        return $response['access_token'];
    }
}
