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

use yanlongli\wechat\support\Curl;
use yanlongli\wechat\support\Json;
use yanlongli\wechat\WechatException;

/**
 * Class AccessTokenService 接口调用凭证
 * @package yanlongli\wechat\service
 */
class AccessToken extends Ability
{

    /**
     * @param bool $useCache
     * @return string
     * @throws WechatException
     */
    public function getAccessToken(bool $useCache = true)
    {
        $cachePath = './access_token/' . md5($this->app->appId);
        if ($useCache) {
            $expire_time = @filemtime($cachePath);
            if ($expire_time && $expire_time >= time()) {
                return file_get_contents($cachePath);
            }
        }

        //获取accessToken
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';
        $response = Curl::get(sprintf($url, $this->app->appId, $this->app->appSecret));
        $arr = Json::parseOrFail($response);
        $this->app->accessToken = $arr['access_token'];

        if (!is_dir($cachePath)) {
            mkdir(dirname($cachePath), 0777, true);
        }

        $_cache = fopen($cachePath, "w");
        fwrite($_cache, $this->app->accessToken);
        fclose($_cache);
        touch($cachePath, strtotime("+2 hours"));

        return $this->app->accessToken;
    }
}
