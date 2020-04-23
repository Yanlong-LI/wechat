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
 *   Desc:   推广功能
 */
declare(strict_types=1);

namespace yanlongli\wechat\service\ability;


use yanlongli\wechat\service\api\QRCode;
use yanlongli\wechat\service\api\URLShorten;
use yanlongli\wechat\WechatException;

/**
 * Class AccountManagement
 * @package yanlongli\wechat\service\ability
 * @link https://developers.weixin.qq.com/doc/offiaccount/Account_Management/Generating_a_Parametric_QR_Code.html
 */
class AccountManagement extends Ability
{
    //Generating_a_Parametric_QR_Code
    //临时二维码
    /**
     * 临时二维码
     * @param string|int $sceneId
     * @param int|null $expireSeconds
     * @return array
     * @throws WechatException
     */
    public function temporary($sceneId, ?int $expireSeconds = null)
    {
        return QRCode::temporary($this->app, $sceneId, $expireSeconds);
    }

    /**
     * 永久二维码
     * @param $sceneId
     * @return array
     * @throws WechatException
     */
    public function forever($sceneId)
    {
        return QRCode::forever($this->app, $sceneId);
    }

    //长链接转短链接 URL_Shortener

    /**
     * 网址缩短
     * @param string $url 长链接
     * @return array
     * @throws WechatException
     */
    public function URLShorten(string $url)
    {
        return URLShorten::shortUrl($this->app, $url);
    }
}
