<?php

namespace App\Helper;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class Validator
{
    public static function getMessageArray(ConstraintViolationListInterface $messages)
    {
        $messagesList = [];
        for ($index = 0; $index < $messages->count(); $index++) {
            $messagesList[] = $messages->get($index)->getMessage();
        }

        return $messagesList;
    }
}
