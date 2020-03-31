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

use ReflectionClass;
use ReflectionException;

/**
 * Class Request
 * @package yanlongli\wechat\service
 */
abstract class Request
{
    /**
     * @return string 请求地址
     */
    abstract public function url(): string;

    /**
     * @return array
     * @throws ReflectionException
     */
    public function toArray(): array
    {

        $refClass = new ReflectionClass($this);
        $refProperties = $refClass->getProperties();
        $params = [];
        foreach ($refProperties as $property) {
            if (!$property->isInitialized($this)) {
                continue;
            }
            $params[$property->getName()] = $property->getValue($this);
        }
        return $params;
    }
}
