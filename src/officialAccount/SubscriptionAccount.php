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

use yanlongli\wechat\ability\CustomerService;
use yanlongli\wechat\ability\CustomerServiceManagement;
use yanlongli\wechat\ability\Menu;
use yanlongli\wechat\ability\UserManagement;

/**
 * Class SubscriptionAccount 订阅号
 * @package yanlongli\wechat\officialAccount
 * @property CustomerService $CustomerService 客服消息能力
 * @property UserManagement $UserManagement 用户管理
 * @property CustomerServiceManagement CustomerServiceManagement 多客服管理
 */
class SubscriptionAccount extends OfficialAccount
{
    public function __construct($appId, string $appSecret = null, string $token = null, string $encodingAesKey = null, string $encodingAesKeyLast = null, string $middleUrl = null)
    {
        parent::__construct($appId, $appSecret, $token, $encodingAesKey, $encodingAesKeyLast, $middleUrl);

        $this->ability = [
            ...$this->ability,
            'CustomerService' => CustomerService::class,
            'Menu' => Menu::class,
            'CustomerServiceManagement' => CustomerServiceManagement::class
        ];
    }
}
