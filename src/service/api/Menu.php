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

namespace yanlongli\wechat\service\api;

use yanlongli\wechat\App;
use yanlongli\wechat\WechatException;

/**
 * Class MenuService 公众号菜单管理
 * @package yanlongli\wechat\ability
 */
class Menu extends Api
{

    /**
     * 自定义菜单查询接口 仅能查询到使用API设置的菜单配置
     * http://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141014&token=&lang=zh_CN
     *
     * 在设置了个性化菜单后，使用本自定义菜单查询接口可以获取默认菜单和全部个性化菜单信息
     *
     * 类型为click、scancode_push、scancode_waitmsg、pic_sysphoto、pic_photo_or_album、 pic_weixin、location_select：保存值到key；
     * 类型为view：保存链接到url
     *
     * @param
     * @return array 例如
     * array(
     *     'menu' => array(
     *         'button' => array(
     *             array('type' => 'click', 'name' => '今日歌曲', 'key' => 'V1001_TODAY_MUSIC', 'sub_button' => array()),
     *             array('type' => 'click', 'name' => '歌手简介', 'key' => 'V1001_TODAY_SINGER', 'sub_button' => array()),
     *             array('name' => '菜单', 'sub_button' => array(
     *                 array('type' => 'view', 'name' => '搜索', 'url' => 'http://www.soso.com/', 'sub_button' => array(),),
     *                 array('type' => 'view', 'name' => '视频', 'url' => 'http://v.qq.com/', 'sub_button' => array(),),
     *                 array('type' => 'click', 'name' => '赞一下我们', 'key' => 'V1001_GOOD', 'sub_button' => array(),),),
     *             )
     *         )
     *     )
     * )
     * @throws WechatException
     */
    public static function all(App $app)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token=ACCESS_TOKEN';
        return static::request($app, $url);
    }

    /**
     * 获取自定义菜单配置
     * http://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1434698695&token=&lang=zh_CN
     *
     * 本接口将会提供公众号当前使用的自定义菜单的配置，如果公众号是通过API调用设置的菜单，则返回菜单的开发配置，
     * 而如果公众号是在公众平台官网通过网站功能发布菜单，则本接口返回运营者设置的菜单配置
     * 1、第三方平台开发者可以通过本接口，在旗下公众号将业务授权给你后，立即通过本接口检测公众号的自定义菜单配置，并通过接口再次给公众号设置好自动回复规则，以提升公众号运营者的业务体验。
     * 2、本接口与自定义菜单查询接口的不同之处在于，本接口无论公众号的接口是如何设置的，都能查询到接口，而自定义菜单查询接口则仅能查询到使用API设置的菜单配置。
     * 3、认证/未认证的服务号/订阅号，以及接口测试号，均拥有该接口权限。
     * 4、从第三方平台的公众号登录授权机制上来说，该接口从属于消息与菜单权限集。
     * 5、本接口中返回的图片/语音/视频为临时素材（临时素材每次获取都不同，3天内有效，通过素材管理-获取临时素材接口来获取这些素材），本接口返回的图文消息为永久素材素材（通过素材管理-获取永久素材接口来获取这些素材）。
     *
     * 如果公众号是在公众平台官网通过网站功能发布菜单,type有可能为news、video、text、img
     *
     * @return array
     *
     * array(
     *     'is_menu_open'=>1
     *     'selfmenu_info' => array(
     *         'button' => array(
     *             array('type' => 'click', 'name' => '今日歌曲', 'key' => 'V1001_TODAY_MUSIC', 'sub_button' => array()),
     *             array('type' => 'click', 'name' => '歌手简介', 'key' => 'V1001_TODAY_SINGER', 'sub_button' => array()),
     *             array('name' => '菜单', 'sub_button' => array(
     *                  'list'=>array(
     *                         array('type' => 'view', 'name' => '搜索', 'url' => 'http://www.soso.com/', 'sub_button' => array(),),
     *                         array('type' => 'view', 'name' => '视频', 'url' => 'http://v.qq.com/', 'sub_button' => array(),),
     *                         array('type' => 'click', 'name' => '赞一下我们', 'key' => 'V1001_GOOD', 'sub_button' => array(),),),
     *                     )
     *             )
     *         )
     *     )
     * )
     * @throws WechatException
     */
    public static function current(App $app)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token=ACCESS_TOKEN';
        return static::request($app, $url);
    }

    /**
     * 创建菜单
     * @param array $data 菜单数据,例如:
     *
     * $data = array(
     *       array(
     *            "type"=>"click",
     *            "name"=>"今日歌曲",
     *            "key"=>"V1001_TODAY_MUSIC",
     *       ),
     *       array(
     *            "name"=>"菜单",
     *            "sub_button"=>array(
     *                  array(
     *                      "type"=>"view",
     *                      "name"=>"搜索",
     *                      "url"=>"http://www.soso.com/"
     *                  ),
     *                  array(
     *                        "type"=>"view",
     *                        "name"=>"视频",
     *                        "url"=>"http://v.qq.com/"
     *                  ),
     *                  array(
     *                      "type"=>"click",
     *                      "name"=>"赞一下我们",
     *                      "key"=>"V1001_GOOD"
     *                  ),
     *              ),
     *       )
     * );
     * @return array {"errcode":0,"errmsg":"ok"}
     * @throws WechatException
     */
    public static function create(App $app, array $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=ACCESS_TOKEN';
        $data = array('button' => $data);
        return static::request($app, $url, $data);
    }

    /**
     * 删除菜单
     * @return array ["errcode"=>0,"errmsg"=>"ok"]
     * @throws WechatException
     */
    public static function delete(App $app)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=ACCESS_TOKEN';
        return static::request($app, $url);
    }

    /**
     * 创建个性化菜单
     * @param array $data
     * @param array $matchRule 菜单匹配规则
     * [
     *      group_id":"2",
     *      "sex":"1",
     *      "country":"中国",
     *      "province":"广东",
     *      "city":"广州",
     *      "client_platform_type":"2"
     *      "language":"zh_CN"
     * ]
     * @return string 返回个性化菜单id
     * @throws WechatException
     */
    public static function createConditional(App $app, array $data, array $matchRule)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=ACCESS_TOKEN';
        $data = array('button' => $data, 'matchrule' => $matchRule);
        $result = static::request($app, $url, $data);
        return $result['menuid'];
    }

    /**
     * 删除个个化菜单，失败抛出异常
     * @param $menuId
     * @throws WechatException
     */
    public static function deleteConditional(App $app, string $menuId)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delconditional?access_token=ACCESS_TOKEN';
        $data = array('menuid' => $menuId,);
        return static::request($app, $url, $data);
    }

    /**
     * 测试个性化菜单匹配结果
     * @param App $app
     * @param string $openid
     * @return array 返回菜单数据
     * @throws WechatException
     */
    public static function tryMatch(App $app, string $openid)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delconditional?access_token=ACCESS_TOKEN';
        $data = array('user_id' => $openid,);
        return static::request($app, $url, $data);
    }


    /**
     * 点击按钮
     * @param string $name
     * @param string $key
     * @return array
     */
    public static function optionClick(string $name, string $key): array
    {
        return [
            'type' => 'click',
            'name' => $name,
            'key' => $key,
        ];
    }

    /**
     * 子菜单
     * @param string $name length max 7
     * @param array $subButton length max 5
     * @return array
     */
    public static function optionSubButton(string $name, array $subButton): array
    {
        return [
            'name' => $name,
            'sub_button' => $subButton
        ];
    }

    /**
     * 跳转URL
     * @param string $name length max 4|7
     * @param string $url
     * @return array
     */
    public static function optionView(string $name, string $url): array
    {
        return [
            'type' => 'view',
            'name' => $name,
            'url' => $url
        ];
    }

    /**
     * 打开小程序
     * @param string $name
     * @param string $appId
     * @param string $path
     * @param string $url 不支持打开小程序的版本将打开此URL
     * @return array
     */
    public static function optionMiniprogram(string $name, string $appId, string $path, string $url): array
    {
        return [
            'type' => 'miniprogram',
            'name' => $name,
            'appid' => $appId,
            'pagepath' => $path,
            'url' => $url
        ];
    }

    /**
     * 发送媒体文件
     * @param string $name
     * @param string $mediaId
     * @return array
     */
    public static function optionMedia(string $name, string $mediaId): array
    {

        return [
            'type' => 'media_id',
            'name' => $name,
            'media_id' => $mediaId
        ];
    }

    /**
     * 发送图文消息
     * @param string $name
     * @param string $mediaId
     * @return array
     */
    public static function optionNews(string $name, string $mediaId): array
    {
        return [
            'type' => 'view_limited',
            'name' => $name,
            'media_id' => $mediaId
        ];
    }

    /**
     * 发送位置信息
     * @param string $name
     * @param string $key
     * @return array
     */
    public static function optionLocation(string $name, string $key): array
    {
        return [
            'type' => 'location_select',
            'name' => $name,
            'key' => $key
        ];
    }

    /**
     * 拍照发送
     * @param string $name
     * @param string $key
     * @return array
     */
    public static function optionPicSysPhoto(string $name, string $key): array
    {
        return [
            'type' => 'pic_sysphoto',
            'name' => $name,
            'key' => $key
        ];
    }

    /**
     * 拍照或相册发送
     * @param string $name
     * @param string $key
     * @return array
     */
    public static function optionPicPhotoOrAlbum(string $name, string $key): array
    {
        return [
            'type' => 'pic_photo_or_album',
            'name' => $name,
            'key' => $key
        ];
    }

    /**
     * 微信相册发送
     * @param string $name
     * @param string $key
     * @return array
     */
    public static function optionPicWeixin(string $name, string $key): array
    {
        return [
            'type' => 'pic_weixin',
            'name' => $name,
            'key' => $key
        ];
    }

    /**
     * 扫码带提示
     * @param string $name
     * @param string $key
     * @return array
     */
    public static function optionScancodeWaitmsg(string $name, string $key): array
    {
        return [
            'type' => 'scancode_waitmsg',
            'name' => $name,
            'key' => $key
        ];
    }

    /**
     * 扫码推事件
     * @param string $name
     * @param string $key
     * @return array
     */
    public static function optionScancodePush(string $name, string $key): array
    {
        return [
            'type' => 'scancode_push',
            'name' => $name,
            'key' => $key
        ];
    }
}
