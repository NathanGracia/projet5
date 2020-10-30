<?php


namespace Core\Form\Type;


use Core\Form\Constraint\AConstraint;

abstract class AFormType
{
    private $constraints;
    private $value;

    /**
     * AFormType constructor.
     * @param AConstraint[] $constraints
     */
    public function __construct($constraints = [])
    {
        $this->constraints = $constraints;
    }

    /**
     * @return array|mixed
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /**
     * @param array|mixed $constraints
     * @return AFormType
     */
    public function setConstraints($constraints)
    {
        $this->constraints = $constraints;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return TextType
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}