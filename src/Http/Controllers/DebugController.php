<?php

namespace Bws\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DebugController extends CoreController
{
    public function optimizeClear(Request $request)
    {
        try {
            Artisan::call('optimize:clear');
            return redirect()->back()->with('_success_msg', trans('bws/core::core.optimize-clear'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('_error_msg', $ex->getMessage());
        }
    }

    public function cacheClear(Request $request)
    {
        try {
            Artisan::call('cache:clear');
            return redirect()->back()->with('_success_msg', trans('bws/core::core.cache-clear'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('_error_msg', $ex->getMessage());
        }
    }

    public function purgeAssets()
    {
        try {
            Artisan::call('assets:purge');
            return redirect()->back()->with('_success_msg', trans('bws/core::core.purge-assets'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('_error_msg', $ex->getMessage());
        }
    }
}
