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


use yanlongli\wechat\service\api\UserManagement as UserManagementApi;
use yanlongli\wechat\service\api\UserTagService;
use yanlongli\wechat\WechatException;

class UserManagement extends Ability
{

    //创建标签

    const LANG_ZH_CN = UserManagementApi::LANG_ZH_CN;

    //获取标签列表
    const LANG_ZH_TW = UserManagementApi::LANG_ZH_TW;

    //编辑标签
    const LANG_EN = UserManagementApi::LANG_EN;

    //删除标签

    /**
     * 创建标签
     * @param $tagName
     * @return array
     * @throws WechatException
     */
    public function createTag($tagName)
    {
        return UserTagService::createTag($this->app, $tagName);
    }

    //标签下粉丝列表

    /**
     * 获取公众号已创建的标签列表
     * @return array
     * @throws WechatException
     */
    public function getTags()
    {
        return UserTagService::tags($this->app);
    }

    //批量为用户打标签

    /**
     * 编辑标签 标签改名
     * @param int $tagId
     * @param string $tagName
     * @return array
     * @throws WechatException
     */
    public function updateTag(int $tagId, string $tagName)
    {
        return UserTagService::tagRename($this->app, $tagId, $tagName);
    }

    //批量为用户取消标签

    /**
     * 删除标签
     * @param int $tagId
     * @return array
     * @throws WechatException
     */
    public function delTag(int $tagId)
    {
        return UserTagService::delTag($this->app, $tagId);
    }

    //获取用户身上的标签

    /**
     * 标签下粉丝列表
     * @param int $tagId
     * @return array
     * @throws WechatException
     */
    public function getUsersByTag(int $tagId)
    {
        return UserTagService::tagUsers($this->app, $tagId);
    }

    //为用户设置备注 服务号

    /**
     * 批量为用户打标签
     * @param int $tagId
     * @param array $openIds
     * @return array
     * @throws WechatException
     */
    public function batchTagging(int $tagId, array $openIds)
    {
        return UserTagService::batchTagging($this->app, $tagId, $openIds);
    }

    /**
     * 批量为用户取消标签
     * @param int $tagId
     * @param string[] $openIds
     * @return array
     * @throws WechatException
     */
    public function batchUnTagging(int $tagId, array $openIds)
    {
        return UserTagService::batchUnTagging($this->app, $tagId, $openIds);
    }

    /**
     * 获取用户身上的标签
     * @param string $openId openID
     * @return array
     * @throws WechatException
     */
    public function getUserTags(string $openId)
    {
        return UserTagService::getUserTags($this->app, $openId);
    }

    /**
     * 为用户设置备注 服务号
     * @param string $openId
     * @param string $lang 返回国家地区语言版本，zh_CN 简体，zh_TW 繁体，en 英语
     * @return array
     * @throws WechatException
     */
    public function getUserInfo(string $openId, string $lang = self::LANG_ZH_CN)
    {
        return UserManagementApi::get($this->app, $openId);
    }

    //todo 获取用户基本信息 UnionID
//    public function getUserInfo2($_)
//    {
//        return UserManagementApi::
//    }
    //批量获取用户基本信息
    /**
     * 批量获取用户基本信息
     * @param string[] $openIds 最多100条记录
     * @param string $lang 返回国家地区语言版本，zh_CN 简体，zh_TW 繁体，en 英语
     * @return array
     * @throws WechatException
     */
    public function getUsersInfo(array $openIds, string $lang = self::LANG_ZH_CN)
    {
        return UserManagementApi::batchGet($this->app, $openIds, $lang);
    }

    //获取用户列表 公众号

    /**
     * 获取用户列表 公众号
     * @param string $nextOpenId
     * @return array
     * @throws WechatException
     */
    public function getUsers(string $nextOpenId = '')
    {
        return UserManagementApi::all($this->app, $nextOpenId);
    }

    //获取公众号黑名单列表

    /**
     * 获取公众号黑名单列表
     * @param string $nextOpenId
     * @return array
     * @throws WechatException
     */
    public function getUsersByBlackList(string $nextOpenId = '')
    {
        return UserManagementApi::getBlackList($this->app, $nextOpenId);
    }

    // 拉黑用户

    /**
     * 拉黑用户
     * @param string[] $openIds
     * @return array
     * @throws WechatException
     */
    public function batchBlackList(array $openIds)
    {
        return UserManagementApi::batchBlackList($this->app, $openIds);
    }
    // 取消拉黑用户

    /**
     * 取消拉黑用户
     * @param string[] $openIds
     * @return array
     */
    public function batchUnBlackList(array $openIds)
    {
        return UserManagementApi::batchUnBlackList($this->app, $openIds);
    }

}
