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


use yanlongli\wechat\service\api\Menu as MenuApi;
use yanlongli\wechat\WechatException;

class Menu extends Ability
{
    /**
     * 点击按钮
     * @param string $name
     * @param string $key
     * @return array
     */
    public static function optionClick(string $name, string $key): array
    {
        return MenuApi::optionClick($name, $key);
    }

    /**
     * 子菜单
     * @param string $name length max 7
     * @param array $subButton length max 5
     * @return array
     */
    public static function optionSubButton(string $name, array $subButton): array
    {
        return MenuApi::optionSubButton($name, $subButton);
    }

    /**
     * 跳转URL
     * @param string $name length max 4|7
     * @param string $url
     * @return array
     */
    public static function optionView(string $name, string $url): array
    {
        return MenuApi::optionView($name, $url);
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
        return MenuApi::optionMiniprogram($name, $appId, $path, $url);
    }

    /**
     * 发送媒体文件
     * @param string $name
     * @param string $mediaId
     * @return array
     */
    public static function optionMedia(string $name, string $mediaId): array
    {

        return MenuApi::optionMedia($name, $mediaId);
    }

    /**
     * 发送图文消息
     * @param string $name
     * @param string $mediaId
     * @return array
     */
    public static function optionNews(string $name, string $mediaId): array
    {
        return MenuApi::optionNews($name, $mediaId);
    }

    /**
     * 发送位置信息
     * @param string $name
     * @param string $key
     * @return array
     */
    public static function optionLocation(string $name, string $key): array
    {
        return MenuApi::optionLocation($name, $key);
    }

    /**
     * 拍照发送
     * @param string $name
     * @param string $key
     * @return array
     */
    public static function optionPicSysPhoto(string $name, string $key): array
    {
        return MenuApi::optionPicSysPhoto($name, $key);
    }

    /**
     * 拍照或相册发送
     * @param string $name
     * @param string $key
     * @return array
     */
    public static function optionPicPhotoOrAlbum(string $name, string $key): array
    {
        return MenuApi::optionPicPhotoOrAlbum($name, $key);
    }

    /**
     * 微信相册发送
     * @param string $name
     * @param string $key
     * @return array
     */
    public static function optionPicWeixin(string $name, string $key): array
    {
        return MenuApi::optionPicWeixin($name, $key);
    }

    /**
     * 扫码带提示
     * @param string $name
     * @param string $key
     * @return array
     */
    public static function optionScancodeWaitmsg(string $name, string $key): array
    {
        return MenuApi::optionScancodeWaitmsg($name, $key);
    }

    /**
     * 扫码推事件
     * @param string $name
     * @param string $key
     * @return array
     */
    public static function optionScancodePush(string $name, string $key): array
    {
        return MenuApi::optionScancodePush($name, $key);
    }

    /**
     * 自定义菜单查询接口
     * @return array
     * @throws WechatException
     */
    public function all()
    {
        return MenuApi::all($this->app);
    }

    /**
     * 获取自定义菜单配置
     * @return array
     * @throws WechatException
     */
    public function current()
    {
        return MenuApi::current($this->app);
    }

    /**
     * 创建菜单
     * @param array $data
     * @return array
     * @throws WechatException
     */
    public function create(array $data)
    {
        return MenuApi::create($this->app, $data);
    }

    /**
     * 删除菜单
     * @return array
     * @throws WechatException
     */
    public function delete()
    {
        return MenuApi::delete($this->app);
    }

    /**
     * 创建个性化菜单
     * @param array $data
     * @param array $matchRule
     * @return string
     * @throws WechatException
     */
    public function createConditional(array $data, array $matchRule)
    {
        return MenuApi::createConditional($this->app, $data, $matchRule);
    }

    /**
     * 删除个性化菜单
     * @param string $menuId
     * @return array
     * @throws WechatException
     */
    public function deleteConditional(string $menuId)
    {
        return MenuApi::deleteConditional($this->app, $menuId);
    }

    /**
     * 匹配测试个性化菜单
     * @param string $menuId
     * @return array
     * @throws WechatException
     */
    public function tryMatch(string $menuId)
    {
        return MenuApi::tryMatch($this->app, $menuId);
    }
}
