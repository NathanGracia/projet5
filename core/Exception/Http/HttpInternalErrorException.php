<?php


namespace Core\Exception\Http;


use Throwable;

class HttpInternalErrorException extends AHttpException
{
    public function __construct($httpMessage = 'Internal error',$message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($httpMessage, 500, $message, $code, $previous);

    }
}