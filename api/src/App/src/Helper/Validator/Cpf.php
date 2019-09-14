<?php

namespace App\Helper\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
class Cpf extends Constraint
{
    public $message = 'O CPF é inválido';
}
