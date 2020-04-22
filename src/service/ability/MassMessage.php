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
 *   Desc:   群发消息
 */
declare(strict_types=1);

namespace yanlongli\wechat\service\ability;


class MassMessage extends Ability
{
    //todo 根据标签进行群发 订阅号和服务号认证可用
    //todo 根据OpenID列表群发 -- 服务号可用

    //todo 查询群发消息发送状态
    //todo 事件推送结果--在事件中

    //todo 获取群发速度
    public function getSpeed()
    {

    }

    //todo 控制群發速度
    public function setSpeed(int $speed)
    {

    }
}
