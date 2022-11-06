<?php

namespace Bws\Core\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class UnsupportedFieldTypeException extends \Exception
{
    protected $code = SymfonyResponse::HTTP_PRECONDITION_FAILED;
    protected $message = 'This field type\'s unsupported.';
}
