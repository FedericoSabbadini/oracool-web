<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * LangController handles the language and timezone settings.
 * It provides methods to change the language and set the timezone.
 */
class LangController extends Controller
{
    /**
     * Display the language selection view.
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, $lang)
    {
        session()->put('language', $lang);
        
        return redirect()->back();
    }

    /**
     * Set the timezone based on user input.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setTimezone(Request $request)
    {
        
        $timezone = $request->input('timezone');

        if ($timezone) {
            session()->put('timezone', $timezone);
            return response()->json(['message' => "Timezone set successfully, $timezone"]);
        } else {
            return response()->json(['message' => 'Timezone not provided'], 400);
        }
        
    }
}