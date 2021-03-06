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

use CURLFile;
use yanlongli\wechat\App;
use yanlongli\wechat\support\Json;
use yanlongli\wechat\WechatException;

/**
 * Class MaterialService 素材资源管理
 * @package yanlongli\wechat\ability
 */
class Material extends Api
{

    /**
     * 上传临时素材文件
     *
     * curl -F media=@test.jpg "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=ACCESS_TOKEN&type=image"
     *
     * @param string $filename 文件名
     * @param string $type 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb，主要用于视频与音乐格式的缩略图）
     *      图片（image）: 大小不超过2M，支持bmp/png/jpeg/jpg/gif格式
     *      语音（voice）：大小不超过5M，播放长度不超过60s，支持AMR\MP3格式
     *      视频（video）：10MB，支持MP4格式
     *      缩略图（thumb）：64KB，支持JPG格式
     * @return array
     * @throws WechatException
     */
    public static function uploadFileTemporary(App $app, string $filename, string $type)
    {
        $filename = realpath($filename);


        //PHP 5.6 禁用了 '@/path/filename' 语法上传文件
        if (class_exists('\CURLFile')) {
            $data['media'] = new CURLFile($filename);
        } else {
            $data['media'] = '@' . $filename;
        }

        $url = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token=ACCESS_TOKEN&type=' . $type;

        return static::request($app, $url, $data, false);
    }


    /**
     * 新增永久素材 媒体文件类型别有图片（image）、语音（voice) 、视频（video）和缩略图（thumb）
     *
     * @param string $filename
     * @param string $type
     * @param string $title 视频素材的标题 只对类型为video有效
     * @param string $introduction 视频素材的描述 只对类型为video有效
     * @return array
     * @throws WechatException
     */
    public static function uploadFile(App $app, string $filename, string $type, string $title = null, string $introduction = null)
    {
        $filename = realpath($filename);

        if (class_exists('\CURLFile')) {
            $data['media'] = new CURLFile($filename);
        } else {
            $data['media'] = '@' . $filename;
        }

        $data['type'] = $type;

        if ('video' === $type) {
            $data['description'] = Json::encode(array(
                'title' => $title,
                'introduction' => $introduction
            ));
        }

        $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=ACCESS_TOKEN';

        return static::request($app, $url, $data, false);
    }

    /**
     * 下载多媒体文件
     * 从微信服务器下载文件 成功返回文件名，失败返回false
     * http://mp.weixin.qq.com/wiki/12/58bfcfabbd501c7cd77c19bd9cfa8354.html
     *
     * @param string $mediaId
     * @param string $savePath
     * @return bool|string
     * @throws WechatException
     */
    public static function downFile(App $app, string $mediaId, string $savePath = './uploads')
    {
        //todo 格式化链接
        $token = $app->AccessToken->getAccessToken();

        $url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=' . $token . '&media_id=' . $mediaId;

        /*
        HTTP/1.1 200 OK
        Connection: close
        Content-Type: image/jpeg
        Content-disposition: attachment; filename="cK4q4fLKK9yFYMf2AukLtZGWltIqauKKygW3osp7YOlaqx8NLMv2hIgidluDOafB.jpg"
        Date: Sun, 18 Jan 2015 16:56:32 GMT
        Cache-Control: no-cache, must-revalidate
        Content-Length: 963704
        */

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HEADER, true);    //需要response header
        curl_setopt($ch, CURLOPT_NOBODY, false);    //需要response body

        $response = curl_exec($ch);

        //分离header与body
        $header = '';
        $body = '';
        if ('200' == curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE); //头信息size
            $header = substr($response, 0, $headerSize);
            $body = substr($response, $headerSize);
        }

        curl_close($ch);

        //文件名
        $arr = array();
        if (preg_match('/filename="(.*?)"/', $header, $arr)) {

            $file = date('Ym') . '/' . uniqid() . strrchr($arr[1], '.');
            $fullName = rtrim($savePath, '/') . '/' . $file;

            //创建目录并设置权限
            $basePath = dirname($fullName);
            if (!file_exists($basePath)) {
                @mkdir($basePath, 0777, true);
                @chmod($basePath, 0777);
            }

            if (@file_put_contents($fullName, $body)) {
                return $file;
            }// else {
            //保存出错
            //  }
        } //else {
        //没有匹配到文件名
        //}

        return false;
    }

    /**
     * 上传图文消息内的图片获取URL (在图文消息的具体内容中，将过滤外部的图片链接)，只能使用此方法返回的url
     * 本接口所上传的图片不占用公众号的素材库中图片数量的5000个的限制。图片仅支持jpg/png格式，大小必须在1MB以下。
     * @param $filename
     * @return string 例如 http://mmbiz.qpic.cn/mmbiz/D7sHwECXBUtWxg2eVOmIsqWOERic2dfBWYhWtOzIxhiaYAIt8ludGP0QHh8cO6pVQT8V8KKZcahvzQiblMWXlA4Pw/0
     * @throws WechatException
     */
    public static function uploadNewsImage(App $app, string $filename)
    {
        $filename = realpath($filename);

        if (class_exists('\CURLFile')) {
            $data['media'] = new CURLFile($filename);
        } else {
            $data['media'] = '@' . $filename;
        }

        $url = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=ACCESS_TOKEN';

        $result = static::request($app, $url, $data, false);
        return $result['url'];
    }

    /**
     * 新增永久图文素材，所有参数全是必填，多图文素材一个参数传入数组即可，数组的key与本方法参数一致
     * @param string|array $title
     * @param string $thumb_media_id
     * @param string $author
     * @param string $digest
     * @param string $show_cover_pic
     * @param string $content
     * @param string $content_source_url
     * @return array
     * @throws WechatException
     */
    public static function uploadNews(App $app, $title, string $thumb_media_id = null, string $author = null, string $digest = null, string $show_cover_pic = null, string $content = null, string $content_source_url = null)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=ACCESS_TOKEN';

        if (!is_array($title)) {
            $title = array(compact(array('title', 'thumb_media_id', 'author', 'digest', 'show_cover_pic', 'content', 'content_source_url')));
        }

        $data = array(
            'articles' => $title,
        );

        return static::request($app, $url, $data);
    }

    //todo 上传临时媒体文件到服务器 小程序 https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/customer-message/customerServiceMessage.uploadTempMedia.html

}
