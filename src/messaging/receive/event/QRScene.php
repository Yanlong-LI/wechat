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

/**
 * Class QRScene 扫码事件
 * @package yanlongli\wechat\messaging\receive\event
 * @property string EventKey 事件KEY值，qrscene_为前缀，后面为二维码的参数值
 * @property string Ticket    二维码的ticket，可用来换取二维码图片
 * @property string EventKeyPrefix 扫码关注事件key前缀
 */
class QRScene extends Subscribe
{
    const EVENT = 'QRSCENE';
    const EventKeyPrefix = 'qrscene_';
}
