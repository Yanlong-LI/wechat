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

namespace yanlongli\wechat\messaging\receive\event;

use yanlongli\wechat\messaging\receive\EventMessage;

/**
 * Class TemplateSendJobFinish 模板消息推送反馈事件
 * @package yanlongli\wechat\messaging\receive\event
 * @property string Status 发送状态
 * @property int MsgID 消息ID
 */
class TemplateSendJobFinish extends EventMessage
{
    const EVENT = 'TEMPLATESENDJOBFINISH';
}
