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

/**
 * 构建微信的XML
 */
class Xml
{
    /**
     * @param array $data
     * @param string $root
     * @param string $item 索引数组，以$item作为key
     * @return string
     */
    public static function build(array $data, $root = 'xml', $item = 'item')
    {
        return '<' . $root . '>' . self::arrayToXml($data, $item) . '</' . $root . '>';
    }

    /**
     * @param array $data
     * @param string $item 索引数组，以$item作为key
     * @return string
     */
    private static function arrayToXml(array $data, $item = 'item')
    {
        $xml = '';

        foreach ($data as $key => $val) {
            if (is_numeric($key)) {
                $key = $item;
            }

            $xml .= '<' . $key . '>';

            if (is_array($val)) {
                $xml .= self::arrayToXml((array)$val, $item);
            } else {
                $xml .= is_numeric($val) ? $val : sprintf('<![CDATA[%s]]>', $val);
            }

            $xml .= '</' . $key . '>';
        }

        return $xml;
    }
}
