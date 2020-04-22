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


/**
 * Trait Client
 * @package yanlongli\wechat\service
 * @deprecated
 */
trait Client
{
//
//    use Request;
//
//    /**
//     * @param Request $request
//     * @return ErrorResponse|Response
//     * @throws ReflectionException
//     * @throws WechatException
//     */
//    public static function exec(Request $request)
//    {
//        $executeUrl = self::replaceUrlParams($request->url());
//
//        $data = Json::encode($request->toArray());
//
//        $response = $request->getResponse(Curl::execute($executeUrl, is_null($data) ? 'get' : 'post', $data));
//
//        //更新AccessToken再次请求
//        if ($response instanceof ErrorResponse && 40001 === $response->errcode) {
//            // 刷新 BasicSupport
//            $this->BasicSupport->getAccessToken(false);
//            $executeUrl = $this->replaceUrlParams($request->url());
//            $response = $request->getResponse(Curl::execute($executeUrl, is_null($data) ? 'get' : 'post', $data));
//            if ($response instanceof ErrorResponse && 0 !== $response->errcode) {
//                throw new WechatException($response->errmsg, $response->errcode);
//            }
//        }
//        return $response;
//
//
//    }
//
//    /**
//     * 匹配替换URL中的参数
//     * 如ACCESS_TOKEN
//     * @param string $executeUrl
//     * @return string
//     */
//    public static function replaceUrlParams(string $executeUrl): string
//    {
//        if (false !== strpos($executeUrl, 'ACCESS_TOKEN')) {
//            $executeUrl = str_replace('ACCESS_TOKEN', $this->BasicSupport->getAccessToken(), $executeUrl);
//        }
//        if (false !== strpos($executeUrl, 'APPID')) {
//            $executeUrl = str_replace('APPID', $this->appId, $executeUrl);
//        }
//        if (false !== strpos($executeUrl, 'APPSECRET')) {
//            $executeUrl = str_replace('APPSECRET', $this->appSecret, $executeUrl);
//        }
//
//        return $executeUrl;
//    }
}
