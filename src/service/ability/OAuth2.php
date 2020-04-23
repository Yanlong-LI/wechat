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

namespace yanlongli\wechat\service\ability;


use yanlongli\wechat\service\api\OAuth2 as OAuth2Api;
use yanlongli\wechat\WechatException;

class OAuth2 extends Ability
{

    /**
     * 自动获取用户信息流程
     * @param bool $openidOnly
     * @param string|null $domain
     * @return array
     * @throws WechatException
     */
    public function getUser(bool $openidOnly = false, ?string $domain = null)
    {
        return OAuth2Api::getUser($this->app, $openidOnly, $domain);
    }

    /**
     * 获取授权 Code
     * @param bool $openidOnly
     * @param string $state
     * @param string|null $domain 跳转URL 默认自动识别，CDN、反向代理、负载均衡等复杂网络可能无法正确识别域名，需要手动设定
     * @return string
     */
    public function getCode(bool $openidOnly = false, $state = OAuth2Api::STATE, ?string $domain = null): string
    {
        return OAuth2Api::getCode($this->app, $openidOnly, $state, $domain);
    }

    /**
     * 获取 OpenId
     * @param string|null $domain 跳转URL 默认自动识别，CDN、反向代理、负载均衡等复杂网络可能无法正确识别域名，需要手动设定
     * @return string
     * @throws WechatException
     */
    public function getOpenid(?string $domain = null): string
    {
        return OAuth2Api::getOpenid($this->app, $domain);
    }

    /**
     * 获取 access_token 通过 Code 获取 AccessToken
     * @param string $code
     * @return array
     * @throws WechatException
     */
    public function getAccessToken(string $code)
    {
        return OAuth2Api::getOAuthAccessToken($this->app, $code);
    }

    //刷新 access_token

    /**
     * 通过 refreshToken 换取 AccessToken
     * @param string $refreshToken
     * @return array
     * @throws WechatException
     */
    public function refreshAccessToken(string $refreshToken)
    {
        return OAuth2Api::refreshOAuthAccessToken($this->app, $refreshToken);
    }
    //拉取用户信息 https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN

    /**
     * 获取用户信息
     * @param string $openId 用户openid
     * @param string $accessToken 授权token
     * @param string $lang
     * @return array
     * @throws WechatException
     */
    public function getUserInfo(string $openId, string $accessToken, string $lang = UserManagement::LANG_ZH_CN)
    {
        return OAuth2Api::getOAuthUserInfo($this->app, $openId, $accessToken, $lang);
    }

    //检查access_token是否有效

    /**
     * 检验授权凭证（access_token）是否有效
     * @param string $accessToken
     * @param string $openId
     * @return array
     * @throws WechatException
     */
    public function checkAccessToken(string $openId, string $accessToken)
    {
        return OAuth2Api::checkAccessToken($this->app, $openId, $accessToken);
    }
}
