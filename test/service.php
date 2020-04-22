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

use yanlongli\wechat\messaging\contract\ReplyMessage;
use yanlongli\wechat\messaging\message\Image;
use yanlongli\wechat\messaging\message\Text;
use yanlongli\wechat\messaging\receive\event\Click;
use yanlongli\wechat\messaging\receive\event\Location as receiveEventLocation;
use yanlongli\wechat\messaging\receive\event\LocationSelect;
use yanlongli\wechat\messaging\receive\event\PicPhotoOrAlbum;
use yanlongli\wechat\messaging\receive\event\PicSysPhoto;
use yanlongli\wechat\messaging\receive\event\PicWeixin;
use yanlongli\wechat\messaging\receive\event\QRScene;
use yanlongli\wechat\messaging\receive\event\ScanCodePush;
use yanlongli\wechat\messaging\receive\event\ScanCodeWaitMsg;
use yanlongli\wechat\messaging\receive\event\Subscribe;
use yanlongli\wechat\messaging\receive\event\View;
use yanlongli\wechat\messaging\receive\event\ViewMiniprogram;
use yanlongli\wechat\messaging\receive\general\Image as receiveImage;
use yanlongli\wechat\messaging\receive\general\Link;
use yanlongli\wechat\messaging\receive\general\Location as receiveLocation;
use yanlongli\wechat\messaging\receive\general\ShortVideo;
use yanlongli\wechat\messaging\receive\general\Text as receiveText;
use yanlongli\wechat\messaging\receive\general\Video;
use yanlongli\wechat\messaging\receive\ReceiveMessage;
use yanlongli\wechat\officialAccount\SubscriptionAccount;
use yanlongli\wechat\support\Config;
use yanlongli\wechat\support\Request;


include '../vendor/autoload.php';

Config::loadConfigFile(__DIR__ . '/config.php');

/**
 * 初始化一个订阅号
 */
$officialAccount = new SubscriptionAccount(Config::get('config'));

// 订阅事件
$officialAccount->HandleService->register(function (Subscribe $subscribe) {
    $subscribe->sendMessage(new Text("感谢您的关注"));
});
// 扫码关注事件
$officialAccount->HandleService->register(function (QRScene $QRScene) {
    return new Text($QRScene->EventKey);
});

//文字消息
$officialAccount->HandleService->register(function (receiveText $text) use ($officialAccount): ReplyMessage {
    if ($text->Content === '1') {
        return new Text($text->FromUserName);
    }

    return new Text($text->Content);
});
//图片消息
$officialAccount->HandleService->register(function (receiveImage $image) use ($officialAccount): ReplyMessage {
    $officialAccount->CustomerService->sendMessage($image->FromUserName, new Text($image->MediaId));
    return new Image($image->MediaId);
});
// 链接
$officialAccount->HandleService->register(function (Link $link) {
    return new Text('收到了您的链接：' . $link->Url);
});
// 视频
$officialAccount->HandleService->register(function (Video $video) {
    return new Text('收到了您的视频');
});
// 收到了您的小视频
$officialAccount->HandleService->register(function (ShortVideo $shortVideo) {
    return new Text('收到了您的视频');
});
//位置消息
$officialAccount->HandleService->register(function (receiveLocation $location) {
    return new Text("收到普通的地址坐标：$location->Location_X,$location->Location_Y,$location->Scale,$location->MsgId");
});
// 坐标事件
$officialAccount->HandleService->register(function (receiveEventLocation $location) {
    return new Text("收到事件的地址坐标：5s一次 " . date(DATE_ATOM));
});

$officialAccount->HandleService->register(function (ReceiveMessage $receiveMessage): ReplyMessage {
    return new Text("收到一条未处理消息:");
});
//点击菜单事件
$officialAccount->HandleService->register(function (Click $click) {
    return new Text("您点击了菜单," . $click->EventKey);
});
$officialAccount->HandleService->register(function (ScanCodeWaitMsg $click) use ($officialAccount) {
    return new Text("扫码等待消息" . json_encode(Request::param()));
});

// 下面这些不能回复消息，回了也没反应，可以主动发送消息
//打开地图选择器事件
$officialAccount->HandleService->register(function (LocationSelect $click) use ($officialAccount) {
    $officialAccount->CustomerService->sendMessage($click->FromUserName, new Text("您打开了地图选择器"));
});
//点击二选一图片菜单事件
$officialAccount->HandleService->register(function (PicPhotoOrAlbum $click) use ($officialAccount) {
    $officialAccount->CustomerService->sendMessage($click->FromUserName, new Text("您点击自由选择图片"));
});
//点击相册选择图片事件
$officialAccount->HandleService->register(function (PicWeixin $click) use ($officialAccount) {
    $officialAccount->CustomerService->sendMessage($click->FromUserName, new Text("您点击微信图片选择器"));
});
//点击直接拍照事件
$officialAccount->HandleService->register(function (PicSysPhoto $click) use ($officialAccount) {
    $officialAccount->CustomerService->sendMessage($click->FromUserName, new Text("您只能直接拍照"));
});
//扫码推送事件，会自动展示code内容或打开网页等
$officialAccount->HandleService->register(function (ScanCodePush $click) use ($officialAccount) {
    $officialAccount->CustomerService->sendMessage($click->FromUserName, new Text("扫码推送"));
});
//打开菜单的URL链接
$officialAccount->HandleService->register(function (View $click) use ($officialAccount) {
    $officialAccount->CustomerService->sendMessage($click->FromUserName, new Text("打开URL"));
});
//打开菜单关联的小程序
$officialAccount->HandleService->register(function (ViewMiniprogram $click) use ($officialAccount) {
    $officialAccount->CustomerService->sendMessage($click->FromUserName, new Text("打开小程序"));
});
//处理动作
try {
    $officialAccount->HandleService->handle();
} catch (Throwable $exception) {
    echo 'success';
}
