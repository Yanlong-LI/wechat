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

namespace yanlongli\wechat\messaging\message;

use yanlongli\wechat\messaging\contract\CallMessage;
use yanlongli\wechat\messaging\contract\ReplyMessage;

/**
 * Class News 图文消息
 * @package yanlongli\wechat\messaging\message
 * @author  Zou Yiliang
 * @license MIT
 */
class News implements ReplyMessage, CallMessage
{
    protected string $type = 'news';
    protected array $attributes;

    /**
     * $arr = ['文章标题', '描述', 'url', 'image'];
     *
     * $news1 = new News('文章标题', '描述', 'url', 'image')
     * $news2 = new News($arr)
     * $news3 = new News([$arr,$arr])
     * $news4 = new News([$news1,$news2])
     *
     * @param array|string $title
     * @param string $description
     * @param string $url
     * @param string $picUrl
     */
    public function __construct($title = '', string $description = '', string $url = '', string $picUrl = '')
    {
        if (is_array($title)) {

            $articles = $title;
            if (array_keys($articles) !== range(0, count($articles) - 1)) {
                //第一个参是关联数组
                $articles = array($articles);
            } else {
                //第一个参是索引数组
                foreach ($articles as $key => $item) {
                    if ($item instanceof News) {
                        $articles[$key] = $item->toArray();
                    } else {
                        $articles[$key] = (array)$item;
                    }
                }
            }
        } else {
            //第一个参数不是数组
            $articles = array(compact(array('title', 'description', 'url', 'picUrl')));
        }

        //将key的首字母转为大写(微信Xml格式首字大写)
        foreach ($articles as $key => $value) {

            $temp = array();
            foreach ($value as $k => $v) {
                $temp[ucfirst($k)] = $v;
            }

            $articles[$key] = $temp;
        }


        $this->attributes = array(
            'ArticleCount' => count($articles),
            'Articles' => $articles,//此参数需要索引数组，XML::arrayToXml()会将索引数组以item为父级生成xml
        );
    }

    public function toArray()
    {
        return current($this->attributes['Articles']);
    }

    /**
     * @return array
     */
    public function xmlData()
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function jsonData()
    {
        $articles = array();

        //将key转为小写，微信json格式为全小写
        foreach ($this->attributes['Articles'] as $k => $v) {
            $articles[$k] = array_change_key_case($v, CASE_LOWER);
        }

        return array('news' => array('articles' => $articles));
    }
}
