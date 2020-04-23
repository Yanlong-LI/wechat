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

use CURLFile;
use yanlongli\wechat\App;
use yanlongli\wechat\WechatException;

/**
 * Class AccountService 多客服管理
 * @package yanlongli\wechat\ability
 */
class CustomService extends Api
{

    /**
     * 新增客服
     * @param App $app
     * @param string $kfAccount
     * @param string $nickname
     * @param string $password
     * @return array
     * @throws WechatException
     */
    public static function addKfAccount(App $app, string $kfAccount, string $nickname, string $password)
    {
        $postData = [
            'kf_account' => $kfAccount,
            'nickname' => $nickname,
            'password' => $password
        ];
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/add?access_token=ACCESS_TOKEN';
        return self::request($app, $url, $postData);
    }

    /**
     * 更新客服资料
     * @param App $app
     * @param string $kfAccount
     * @param string $nickname
     * @param string $password todo 新版客服无此参数，待确定
     * @return array
     * @throws WechatException
     */
    public static function updateKfAccount(App $app, string $kfAccount, string $nickname, string $password = '')
    {
        $postData = [
            'kf_account' => $kfAccount,
            'nickname' => $nickname,
            'password' => $password
        ];
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/update?access_token=ACCESS_TOKEN';
        return self::request($app, $url, $postData);
    }

    /**
     * 设置客服帐号的头像
     * @param App $app
     * @param string $kfAccount
     * @param string $filename 头像图片文件必须是jpg格式，推荐使用640*640大小的图片以达到最佳效果
     * @return array
     * @throws WechatException
     */
    public static function uploadKfAccountPicture(App $app, string $kfAccount, string $filename)
    {
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/uploadheadimg?access_token=ACCESS_TOKEN&kf_account=KFACCOUNT';
        $url = str_replace('KFACCOUNT', $kfAccount, $url);

        $filename = realpath($filename);

        $data['media'] = new CURLFile($filename);

        return self::request($app, $url, $data, false);
    }

    /**
     * 获取客服基本信息
     * @param App $app
     * @return array
     * @throws WechatException
     */
    public static function getKfList(App $app)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=ACCESS_TOKEN';

        return self::request($app, $url)['kf_list'];

    }

    /**
     * 邀请绑定客服账号
     * @param App $app
     * @param string $kfAccount 客服账号
     * @param string $inviteWx 客服微信
     * @return array
     * @throws WechatException
     */
    public static function inviteWorker(App $app, string $kfAccount, string $inviteWx)
    {
        $postData = [
            'kf_account' => $kfAccount,
            'invite_wx' => $inviteWx
        ];
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/inviteworker?access_token=ACCESS_TOKEN';
        return self::request($app, $url, $postData);
    }

    public static function delKfAccount(App $app, string $kfAccount)
    {
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/del?access_token=ACCESS_TOKEN&kf_account=KFACCOUNT';
        $url = str_replace('KFACCOUNT', $kfAccount, $url);
        return self::request($app, $url);
    }

    //创建会话

    /**
     * 创建会话
     * @param App $app
     * @param string $kfAccount 客服账号 完整客服帐号，格式为：帐号前缀@公众号微信号
     * @param string $openId 粉丝的openid
     * @return array
     * @throws WechatException
     */
    public static function createKfSession(App $app, string $kfAccount, string $openId)
    {
        $postData = [
            'kf_account' => $kfAccount,
            'openid' => $openId
        ];
        $url = 'https://api.weixin.qq.com/customservice/kfsession/create?access_token=ACCESS_TOKEN';
        return self::request($app, $url, $postData);
    }
    //关闭会话

    /**
     * 关闭会话
     * @param App $app
     * @param string $kfAccount 客服账号 完整客服帐号，格式为：帐号前缀@公众号微信号
     * @param string $openId 粉丝的openid
     * @return array
     * @throws WechatException
     */
    public static function closeKfSession(App $app, string $kfAccount, string $openId)
    {
        $postData = [
            'kf_account' => $kfAccount,
            'openid' => $openId
        ];
        $url = 'https: //api.weixin.qq.com/customservice/kfsession/close?access_token=ACCESS_TOKEN';
        return self::request($app, $url, $postData);
    }

    //会话状态

    /**
     * 获取客户会话状态
     * @param App $app
     * @param string $openId
     * @return array
     * @throws WechatException
     */
    public static function getUserSession(App $app, string $openId)
    {
        $url = 'https://api.weixin.qq.com/customservice/kfsession/getsession?access_token=ACCESS_TOKEN&openid=OPENID';
        $url = str_replace('OPENID', $openId, $url);

        return self::request($app, $url);
    }

    //会话列表

    /**
     * 获取客服会话列表
     * @param App $app
     * @param string $kfAccount
     * @return array
     * @throws WechatException
     */
    public static function getKfSessionList(App $app, string $kfAccount)
    {
        $url = 'https://api.weixin.qq.com/customservice/kfsession/getsessionlist?access_token=ACCESS_TOKEN&kf_account=KFACCOUNT';
        $url = str_replace('KFACCOUNT', $kfAccount, $url);

        return self::request($app, $url);
    }

    //未接入会话列表

    /**
     * 获取未接入会话列表
     * @param App $app
     * @return array
     * @throws WechatException
     */
    public static function getWaitCase(App $app)
    {
        $url = 'https://api.weixin.qq.com/customservice/kfsession/getwaitcase?access_token=ACCESS_TOKEN';

        return self::request($app, $url);
    }
}
