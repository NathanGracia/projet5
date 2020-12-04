<?php


namespace Core\Form\Type;

use DateTime;
use Ramsey\Uuid\Uuid;

class CsrfType extends AFormType
{
    public function generate(): string {
        $csrf = [
            'token' => Uuid::uuid4()->toString(),
            'createdAt' => new DateTime()
        ];

        $_SESSION['_csrf'] = $csrf;
     
        return $csrf['token'];
    }
}