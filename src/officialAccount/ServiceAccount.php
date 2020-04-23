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

use yanlongli\wechat\service\ability\AccountManagement;
use yanlongli\wechat\service\ability\Menu;
use yanlongli\wechat\service\ability\OAuth2;

/**
 * Class ServiceAccount 服务号
 * @package yanlongli\wechat\officialAccount
 * @property AccountManagement $AccountManagement 账号服务
 * @property OAuth2 $OAuth2 OAuth2 网页授权
 */
class ServiceAccount extends SubscriptionAccount
{
    public function __construct($appId, string $appSecret = null, string $token = null, string $encodingAesKey = null, string $encodingAesKeyLast = null, string $middleUrl = null)
    {
        parent::__construct($appId, $appSecret, $token, $encodingAesKey, $encodingAesKeyLast, $middleUrl);

        $this->addAbility([
            'AccountManagement' => AccountManagement::class,
            'Menu' => Menu::class,
        ]);
    }
}
