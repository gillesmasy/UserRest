<?php
// src/Gilles/UserRestBundle/Validator/Constraints/PasswordStrategy.php

namespace Gilles\UserRestBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PasswordStrategy extends Constraint {
    public $message = 'Le password "%string%" ne correspond pas à la stratégie de sécurité.';
}

?>
