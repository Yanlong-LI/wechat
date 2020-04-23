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
 * 生成带参数的二维码
 * https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1443433542
 * @author  Zou Yiliang
 * @since   1.0
 */
class QRCode extends Api
{

    /**
     * 生成临时二唯码
     * @param App $app
     * @param int|string $sceneId
     *
     * 场景值ID 为整数时:32位非0整型, 建议大于100000,避免与永久二唯码冲突
     * 场景值ID（字符串形式的ID），字符串类型，长度限制为1到64
     *
     * @param int|null $expireSeconds
     * @return array
     * [
     *      'ticket'=>'gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9x',   //获取的二维码ticket，凭借此ticket可以在有效时间内换取二维码
     *      'expire_seconds'=>'60',                                         //该二维码有效时间，以秒为单位。 最大不超过2592000（即30天)
     *      'url'=>'http://weixin.qq.com/q/kZgfwMTm72WWPkovabbI',           //二维码图片解析后的地址，开发者可根据该地址自行生成需要的二维码图片
     * ]
     * @throws WechatException
     */
    public static function temporary(App $app, $sceneId, ?int $expireSeconds = null)
    {

        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=ACCESS_TOKEN';

        //0x7FFFFFFF 32位int最大值
        if (is_integer($sceneId) && $sceneId > 100000 && $sceneId <= 0x7FFFFFFF) {
            $data = array(
                'action_name' => 'QR_SCENE',
                'action_info' => array(
                    'scene' => array(
                        'scene_id' => $sceneId,
                    ),
                ),
            );
        } else {
            $data = array(
                'action_name' => 'QR_STR_SCENE',
                'action_info' => array(
                    'scene' => array(
                        'scene_str' => $sceneId,
                    ),
                ),
            );
        }

        if (null !== $expireSeconds) {
            $data['expire_seconds'] = $expireSeconds;
        }

        return self::request($app, $url, $data);
    }

    /**
     * 生成永久二唯码
     * @param App $app
     * @param int|string $sceneId 场景值ID 32位非0整型,最大值为100000,目前参数只支持1--100000; 字符串形式的ID，长度限制为1到64
     * @return array 返回值参考 QrcodeService::temporary()方法的返回值
     * @throws WechatException
     */
    public static function forever(App $app, $sceneId)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=ACCESS_TOKEN';

        if (is_integer($sceneId) && $sceneId >= 1 && $sceneId <= 100000) {
            $data = array(
                'action_name' => 'QR_LIMIT_SCENE',
                'action_info' => array(
                    'scene' => array(
                        'scene_id' => $sceneId,
                    ),
                ),
            );
        } else {
            $data = array(
                'action_name' => 'QR_LIMIT_STR_SCENE',
                'action_info' => array(
                    'scene' => array(
                        'scene_str' => $sceneId,
                    ),
                ),
            );
        }

        return self::request($app, $url, $data);
    }

    /**
     * 通过ticket换取二维码
     * @param string $ticket 获取二维码ticket后，用ticket换取二维码图片。本接口无须登录态即可调用
     * @return string 返回可用于 <img src="...">
     */
    public static function url(string $ticket)
    {
        return 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($ticket);
    }
}
