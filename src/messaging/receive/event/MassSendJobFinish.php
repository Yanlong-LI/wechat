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

namespace yanlongli\wechat\messaging\receive\event;


use yanlongli\wechat\messaging\receive\EventMessage;

/**
 * Class MassSendJobFinish
 * @package yanlongli\wechat\messaging\receive\event
 * todo 完善參數
 * @property string Status
 * @property int TotalCount
 * @property int FilterCount
 * @property int SentCount
 * @property int ErrorCount
 * @property CopyrightCheckResult CopyrightCheckResult
 * @property ArticleUrlResult ArticleUrlResult
 */
class MassSendJobFinish extends EventMessage
{
    const TYPE = 'MASSSENDJOBFINISH';
}

class ArticleUrlResult
{
    public int $Count;
    public array $ResultList;

}

class CopyrightCheckResult
{
    public int $Count;
    /**
     * @var ResultList[]
     */
    public array $ResultList;
    public int $CheckState;
}

class ResultList
{
    /**
     * @var int 群发文章的序号，从1开始
     */
    public int $ArticleIdx;
    /**
     * @var int 用户声明文章的状态
     */
    public int $UserDeclareState;
    /**
     * @var int 系统校验的状态
     */
    public int $AuditState;
    /**
     * @var string 相似原创文的url
     */
    public string $OriginalArticleUrl;
    /**
     * @var int 相似原创文的类型
     */
    public int $OriginalArticleType;
    /**
     * @var int 是否能转载
     */
    public int $CanReprint;
    /**
     * @var int 是否需要替换成原创文内容
     */
    public int $NeedReplaceContent;
    /**
     * @var int 是否需要注明转载来源
     */
    public int $NeedShowReprintSource;
}
