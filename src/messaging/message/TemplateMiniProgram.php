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
 * Class TemplateMiniProgram 小程序模板消息
 * @package yanlongli\wechat\message
 */
class TemplateMiniProgram implements TemplateMessage
{
    protected string $templateId;
    protected array $date;
    protected string $page;
    protected string $fromId;
    protected string $emphasis_keyword;

    /**
     * Template constructor.
     * @param string $templateId
     * @param string $fromId
     * @param string $page
     * @param array $data
     * @param string $emphasis_keyword
     */
    public function __construct(string $templateId, string $fromId, string $page = '', array $data = [], $emphasis_keyword = '')
    {
        $this->templateId = $templateId;
        $this->date = $data;
        $this->page = $page;
        $this->fromId = $fromId;
        $this->emphasis_keyword = $emphasis_keyword;

    }

    /**
     * @inheritDoc
     */
    public function jsonData()
    {
        return [
            'template_id' => $this->templateId,
            'page' => $this->page,
            'form_id' => $this->fromId,
            'data' => $this->date,
            'emphasis_keyword' => $this->emphasis_keyword,
        ];
    }
}
