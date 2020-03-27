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

namespace yanlongli\wechat\messaging\message;

use yanlongli\wechat\messaging\contract\MassMessage;
use yanlongli\wechat\messaging\contract\ReplyMessage;

/**
 * Class Text 文本消息
 * @package yanlongli\wechat\messaging\message
 * @author  Zou Yiliang
 * @license MIT
 */
class Text implements ReplyMessage, MassMessage
{
    protected string $type = 'text';
    protected string $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @return array
     */
    public function xmlData()
    {
        return [
            'Content' => $this->content,
        ];
    }

    /**
     * @return array
     */
    public function jsonData()
    {
        return ['text' => ['content' => $this->content]];
    }

    public function type()
    {
        return $this->type;
    }
}
