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

namespace yanlongli\wechat\service\api;

use yanlongli\wechat\service\model\Kf;
use yanlongli\wechat\service\Response;

/**
 * Class CustomserviceGetkflistResponse 获取所有客服列表
 * @package yanlongli\wechat\service\api
 * @link https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Service_Center_messages.html#0
 */
class CustomserviceGetkflistResponse extends Response
{
    /**
     * @var kf[]
     */
    public array $kf_list;

    /**
     * @return array
     */
    protected function setDataKeyAlias(): array
    {
        return [
            'kf_list' => Kf::class
        ];
    }
}
