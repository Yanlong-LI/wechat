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

namespace yanlongli\wechat\ability;

use ReflectionException;
use ReflectionFunction;
use yanlongli\wechat\messaging\contract\ReplyMessage;
use yanlongli\wechat\messaging\receive\EventMessage;
use yanlongli\wechat\messaging\receive\ReceiveMessage;
use yanlongli\wechat\miniProgram\MiniProgram;
use yanlongli\wechat\officialAccount\OfficialAccount;
use yanlongli\wechat\sdk\WXBizMsgCrypt;
use yanlongli\wechat\support\Json;
use yanlongli\wechat\support\Request;
use yanlongli\wechat\support\Xml;
use yanlongli\wechat\WechatException;

/**
 * Class Service 服务监听能力 监听客服消息、公众号消息、事件消息
 * @package yanlongli\wechat
 */
abstract class HandleService extends Ability
{
    //加密类型
    const ENCRYPT_TYPE_RAW = 'raw';
    const ENCRYPT_TYPE_AES = 'aes';


    /**
     * @var array $handles 事件集合
     */
    protected array $handles = [];

    protected bool $stopPropagation = false;


    /**
     * @var ReceiveMessage
     */
    protected ReceiveMessage $receiveMessage;

    //当次请求的加密方式，对应ENCRYPT_TYPE_XX常量
    /**
     * @var string self::ENCRYPT_TYPE_RAW|self::ENCRYPT_TYPE_AES
     */
    protected ?string $encryptType = null;

    /**
     * 验证签名验证
     * @return bool
     */
    protected function checkSignature(): bool
    {
        $tmpArr = array($this->app->accessToken, Request::param('timestamp'), Request::param('nonce'));
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        return Request::param('signature') === $tmpStr;
    }

    /**
     * 处理首次配置
     * @return bool
     */
    protected function handleFirstOption(): bool
    {
        //先处理签名验证
        if (Request::has('echostr') && Request::has('nonce')) {
            return $this->checkSignature();
        }
        return true;
    }

    /**
     * 注册事件处理函数
     * @param callable $function
     * @throws ReflectionException
     * @see 没有优先级控制，请按照先后顺序进行注册
     */
    public function register(callable $function): void
    {
        $reflection = new ReflectionFunction($function);
        $params = $reflection->getParameters();

        if (!$params[0]->getClass()->hasConstant("TYPE")) {
            $this->handles[''][] = $function;
            return;
        }

        $type = $params[0]->getClass()->getConstant("TYPE");
        if ($type === EventMessage::TYPE) {
            if (!$params[0]->getClass()->hasConstant("EVENT")) {
                $this->handles[$type][''][] = $function;
                return;
            }
            $event = $params[0]->getClass()->getConstant("EVENT");
            $this->handles[$type][$event][] = $function;
        } else {
            $this->handles[$type][] = $function;
        }
    }

    /**
     * 处理动作
     * @see 该方法会终止继续执行 die()
     */
    public function handle(): void
    {
        //处理首次请求验证
        if (!$this->handleFirstOption()) {
            die('signature error');
        }

        //如果识别出是加密才会进行解析等操作
        if ($this->attemptIsEncrypt()) {
            // 这里不一定就是xml传输 还可能是json传输
            $xmlStr = $this->attemptDecrypt(file_get_contents('php://input'));
            Request::setParams(Request::xmlToArray($xmlStr));
        }
        $MsgType = Request::param('MsgType/s');
        $Event = Request::param('Event/s');
        $EventKey = Request::param('EventKey/s');


        $this->receiveMessage = ReceiveMessage::build($MsgType, $Event, $EventKey);

        //赋值处理
        $this->receiveMessage->setAttr(Request::param());

        $handles = [];
        //处理事件消息
        if (EventMessage::TYPE === $MsgType) {
            if (isset($this->handles[EventMessage::TYPE][$Event])) {
                $handles = $this->handles[EventMessage::TYPE][$Event];
            } elseif (isset($this->handles[EventMessage::TYPE][''])) {
                $handles = $this->handles[EventMessage::TYPE][''];
            } elseif (isset($this->handles[''])) {
                $handles = $this->handles[''];
            }
        } elseif (isset($this->handles[$MsgType])) {
            if (isset($this->handles[$MsgType])) {
                $handles = $this->handles[$MsgType];
            } elseif (isset($this->handles[''])) {
                $handles = $this->handles[''];
            }
        }

        foreach ($handles as $key => $handle) {
            if (!$this->receiveMessage->isPropagationStopped()) {
                $replayMessage = call_user_func($handle, $this->receiveMessage);
                if (!$this->receiveMessage->isPropagationStopped()) {
                    $this->receiveMessage->sendMessage($replayMessage);
                }
            }
        }

        //处理默认动作
        echo $this->buildReply();
        //结束
    }

