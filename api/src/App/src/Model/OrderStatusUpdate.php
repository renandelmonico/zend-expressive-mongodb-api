<?php

namespace App\Model;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

class OrderStatusUpdate
{
    /**
     * @Type("string")
     * @Assert\Type("string")
     * @Assert\NotBlank(message="O status é obrigatório")
     */
    public $status;

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
}
