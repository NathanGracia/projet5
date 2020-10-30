<?php

namespace Core\Form\Constraint;

abstract class AConstraint
{
    abstract public function isValid($value): bool;
}