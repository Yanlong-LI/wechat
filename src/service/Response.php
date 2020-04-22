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
    protected array $dataKeyAlias = [];

    public function __construct(stdClass $resultObj)
    {
        $this->dataKeyAlias = $this->setDataKeyAlias();
        $this->FillData($resultObj, $this);
    }

    /**
     * 设置属性别名
     */
    protected function setDataKeyAlias(): array
    {
        return [];
    }

    /**
     * 填充数据
     * @param StdClass $data
     * @param mixed $obj 填充对象
     */
    protected function FillData($data, $obj): void
    {
        foreach ($data as $key => $item) {
            if (is_object($item)) {
                $obj->$key = $this->FillNewObject($key, $item);
            } elseif (is_array($item)) {
                $obj->$key = [];
                foreach ($item as $value) {
                    $obj->$key[] = $this->FillNewObject($key, $value);
                }
            } else {
                $obj->$key = $item;
            }
        }
    }

    /**
     * 配个 FillData 创建对应的新对象并返回
     * @param $key
     * @param $item
     * @return mixed
     */
    protected function FillNewObject($key, $item)
    {
        $itemObjKey = isset($this->dataKeyAlias[$key]) ? $this->dataKeyAlias[$key] : $key;
        $itemObj = new $itemObjKey();
        $this->FillData($item, $itemObj);
        return $itemObj;
    }
}
