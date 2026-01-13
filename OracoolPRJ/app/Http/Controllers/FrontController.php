<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * FrontController handles the main functionalities of the application.
 * It provides methods to display the index view and manage user admin status.
 */
class FrontController extends Controller
{
    /**
     * Display the index view or redirect to the control panel if the user is an admin.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->admin) 
        {
            return redirect()->route('controlPanel.index');
        } 
        else 
        {
            return view('index');
        }
    }

    /**
     * Set the admin status of the authenticated user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setIsAdmin(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Utente non autenticato');
        }

        $adminValue = $request->input('admin');

        if (!in_array($adminValue, ['0', '1', 0, 1], true)) {
            return response()->json(['error' => 'Valore admin non valido'], 422);
        }

        $user->admin = $adminValue;
        $user->save();

        return response()->json(['success' => true]);
    }
}