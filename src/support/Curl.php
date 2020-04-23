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

namespace yanlongli\wechat\support;

use CURLFile;

class Curl
{

    public static function get($url)
    {
        return self::execute($url, 'get');
    }

    /**
     * @param $url
     * @param string $method 'post' or 'get'
     * @param null $postData
     *      类似'para1=val1&para2=val2&...'，
     *      也可以使用一个以字段名为键值，字段数据为值的数组。
     *      如果value是一个数组，Content-Type头将会被设置成multipart/form-data
     *      从 PHP 5.2.0 开始，使用 @ 前缀传递文件时，value 必须是个数组。
     *      从 PHP 5.5.0 开始, @ 前缀已被废弃，文件可通过 \CURLFile 发送。
     * @param array $options
     * @param array $errors
     * @return mixed
     */
    public static function execute($url, $method, $postData = null, $options = array(), &$errors = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 150); //设置cURL允许执行的最长秒数

        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        if ('post' === strtolower($method)) {
            curl_setopt($ch, CURLOPT_POST, true);
            if (null !== $postData) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            }
        }

        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }

        //https://github.com/pfinal/proxy
//        $proxy = getenv('WECHAT_PROXY');
//        $proxyPort = getenv('WECHAT_PROXYPORT');
//
//        if ($proxy) {
//            curl_setopt($ch, CURLOPT_PROXY, $proxy);
//        }
//
//        if ($proxyPort) {
//            curl_setopt($ch, CURLOPT_PROXYPORT, $proxyPort);
//        }

//        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "代理用户:代理密码");

        if (!($output = curl_exec($ch))) {
            $errors = array(
                    'errno' => curl_errno($ch),
                    'error' => curl_error($ch),
                ) + curl_getinfo($ch);
        }

        curl_close($ch);
        return $output;
    }

    public static function post($url, $postData)
    {
        return self::execute($url, 'post', $postData);
    }

    public static function file($url, $field, $filename, $postData = array())
    {
        $filename = realpath($filename);

        //PHP 5.6 禁用了 '@/path/filename' 语法上传文件
        if (class_exists('\CURLFile')) {
            $postData[$field] = new CURLFile($filename);
        } else {
            $postData[$field] = '@' . $filename;
        }

        return self::execute($url, 'post', $postData);
    }
}
