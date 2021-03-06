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

/**
 * Class WxCard 发送卡券
 * @package yanlongli\wechat\messaging\message
 * @author  Zou Yiliang
 * @license MIT
 * 客服消息接口投放卡券仅支持非自定义Code码和导入code模式的卡券的卡券
 * http://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1451025056&token=&lang=zh_CN&anchor=2.2.2
 */
class WxCard implements CallMessage
{
    protected string $type = 'wxcard';
    protected string $cardId;

    public function __construct(string $cardId)
    {
        $this->cardId = $cardId;
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
        return array(
            'wxcard' => array(
                'card_id' => $this->cardId,
            ),
        );
    }
}
