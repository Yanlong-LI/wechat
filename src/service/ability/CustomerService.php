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
 *   Desc:   客服消息
 */
declare(strict_types=1);

namespace yanlongli\wechat\service\ability;


use yanlongli\wechat\messaging\contract\CallMessage;
use yanlongli\wechat\messaging\message\Template;
use yanlongli\wechat\service\api\MessageService;
use yanlongli\wechat\service\api\TemplateMessage;
use yanlongli\wechat\WechatException;

class CustomerService extends Ability
{
    /**
     * 发送消息
     * @param string $openId
     * @param CallMessage $message 消息
     * @param string|null $account 客服账户
     * @return array
     * @throws WechatException
     */
    public function sendMessage(string $openId, CallMessage $message, ?string $account = null)
    {
        //todo 转换成 对象处理
        return MessageService::sendMessage($this->app, $openId, $message, $account);
    }

    /**
     * 发送模板消息
     * @param string $openId
     * @param Template $message
     * @return array
     * @throws WechatException
     */
    public function sendTemplateMessage(string $openId, Template $message)
    {
        return TemplateMessage::send($this->app, $openId, $message);
    }
}
