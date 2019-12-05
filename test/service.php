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
 *   Date:   2019/11/20
 *   IDE:    PhpStorm
 *   Desc:   服务器监听事件演示demo
 */
declare(strict_types=1);

use yanlongli\wechat\WechatException;
use yanlongli\wechat\support\Config;
use yanlongli\wechat\officialAccount\OfficialAccount;
use yanlongli\wechat\officialAccount\HandleEventService;
use yanlongli\wechat\messaging\receive\event\Subscribe;
use yanlongli\wechat\messaging\message\Text;
use yanlongli\wechat\messaging\receive\general\Text as receiveText;
use yanlongli\wechat\messaging\message\Image;
use yanlongli\wechat\messaging\receive\general\Image as receiveImage;
use yanlongli\wechat\messaging\receive\general\Location as receiveLocation;
use yanlongli\wechat\messaging\receive\event\Location as receiveEventLocation;
use yanlongli\wechat\service\CallMessageService;
use yanlongli\wechat\messaging\contract\ReplyMessage;
use yanlongli\wechat\messaging\receive\ReceiveMessage;


include '../vendor/autoload.php';

Config::loadConfigFile(__DIR__ . '/config.php');

$officialAccount = new OfficialAccount(Config::get('config'));

$service = new HandleEventService($officialAccount);


$service->register(Subscribe::EVENT, function (Subscribe $subscribe) {
    $subscribe->sendMessage(new Text("感谢您的关注"));
});
//发什么文字回什么文字
$service->register(receiveText::TYPE, function (receiveText $text) use ($officialAccount): ReplyMessage {
//    todo 这里改成 return 直接返回消息
//    $text->sendMessage(new Text($text->Content));
    try {

        CallMessageService::send($officialAccount, $text->FromUserName, new Text("这个来自主动发送消息:" . $text->Content));
    } catch (WechatException $exception) {
        //屏蔽这个错误
    }
    return new Text($text->Content);
});
//发什么图片回什么图片
$service->register(receiveImage::TYPE, function (receiveImage $image) use ($officialAccount): ReplyMessage {
//    CallMessageService::send($officialAccount, $image->FromUserName, new Image($image->MediaId));
    CallMessageService::send($officialAccount, $image->FromUserName, new Text($image->MediaId));
    return new Image($image->MediaId);
});
//收到位置
$service->register(receiveLocation::TYPE, function (receiveLocation $location) {

    return new Text("收到普通的地址坐标：$location->Location_X,$location->Location_Y,$location->Scale,$location->MsgId");
});
$service->register(receiveEventLocation::TYPE, function (receiveEventLocation $location) {
    return new Text("收到事件的地址坐标：5s一次 " . date(DATE_ATOM));
});

$service->register("", function (ReceiveMessage $receiveMessage): ReplyMessage {
    return new Text("收到一条未处理消息" . $receiveMessage->MsgType);
});


//处理动作
try {
    $service->handle();
} catch (WechatException $e) {
    //处理异常，回复 success让微信不报错
    echo 'success';
}