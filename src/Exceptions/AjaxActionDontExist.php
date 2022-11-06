<?php

namespace Bws\Core\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class AjaxActionDontExist extends \Exception
{
    protected $code = SymfonyResponse::HTTP_PRECONDITION_FAILED;
    protected $message = 'Ajax action n\'t exist!';
}
