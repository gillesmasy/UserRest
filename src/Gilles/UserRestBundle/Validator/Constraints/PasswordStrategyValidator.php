<?php
// src/Gilles/UserRestBundle/Validator/Constraints/PasswordStrategyValidator.php

namespace Gilles\UserRestBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordStrategyValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint){
        /* Préciser la logique validant le password
         * Exemple : 
         * if(strlen ($value) < 3){
         *    $this->context->addViolation($constraint->message, array('%string%' => $value ));
         * }
         */
    }
}

?>
