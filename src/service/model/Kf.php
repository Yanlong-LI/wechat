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
 *   Date:   2020/4/21
 *   IDE:    PhpStorm
 *   Desc:   _
 */
declare(strict_types=1);

namespace yanlongli\wechat\service\model;

/**
 * Class Kf
 * @package yanlongli\wechat\service\model
 */
class Kf
{
    /**
     * @var string 完整客服账号，格式为：账号前缀@公众号微信号
     */
    public string $kf_account;
    /**
     * @var string 客服昵称
     */
    public string $kf_nick;
    /**
     * @var string 客服工号
     */
    public string $kf_id;
    /**
     * @var string 客服头像
     */
    public string $kf_headimgurl;
}
