<?php

namespace App\Entity\Order;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

class Item
{
    /**
     * @Type("int")
     * @Assert\Type("int")
     * @Assert\Positive(message="A quantidade deve ser maior que zero")
     * @Assert\NotBlank(message="A quantidade é obrigatório")
     */
    public $amount;

    /**
     * @Type("float")
     * @Assert\Type("float")
     * @Assert\Positive(message="O valor unitário deve ser maior que zero")
     * @Assert\NotBlank(message="O valor unitário é obrigatório")
     */
    public $price_unit;

    /**
     * @Type("float")
     * @Assert\Type("float")
     * @Assert\Positive(message="O valor total deve ser maior que zero")
     * @Assert\NotBlank(message="O valor total é obrigatório")
     */
    public $total;

    /**
     * @Type("App\Entity\Order\Product")
     * @Assert\NotBlank(message="O produto é obrigatório")
     */
    public $product;

    /**
     * Get the value of amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get the value of price_unit
     */
    public function getPriceUnit()
    {
        return $this->price_unit;
    }

    /**
     * Set the value of price_unit
     */
    public function setPriceUnit($price_unit)
    {
        $this->price_unit = $price_unit;
    }

    /**
     * Get the value of total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set the value of total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * Get the value of product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set the value of product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }
}
