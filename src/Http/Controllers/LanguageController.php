<?php

namespace Bws\Core\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends CoreController
{
    public function setLanguage(Request $request, $language)
    {
        try {
            app()->setLocale($language);
            session()->put('locale', $language);
            return redirect()->back()->with('_success_msg', trans('bws/core::core.set-language'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('_error_msg', $ex->getMessage());
        }
    }
}
