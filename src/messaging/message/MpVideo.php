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
 *   Desc:   群发视频
 */
declare(strict_types=1);

namespace yanlongli\wechat\messaging\message;


use yanlongli\wechat\messaging\contract\MassMessage;

/**
 * Class MpVideo 群发视频
 * @package yanlongli\wechat\messaging\message
 */
class MpVideo implements MassMessage
{
    public string $mediaId;
    public string $title;
    public string $description;
    protected string $type = 'mpvideo';

    public function __construct(string $mediaId, string $title, string $description)
    {
        $this->mediaId = $mediaId;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @inheritDoc
     */
    public function jsonData()
    {
        return [
            $this->type => [
                'media_id' => $this->mediaId,
                'title' => $this->title,
                'description' => $this->description
            ]
        ];
    }

    public function type()
    {
        return $this->type;
    }
}
