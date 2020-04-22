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
 *
 *   Author: Yanlongli <jobs@yanlongli.com>
 *   Date:   2020/4/22
 *   IDE:    PhpStorm
 *   Desc:   多图片消息
 */
declare(strict_types=1);

namespace yanlongli\wechat\messaging\message;

use yanlongli\wechat\messaging\contract\MassMessage;

/**
 * Class Image 群发多图片
 * @package yanlongli\wechat\messaging\message
 */
class Images implements MassMessage
{
    protected string $type = 'image';
    protected array $mediaIds;
    protected ?string $recommend;
    protected bool $needOpenComment;
    protected bool $onlyFansCanComment;

    /**
     * Images constructor.
     * @param array $mediaIds 媒体数组
     * @param string|null $recommend 描述
     * @param bool $needOpenComment 是否打开评论
     * @param bool $onlyFansCanComment 是否只能粉丝评论
     */
    public function __construct(array $mediaIds, ?string $recommend = null, bool $needOpenComment = false, bool $onlyFansCanComment = false)
    {
        $this->mediaIds = $mediaIds;
        $this->recommend = $recommend;
        $this->needOpenComment = $needOpenComment;
        $this->onlyFansCanComment = $onlyFansCanComment;

    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function jsonData()
    {
        return [
            'images' => [
                "media_ids" => $this->mediaIds,
                'recommend' => $this->recommend,
                'need_open_comment' => (int)$this->needOpenComment,
                'only_fans_can_comment' => (int)$this->onlyFansCanComment
            ]
        ];
    }
}
