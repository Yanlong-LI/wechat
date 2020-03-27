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
 * Class PicSysPhoto 相册选择或拍照发送
 * @package yanlongli\wechat\messaging\receive\event
 * @property string EventKey menu_key 自定义菜单的 key
 * @property array $SendPicsInfo 发送的图片数量  图片列表  图片的MD5值，开发者若需要，可用于验证接收到图片
 * @property int $_Count 数量
 * @property array $_PicList 照片列表
 * @property string $__PicMd5Sum 照片的md5值
 */
class PicPhotoOrAlbum extends Click
{
    const EVENT = 'pic_photo_or_album';
}
