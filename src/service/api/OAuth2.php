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

namespace yanlongli\wechat\service\api;


use yanlongli\wechat\App;
use yanlongli\wechat\WechatException;

/**
 * Class OAuthService OAuth
 * @package yanlongli\wechat\ability
 */
class OAuth2 extends Api
{

    /**
     * 获取微信用户openid,此方法会跳转到微信授权页面获取用户授权然后返回
     * 在ajax中调用本方法无效，url中请勿包含code和state查询参数
     *
     * 请先填写授权回调页面域名
     * https://mp.weixin.qq.com 开发>接口权限>网页服务>网页账号>网页授权获取用户基本信息>授权回调页面域名
     *
     * @param App $app
     * @param string|null $domain 跳转URL 默认自动识别，CDN、反向代理、负载均衡等复杂网络可能无法正确识别域名，需要手动设定
     * @return string
     * @throws WechatException
     */
    public static function getOpenid(App $app, ?string $domain = null)
    {
        return self::getUser($app, true, $domain)['openid'];
    }

    /**
     * 公众号基于网页的全自动获取用户信息
     * 获取微信用户信息,此方法会跳转到微信授权页面获取用户授权然后返回
     * 在ajax中调用本方法无效，url中请勿包含code和state查询参数
     *
     * @param App $app
     * @param bool|false $openidOnly 此参数为true时，仅返回openid 响应速度会更快，并且不需要用户点击同意授权
     * @param string|null $domain 跳转URL 默认自动识别，CDN、反向代理、负载均衡等复杂网络可能无法正确识别域名，需要手动设定
     * @return array
     * @throws WechatException
     */
    public static function getUser(App $app, bool $openidOnly = false, ?string $domain = null): array
    {
        $state = self::STATE;
        $code = self::getCode($app, $openidOnly, $state, $domain);

        //通过code换取网页授权access_token
        $OauthAccessTokenArr = self::getOAuthAccessToken($app, $code);

        if ($openidOnly) {
            return $OauthAccessTokenArr;
        }

        //拉取用户信息(需scope为 snsapi_userinfo)
        return self::getOAuthUserInfo($app, $OauthAccessTokenArr['openid'], $OauthAccessTokenArr['access_token']);
    }


    const STATE = 'YANLONGLI_WECHAT';

    /**
     * OAuth2 获取 Code 移动授权获取用户基本信息 流程第1.2步 授权后返回获取code
     * @param App $app
     * @param bool $openidOnly
     * @param string $state
     * @param string|null $domain 跳转URL 默认自动识别，CDN、反向代理、负载均衡等复杂网络可能无法正确识别域名，需要手动设定
     * @return string
     */
    public static function getCode(App $app, bool $openidOnly = false, ?string $state = self::STATE, ?string $domain = null): string
    {
        $sessionCacheKey = 'access_code_' . $state;
        //重新修正state
        if ($state === null) {
            $state = self::STATE;
        }

        if ($domain === null) {
            if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
                $proto = strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']);
            } else {
                $proto = isset($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']) ? 'https' : 'http';
            }
            //当前url
            $domain = $proto . '://' . $_SERVER['HTTP_HOST'];
        }
        $domain .= $_SERVER['REQUEST_URI'];
        // 开启 session
        if (!session_id()) session_start();
        // 已授权
        if (isset($_GET['code']) && isset($_GET['state']) && $state === $_GET['state']) {
            $_SESSION[$sessionCacheKey] = $_GET['code'];
            //第三次重定向
            self::redirect(self::urlClean($domain));
        }
        //最终返回授权code
        if (isset($_SESSION[$sessionCacheKey])) {
            // 读取授权code
            $code = $_SESSION[$sessionCacheKey];
            // 删除 session 缓存
            unset($_SESSION[$sessionCacheKey]);
            // 返回 授权 code
            return $code;
        }
        //授权后跳转地址
        $uri = self::urlClean($domain);

        //跳转到微信授权url
        self::getOAuthAuthorizeUrl($app, $uri, $state, $openidOnly ? 'snsapi_base' : 'snsapi_userinfo');
        exit();
    }

    /**
     * 移动授权获取用户基本信息 流程第2步 通过code换取APP授权access_token
     * 网页授权获取用户基本信息 流程第2步 通过code换取网页授权access_token
     * @param App $app
     * @param string $code
     * @return array
     * [
     *      "access_token"=>"ACCESS_TOKEN",
     *      "expires_in"=>7200,    //access_token接口调用凭证超时时间，单位（秒）
     *      "refresh_token"=>"REFRESH_TOKEN",
     *      "openid"=>"OPENID",
     *      "scope"=>"SCOPE"
     * ]
     * @throws WechatException
     */
    public static function getOAuthAccessToken(App $app, string $code)
    {

        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$app->appId}&secret={$app->appSecret}&code={$code}&grant_type=authorization_code";

