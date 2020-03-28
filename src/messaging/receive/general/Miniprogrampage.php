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

namespace yanlongli\wechat\messaging\receive\general;

use yanlongli\wechat\messaging\receive\GeneralMessage;

/**
 * Class Miniprogrampage 小程序卡片
 * @package yanlongli\wechat\messaging\receive\event
 * @property string $Title 标题
 * @property string $AppId 小程序 app id
 * @property string $PagePath 小程序页面的 path
 * @property string $ThumbUrl 小程序封面 cdn 地址
 * @property string $ThumbMediaId 小程序封面 media id
 */
class Miniprogrampage extends GeneralMessage
{
    const TYPE = 'miniprogrampage';
}
