<?php
/**
 *   Copyright (c) [2019] [Yanlongli <jobs@yanlongli.com>]
 *   [Wechat] is licensed under the Mulan PSL v1.
 *   You can use this software according to the terms and conditions of the Mulan PSL v1.
 *   You may obtain a copy of Mulan PSL v1 at:
 *       http://license.coscl.org.cn/MulanPSL
 *   THIS SOFTWARE IS PROVIDED ON AN "AS IS" BASIS, WITHOUT WARRANTIES OF ANY KIND, EITHER EXPRESS OR
 *   IMPLIED, INCLUDING BUT NOT LIMITED TO NON-INFRINGEMENT, MERCHANTABILITY OR FIT FOR A PARTICULAR
 *   PURPOSE.
 *   See the Mulan PSL v1 for more details.
 *
 *   Author: Yanlongli <jobs@yanlongli.com>
 *   Date:   2020/4/22
 *   IDE:    PhpStorm
 *   Desc:   消息转发到客服
 */
declare(strict_types=1);

namespace yanlongli\wechat\messaging\message;


use yanlongli\wechat\messaging\contract\ReplyMessage;

class TransferCustomerService implements ReplyMessage
{
    protected string $type = 'transfer_customer_service';
    protected ?string $kfAccount = null;

    /**
     * Music constructor.
     * @param string $kfAccount 指定会话接入的客服账号
     */
    public function __construct(?string $kfAccount = null)
    {
        $this->kfAccount = $kfAccount;
    }

    /**
     * @return array
     */
    public function xmlData()
    {
        return [
            'TransInfo' => [
                'KfAccount' => $this->kfAccount
            ]
        ];
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
        return ['TransInfo' => ['KfAccount' => $this->kfAccount]];
    }
}
