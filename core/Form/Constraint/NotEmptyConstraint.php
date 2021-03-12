<?php

namespace Core\Form\Constraint;

class NotEmptyConstraint extends AConstraint
{

    public function isValid($value): bool
    {
        return is_string($value) && mb_strlen($value) > 0;
    }

    public function getMessage(): string
    {
        return "Veuillez remplir tout les champs obligatoires";
    }
}