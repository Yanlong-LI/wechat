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

use yanlongli\wechat\service\ability\Ability;
use yanlongli\wechat\service\ability\BasicSupport;

/**
 * Class App
 * @package yanlongli\wechat
 * @property BasicSupport $BasicSupport 客服消息能力
 */
abstract class App
{

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

//    public ?string $accessToken = '';

    /**
     * @var array
     */
    protected array $ability = [
        'BasicSupport' => BasicSupport::class
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
            $this->ability[$name] = new $ability($this);
            return $this->ability[$name];
        }
        throw new WechatException("App 初始化功能 $name 失败");
    }

    /**
     * 设置能力
     * @param $name
     * @param $ability
     */
    public function __set($name, $ability)
    {
        $this->ability[$name] = $ability;
    }


    /**
     * 添加能力
     * @param array|string $abilityName
     * @param string|object|null $ability
     * @throws WechatException
     */
    public function addAbility($abilityName, $ability = null)
    {
        if (is_string($abilityName)) {
            $ability = [
                basename(str_replace('\\', '/', $abilityName)) => $ability
            ];
        } elseif (is_array($abilityName)) {
            $ability = [];
            // 获取基础名称 我比较懒
            foreach ($abilityName as $_name => $_ability) {
                $ability[basename(str_replace('\\', '/', $_name))] = $_ability;
            }
        } else {
            throw new WechatException("App 启用功能必须是功能对象或功能类");
        }

        $this->ability += $ability;
    }

}
