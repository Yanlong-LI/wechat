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
 *   Date:   2020/4/23
 *   IDE:    PhpStorm
 *   Desc:   长链接转短链接接口
 */
declare(strict_types=1);

namespace yanlongli\wechat\service\api;

use yanlongli\wechat\App;
use yanlongli\wechat\WechatException;

/**
 * Class URLShortener
 * @package yanlongli\wechat\service\api
 * @link https://developers.weixin.qq.com/doc/offiaccount/Account_Management/URL_Shortener.html
 */
class URLShorten extends Api
{
    /**
     * 网址缩短
     * @param App $app
     * @param string $url
     * @return array
     * @throws WechatException
     */
    public static function shortUrl(App $app, string $url)
    {
        $postData = [
            'action' => 'long2short',
            'long_url' => $url
        ];
        $url = 'https://api.weixin.qq.com/cgi-bin/shorturl?access_token=ACCESS_TOKEN';
        return self::request($app, $url, $postData);
    }
}