        return self::request($app, $url);
    }

    /**
     * 网页授权获取用户基本信息 流程第4步 拉取用户信息
     * @param App $app
     * @param string $openId
     * @param string $accessToken
     * @param string $lang
     * @return array
     * [
     *    'openid'      //用户的唯一标识
     *    'nickname'    //用户昵称
     *    'sex'         //用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
     *    'province'    //用户个人资料填写的省份
     *    'city'        //普通用户个人资料填写的城市
     *    'country'     //国家，如中国为CN
     *    'headimgurl'  //用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），用户没有头像时该项为空
     * ]
     * @throws WechatException
     */
    public static function getOAuthUserInfo(App $app, string $openId, string $accessToken, string $lang = UserManagement::LANG_ZH_CN)
    {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$accessToken}&openid={$openId}&lang=$lang";
        return self::request($app, $url);
    }

    /**
     * 从url中移除code参数 例如 http://www.test.com?/oauth?code=1234&params=11 将返回 http://www.test.com?/oauth?params=11
     * @param string $uri
     * @param array $remove
     * @return string
     */
    private static function urlClean(string $uri, array $remove = ['state', 'code'])
    {
        $arr = parse_url($uri);

        if (isset($arr['query'])) {
            parse_str($arr['query'], $temp);

            foreach ($remove as $v) {
                if (array_key_exists($v, $temp)) {
                    unset($temp[$v]);
                }
            }

            if (count($temp) === 0) {
                unset($arr['query']);
            } else {
                $arr['query'] = http_build_query($temp);
            }
        }

        $arr['path'] = array_key_exists('path', $arr) ? $arr['path'] : '';
        $arr['query'] = array_key_exists('query', $arr) ? ('?' . $arr['query']) : '';

        return $arr['scheme'] . '://' . $arr['host'] . $arr['path'] . $arr['query'];
    }

    /**
     * 跳转到微信平台，让用户同意授权，获取code
     * @param $url
     */
    protected static function redirect($url): void
    {
        header('Location: ' . $url);
        exit;
    }

    /**
     * 网页授权获取用户基本信息 流程第1步 引导用户进入授权页面的Url (用户允许后，获取code)
     * @param App $app
     * @param string $redirectUri 授权后重定向的回调链接地址
     * @param string $state 重定向后会带上state参数，开发者可以填写a-zA-Z0-9的参数值
     * @param string $scope 应用授权作用域，snsapi_base （不弹出授权页面，直接跳转，只能获取用户openid），snsapi_userinfo（弹出授权页面，可通过openid拿到昵称、性别、所在地。并且，即使在未关注的情况下，只要用户授权，也能获取其信息）
     * @return string
     */
    protected static function getOAuthAuthorizeUrl(App $app, string $redirectUri, string $state = '0', string $scope = 'snsapi_userinfo')
    {
        //通过一个中间url
        $middleUrl = $app->middleUrl;
        if (null !== $middleUrl) {
            $redirectUri = $middleUrl . ((false === strpos($middleUrl, '?')) ? '?' : '&') . 'url=' . urlencode($redirectUri);
        }

        $redirectUri = urlencode($redirectUri);

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$app->appId}&redirect_uri={$redirectUri}&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
        self::redirect($url);
        exit;
    }

    /**
     * 网页授权获取用户基本信息 流程第3步 刷新access_token（如果需要）
     * @param App $app
     * @param $refreshToken
     * @return array
     * @throws WechatException
     */
    public static function refreshOAuthAccessToken(App $app, $refreshToken)
    {
        $url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid={$app->appId}&grant_type=refresh_token&refresh_token={$refreshToken}";
        return self::request($app, $url);
    }

    /**
     * 小程序登录 code换取 session_key 和 openid
     *
     * 返回 ['openid'=>'', 'session_key'=>'']
     * @param App $app
     * @param string $code
     * @return mixed
     * @throws WechatException
     */
    public static function code2Session(App $app, string $code)
    {
        //小程序配置信息
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid={$app->appId}&secret={$app->appSecret}&js_code={$code}&grant_type=authorization_code";
        $result = self::request($app, $url);

        if (!array_key_exists('openid', $result)) {
            throw new WechatException($result['errmsg'], $result['errcode']);
        }

        return $result;
    }

    /**
     * 检验授权凭证（access_token）是否有效
     * @param App $app
     * @param string $accessToken
     * @param string $openId
     * @return array
     * @throws WechatException
     */
    public static function checkAccessToken(App $app, string $openId, string $accessToken)
    {
        $url = "https://api.weixin.qq.com/sns/auth?access_token=$accessToken&openid=$openId";
        return self::request($app, $url);
    }
}
