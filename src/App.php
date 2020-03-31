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

namespace yanlongli\wechat;


use yanlongli\wechat\ability\Ability;
use yanlongli\wechat\ability\AccessToken;
use yanlongli\wechat\service\Client;

/**
 * Class App
 * @package yanlongli\wechat
 * @property AccessToken $AccessToken
 */
abstract class App
{
    use Client;

    /**
     * 应用id
     * @var string
     */
    public string $appId;

    /**
     * 原始ID
     * @var string
     */
    public string $id;

    //加密类型
    const ENCRYPT_TYPE_RAW = 'raw';
    const ENCRYPT_TYPE_AES = 'aes';

    /**
     * @var string
     */
    public ?string $appSecret;
    /**
     * @var string 服务器配置令牌
     */
    public ?string $token;
    /**
     * @var string 消息加解密密钥
     */
    public ?string $encodingAesKey;
    public ?string $encodingAesKeyLast;
    public ?string $middleUrl;

    public ?string $accessToken = '';

    /**
     * @var array
     */
    protected array $ability = [
        'AccessToken' => AccessToken::class
    ];

    /**
     * 应用名称
     * @var string
     */
    public string $name;


    /**
     * 构造方法 可以使用一个数组作为参数
     * @param array|string $appId
     * @param string $appSecret
     * @param string $token
     * @param string $encodingAesKey
     * @param string $encodingAesKeyLast
     * @param string $middleUrl
     */
    public function __construct($appId, string $appSecret = null, string $token = null, string $encodingAesKey = null, string $encodingAesKeyLast = null, string $middleUrl = null)
    {
        if (is_array($appId)) {
            extract($appId, EXTR_OVERWRITE);
        }

        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->token = $token;
        $this->encodingAesKey = $encodingAesKey;
        $this->encodingAesKeyLast = $encodingAesKeyLast;
        $this->middleUrl = $middleUrl;

        //注册到 Wechat 中
        Wechat::addApp($this);

    }

    /**
     * @param bool $useCache
     * @return string
     * @throws WechatException
     */
    public function getAccessToken(bool $useCache = true)
    {
        if ($useCache && $this->accessToken) {
            return $this->accessToken;
        }
        return $this->AccessToken->getAccessToken($useCache);
    }


    /**
     * @param $name
     * @return mixed|null
     * @throws WechatException
     */
    public function __get($name)
    {
        /**
         * @var Ability $ability
         */
        $ability = $this->ability[$name] ?? null;
        if (is_object($ability)) {
            return $ability;
        } else if (is_string($ability)) {
            return new $ability($this);
        }
        throw new WechatException("获取能力失败");
    }

    /**
     * 设置能力
     * @param $name
     * @param $ability
     * @throws WechatException
     */
    public function __set($name, $ability)
    {
        if (is_object($ability)) {
            $this->ability[$name] = $ability;
        } else if (is_string($ability)) {
            $this->ability[$name] = new $ability($this);
        }
        throw new WechatException("设定能力失败");
    }

}
