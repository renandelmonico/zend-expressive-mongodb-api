<?php

namespace App\Model\OrderList;

use App\Entity\Order\Item as EntityItem;
use JMS\Serializer\Annotation\Type;

class Item extends EntityItem
{
    /**
     * @Type("App\Entity\Product")
     */
    public $product;
}
