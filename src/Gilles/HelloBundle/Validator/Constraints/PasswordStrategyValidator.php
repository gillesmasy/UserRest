<?php
// src/Gilles/HelloBundle/Validator/Constraints/PasswordStrategyValidator.php

namespace Gilles\HelloBundle\Validator\Constraints;

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
