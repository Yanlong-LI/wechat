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
use yanlongli\wechat\service\ability\ConnectingDevices;
use yanlongli\wechat\service\ability\InstantStores;
use yanlongli\wechat\service\ability\IntelligentInterface;
use yanlongli\wechat\service\ability\MassMessage;
use yanlongli\wechat\service\ability\MassMessagePlus;
use yanlongli\wechat\service\ability\NonTaxPay;
use yanlongli\wechat\service\ability\OAuth2;
use yanlongli\wechat\service\ability\ShoppingGuide;
use yanlongli\wechat\service\ability\UniqueItemCode;
use yanlongli\wechat\service\ability\WiFiViaWeChat;

/**
 * Class ServiceAccount 服务号
 * @package yanlongli\wechat\officialAccount
 * @property AccountManagement $AccountManagement 账号服务
 * @property OAuth2 $OAuth2 OAuth2 网页授权
 * @property MassMessagePlus $MassMessage 消息群发
 * @property UniqueItemCode UniqueItemCode 一物一码
 * @property NonTaxPay NonTaxPay 非税缴费
 * @property WiFiViaWeChat WiFiViaWeChat 微信连WiFi
 * @property ShoppingGuide ShoppingGuide 微信导购
 * @property ConnectingDevices ConnectingDevices 微信设备功能
 * @property IntelligentInterface IntelligentInterface 智能接口
 * @property InstantStores InstantStores 智能接口
 */
class ServiceAccount extends SubscriptionAccount
{
    public function __construct($appId, string $appSecret = null, string $token = null, string $encodingAesKey = null, string $encodingAesKeyLast = null, string $middleUrl = null)
    {
        parent::__construct($appId, $appSecret, $token, $encodingAesKey, $encodingAesKeyLast, $middleUrl);

        $this->addAbility([
            OAuth2::class => OAuth2::class,
            'AccountManagement' => AccountManagement::class,
            MassMessage::class => MassMessagePlus::class,
            UniqueItemCode::class => UniqueItemCode::class,
            NonTaxPay::class => NonTaxPay::class,
            WiFiViaWeChat::class => WiFiViaWeChat::class,
            ShoppingGuide::class => ShoppingGuide::class,
            ConnectingDevices::class => ConnectingDevices::class,
            IntelligentInterface::class => IntelligentInterface::class,
            InstantStores::class => InstantStores::class,
        ]);
    }
}
