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
 * Class UserManagement 用户管理
 * @package yanlongli\wechat\ability
 */
class UserManagement extends Api
{


    const LANG_ZH_CN = 'zh_CN';
    const LANG_ZH_TW = 'zh_TW';
    const LANG_EN = 'en';

    /**
     * 获取用户基本信息
     * @param App $app
     * @param string $openid
     * @param string $lang
     * @return array 数据如下
     *     [
     *          "subscribe": 1,  //用户是否订阅该公众号标识，值为0时，代表此用户没有关注该公众号，拉取不到其余信息
     *          "openid": "otvxTs4dckWG7imySrJd6jSi0CWE",
     *          "nickname": "iWithery",
     *          "sex": 1,  //用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
     *          "language": "zh_CN",
     *          "city": "Jieyang",
     *          "province": "Guangdong",
     *          "country": "China",
     *          "headimgurl": "http://wx.qlogo.cn/mmopen/xbIQx1GRqdvyqkMMhEaGOX802l1CyqMJNgUzKP8MeAeHFicRDSnZH7FY4XB7p8XHXIf6uJA2SCun
     *          TPicGKezDC4saKISzRj3nz/0",
     *          "subscribe_time": 1434093047,   //用户关注时间，为时间戳。如果用户曾多次关注，则取最后关注时间
     *          "unionid": "oR5GjjgEhCMJFyzaVZdrxZ2zRRF4",
     *          "remark": "",  //公众号运营者对粉丝的备注
     *          "groupid": 0,  //用户所在的分组ID（兼容旧的用户分组接口）
     *          "tagid_list":[128,2]  //用户被打上的标签ID列表
     *    ]
     * @throws WechatException
     */
    public static function get(App $app, string $openid, string $lang = self::LANG_ZH_CN)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=%s&lang=%s';
        $url = sprintf($url, $openid, $lang);

        return self::request($app, $url);
    }

    /**
     * 批量获取用户基本信息 最多支持一次拉取100条
     * @param App $app
     * @param array $openIds
     * @param string $lang
     * @return array 示例中为一次性拉取了2个openid的用户基本信息，第一个是已关注的，第二个是未关注的
     * [
     *      {
     *          "subscribe": 1,
     *          "openid": "otvxTs4dckWG7imySrJd6jSi0CWE",
     *          "nickname": "iWithery",
     *          "sex": 1,  //用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
     *          "language": "zh_CN",
     *          "city": "Jieyang",
     *          "province": "Guangdong",
     *          "country": "China",
     *          "headimgurl": "http://wx.qlogo.cn/mmopen/xbIQx1GRqdvyqkMMhEaGOX802l1CyqMJNgUzKP8MeAeHFicRDSnZH7FY4XB7p8XHXIf6uJA2SCun
     *          TPicGKezDC4saKISzRj3nz/0",
     *          "subscribe_time": 1434093047,   //用户关注时间，为时间戳。如果用户曾多次关注，则取最后关注时间
     *          "unionid": "oR5GjjgEhCMJFyzaVZdrxZ2zRRF4",
     *          "remark": "",  //公众号运营者对粉丝的备注
     *          "groupid": 0,  //用户所在的分组ID（兼容旧的用户分组接口）
     *          "tagid_list":[128,2]  //用户被打上的标签ID列表
     *      },
     *      {
     *          "subscribe": 0,
     *          "openid": "otvxTs_JZ6SEiP0imdhpi50fuSZg",
     *          "unionid": "oR5GjjjrbqBZbrnPwwmSxFukE41U",
     *      }
     * ]
     * @throws WechatException
     */
    public static function batchGet(App $app, array $openIds, string $lang = 'zh_CN')
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=ACCESS_TOKEN';

        $data = [];
        foreach ($openIds as $openid) {
            $data[] = array('openid' => $openid, 'lang' => $lang);
        }

        $data = ['user_list' => $data];

        return self::request($app, $url, $data)['user_info_list'];
    }

    /**
     * 获取关注者列表
     *
     * 公众号可通过本接口来获取帐号的关注者列表，关注者列表由一串OpenID（加密后的微信号，每个用户对每个公众号的OpenID是唯一的）组成
     * 一次拉取调用最多拉取10000个关注者的OpenID
     * 将上一次调用得到的返回中的next_openid值，作为下一次调用中的next_openid值
     * 关注者列表已返回完时，返回next_openid为空
     *
     * @param App $app
     * @param string $nextOpenId
     * @return array ["total"=>关注该公众账号的总用户数,"count"=>本次拉取个数,"data"=>["openid":["","OPENID1","OPENID2"]],"next_openid"=>"NEXT_OPENID"]
     * @throws WechatException
     */
    public static function all(App $app, string $nextOpenId = '')
    {
        //原始URL
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&next_openid=NEXT_OPENID";
        // 替换参数
        $url = str_replace('NEXT_OPENID', $nextOpenId, $url);

        return self::request($app, $url);
    }

    /**
     * 获取黑名单列表
     * @param App $app
     * @param string $beginOpenId 开始拉取索引openid
     * @return array
     * @throws WechatException
     * @link https://developers.weixin.qq.com/doc/offiaccount/User_Management/Manage_blacklist.html
     */
    public static function getBlackList(App $app, string $beginOpenId = '')
    {
        $postData = [
            'begin_openid' => $beginOpenId
        ];

        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/getblacklist?access_token=ACCESS_TOKEN';
        return self::request($app, $url, $postData);
    }

    /**
     * 批量拉黑用户
     * @param App $app
     * @param string[] $openIds
     * @return array
     * @throws WechatException
     */
    public static function batchBlackList(App $app, array $openIds)
    {
        $postData = [
            'openid_list' => $openIds
        ];
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchblacklist?access_token=ACCESS_TOKEN';
        return self::request($app, $url, $postData);
    }

    /**
     * @param App $app
     * @param array $openIds
     * @return array
     * @throws WechatException
     */
    public static function batchUnBlackList(App $app, array $openIds)
    {
        $postData = [
            'openid_list' => $openIds
        ];
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchunblacklist?access_token=ACCESS_TOKEN';
        return self::request($app, $url, $postData);
    }


}
