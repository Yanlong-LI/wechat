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
use yanlongli\wechat\messaging\contract\ReplyMessage;

/**
 * Class Music 音乐消息
 * @package yanlongli\wechat\messaging\message
 * @author  Zou Yiliang
 * @license MIT
 */
class Music implements ReplyMessage, CallMessage
{
    protected string $type = 'music';
    protected array $music;

    /**
     * Music constructor.
     * @param array|string $thumbMediaId
     * @param string $title
     * @param string $description
     * @param string $musicUrl
     * @param string $hqMusicUrl
     */
    public function __construct($thumbMediaId, string $title = '', string $description = '', string $musicUrl = '', string $hqMusicUrl = '')
    {
        if (is_array($thumbMediaId)) {
            extract($thumbMediaId, EXTR_OVERWRITE);
        }

        $this->music = [
            'Title' => $title,
            'Description' => $description,
            'MusicUrl' => $musicUrl,
            'HQMusicUrl' => $hqMusicUrl,
            'ThumbMediaId' => $thumbMediaId,
        ];
    }

    /**
     * @return array
     */
    public function xmlData()
    {
        return ['Music' => $this->music];
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function jsonData()
    {
        $music = array();

        //将key转为小写，微信json格式为全小写
        foreach ($this->music as $k => $v) {
            $music[$k] = array_change_key_case($v, CASE_LOWER);
        }

        return ['music' => $music];
    }
}
