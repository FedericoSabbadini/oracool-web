<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventFootball;
use App\Models\DataLayer;
use Carbon\Carbon;
use App\Models\Event;

/**
 * PredictionEditController handles the editing of predictions for football events.
 * It provides methods to display the edit form and update predictions in the database.
 */
class PredictionEditController extends Controller
{

    /**
     * Create a new prediction.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $dl = new DataLayer();
        $eventsFootball = $dl->getEventFootballEditing();

        if($eventsFootball->isEmpty()){
            return redirect()->route('controlPanel.index')->with('error', 'No events available for editing.');
        } else {
            return view('predictionList', ['eventsFootball' => $eventsFootball, 'action' => 'edit']);
        }
    }

    /**
     * Display the prediction edit form for a specific event.
     *
     * @param int $id
     * @return \Illuminate\View\View
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show($id)
    {
        $dl = new DataLayer();
        $eventFootball = $dl->getEventFootballById($id);
        $clubData = include resource_path('data/clubData.php');

        return view('predictionEdit', [
        'eventFootball' => $eventFootball,         
        'stadiums_cwc' => $clubData['club_world_cup_usa_stadiums'],
        'cities_cwc' => $clubData['club_world_cup_usa_cities'],
    ]);
    }

    /**
     * Update the prediction for a specific event.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function edit(Request $request, $id)
    {
        $dl = new DataLayer();
        $start_time = Carbon::createFromFormat('d-m-Y, H:i', $request->input('start_time'));

        switch ($request->input('type')) {
            case 'football':
                $dl->editEventFootball(
                    $id, 
                    $request
                );
                break;
            default:
                throw new \Exception("Invalid event type");
        }

        return redirect()->route('predictionEdit.create')->with('success', __('error.prediction-edited-successfully'));

    }
}