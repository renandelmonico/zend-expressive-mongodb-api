<?php

namespace App\Entity;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

class Order extends Entity
{
    /**
     * @Type("DateTime<'Y-m-d H:i:s'>")
     */
    public $created_at;

    /**
     * @Type("DateTime<'Y-m-d H:i:s'>")
     */
    public $cancelDate;

    /**
     * @Type("string")
     * @Assert\Type("string")
     * @Assert\NotBlank(message="O status é obrigatório")
     */
    public $status;

    /**
     * @Type("float")
     * @Assert\Type("float")
     * @Assert\Positive(message="O preço deve ser maior que zero")
     * @Assert\NotBlank(message="O preço é obrigatório")
     */
    public $total;

    /**
     * @Type("App\Entity\Order\Buyer")
     * @Assert\NotBlank(message="O cliente é obrigatório")
     */
    public $buyer;

    /**
     * @Type("array<App\Entity\Order\Item>")
     * @Assert\NotBlank(message="Os itens são obrigatórios")
     * @Assert\Valid
     * @Assert\All({
     *      @Assert\Type(type="App\Entity\Order\Item")
     * })
     */
    public $items;

    /**
     * Get the value of created_at
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
     * Get the value of buyer
     */
    public function getBuyer()
    {
        return $this->buyer;
    }

    /**
     * Set the value of buyer
     */
    public function setBuyer($buyer)
    {
        $this->buyer = $buyer;
    }

    /**
     * Get the value of items
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set the value of items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * Get the value of cancelDate
     */
    public function getCancelDate()
    {
        return $this->cancelDate;
    }

    /**
     * Set the value of cancelDate
     */
    public function setCancelDate($cancelDate)
    {
        $this->cancelDate = $cancelDate;
    }
}
