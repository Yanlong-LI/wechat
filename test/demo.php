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

use yanlongli\wechat\officialAccount\SubscriptionAccount;
use yanlongli\wechat\support\Config;
use yanlongli\wechat\WechatException;

include __DIR__ . '/../vendor/autoload.php';

Config::loadConfigFile(__DIR__ . '/config.php');
//$wechat = new Wechat();
$app = new SubscriptionAccount(Config::get('config'));
try {
//    $response = $app->CustomerService->sendMessage('o1_FZ6DePqRIQ5mOgfnzu5oojDPY', new Text("test"));


    // 检查网络回调信息
    //    $response = $app->BasicSupport->callbackCheck();
    //获取所有用户列表
    //    $response = $app->UserManagement->getAllUser();
    // 获取客服列表
    $response = $app->CustomService->getKfList();
    var_dump($response, $app->BasicSupport->getAccessToken());


//    CallMessageService::send($app, '', new Text("test"));
//    MessageService::send($app, '', new MsgMenu("test", [
//        MsgMenu::option('1', '一星'),
//        MsgMenu::option('2', '二星'),
//    ], '感谢'));
//    $acc = \yanlongli\wechat\service\AccountService::all($app);
//    var_dump($app);
} catch (WechatException $e) {
    var_dump($e);
}
