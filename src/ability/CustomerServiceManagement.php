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

use CURLFile;
use yanlongli\wechat\WechatException;

/**
 * Class AccountService 多客服管理
 * @package yanlongli\wechat\ability
 */
class CustomerServiceManagement extends Ability
{
    use Request;

    /**
     * 新增客服
     * @param $account
     * @param $nickname
     * @param $password
     * @return array
     * @throws WechatException
     */
    public function add(string $account, string $nickname, string $password)
    {
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/add?access_token=ACCESS_TOKEN';
        return $this->request($url, compact('account', 'nickname', 'password'));
    }

    /**
     * 更新客服资料
     * @param string $account
     * @param string $nickname
     * @param $password
     * @return array
     * @throws WechatException
     */
    public function update(string $account, string $nickname, string $password)
    {
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/update?access_token=ACCESS_TOKEN';
        return $this->request($url, compact('account', 'nickname', 'password'));
    }

    /**
     * 设置客服帐号的头像
     * @param string $account
     * @param string $filename 头像图片文件必须是jpg格式，推荐使用640*640大小的图片以达到最佳效果
     * @return array
     * @throws WechatException
     */
    public function avatar(string $account, string $filename)
    {
        $url = 'http://api.weixin.qq.com/customservice/kfaccount/uploadheadimg?access_token=ACCESS_TOKEN&kf_account=' . $account;

        $filename = realpath($filename);

        if (class_exists('\CURLFile')) {
            $data['media'] = new CURLFile($filename);
        } else {
            $data['media'] = '@' . $filename;
        }

        return $this->request($url, $data, false);
    }

    /**
     * 获取所有客服账号
     * @return array
     * @throws WechatException
     */
    public function all()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=ACCESS_TOKEN';

        $result = $this->request($url);
        return $result['kf_list'];
    }
}
