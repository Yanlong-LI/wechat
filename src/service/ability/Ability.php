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
    //图文消息留言管理
    //todo 打开已群发文章评论
    //https://developers.weixin.qq.com/doc/offiaccount/Comments_management/Image_Comments_Management_Interface.html
    //todo 关闭已群发文章评论
    //https://developers.weixin.qq.com/doc/offiaccount/Comments_management/Image_Comments_Management_Interface.html
    //todo 查看指定文章的评论数据
    //https://developers.weixin.qq.com/doc/offiaccount/Comments_management/Image_Comments_Management_Interface.html
    //todo 评论标记为精选
    //https://developers.weixin.qq.com/doc/offiaccount/Comments_management/Image_Comments_Management_Interface.html
    //todo 评论取消精选
    //https://developers.weixin.qq.com/doc/offiaccount/Comments_management/Image_Comments_Management_Interface.html
    //todo 删除评论
    //todo 回复评论
    //todo 删除回复

    //一次性订阅消息
    //todo 获取授权
    //todo 推送订阅模板消息到授权微信用户 https://api.weixin.qq.com/cgi-bin/message/template/subscribe?access_token=ACCESS_TOKEN
    //todo 获取微信公众号自动回复规则 https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Getting_Rules_for_Auto_Replies.html

    //todo 数据统计
    //todo 获取用户增减数据
    //todo 获取累计用户数据
    //todo 获取图文群发每日数据
    //todo 获取图文群发总数据
    //todo 获取图文统计数据
    //todo 获取图文统计分时数据
    //todo 获取图文分享转发数据
    //todo 获取图文分享转发分时数据

    //todo 获取消息发送概况
    //todo 获取消息发送分时数据
    //todo 获取消息发送周数据
    //todo 获取消息发送月数据
    //todo 获取消息发送分布数据
    //todo 获取消息发送分布周数据
    //todo 获取消息发送分布月数据

    //todo 获取公众号广告汇总数据
    //todo 获取公众号返佣商品数据

    //todo 获取接口分析数据
    //todo 获取接口分析分时数据

    //todo 微信卡券  这个比较复杂

    //todo 微信门店 这个比较复杂

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
