<?php

namespace Core\Form\Constraint;
use DateTime;

class ValidCsrfConstraint extends AConstraint
{
    public function isValid($value): bool
    {
        $sessionCsrf = $_SESSION['_csrf'] ?? null;
        var_dump('1');
        if (!$sessionCsrf){
            return false;
        }
        var_dump('2');
        if($sessionCsrf['token'] !== $value ){
    
            return false;
        }
        var_dump('3');
        if(!$sessionCsrf['createdAt'] instanceof \DateTimeInterface){
            return false;
        }
        var_dump('4');
        $seconds = (new DateTime())->getTimestamp() - $sessionCsrf['createdAt']->getTimestamp(); 

        if ($seconds >= 10*60){
            var_dump($seconds);

            return false;
        }
        var_dump('5');
      
        return true;
    }
}