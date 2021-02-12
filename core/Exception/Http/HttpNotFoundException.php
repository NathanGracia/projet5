<?php


namespace Core\Exception\Http;


use Throwable;

class HttpNotFoundException extends AHttpException
{
    public function __construct($httpMessage = 'Page not found',$message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($httpMessage, 404, $message, $code, $previous);

    }
}