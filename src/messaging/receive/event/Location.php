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
 * Class Location 地理位置 被动
 * @package yanlongli\wechat\messaging\receive\event
 * @property string $Latitude 地理位置纬度
 * @property string $Longitude 地理位置经度
 * @property string $Precision 地理位置精度
 */
class Location extends EventMessage
{
    const EVENT = 'LOCATION';
}
