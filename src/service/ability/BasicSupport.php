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
 *   Desc:   基础支持
 */
declare(strict_types=1);

namespace yanlongli\wechat\service\ability;

use yanlongli\wechat\service\api\AccessToken;
use yanlongli\wechat\service\api\BasicInformation;
use yanlongli\wechat\WechatException;

class BasicSupport extends Ability
{
    public const CHECK_ACTION_ALL = BasicInformation::CHECK_ACTION_ALL;
    public const CHECK_ACTION_DNS = BasicInformation::CHECK_ACTION_ALL;
    public const CHECK_ACTION_PING = BasicInformation::CHECK_ACTION_ALL;
    public const CHECK_OPERATOR_CHINANET = BasicInformation::CHECK_ACTION_ALL;
    public const CHECK_OPERATOR_UNICOM = BasicInformation::CHECK_ACTION_ALL;
    public const CHECK_OPERATOR_CAP = BasicInformation::CHECK_ACTION_ALL;
    public const CHECK_OPERATOR_DEFAULT = BasicInformation::CHECK_ACTION_ALL;
    protected string $accessToken;
    protected int $expiresIn;

    /**
     * 获取AccessToken
     * @param bool $useCache 是否可读缓存
     * @return false|string
     * @throws WechatException
     */
    public function getAccessToken(bool $useCache = true)
    {
        $cachePath = './access_token/' . md5($this->app->appId);
        if ($useCache) {

            if (isset($this->accessToken)) {
                return $this->accessToken;
            }

            $expire_time = @filemtime($cachePath);
            if ($expire_time && $expire_time >= time()) {
                return file_get_contents($cachePath);
            }
        }
        $accessToken = AccessToken::getAccessToken($this->app);

        $this->setAccessToken($accessToken);

        if (!is_dir($cachePath) || !file_exists($cachePath)) {
            mkdir(dirname($cachePath), 0777, true);
        }

        $_cache = fopen($cachePath, "w");
        fwrite($_cache, $accessToken);
        fclose($_cache);
        touch($cachePath, strtotime("+2 hours"));

        return $accessToken;
    }

    protected function setAccessToken(string $accessToken, int $expireIn = 7200)
    {
        $this->accessToken = $accessToken;
        $this->expiresIn = $expireIn;
    }

    /**
     * 获取微信callback IP地址
     * @throws WechatException
     */
    public function getTheWeChatServerIPAddress()
    {
        return BasicInformation::getCallbackIP($this->app);
    }

    /**
     * 网络检测
     * @param string $action
     * @param string $operator
     * @return array
     * @throws WechatException
     */
    public function callbackCheck(string $action = self::CHECK_ACTION_ALL, string $operator = self::CHECK_OPERATOR_DEFAULT)
    {
        return BasicInformation::callbackCheck($this->app);
    }
}
