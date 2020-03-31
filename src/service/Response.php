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

namespace yanlongli\wechat\service;


use stdClass;

abstract class Response
{

    protected array $data;

    public function __construct(string $result)
    {
        $resultObj = json_decode($result);
        $this->FillData($resultObj, $this);
    }

    /**
     * 填充数据
     * @param StdClass $data
     * @param mixed $obj 填充对象
     */
    public function FillData($data, $obj): void
    {
        foreach ($data as $key => $item) {
            if (is_object($item)) {
                $itemObj = new $key();
                $this->FillData($item, $itemObj);
                $obj->$key = $itemObj;
            } elseif (is_array($item)) {
                $obj->$key = [];
                foreach ($item as $value) {
                    $valueObj = new $key();
                    $this->FillData($value, $valueObj);
                    $obj->$key[] = $valueObj;
                }
            } else {
                $obj->$key = $item;
            }
        }
    }

    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }
}
