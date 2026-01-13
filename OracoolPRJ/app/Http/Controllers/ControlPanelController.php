<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLayer;
use App\Models\EventFootball;

/**
 * ControlPanelController handles the control panel functionalities.
 * It provides methods to display the control panel, create or edit predictions,
 * and close predictions for football events.
 */
class ControlPanelController extends Controller
{
    /**
     * Display the control panel view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('controlPanel');
    }
}