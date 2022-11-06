<?php

namespace Bws\Core\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class NoFieldNameException extends \Exception
{
    protected $code = SymfonyResponse::HTTP_PRECONDITION_FAILED;
    protected $message = 'Field\'s set name.';
}
