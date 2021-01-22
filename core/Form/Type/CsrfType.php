<?php


namespace Core\Form\Type;

use DateTime;
use Ramsey\Uuid\Uuid;

class CsrfType extends AFormType
{
    private static $token;
    public function generate(): string {
        if(!isset(self::$token)){
            self::$token = Uuid::uuid4()->toString();

            $_SESSION['_csrf'] = [
                'token' => self::$token,
                'createdAt' => new DateTime()
            ];
        }

        return self::$token;
    }
}