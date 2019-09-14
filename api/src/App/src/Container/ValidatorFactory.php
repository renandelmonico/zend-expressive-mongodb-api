<?php
/**
 * @author Renan Delmonico <renandelmonico@gmail.com>
 */
namespace App\Container;

use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Validation;

class ValidatorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
    }
}
