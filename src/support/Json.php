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

namespace yanlongli\wechat\support;


use stdClass;
use yanlongli\wechat\WechatException;

class Json
{
    /**
     * 将数据编码为json，用于请求微信平台服务器
     * @param $data
     * @return string
     */
    public static function encode($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * 解析微信平台返回的json字符串，错误时，抛异常
     * @param $jsonStr
     * @return stdClass
     * @throws WechatException
     */
    public static function parseOrFail($jsonStr)
    {
        $responseStd = json_decode($jsonStr);

        if (isset($responseStd->errcode) && 0 !== $responseStd->errcode) {
            if (empty($responseStd->errmsg)) {
                $responseStd->errmsg = 'Unknown';
            }

            throw new WechatException($responseStd->errmsg, $responseStd->errcode);
        }
        return $responseStd;
    }
}
