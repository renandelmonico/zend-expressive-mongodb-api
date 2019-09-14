<?php

namespace App\Model;

use JMS\Serializer\Annotation\Type;
use App\Entity\Order;

class OrderList extends Order
{
    /**
     * @Type("App\Entity\Customer")
     */
    public $buyer;

    /**
     * @Type("array<App\Model\OrderList\Item>")
     */
    public $items;
}
