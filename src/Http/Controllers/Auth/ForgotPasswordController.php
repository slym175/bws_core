<?php

namespace Bws\Core\Http\Controllers\Auth;

use Bws\Core\Http\Controllers\CoreController;
use Bws\Core\Traits\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends CoreController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
}
