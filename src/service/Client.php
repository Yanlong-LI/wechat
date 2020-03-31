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

namespace yanlongli\wechat\service;


use ReflectionException;
use stdClass;
use yanlongli\wechat\support\Curl;
use yanlongli\wechat\support\Json;
use yanlongli\wechat\Wechat;
use yanlongli\wechat\WechatException;

/**
 * Trait Client
 * @package yanlongli\wechat\service
 */
trait Client
{


    /**
     * @param Request $request
     * @return stdClass
     * @throws ReflectionException
     * @throws WechatException
     */
    public function exec(Request $request)
    {
        $executeUrl = $request->url();
        // 修正 仅在含有需要token的链接中替换token
        if (false !== strpos($executeUrl, 'ACCESS_TOKEN')) {
            $executeUrl = str_replace('ACCESS_TOKEN', $this->getAccessToken(), $executeUrl);
        }

        $data = Json::encode($request->toArray());

        try {

            return Json::parseOrFail(Curl::execute($executeUrl, is_null($data) ? 'get' : 'post', $data));

        } catch (WechatException $ex) {

            //更新AccessToken再次请求
            if (40001 === $ex->getCode()) {
                $executeUrl = str_replace('ACCESS_TOKEN', Wechat::getApp($app->appId)->getAccessToken(false), $url);
                return Json::parseOrFail(Curl::execute($executeUrl, is_null($data) ? 'get' : 'post', $data));
            }

            throw $ex;
        }
    }
}
