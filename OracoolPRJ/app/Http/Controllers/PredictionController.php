<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLayer;

/**
 * PredictionController handles the creation and storage of predictions for football events.
 * It retrieves today's football events and allows users to make predictions.
 */
class PredictionController extends Controller
{
    /**
     * Display the prediction creation form with today's football events.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $dl = new DataLayer();
        $eventsFootball = $dl->getTodayEventsFootballPredictions();

        $pred=0;
        foreach ($eventsFootball as $eventFootball) {
            if ($eventFootball->status === 'scheduled') {
                $pred=1;
            }
        }

        if ($eventsFootball->isEmpty()) {
            return view('prediction', ['eventsFootball' => $eventsFootball, 'error' => __('error.no-predictions-today'),]);
            
        } elseif ($pred == 0) {
            return view('prediction', ['eventsFootball' => $eventsFootball, 'error' => __('error.no-predictions-today'),]);

        } else {
            return view('prediction', ['eventsFootball' => $eventsFootball,]);
        }
    }

    /**
     * Store predictions for today's football events.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $dl = new DataLayer();
        $eventsFootball = $dl->getTodayEventsFootball();
        

        foreach ($eventsFootball as $eventFootball) {
            if ($request->input($eventFootball->id)) {
                $dl->storeTodayEventsFootballPredictions($eventFootball->id, $request->input($eventFootball->id));
            }
        }

        return redirect()->route('prediction.create')->with('success', __('error.prediction-registered-successfully'));
    }
}