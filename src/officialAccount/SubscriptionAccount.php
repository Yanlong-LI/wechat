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
 *
 *   Author: Yanlongli <jobs@yanlongli.com>
 *   Date:   2020/4/23
 *   IDE:    PhpStorm
 *   Desc:   订阅号
 */
declare(strict_types=1);

namespace yanlongli\wechat\officialAccount;


use yanlongli\wechat\service\ability\Analytics;
use yanlongli\wechat\service\ability\CommentsManagement;
use yanlongli\wechat\service\ability\CustomerServiceManagement;
use yanlongli\wechat\service\ability\Invoice;
use yanlongli\wechat\service\ability\MassMessage;
use yanlongli\wechat\service\ability\Material;
use yanlongli\wechat\service\ability\Menu;
use yanlongli\wechat\service\ability\UserManagement;
use yanlongli\wechat\service\ability\WeChatStores;

/**
 * Class SubscriptionAccount 订阅号
 * @package yanlongli\wechat\officialAccount
 * @property UserManagement $UserManagement 用户管理
 * @property CustomerServiceManagement $CustomService 多客服管理
 * @property MassMessage $MassMessage 消息群发
 * @property Menu $Menu 菜单管理
 * @property Invoice Invoice 微信电子发票
 * @property WeChatStores WeChatStores 微信门店
 * @property Analytics Analytics 统计分析
 * @property Material Material 素材管理
 * @property CommentsManagement CommentsManagement 评论管理
 */
class SubscriptionAccount extends PersonalSubscriptionAccount
{
    /**
     * @inheritDoc
     */
    public function __construct($appId, string $appSecret = null, string $token = null, string $encodingAesKey = null, string $encodingAesKeyLast = null, string $middleUrl = null)
    {
        parent::__construct($appId, $appSecret, $token, $encodingAesKey, $encodingAesKeyLast, $middleUrl);

        $this->addAbility([
            'Menu' => Menu::class,
            'CustomService' => CustomerServiceManagement::class,
            UserManagement::class => UserManagement::class,
            MassMessage::class => MassMessage::class,
            Invoice::class => Invoice::class,
            WeChatStores::class => WeChatStores::class,
            Analytics::class => Analytics::class,
            Material::class => Material::class,
            CommentsManagement::class => CommentsManagement::class,
        ]);
    }
}
