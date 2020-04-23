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

namespace yanlongli\wechat\service\api;

use yanlongli\wechat\App;
use yanlongli\wechat\messaging\contract\CallMessage;
use yanlongli\wechat\messaging\contract\MassMessage;
use yanlongli\wechat\messaging\message\Typing;
use yanlongli\wechat\WechatException;

/**
 * Trait CallMessageService 客服服务
 * @package yanlongli\wechat\service
 */
class MessageService extends Api
{
    const Typing = 'Typing';
    const CancelTyping = 'CancelTyping';
    const MSG_STATUS_SEND_SUCCESS = 'SEND_SUCCESS';
    const MSG_STATUS_SENDING = 'SENDING';
    const MSG_STATUS_SEND_FAIL = 'SEND_FAIL';
    const MSG_STATUS_DELETE = 'DELETE';
    const SPEED_80W = 0;
    const SPEED_60W = 1;
    const SPEED_45W = 2;
    const SPEED_30W = 3;
    const SPEED_10W = 4;

    /**
     * 客服消息接口，主动给粉丝发消息。当用户和公众号产生特定动作的交互的48小时内有效。
     * @param App $app
     * @param string $openid
     * @param CallMessage $message
     * @param string $account 客服帐号(显示客服自定义头像)
     * @return array
     * @throws WechatException
     */
    public static function sendMessage(App $app, string $openid, CallMessage $message, string $account = null)
    {
        $data = $message->jsonData();
        $type = $message->type();

        $message = array(
            'touser' => $openid,
            'msgtype' => $type,
        );

        $data = array_merge($message, $data);

        if ($account != null) {
            $data['customservice'] = array('kf_account' => $account);
        }

        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=ACCESS_TOKEN';

        return self::request($app, $url, $data);
    }

    /**
     * 打字状态下发
     * @param App $app
     * @param string $openid
     * @param Typing $message
     * @param string $account 客服帐号(显示客服自定义头像)
     * @return array
     * @throws WechatException
     */
    public static function Typing(App $app, string $openid, Typing $message, string $account = null)
    {
        $type = $message->type();
        $data = array(
            'touser' => $openid,
            'command' => $type,
        );

        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/typing?access_token=ACCESS_TOKEN';

        return self::request($app, $url, $data);
    }

    /**
     * 高级群发 根据分组进行群发 【订阅号与服务号认证后均可用】
     * 对于认证订阅号，群发接口每天可成功调用1次，此次群发可选择发送给全部用户或某个分组；
     * 对于认证服务号虽然开发者使用高级群发接口的每日调用限制为100次，但是用户每月只能接收4条，无论在公众平台网站上，
     * 还是使用接口群发，用户每月只能接收4条群发消息，多于4条的群发将对该用户发送失败；
     * 具备微信支付权限的公众号，在使用群发接口上传、群发图文消息类型时，可使用<a>标签加入外链；
     * 可以使用预览接口校对消息样式和排版，通过预览接口可发送编辑好的消息给指定用户校验效果。
     *
     * 关于群发时使用is_to_all为true使其进入公众号在微信客户端的历史消息列表：
     * 1、使用is_to_all为true且成功群发，会使得此次群发进入历史消息列表。2、为防止异常，认证订阅号在一天内，只能使用is_to_all为true进行群发一次，或者在公众平台官网群发（不管本次群发是对全体还是对某个分组）一次。以避免一天内有2条群发进入历史消息列表。
     * 3、类似地，服务号在一个月内，使用is_to_all为true群发的次数，加上公众平台官网群发（不管本次群发是对全体还是对某个分组）的次数，最多只能是4次。
     * 4、设置is_to_all为false时是可以多次群发的，但每个用户只会收到最多4条，且这些群发不会进入历史消息列表。
     *
     * @param App $app
     * @param int $tagId
     * @param MassMessage $message
     * @param bool $isToAll 选择true该消息群发给所有用户
     * @return array
     * @throws WechatException
     */
    public static function sendAll(App $app, MassMessage $message, ?int $tagId = null, bool $isToAll = false)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=ACCESS_TOKEN';
        $data = array(
            'filter' => array('is_to_all' => (bool)$isToAll, 'tag_id' => $tagId),
        );
        if ($isToAll) {
            unset($data['filter']['tag_id']);
        }

        $data = array_merge($data, $message->jsonData());
        $data['msgtype'] = $message->type();

        return self::request($app, $url, $data);
    }

    /**
     * 根据OpenID列表群发
     * @param App $app
     * @param array $openIds
     * @param MassMessage $message
     * @return array
     * @throws WechatException
     */
    public static function sendAllWithOpenIds(App $app, array $openIds, MassMessage $message)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=ACCESS_TOKEN';
        $data = [
            'touser' => $openIds,
        ];
        $data = array_merge($data, $message->jsonData());
        $data['msgtype'] = $message->type();

        return self::request($app, $url, $data);
    }

    /**
     * 查询群发消息发送状态
     * @param App $app
     * @param int $msgId
     * @return array
     * @throws WechatException
     */
    public static function getMassStatus(App $app, int $msgId)
    {
        $postData = [
            'msg_id' => $msgId
        ];
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/get?access_token=ACCESS_TOKEN';
        return self::request($app, $url, $postData);
    }

    /**
     * 删除群发
     * @param App $app
     * @param string $msgId
     * @return array
     * @throws WechatException
     */
    public static function delete(App $app, string $msgId)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/delete?access_token=ACCESS_TOKEN';
        return self::request($app, $url, array('msg_id' => $msgId));
    }

    /**
     * 预览(发给某个openid)
     * @param App $app
     * @param string $openId
     * @param MassMessage $message
     * @return array
     * @throws WechatException
     */
    public static function previewWithOpenId(App $app, string $openId, MassMessage $message)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=ACCESS_TOKEN';

        $data = array(
            'touser' => $openId,
        );

        $data = array_merge($data, $message->jsonData());
        $data['msgtype'] = $message->type();

        return self::request($app, $url, $data);
    }

    /**
     * 预览(发给某个微信号)
     * @param App $app
     * @param string $wxname
     * @param MassMessage $message
     * @return array
     * @throws WechatException
     */
    public static function previewWithWxname(App $app, string $wxname, MassMessage $message)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=ACCESS_TOKEN';
        $data = array(
            'towxname' => $wxname,
        );

        $data = array_merge($data, $message->jsonData());
        $data['msgtype'] = $message->type();

        return self::request($app, $url, $data);
    }

    /**
     * 查询群发消息发送状态
     * @param App $app
     * @param string $msgId
     * @return array
     * @throws WechatException
     */
    public static function status(App $app, string $msgId)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/get?access_token=ACCESS_TOKEN';
        return self::request($app, $url, array('msg_id' => $msgId));
    }

    /**
     * 获取群发速度
     * @param App $app
     * @return array
     * @throws WechatException
     */
    public static function getMassSpeed(App $app)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/speed/get?access_token=ACCESS_TOKEN';
        return self::request($app, $url);
    }

    /**
     * 设置群发速度
     * @param App $app
     * @param int $speed speed    0    80w/分钟    1    60w/分钟    2    45w/分钟    3    30w/分钟    4    10w/分钟
     * @return array
     * @throws WechatException
     */
    public static function setMassSpeed(App $app, int $speed = self::SPEED_80W)
    {
        $postData = [
            'speed' => $speed
        ];
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/speed/get?access_token=ACCESS_TOKEN';
        return self::request($app, $url, $postData);
    }

    public static function getCurrentAutoReplyInfo(App $app)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/get_current_autoreply_info?access_token=ACCESS_TOKEN';
        return self::request($app, $url);
    }
}
