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

class JsService extends Api
{
    /**
     * 返回js sdk SignPackage
     *
     * [php] $signPackage = JsService::getSignPackage(); [/php]
     *
     * <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
     * <script>
     * wx.config({
     *     appId: '<?php echo $signPackage["appId"];?>',
     *     timestamp: <?php echo $signPackage["timestamp"];?>,
     *     nonceStr: '<?php echo $signPackage["nonceStr"];?>',
     *     signature: '<?php echo $signPackage["signature"];?>',
     *     jsApiList: [
     *         // 所有要调用的 API 都要加到这个列表中
     *         'onMenuShareAppMessage',
     *         'onMenuShareTimeline',
     *         'onMenuShareQQ',
     *         'onMenuShareWeibo',
     *
     *         //拍照或相册
     *         'chooseImage',
     *         //上传图片
     *         'uploadImage'
     *     ]
     * });
     * wx.ready(function () {
     *     // 在这里调用 API
     * });
     * </script>
     *
     * @return array
     */
    public static function getSignPackage(App $app, $url = null)
    {
        $jsapiTicket = static::getJsApiTicket($app);

        if (null === $url) {
            $url = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }

        $timestamp = time();
        $nonceStr = static::createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId" => static::getApi($app)->getAppId(),
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    /**
     * 公众号用于调用微信JS接口的临时票据
     *
     * http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html#.E9.99.84.E5.BD.951-JS-SDK.E4.BD.BF.E7.94.A8.E6.9D.83.E9.99.90.E7.AD.BE.E5.90.8D.E7.AE.97.E6.B3.95
     * jsapi_ticket 的type为jsapi (腾讯demo中的JSSDK.php代码中type为1 不知为何)
     * 卡券 api_ticket 的type为 wx_card
     *
     * @param string $type
     * @return string
     */
    public static function getJsApiTicket(App $app, $type = 'jsapi')
    {

        $cacheKey = static::getApi()->getAppId() . $type . 'jsapi_ticket';
        $ticket = Cache::get($cacheKey, false);

        if (false !== $ticket) {
            return $ticket;
        }

        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type={$type}&access_token=ACCESS_TOKEN";

        $data = static::request($url);

        $ticket = $data['ticket'];

        //jsapi_ticket的有效期为7200秒
        Cache::set($cacheKey, $ticket, $data['expires_in'] - 200);

        Log::debug('getJsApiTicket');

        return $ticket;
    }

    public static function createNonceStr($length = 16)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
}
