<?php

namespace App\Entity;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

class Product extends Entity
{
    /**
     * @Type("int")
     * @Assert\Type("int")
     * @Assert\NotBlank(message="O SKU é obrigatório")
     */
    public $sku;

    /**
     * @Type("string")
     * @Assert\Type("string")
     * @Assert\NotBlank(message="O nome é obrigatório")
     */
    public $name;

    /**
     * @Type("float")
     * @Assert\Type("float")
     * @Assert\Positive(message="O preço deve ser maior que zero")
     * @Assert\NotBlank(message="O preço é obrigatório")
     */
    public $price;

    /**
     * @Type("DateTime<'Y-m-d H:i:s'>")
     */
    public $created_at;

    /**
     * @Type("DateTime<'Y-m-d H:i:s'>")
     */
    public $updated_at;

    /**
     * Get the value of sku
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set the value of sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

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
     * Get the value of updated_at
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }
}
