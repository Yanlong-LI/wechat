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

use yanlongli\wechat\service\ability\CustomerService;
use yanlongli\wechat\service\ability\Menu;
use yanlongli\wechat\service\ability\OAuth2;
use yanlongli\wechat\service\ability\Qrcode;
use yanlongli\wechat\service\ability\UserManagement;

/**
 * Class ServiceAccount 服务号
 * @package yanlongli\wechat\officialAccount
 * @property CustomerService $MessageService 客服消息能力
 * @property Qrcode $Qrcode 生成带参数二维码
 * @property UserManagement $UserManagement 生成带参数二维码
 * @property OAuth2 $OAuth2 OAuth2
 * @property Menu $Menu 菜单管理
 */
class ServiceAccount extends OfficialAccount
{
    public function __construct($appId, string $appSecret = null, string $token = null, string $encodingAesKey = null, string $encodingAesKeyLast = null, string $middleUrl = null)
    {
        parent::__construct($appId, $appSecret, $token, $encodingAesKey, $encodingAesKeyLast, $middleUrl);

        $this->addAbility([
            'UserManagement' => UserManagement::class,
            'OAuth2' => OAuth2::class,
            'Qrcode' => Qrcode::class,
            'Menu' => Menu::class,
        ]);
    }
}
