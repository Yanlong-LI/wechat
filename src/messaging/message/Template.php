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

use yanlongli\wechat\messaging\contract\TemplateMessage;

/**
 * Class Template 模板消息
 * @package yanlongli\wechat\messaging\message
 */
class Template implements TemplateMessage
{
    protected string $templateId;
    protected array $date;
    protected string $url;
    protected string $topColor;

    /**
     * Template constructor.
     * @param string $templateId
     * @param array $data
     * @param string $url
     * @param string $topColor
     * @param string $defaultItemColor
     */
    public function __construct(string $templateId, array $data, string $url = '', string $topColor = '#FF0000', string $defaultItemColor = '#173177')
    {
        $this->templateId = $templateId;

        foreach ($data as $key => $val) {
            if (!is_array($val)) {
                $data[$key] = array(
                    'value' => "$val",
                    'color' => "$defaultItemColor",
                );
            }
        }

        $this->date = $data;
        $this->url = $url;
        $this->topColor = $topColor;

    }

    /**
     * @inheritDoc
     */
    public function jsonData()
    {
        return [
            'template_id' => $this->templateId,
            'url' => $this->url,
            'topcolor' => $this->topColor,
            'data' => $this->date,
        ];
    }
}
