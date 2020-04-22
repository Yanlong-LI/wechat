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
use yanlongli\wechat\support\Curl;
use yanlongli\wechat\support\Json;
use yanlongli\wechat\WechatException;

/**
 * Trait Request 请求封装
 * @package yanlongli\wechat\ability
 */
trait Request
{

    /**
     * 请求微信平台服务器，并解析返回的json字符串为数组，失败抛异常
     * @param App $app 微信公众平台账号
     * @param string $url
     * @param array|null $data
     * @param bool $jsonEncode
     * @return array
     * @throws WechatException
     */
    protected static function request(App $app, string $url, array $data = null, bool $jsonEncode = true)
    {
        $executeUrl = self::replaceUrlParams($app, $url);

        if ($jsonEncode) {
            $data = Json::encode($data);
        }

        try {

            return Json::parseOrFail(Curl::execute($executeUrl, is_null($data) ? 'get' : 'post', $data));

        } catch (WechatException $ex) {

            //更新AccessToken再次请求
            if (40001 === $ex->getCode()) {
                $executeUrl = self::replaceUrlParams($app, $url);
                return Json::parseOrFail(Curl::execute($executeUrl, is_null($data) ? 'get' : 'post', $data));
            }

            throw $ex;
        }
    }

    /**
     * 替换URL中的参数
     * @param App $app
     * @param string $url
     * @return array|string|string[]|null
     */
    protected static function replaceUrlParams(App $app, string $url)
    {
        if (false !== strpos($url, 'ACCESS_TOKEN')) {
            $url = str_replace('ACCESS_TOKEN', $app->BasicSupport->getAccessToken(), $url);
        }
        if (false !== strpos($url, 'APPID')) {
            $url = str_replace('APPID', $app->appId, $url);
        }
        if (false !== strpos($url, 'APPSECRET')) {
            $url = str_replace('APPSECRET', $app->appSecret, $url);
        }
        return $url;
    }
}
