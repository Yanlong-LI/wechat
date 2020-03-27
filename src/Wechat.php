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

namespace yanlongli\wechat;


/**
 * Class Wechat
 * @package yanlongli\wechat\core
 */
class Wechat
{
    /**
     * 实例
     * @var array[App]
     */
    protected static array $apps = [];

    public function __get($name)
    {
        var_dump($name);
    }

    /**
     * @return array
     */
    public function getApps(): array
    {
        return self::$apps;
    }

    /**
     * @param string $appId
     * @return App|null
     */
    public static function getApp(string $appId)
    {
        return self::$apps[$appId] ?? null;
    }

    /**
     * @param App $app
     */
    public static function addApp(App $app): void
    {
        self::$apps[$app->appId] = $app;
    }
}
