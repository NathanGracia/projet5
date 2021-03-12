<?php

namespace Core\Form\Constraint;

class NotNullConstraint extends AConstraint
{
    public function isValid($value): bool
    {
        return $value !== null;
    }

    public function getMessage(): string
    {
        return "Veuillez remplir tout les champs obligatoires";
    }
}