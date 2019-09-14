<?php

namespace App\Entity;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;
use App\Helper\Validator;

class Customer extends Entity
{
    /**
     * @Type("string")
     * @Assert\Type("string")
     * @Assert\NotBlank(message="O nome é obrigatório")
     */
    public $name;

    /**
     * @Type("string")
     * @Assert\Type("string")
     * @Assert\Length(
     *      min=11,
     *      max=11,
     *      exactMessage="O CPF deve conter {{ limit }} caracteres"
     * )
     * @Assert\NotBlank(message="O CPF é obrigatório")
     * @Validator\Cpf()
     */
    public $cpf;

    /**
     * @Type("string")
     * @Assert\Type("string")
     * @Assert\Email(
     *      message="O endereço '{{ value }}' não é um email válido",
     *      checkMX=false
     * )
     * @Assert\NotBlank(message="O email é obrigatório")
     */
    public $email;

    /**
     * @Type("DateTime<'Y-m-d H:i:s'>")
     */
    public $created_at;

    /**
     * @Type("DateTime<'Y-m-d H:i:s'>")
     */
    public $updated_at;

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
     * Get the value of cpf
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set the value of cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
