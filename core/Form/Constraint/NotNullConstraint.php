<?php

namespace Core\Form\Constraint;

class NotNullConstraint extends AConstraint
{
    public function isValid($value): bool
    {
        return $value !== null;
    }
}