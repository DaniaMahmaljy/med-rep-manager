<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function swap(Request $request)
    {
        if (!array_key_exists($request->locale, config('local.available_locales'))) {
            session()->flash('error', 'Invalid locale');
            return redirect()->back();
        }

        session()->put('locale', $request->locale);
        session()->flash('message', 'Language changed successfully');

        return redirect()->back();
    }
}