    /**
     * 构造响应xml字符串，用于微信服务器请求时被动响应
     * @return string
     * @throws WechatException
     */
    public function buildReply()
    {
        //回复的消息为NoReply，会返回给微信一个"success"，微信服务器不会对此作任何处理，并且不会发起重试
        if (is_null($this->receiveMessage->getReplyMessage())) {
            return 'success';
        }

        if (!$this->receiveMessage->getReplyMessage() instanceof ReplyMessage) {
            throw new WechatException('Argument ReplyMessage must implement interface ReplyMessage');
        }


        $data = array(
            'ToUserName' => $this->receiveMessage->FromUserName,
            'FromUserName' => $this->receiveMessage->ToUserName,
            'CreateTime' => time(),
            'MsgType' => $this->receiveMessage->getReplyMessage()->type(),
        );

        $data = array_merge($data, $this->receiveMessage->getReplyMessage()->xmlData());

        if ($this->app instanceof OfficialAccount) {

            $data = Xml::build($data);
        } else if ($this->app instanceof MiniProgram) {
            $data = Json::encode($data);
        }

        return $this->attemptEncrypt($data);

    }

    /**
     * @return bool
     */
    protected function attemptIsEncrypt()
    {
        //加密类型
        if (null === $this->encryptType) {
            $this->encryptType = (isset($_GET['encrypt_type']) && (static::ENCRYPT_TYPE_AES === $_GET['encrypt_type'])) ? static::ENCRYPT_TYPE_AES : static::ENCRYPT_TYPE_RAW;
        }
        return static::ENCRYPT_TYPE_AES === $this->encryptType;
    }

    /**
     * 尝试解密数据，从$_GET['encrypt_type']中获取加密类型，如果未加密，原样返回
     * @param string $message
     * @return string
     * @throws WechatException
     */
    protected function attemptDecrypt($message)
    {
        //加密类型
        if (null === $this->encryptType) {
            $this->encryptType = (isset($_GET['encrypt_type']) && (static::ENCRYPT_TYPE_AES === $_GET['encrypt_type'])) ? static::ENCRYPT_TYPE_AES : static::ENCRYPT_TYPE_RAW;
        }

        //未加密,原样返回
        if (static::ENCRYPT_TYPE_RAW === $this->encryptType) {
            return $message;
        }

        $timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : '';
        $nonce = isset($_GET['nonce']) ? $_GET['nonce'] : '';
        $msgSignature = isset($_GET['msg_signature']) ? $_GET['msg_signature'] : '';

        //解密
        if (static::ENCRYPT_TYPE_AES === $this->encryptType) {
            return $this->decryptMsg($msgSignature, $timestamp, $nonce, $message);
        }

        throw new WechatException('unknown encrypt type: ' . $this->encryptType);
    }


    /**
     * 解密
     * @param string $msgSignature
     * @param string $timestamp
     * @param string $nonce
     * @param string $encryptMsg
     * @return string
     * @throws WechatException
     */
    protected function decryptMsg($msgSignature, $timestamp, $nonce, $encryptMsg)
    {
        $msg = '';

        //传入公众号第三方平台的token（申请公众号第三方平台时填写的接收消息的校验token）, 公众号第三方平台的appid, 公众号第三方平台的 EncodingAESKey（申请公众号第三方平台时填写的接收消息的加密symmetric_key）
        $pc = new WXBizMsgCrypt($this->app->token, $this->app->encodingAesKey, $this->app->appId);

        // 第三方收到公众号平台发送的消息
        $errCode = $pc->decryptMsg($msgSignature, $timestamp, $nonce, $encryptMsg, $msg);

        if (0 === $errCode) {

            return $msg;
        }

        throw new WechatException('decrypt msg error. error code ' . $errCode);
    }

    /**
     * 对响应给微信服务器的消息进行加密，自动识别是否需要加密，本次请求未加密时，数据原样返回
     * @param string $message
     * @return string
     * @throws WechatException
     */
    protected function attemptEncrypt($message)
    {
        //请求未加密时，回复明文内容
        if (static::ENCRYPT_TYPE_RAW === $this->encryptType) {
            return $message;
        }

        //加密
        if (static::ENCRYPT_TYPE_AES === $this->encryptType) {
            $timestamp = time();
            $nonce = uniqid();
            return $this->encryptMsg($message, $timestamp, $nonce);
        }

        throw new WechatException('unknown encrypt type: ' . $this->encryptType);
    }

    /**
     * 解密
     * @param $replyMsg
     * @param $timestamp
     * @param $nonce
     * @return string
     * @throws WechatException
     */
    protected function encryptMsg($replyMsg, $timestamp, $nonce)
    {
        $msg = '';

        //传入公众号第三方平台的token（申请公众号第三方平台时填写的接收消息的校验token）, 公众号第三方平台的appid, 公众号第三方平台的 EncodingAESKey（申请公众号第三方平台时填写的接收消息的加密symmetric_key）
        $pc = new WXBizMsgCrypt($this->app->token, $this->app->encodingAesKey, $this->app->appId);

        //第三方收到公众号平台发送的消息
        $errCode = $pc->encryptMsg($replyMsg, $timestamp, $nonce, $msg);

        if (0 === $errCode) {
            return $msg;
        }
        throw new WechatException('encrypt msg error. error code ' . $errCode);
    }
}
