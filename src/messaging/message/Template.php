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
    protected array $miniprogram;

    /**
     * Template constructor.
     * @param string $templateId
     * @param array $data
     * @param string|array $jumpOption 跳转 链接 或者 小程序
     * @param string $topColor
     * @param string $defaultItemColor
     */
    public function __construct(string $templateId, array $data, $jumpOption = null, string $defaultItemColor = '#173177')
    {
        $this->templateId = $templateId;

        foreach ($data as $key => $val) {
            if (!is_array($val)) {
                $data[$key] = array(
                    'value' => $val,
                    'color' => $defaultItemColor,
                );
            }
        }

        $this->date = $data;
        if (is_string($jumpOption))
            $this->url = (string)$jumpOption;
        if (is_array($jumpOption)) {
            $this->miniprogram = (array)$jumpOption;
        }

    }

    /**
     * @param string $appId
     * @param string $pagePath
     * @param string|null $url
     * @return array
     */
    public static function jumpMiniprogram(string $appId, string $pagePath, string $url = null)
    {
        return [
            'miniprogram' => [
                'appid' => $appId,
                'pagepath' => $pagePath
            ],
            'url' => $url
        ];
    }

    /**
     * @return array|string[]
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
                'template_id' => $this->templateId,
                'data' => $this->date,
            ] + $jumpOption;
    }
}
