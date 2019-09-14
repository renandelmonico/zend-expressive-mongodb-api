<?php

namespace App\Helper\Validator;

use Bissolli\ValidadorCpfCnpj\CPF;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CpfValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $validacao = new CPF($value);

        if (!$validacao->isValid()) {
            $this->context->buildViolation($constraint->message)
               ->addViolation();
        }
    }
}
