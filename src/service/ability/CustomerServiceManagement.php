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
 *   Desc:   客服管理
 */
declare(strict_types=1);

namespace yanlongli\wechat\service\ability;


use yanlongli\wechat\service\api\CustomService;
use yanlongli\wechat\WechatException;

class CustomerServiceManagement extends CustomerService
{
    //获取客服基本信息
    /**
     * 获取客服基本信息
     * @return array
     * @throws WechatException
     */
    public function getKfList()
    {
        return CustomService::getKfList($this->app);
    }

    //添加客服账号

    /**
     * 添加客服账号
     * @param string $kfAccount
     * @param string $nickname
     * @param string $password
     * @return array
     * @throws WechatException
     */
    public function addKfAccount(string $kfAccount, string $nickname, string $password = '')
    {
        return CustomService::addKfAccount($this->app, $kfAccount, $nickname, $password);
    }

    // 邀请绑定客服账号

    /**
     * 邀请绑定客服账号
     * @param string $kfAccount
     * @param $inviteWx
     * @return array
     * @throws WechatException
     */
    public function inviteWorker(string $kfAccount, $inviteWx)
    {
        return CustomService::inviteWorker($this->app, $kfAccount, $inviteWx);
    }

    // 设置客服信息

    /**
     * 设置客服信息
     * @param string $kfAccount
     * @param string $nickname
     * @param string $password
     * @return array
     * @throws WechatException
     */
    public function setKfAccount(string $kfAccount, string $nickname, string $password = '')
    {
        return CustomService::updateKfAccount($this->app, $kfAccount, $nickname, $password);
    }

    // 上传客服头像

    /**
     * 上传客服头像
     * @param string $kfAccount
     * @param string $filename
     * @return array
     * @throws WechatException
     */
    public function setKfAccountPicture(string $kfAccount, string $filename)
    {
        return CustomService::uploadKfAccountPicture($this->app, $kfAccount, $filename);
    }

    // 删除客服账号

    /**
     * 删除客服账号
     * @param string $kfAccount
     * @return array
     */
    public function delKfAccount(string $kfAccount)
    {
        return CustomService::delKfAccount($this->app, $kfAccount);
    }

    // 创建会话

    /**
     * 创建会话
     * @param string $kfAccount 客服账号 完整客服帐号，格式为：帐号前缀@公众号微信号
     * @param string $openId 粉丝的openid
     * @return array
     * @throws WechatException
     */
    public function createKfSession(string $kfAccount, string $openId)
    {
        return CustomService::createKfSession($this->app, $kfAccount, $openId);
    }
    //关闭会话

    /**
     * 关闭会话
     * @param string $kfAccount 客服账号 完整客服帐号，格式为：帐号前缀@公众号微信号
     * @param string $openId 粉丝的openid
     * @return array
     * @throws WechatException
     */
    public function closeKfSession(string $kfAccount, string $openId)
    {
        return CustomService::closeKfSession($this->app, $kfAccount, $openId);
    }

    //会话状态

    /**
     * 获取客户会话状态
     * @param string $openId
     * @return array
     * @throws WechatException
     */
    public function getUserSession(string $openId)
    {
        return CustomService::getUserSession($this->app, $openId);
    }

    //会话列表

    /**
     * 获取客服会话列表
     * @param string $kfAccount
     * @return array
     * @throws WechatException
     */
    public function getKfSessionList(string $kfAccount)
    {
        return CustomService::getKfSessionList($this->app, $kfAccount);
    }

    //未接入会话列表

    /**
     * 获取未接入会话列表
     * @return array
     * @throws WechatException
     */
    public function getWaitCase()
    {
        return CustomService::getWaitCase($this->app);
    }
}
