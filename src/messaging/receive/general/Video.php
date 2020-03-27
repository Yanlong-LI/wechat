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
 * Class Video 视频消息
 * @package yanlongli\wechat\messaging\receive
 * @property string $MediaId 素材ID
 * @property string $ThumbMediaId 视频缩略图
 */
class Video extends GeneralMessage
{
    const TYPE = 'video';
}
