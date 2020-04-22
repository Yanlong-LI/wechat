<?php
/**
 *   Copyright (c) [2019] [Yanlongli <jobs@yanlongli.com>]
 *   [Wechat] is licensed under the Mulan PSL v1.
 *   You can use this software according to the terms and conditions of the Mulan PSL v1.
 *   You may obtain a copy of Mulan PSL v1 at:
 *       http://license.coscl.org.cn/MulanPSL
 *   THIS SOFTWARE IS PROVIDED ON AN "AS IS" BASIS, WITHOUT WARRANTIES OF ANY KIND, EITHER EXPRESS OR
 *   IMPLIED, INCLUDING BUT NOT LIMITED TO NON-INFRINGEMENT, MERCHANTABILITY OR FIT FOR A PARTICULAR
 *   PURPOSE.
 *   See the Mulan PSL v1 for more details.
 *
 *   Author: Yanlongli <jobs@yanlongli.com>
 *   Date:   2020/4/22
 *   IDE:    PhpStorm
 *   Desc:   _
 */
declare(strict_types=1);

namespace yanlongli\wechat\service\api;


use yanlongli\wechat\App;
use yanlongli\wechat\WechatException;

class BasicInformation extends Api
{
    public const CHECK_ACTION_ALL = 'all';
    public const CHECK_ACTION_DNS = 'dns';
    public const CHECK_ACTION_PING = 'ping';
    public const CHECK_OPERATOR_CHINANET = 'CHINANET';
    public const CHECK_OPERATOR_UNICOM = 'UNICOM';
    public const CHECK_OPERATOR_CAP = 'CAP';
    public const CHECK_OPERATOR_DEFAULT = 'DEFAULT';

    /**
     * 获取微信 callback ip地址
     * @param App $app
     * @return array
     * @throws WechatException
     */
    public static function getCallbackIP(App $app)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=ACCESS_TOKEN';
        return self::request($app, $url);
    }

    /**
     * 获取微信API接口 IP地址
     * @param App $app
     * @return array
     * @throws WechatException
     */
    public static function getApiDomainIP(App $app)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/get_api_domain_ip?access_token=ACCESS_TOKEN';
        return self::request($app, $url);
    }

    /**
     * 网络检测
     * @param App $app
     * @param string $action
     * @param string $operator
     * @return array
     * @throws WechatException
     */
    public static function callbackCheck(App $app, string $action = self::CHECK_ACTION_ALL, string $operator = self::CHECK_OPERATOR_DEFAULT)
    {

        $postData = [
            'action' => 'all',
            'check_operator' => 'DEFAULT'
        ];

        $url = 'https://api.weixin.qq.com/cgi-bin/callback/check?access_token=ACCESS_TOKEN';
        return self::request($app, $url, $postData);
    }
}
