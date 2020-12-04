<?php

namespace Core\Form\Constraint;

class NotEmptyConstraint extends AConstraint
{

    public function isValid($value): bool
    {
        return is_string($value) && mb_strlen($value) > 0;
    }
}