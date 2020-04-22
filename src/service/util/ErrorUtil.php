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
 *   Date:   2020/4/21
 *   IDE:    PhpStorm
 *   Desc:   _
 */
declare(strict_types=1);

namespace yanlongli\wechat\service\util;


return [
    -1 => '系统繁忙，此时请开发者稍候再试',
    0 => '请求成功',
    40001 => 'AppSecret错误或者AppSecret不属于这个公众号，请开发者确认AppSecret的正确性',
    40002 => '请确保grant_type字段值为client_credential',
    40164 => '调用接口的IP地址不在白名单中，请在接口IP白名单中进行设置。（小程序及小游戏调用不要求IP地址在白名单内。）',
    89503 => '此IP调用需要管理员确认,请联系管理员',
    89501 => '此IP正在等待管理员确认,请联系管理员',
    89506 => '24小时内该IP被管理员拒绝调用两次，24小时内不可再使用该IP调用',
    89507 => '1小时内该IP被管理员拒绝调用一次，1小时内不可再使用该IP调用',

    45072 => 'command字段取值不对',
    45080 => '下发输入状态，需要之前30秒内跟用户有过消息交互',
    45081 => '已经在输入状态，不可重复下发',

    65400 => 'API不可用，即没有开通/升级到新版客服功能',
    65401 => '无效客服帐号',
    65403 => '客服昵称不合法',
    65404 => '客服帐号不合法',
    65405 => '帐号数目已达到上限，不能继续添加',
    65406 => '已经存在的客服帐号',
    65407 => '邀请对象已经是该公众号客服',
    65408 => '本公众号已经有一个邀请给该微信',
    65409 => '无效的微信号',
    65410 => '邀请对象绑定公众号客服数达到上限（目前每个微信号可以绑定5个公众号客服帐号）',
    65411 => '该帐号已经有一个等待确认的邀请，不能重复邀请',
    65412 => '该帐号已经绑定微信号，不能进行邀请',
    40005 => '不支持的媒体类型',
    40009 => '媒体文件长度不合法',
];
