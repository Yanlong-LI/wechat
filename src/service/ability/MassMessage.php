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


use yanlongli\wechat\messaging\contract\MassMessage as MassMessageContract;
use yanlongli\wechat\messaging\receive\event\MassSendJobFinish;
use yanlongli\wechat\service\api\MessageService;
use yanlongli\wechat\WechatException;

class MassMessage extends Ability
{

    const SPEED_80W = MessageService::SPEED_80W;
    //根据标签进行群发 订阅号和服务号认证可用
    const SPEED_60W = MessageService::SPEED_60W;

    //查询群发消息发送状态
    const SPEED_45W = MessageService::SPEED_45W;
    //事件推送结果--在事件中
    /**
     * @see MassSendJobFinish
     */

    //获取群发速度
    const SPEED_30W = MessageService::SPEED_30W;
    const SPEED_10W = MessageService::SPEED_10W;

    /**
     * 消息群发
     * @param MassMessageContract $message
     * @return array
     * @throws WechatException
     */
    public function sendAll(MassMessageContract $message)
    {
        return MessageService::sendAll($this->app, $message, null, true);
    }

    /**
     * 根据标签进行群发
     * @param int $tagId
     * @param MassMessageContract $message
     * @return array
     * @throws WechatException
     */
    public function sendByTagId(int $tagId, MassMessageContract $message)
    {
        return MessageService::sendAll($this->app, $message, $tagId);
    }

    /**
     * @param int $msgId
     * @return array
     * @throws WechatException
     */
    public function getStatus(int $msgId)
    {
        return MessageService::getMassStatus($this->app, $msgId);
    }

    /**
     * 获取群发速度
     * @return array
     * @throws WechatException
     */
    public function getSpeed()
    {
        return MessageService::getMassSpeed($this->app);
    }

    //控制群發速度

    /**
     * 控制群發速度
     * @param int $speed
     * @return array
     * @throws WechatException
     */
    public function setSpeed(int $speed = self::SPEED_80W)
    {
        return MessageService::setMassSpeed($this->app, $speed);
    }
}
