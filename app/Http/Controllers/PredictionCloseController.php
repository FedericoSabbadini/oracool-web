<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLayer;
use App\Models\EventFootball;
use App\Models\Event;

/**
 * PredictionCloseController handles the closing of predictions for events.
 * It retrieves the event details and allows updating the scores for football events.
 */
class PredictionCloseController extends Controller
{

    /**
     * Close predictions for football events.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $dl = new DataLayer();
        $eventsFootball = $dl->getEventFootballClosing();

        if($eventsFootball->isEmpty()){
            return redirect()->route('controlPanel.index')->with('error', 'No events available for closing.');
        } else {
            return view('predictionList', ['eventsFootball' => $eventsFootball, 'action' => 'close']);

        }
    }

    /**
     * Show the form for closing a prediction for a specific event.
     *
     * @param int $id The ID of the event.
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $dl = new DataLayer();
        $eventFootball = $dl->getEventFootballById($id);

        return view('predictionClose', ['eventFootball' => $eventFootball]);
    }

    /**
     * Update the prediction for a specific event.
     *
     * @param Request $request The request containing the updated scores.
     * @param int $id The ID of the event.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $dl = new DataLayer();
    
        switch ($request->input('type')) {
            case 'football':
                $dl->closeEventFootball(
                    $id,
                    $request->input('home_score'),
                    $request->input('away_score'),
                );
                break;
            default:
                throw new \Exception("Invalid event type");
        }
        return redirect()->route('predictionClose.create')->with('success', __('error.prediction-closed-successfully'));
    }
}