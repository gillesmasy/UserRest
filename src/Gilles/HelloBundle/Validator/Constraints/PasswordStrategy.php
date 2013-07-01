<?php
// src/Gilles/HelloBundle/Validator/Constraints/PasswordStrategy.php

namespace Gilles\HelloBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PasswordStrategy extends Constraint {
    public $message = 'Le password "%string%" ne correspond pas à la stratégie de sécurité.';
}

?>
