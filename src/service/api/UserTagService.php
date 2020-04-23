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

class UserTagService extends Api
{

    /**
     * 创建标签
     *  总最多可以创建100个
     * @param App $app
     * @param string $name
     * @return array {
     * {
     * "tag":
     *      {
     *      "name":"广东"
     *      }
     * }
     * @throws WechatException
     */
    public static function createTag(App $app, string $name)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/tags/create?access_token=ACCESS_TOKEN";
        $postData['tag'] = ['name' => $name];
        return self::request($app, $url, $postData);
    }

    /**
     * 获取标签列表
     * @param App $app
     * @return array {
     * "tags":[{
     * "id":1,
     * "name":"每天一罐可乐星人",
     * "count":0 //此标签下粉丝数
     * },
     * {
     * "id":2,
     * "name":"星标组",
     * "count":0
     * },
     * {
     * "id":127,
     * "name":"广东",
     * "count":5
     * }
     * ] }
     * @throws WechatException
     */
    public static function tags(App $app)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/tags/get?access_token=ACCESS_TOKEN";
        return self::request($app, $url);
    }

    /**
     * 标签重命名
     * @param App $app
     * @param int $tagId
     * @param string $name
     * @return array {   "errcode":0,   "errmsg":"ok" }
     * @throws WechatException
     */
    public static function tagRename(App $app, int $tagId, string $name)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/tags/update?access_token=ACCESS_TOKEN";
        $postData = [
            'id' => $tagId,
            'name' => $name
        ];
        return self::request($app, $url, ['tag' => $postData]);
    }

    /**
     * 删除标签，粉丝数大于10W时需要先撤销对应用户标签
     * @param App $app
     * @param int $tagId
     * @return array
     * @throws WechatException
     */
    public static function delTag(App $app, int $tagId)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/tags/delete?access_token=ACCESS_TOKEN";
        $postData['tag'] = ['id' => $tagId];
        return self::request($app, $url, $postData);
    }

    /**
     * 获取标签下的用户列表 -- 50个 以内
     * @param App $app
     * @param int $tagId
     * @param string $nextOpenId
     * @return array
     * @throws WechatException
     */
    public static function tagUsers(App $app, int $tagId, string $nextOpenId = "")
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token=ACCESS_TOKEN";
        $postData = ['tagid' => $tagId, 'next_openid' => $nextOpenId];
        return self::request($app, $url, $postData);
    }

    /**
     * 批量为用户打标签
     * @param App $app
     * @param int $tagId
     * @param string[] $openIds
     * @return array
     * @throws WechatException
     */
    public static function batchTagging(App $app, int $tagId, array $openIds)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=ACCESS_TOKEN';
        $postData = [
            'openid_list' => $openIds,
            'tagid' => $tagId
        ];
        return self::request($app, $url, $postData);
    }

    /**
     * 批量取消用户标签 50 个以内
     * @param App $app
     * @param int $tagId
     * @param string[] $openIds
     * @return array
     * @throws WechatException
     */
    public static function batchUnTagging(App $app, int $tagId, array $openIds)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging?access_token=ACCESS_TOKEN';
        $postData = [
            'openid_list' => $openIds,
            'tagid' => $tagId
        ];
        return self::request($app, $url, $postData);
    }

    /**
     * 获取指定用户的所有标签ID
     * @param App $app
     * @param string $openId
     * @return array {   "tagid_list":[//被置上的标签列表 134, 2   ] }
     * @throws WechatException
     */
    public static function getUserTags(App $app, string $openId)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token=ACCESS_TOKEN";
        $postData = [
            'openid' => $openId
        ];
        return self::request($app, $url, $postData);
    }
}
