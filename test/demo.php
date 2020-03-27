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


use yanlongli\wechat\messaging\message\MsgMenu;
use yanlongli\wechat\officialAccount\OfficialAccount;
use yanlongli\wechat\service\CallMessageService;
use yanlongli\wechat\support\Config;
use yanlongli\wechat\Wechat;
use yanlongli\wechat\WechatException;

include __DIR__ . '/../vendor/autoload.php';

$wechat = new Wechat();
$app = new OfficialAccount(Config::get('config'), '', '');
$app->accessToken = '';
try {
//    CallMessageService::send($app, '', new Text("test"));
    CallMessageService::send($app, '', new MsgMenu("test", [
        MsgMenu::option('1', '一星'),
        MsgMenu::option('2', '二星'),
    ], '感谢'));
//    $acc = \yanlongli\wechat\service\AccountService::all($app);
//    var_dump($app);
} catch (WechatException $e) {
    var_dump($e);
}
