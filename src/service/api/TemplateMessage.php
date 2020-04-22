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
use yanlongli\wechat\messaging\message\Template;
use yanlongli\wechat\miniProgram\MiniProgram;
use yanlongli\wechat\officialAccount\ServiceAccount;
use yanlongli\wechat\WechatException;

/**
 * Class TemplateMessageService
 * @package yanlongli\wechat\service
 * @link https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Template_Message_Interface.html
 */
class TemplateMessage extends Api
{

    /**
     * 设置所属行业
     * @param ServiceAccount $app
     * @param int $industryId1 公众号模板消息所属行业编号 1
     * @param int $industryId2 公众号模板消息所属行业编号 2
     * @return array
     * @throws WechatException
     */
    public static function setIndustry(ServiceAccount $app, int $industryId1, int $industryId2)
    {
        $postData = [
            'industry_id1' => $industryId1,
            'industry_id2' => $industryId2,
        ];

        $apiUrl = 'https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token=ACCESS_TOKEN';

        return self::request($app, $apiUrl, $postData);
    }

    /**
     * 获取设置的行业信息
     * @param ServiceAccount $app
     * @return array
     * @throws WechatException
     */
    public static function getIndustry(ServiceAccount $app)
    {

        $apiUrl = 'https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=ACCESS_TOKEN';

        return self::request($app, $apiUrl);
    }

    /**
     * 获得模板编号
     * @param ServiceAccount $app
     * @param string $templateIdShort 模板ID
     * @return array
     * @throws WechatException
     */
    public static function addTemplate(ServiceAccount $app, string $templateIdShort)
    {
        $postData = [
            'template_id_short' => $templateIdShort,
        ];

        $apiUrl = 'https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=ACCESS_TOKEN';

        return self::request($app, $apiUrl, $postData);
    }

    /**
     * 获取模板列表
     * 获取已添加至帐号下所有模板列表，可在微信公众平台后台中查看模板列表信息。为方便第三方开发者，提供通过接口调用的方式来获取帐号下所有模板信息
     * http请求方式：GET https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=ACCESS_TOKEN
     * @param ServiceAccount $app 服务号
     * @return array
     * @throws WechatException
     */
    public static function getAllPrivateTemplate(ServiceAccount $app)
    {
        $apiUrl = 'https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=ACCESS_TOKEN';

        return self::request($app, $apiUrl);
    }

    /**
     * @param ServiceAccount $app
     * @param string $templateId 公众账号下模板消息ID
     * @return array
     * @throws WechatException
     */
    public static function delPrivateTemplate(ServiceAccount $app, string $templateId)
    {
        $postData = [
            'template_id' => $templateId
        ];

        $apiUrl = 'https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token=ACCESS_TOKEN';

        return self::request($app, $apiUrl, $postData);
    }

    /**
     * 发送公众号模板消息
     *
     * @param App $app
     * @param string $openid
     * @param Template $template
     * @return array
     * @throws WechatException
     */
    public static function send(App $app, string $openid, Template $template)
    {
        if ($app instanceof ServiceAccount) {
            $apiUrl = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=ACCESS_TOKEN';
        } elseif ($app instanceof MiniProgram) {
            $apiUrl = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=ACCESS_TOKEN';
        } else {
            throw new WechatException('不支持的 账户 类型');
        }


        $postData = array_merge([
            'touser' => $openid
        ], $template->jsonData());

        return self::request($app, $apiUrl, $postData);
    }
}
