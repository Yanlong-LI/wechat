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
 * Class MsgMenu 菜单消息
 * @package yanlongli\wechat\messaging\message
 * @author  Zou Yiliang
 * @license MIT
 */
class MsgMenu implements CallMessage
{

    protected string $type = 'msgmenu';
    protected string $tail;
    protected array $list;
    protected string $title;

    /**
     * Menu constructor.
     * @param string $title
     * @param array $list
     * @param string $tail
     */
    public function __construct(string $title, array $list, string $tail)
    {
        $this->title = $title;
        $this->list = $list;
        $this->tail = $tail;
    }

    public function type()
    {
        return $this->type;
    }

    /**
     * @param string $id
     * @param string $title
     * @return array
     */
    public static function option(string $id, string $title)
    {
        return ['id' => $id, 'title' => $title];
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function jsonData()
    {
        return [
            'msgmenu' => [
                'head_content' => $this->title,
                'list' => $this->list,
                'tail_content' => $this->tail,
            ]
        ];
    }
}
