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

use yanlongli\wechat\messaging\contract\CallMessage;

/**
 * Class Typing 打字消息
 * @package yanlongli\wechat\messaging\message
 */
class Typing implements CallMessage
{
    const TYPING = 'Typing';
    const CANCEL_TYPING = 'CancelTyping';

    protected string $type = 'Typing';

    /**
     * Typing constructor.
     * @param string $type
     */
    public function __construct(string $type = self::TYPING)
    {
        $this->type = $type;
    }


    public function jsonData()
    {
        return [];
    }

    public function type()
    {
        return $this->type;
    }
}
