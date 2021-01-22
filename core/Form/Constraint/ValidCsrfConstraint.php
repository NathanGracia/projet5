<?php

namespace Core\Form\Constraint;
use DateTime;

class ValidCsrfConstraint extends AConstraint
{
    public function isValid($value): bool
    {
        $sessionCsrf = $_SESSION['_csrf'] ?? null;
    
        if (!$sessionCsrf){
            return false;
        }
      
        if($sessionCsrf['token'] !== $value ){
    
            return false;
        }
        
        if(!$sessionCsrf['createdAt'] instanceof \DateTimeInterface){
            return false;
        }
    
        $seconds = (new DateTime())->getTimestamp() - $sessionCsrf['createdAt']->getTimestamp(); 

        if ($seconds >= 10*60){
      

            return false;
        }
 
      
        return true;
    }
}