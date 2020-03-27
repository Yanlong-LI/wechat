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
 * Class LocationSelect 弹出地图选择器 主动
 * @package yanlongli\wechat\messaging\receive\event
 * @property array SendLocationInfo
 * @property string _Location_X
 * @property string _Location_Y
 * @property string _Scale
 * @property string _Label
 * @property string _Poiname
 */
class LocationSelect extends Click
{
    const EVENT = 'location_select';
}
