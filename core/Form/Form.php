<?php


namespace Core\Form;


use Core\Form\Type\AFormType;
use Core\Utilities\Explorer;

class Form
{
    private $parts = [];
    private $datas;

    public function __construct($parts, $datas = [])
    {
        $this->parts = $parts;
        $this->datas = $datas;

        foreach ($this->parts as $name => $type) {

            $type->setValue(Explorer::getValue($datas, $name));

        }
    }

    public function isSubmitted(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isValid()
    {

        if(empty($this->getErrors())){
            return true;
        }else{
            return false;
        }


    }
    public function getErrors(){
        /**
         * @var string $name
         * @var AFormType $type
         */
        $errorMessages = [];
        foreach ($this->parts as $name => $type) {
            foreach ($type->getConstraints() as $constraint) {
                if (!$constraint->isValid($type->getValue())) {
                    $errorMessages[] = $constraint->getMessage();
                }
            }
        }

        return array_unique($errorMessages);
    }

    public function handleRequest(): void
    {
        if ($this->isSubmitted()) {
            /**
             * @var string $name
             * @var AFormType $type
             */
            foreach ($this->parts as $name => $type) {
                $type->setValue($_POST[$name] ?? null);
                Explorer::setValue($this->datas, $name, $type->getValue());
            }
        }
    }

    public function getData()
    {
        return $this->datas;
    }

    public function getParts(){
        return $this->parts;
    }
}