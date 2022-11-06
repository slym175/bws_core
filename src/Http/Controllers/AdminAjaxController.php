<?php

namespace Bws\Core\Http\Controllers;

use Bws\Core\Exceptions\AjaxActionDontExist;
use Illuminate\Http\Request;

class AdminAjaxController extends CoreController
{
    public function __invoke(Request $request)
    {
        try {
            $action = $request->input('_action', null);
            if (!$action) {
                throw new AjaxActionDontExist();
            }
        } catch (AjaxActionDontExist $ex) {
            report($ex->getMessage());
        }
    }
}
