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
 *   Desc:   _
 */
declare(strict_types=1);

namespace yanlongli\wechat\messaging\message;


use yanlongli\wechat\messaging\contract\CallMessage;

class SubscribeTemplate implements CallMessage
{
    protected string $templateId;
    protected array $date;
    protected string $url;
    protected string $title;
    protected array $miniprogram;
    protected int $scene;

    public function __construct(string $templateId, int $scene, string $title, array $data, string $defaultItemColor = '#173177')
    {

        $this->templateId = $templateId;
        $this->title = $title;
        $this->scene = $scene;

//        foreach ($data as $key => $val) {
//            if (!is_array($val)) {
//                $data[$key] = array(
//                    'value' => $val,
//                    'color' => $defaultItemColor,
//                );
//            }
//        }

        $this->date = ['content' => $data];

    }

    /**
     * @inheritDoc
     */
    public function jsonData()
    {
        $jumpOption = [];
        if (isset($this->url)) {
            $jumpOption = [
                    'url' => $this->url
                ] + $jumpOption;
        }
        if (isset($this->miniprogram)) {
            $jumpOption = $this->miniprogram + $jumpOption;
        }
        return [
                'template' => $this->templateId,
                'title' => $this->title,
                'scene' => $this->scene
            ] + $jumpOption;
    }

    public function type()
    {
        // TODO: Implement type() method.
    }
}
