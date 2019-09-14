<?php
/**
 * @author Renan Delmonico <renandelmonico@gmail.com>
 */
namespace App\Entity;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Accessor;

/**
 * Documento de empresa
 */
abstract class Entity
{
    /**
     * @Type("string")
     * @SerializedName("_id")
     * @Accessor(getter="getId",setter="setId")
     */
    public $id;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id)
    {
        if (!$id) {
            return;
        }

        $this->id = new \MongoDB\BSON\ObjectId($id);
    }
}
