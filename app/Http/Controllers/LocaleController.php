<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log; 

class LocaleController extends Controller
{
    public function switchLocale(Request $request)
    {
        Log::info($request);
        $request->validate([
            'locale' => 'required|string|in:en,hr',
        ]);

        session()->put('locale', $request->locale);
        
        App::setLocale($request->locale);
        Log::info($request->locale);

        return redirect()->back(); 
    }
}
