<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLayer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * PredictionAddController handles the creation and storage of predictions.
 * It provides methods to display the prediction form and store predictions in the database.
 */
class PredictionAddController extends Controller
{

    /**
     * Display the prediction creation form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $clubData = include resource_path('data/clubData.php');

        return view('predictionAdd', [
        'teams' => $clubData['teams'],
        'countries' => $clubData['countries'],
        'cities' => $clubData['cities'],
        'stadiums' => $clubData['stadiums'],
        'competitions' => $clubData['competitions'],

        'stadiums_cwc' => $clubData['club_world_cup_usa_stadiums'],
        'cities_cwc' => $clubData['club_world_cup_usa_cities'],
        ]);;
    }

    /**
     * Store a new prediction in the database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $dl = new DataLayer();
        $start_time = Carbon::createFromFormat('d-m-Y, H:i', $request->input('start_time'));
    
        switch ($request->input('type')) {
            case 'football':
                $dl->addEventFootball(
                    $start_time,
                    $request->input('home_team'),
                    $request->input('away_team'),
                    $request->input('competition'),
                    $request->input('season'),
                    $request->input('stadium'),
                    $request->input('city'),
                    $request->input('country'),
                    $request->input('quote_1'),
                    $request->input('quote_X'),
                    $request->input('quote_2')
                );
                break;
            default:
                throw new \Exception("Invalid event type");
        }
        return redirect()->route('controlPanel.index')->with('success', __('error.prediction-added-successfully'));
    }

    /**
     * Store a new prediction via AJAX.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAjax (Request $request) {

        $dl = new DataLayer();
        $exists = $dl->detectIfExixtsEventFootball(
            $request->input('home_team'),
            $request->input('away_team'),
            $request->input('competition')
        );

        if ($exists) {
           return response()->json(['error' => __('error.event-already-exists')]);
        } else {
            return response()->json(['success' => __('error.event-not-found')]);
        }
    }
}