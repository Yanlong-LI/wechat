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

use yanlongli\wechat\messaging\message\Text;
use yanlongli\wechat\officialAccount\ServiceAccount;
use yanlongli\wechat\officialAccount\SubscriptionAccount;
use yanlongli\wechat\support\Config;
use yanlongli\wechat\WechatException;

include __DIR__ . '/../vendor/autoload.php';

Config::loadConfigFile(__DIR__ . '/config.php');
//$wechat = new Wechat();
$app = new SubscriptionAccount(Config::get('config'));
$serviceAccount = new ServiceAccount(Config::get('config'));
try {
//    $response = $app->CustomerService->sendMessage('o1_FZ6DePqRIQ5mOgfnzu5oojDPY', new Text("test"));


    // 检查网络回调信息
    //    $response = $app->BasicSupport->callbackCheck();
    //获取所有用户列表
    //    $response = $app->UserManagement->getAllUser();
    // 获取客服列表
//    $response = $app->CustomService->getKfList();
    // 设置菜单
//    $response = $app->Menu->create([
//        $app->Menu::optionSubButton('菜单1', [
//            $app->Menu::optionView('打开腾讯官网', 'https://www.tencent.com')
//        ]),
//        $app->Menu::optionSubButton('菜单2', [
//            $app->Menu::optionClick('click', 'click')
//        ]),
//        $app->Menu::optionSubButton('菜单3', [
//            $app->Menu::optionScancodePush('"扫码推事件', 'scanCodePush')
//        ]),
//    ]);
    // 获取菜单
//    $response = $app->Menu->all();
    //获取标签列表
//    $response = $app->UserManagement->getTags();
    //获取标签下用户列表
//    $response = $app->UserManagement->getUsersByTag(2);
    //用户打标签
//    $response = $app->UserManagement->batchTagging(2, ['o1_FZ6DePqRIQ5mOgfnzu5oojDPY']);
    // 按标签群发
//    $response = $app->CustomService->sendMessage('o1_FZ6DePqRIQ5mOgfnzu5oojDPY', new Text('这是按 openid 单发'));
//    $response = $app->MassMessage->sendByTagId(2, new Text("这是按 Tag 群发"));
    //服务号有这个能力
    $response = $serviceAccount->MassMessage->sendByOpenIds([], new Text("这是按 OpenId 群发"));
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
