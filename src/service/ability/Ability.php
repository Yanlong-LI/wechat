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

namespace yanlongli\wechat\service\ability;

use yanlongli\wechat\App;

/**
 * Class Ability 能力抽象类
 * @package yanlongli\wechat\ability
 */
abstract class Ability
{

    public App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }


    //一次性订阅消息
    //todo 获取授权
    //todo 推送订阅模板消息到授权微信用户 https://api.weixin.qq.com/cgi-bin/message/template/subscribe?access_token=ACCESS_TOKEN
    //todo 获取微信公众号自动回复规则 https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Getting_Rules_for_Auto_Replies.html


    //智能接口
    //todo 语义理解

    //todo 提交语音
    //todo 获取语音识别结果
    //todo 微信翻译

    //ocr接口
    //todo 身份证识别接口
    //todo 银行卡识别接口
    //todo 行驶证识别接口
    //todo 驾驶证识别接口
    //todo 营业执照识别接口
    //todo 通用印刷体识别接口

    //图像处理
    //todo 二维码/条形码识别
    //todo 图片高清化接口
    //todo 图片智能裁剪接口


}
