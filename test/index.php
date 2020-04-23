<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OAuth2.0测试</title>
</head>
<body>
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

use yanlongli\wechat\officialAccount\ServiceAccount;
use yanlongli\wechat\support\Config;
use yanlongli\wechat\WechatException;

include '../vendor/autoload.php';
Config::loadConfigFile(__DIR__ . '/config.php');

$officialAccount = new ServiceAccount(Config::get('config.'));
//var_dump($_SERVER);
//
//die();

//OAuth2
try {
    session_start();
    //用户静默授权获取openid
//    $_SESSION['openId'] = $officialAccount->OAuth2->getOpenid("https://wechat.yanlongli.com");
    // 获取 静默 code
    $_SESSION['code'] = $officialAccount->OAuth2->getCode(true, null, "https://wechat.yanlongli.com");
//    $_SESSION['ACCESS_TOKEN'] = $officialAccount->OAuth2->getAccessToken('071fSUGf0f0yKw1sq0If0IRaHf0fSUG5');
    var_dump($_SESSION);

} catch (WechatException $e) {
    throw $e;
}

?>

</body>
</html>
