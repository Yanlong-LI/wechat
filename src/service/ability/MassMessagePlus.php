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
 *   Desc:   _
 */
declare(strict_types=1);

namespace yanlongli\wechat\service\ability;


use yanlongli\wechat\messaging\contract\MassMessage as MassMessageContract;
use yanlongli\wechat\service\api\MessageService;
use yanlongli\wechat\WechatException;

/**
 * 群发增强版 服务号使用
 * Class MassMessagePlus
 * @package yanlongli\wechat\service\ability
 */
class MassMessagePlus extends MassMessage
{
    //根据OpenID列表群发 -- 服务号可用

    /**
     * 根据OpenID列表群发
     * @param array $openIds
     * @param MassMessageContract $message
     * @return array
     * @throws WechatException
     */
    public function sendByOpenIds(array $openIds, MassMessageContract $message)
    {
        return MessageService::sendAllWithOpenIds($this->app, $openIds, $message);
    }
}
