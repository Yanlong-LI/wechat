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

namespace yanlongli\wechat\officialAccount;

use yanlongli\wechat\App;
use yanlongli\wechat\service\ability\HandleService;

/**
 * Class OfficialAccount 公众号
 * @package yanlongli\wechatOfficialAccount
 * @property HandleService $HandleService 接收消息
 */
abstract class OfficialAccount extends App
{

    public function __construct($appId, string $appSecret = null, string $token = null, string $encodingAesKey = null, string $encodingAesKeyLast = null, string $middleUrl = null)
    {
        parent::__construct($appId, $appSecret, $token, $encodingAesKey, $encodingAesKeyLast, $middleUrl);

        $this->addAbility([
            HandleService::class => HandleService::class,
        ]);
    }
}
