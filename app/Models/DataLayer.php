<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use App\Models\EventFootball;
use App\Models\Prediction;
use App\Models\PredictionFootball;
use Illuminate\Support\Facades\Auth;


/**
 *  DataLayer is a model class that interacts with the database to manage football events and predictions.
 *  It provides methods to retrieve today's football events, store predictions, add new events, and close events with results.
 *  It also handles user-specific predictions and updates user points based on the outcome of the events.
 */
class DataLayer extends Model
{

    /**
     * Get today's football events.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getTodayEvents(){

        $events = Event::whereDate('start_time', now()->toDateString())
            ->orderBy('start_time','asc')
            ->get();

        return $events; 
    }

    /**
     * Get today's football events with their predictions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTodayEventsFootball(){

        $events = $this->getTodayEvents()
            ->where('type', 'football')
            ->pluck('id');;

        
        $eventsFootball = EventFootball::whereIn('id', $events)
            ->orderBy('start_time', 'asc')
            ->get();
    

        return $eventsFootball; 
    }

    /**
     * Get today's football events with user predictions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTodayEventsFootballPredictions(){

        $eventsFootball = $this->getTodayEventsFootball();

        if (Auth::check()) {
            $userId = Auth::user()->id;

            foreach ($eventsFootball as $event) {
                $prediction = Prediction::where('user_id', $userId)
                    ->where('event_id', $event->id)
                    ->first(); // Restituisce null se non esiste

                if ($prediction) {
                    $predictionFootball = PredictionFootball::where('id', $prediction->id)
                        ->first(); // Restituisce null se non esiste

                    if ($predictionFootball) {
                        $event->predicted_1 = $predictionFootball->predicted_1;
                        $event->predicted_X = $predictionFootball->predicted_X;
                        $event->predicted_2 = $predictionFootball->predicted_2;
                    }
                }
            }
        }

        return $eventsFootball; 
    }

    /**
     * Store today's football event predictions for the authenticated user.
     *
     * @param int $id The ID of the event.
     * @param string $result The predicted result ('1', '2', or 'X').
     * @return void
     */
    public function storeTodayEventsFootballPredictions($id, $result){

        $prediction = Prediction::updateOrCreate(
            [
                'event_id' => $id,
                'user_id' => Auth::user()->id,
            ]
        );

        $predictionFootball = PredictionFootball::updateOrCreate(
            ['id' => $prediction->id], 
            [
                'predicted_1' => $result === '1',
                'predicted_2' => $result === '2',
                'predicted_X' => $result === 'X',
            ]
        );
    }

    /**
     * Add a new football event to the database.
     *
     * @param string $start_time The start time of the event.
     * @param string $home_team The home team name.
     * @param string $away_team The away team name.
     * @param string $competition The competition name.
     * @param string $season The season name.
     * @param string $stadium The stadium name.
     * @param string $city The city where the event takes place.
     * @param string $country The country where the event takes place.
     * @param float $quote_1 The quote for home win.
     * @param float $quote_X The quote for draw.
     * @param float $quote_2 The quote for away win.
     */
    public function addEventFootball($start_time, $home_team, $away_team, $competition, $season, $stadium, $city, $country, $quote_1, $quote_X, $quote_2){

        $event = Event::create([
            'status' => 'scheduled',
            'type' => 'football',
            'start_time' => $start_time,
        ]);

        EventFootball::create([
            'id' => $event->id,
            'start_time' => $event->start_time,
            'competition' => $competition,
            'home_team' => $home_team,
            'away_team' => $away_team,
            'season' => $season,
            'stadium' => $stadium,
            'city' => $city,
            'country' => $country,
            'status' => 'scheduled',
            'quote_1' => $quote_1,
            'quote_X' => $quote_X,
            'quote_2' => $quote_2,
        ]);
    }

    /**
     * Close a football event by updating its scores and status.
     *
     * @param int $id The ID of the event.
     * @param int $home_score The score of the home team.
     * @param int $away_score The score of the away team.
     */
    public function closeEventFootball($id, $home_score, $away_score){

        $eventFootball = EventFootball::findOrFail($id);
        $eventFootball->home_score = $home_score;
        $eventFootball->away_score = $away_score;
        $eventFootball->status = 'ended';
        $eventFootball->save();
        

        $event = Event::findOrFail($id);
        $event->status = 'ended';
        $event->save();

        $this->closePredictionFootball($event);
    }

    /**
     * Close predictions for a football event by calculating the results and updating user points.
     *
     * @param Event $event The event for which predictions are being closed.
     */
    private function closePredictionFootball($event)
    {
        $predictions = Prediction::where('event_id', $event->id)->get();
        $eventFootball = EventFootball::find($event->id);


        foreach ($predictions as $prediction) {

            $predictionFootball = PredictionFootball::where('id', $prediction->id)->first();

            $actualResult = null;
            $points = -1;

            if ($eventFootball->home_score > $eventFootball->away_score) {
                $actualResult = '1';
            } elseif ($eventFootball->home_score < $eventFootball->away_score) {
                $actualResult = '2';
            } elseif ($eventFootball->home_score == $eventFootball->away_score) {
                $actualResult = 'X';
            }

            if ($actualResult === '1' && $predictionFootball->predicted_1) {
                $prediction->value = true;
                $points = $eventFootball->quote_1;
            } elseif ($actualResult === '2' && $predictionFootball->predicted_2) {
                $prediction->value = true;
                $points = $eventFootball->quote_2;
            } elseif ($actualResult === 'X' && $predictionFootball->predicted_X) {
                $prediction->value = true;
                $points = $eventFootball->quote_X;
            } else {
                $prediction->value = false;
            }

            if ($prediction->value) {
                User::find($prediction->user_id)?->increment('points', $points);
            }
            $prediction->save();
        }
    }


    /**     * Edit an existing football event with new data.
     *
     * @param int $id The ID of the event to edit.
     * @param \Illuminate\Http\Request $request The request containing the updated data.
     */
    public function editEventFootball($id, $request)
    {
        $eventFootball = EventFootball::findOrFail($id);

        $updateData = $request->only([
            'home_score', 'away_score', 'season', 'start_time',
            'stadium', 'city', 'country', 'quote_1', 'quote_X', 'quote_2'
        ]);
        $updateData = array_filter($updateData, function($value) {
            return $value !== null;
        });


        if (!empty($updateData)) {
            $eventFootball->update($updateData);
            
        }
        if ($request->has('start_time') && $request->input('start_time') !== null) {
            Event::find($id)->update([
                'start_time' => $request->input('start_time'),
            ]);
        }
    }

    
    /**
     *  Detect if a football event already exists based on home team, away team, and competition.
     * @param string $home The home team name.
     * @param string $away The away team name.
     * @param string $competition The competition name.
     * @return bool True if the event exists, false otherwise.
     */
    public function detectIfExixtsEventFootball($home,  $away,  $competition)
    {
        return EventFootball::where('home_team', $home)
            ->where('away_team', $away)
            ->where('competition', $competition)
            ->where('status', 'scheduled')
            ->exists();
    }

    /**
     * Get a football event by its ID.
     *
     * @param int $id The ID of the event.
     * @return EventFootball
     */
    public function getEventFootballById($id)
    {
        return EventFootball::findOrFail($id);
    }

    /**
     * Get football events that are scheduled for today.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getEventFootballEditing  (){
        $eventsFootball = EventFootball::where('status', '!=', 'ended')
            ->where('status', '!=', 'deleted')
            ->orderBy('start_time', 'asc')
            ->get();

        return $eventsFootball;
    }

    /**
     * Get football events that are currently in progress.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getEventFootballClosing  (){
        $eventsFootball = EventFootball::where('status', 'in_progress')
            ->orderBy('start_time', 'asc')
            ->get();

        return $eventsFootball;
    }


    
    /**
     * Add random predictions for each user on random football events.
     */
    public function addPredictions (){
        foreach (User::all() as $user) {
            if ($user->admin) 
                continue;
            $events = EventFootball::all();
            $rand = rand(2,5);
            for ($i = 0; $i < $rand; $i++) {
                $event = $events->random();
                $this->addRandomPredictions($event->id, $user->id);
            }
        }
    }
    /**
     * Add random predictions for a specific event and user.
     *
     * @param int $eventId The ID of the event.
     * @param int $userId The ID of the user.
     */
    private function addRandomPredictions($eventId, $userId)
    {
        $prediction = Prediction::updateOrCreate(
            [
                'event_id' => $eventId,
                'user_id' => $userId,
            ]
        );

        $randomResult = rand(0, 2);
        $predicted_1 = $randomResult === 0;
        $predicted_X = $randomResult === 1;
        $predicted_2 = $randomResult === 2;

        PredictionFootball::updateOrCreate(
            ['id' => $prediction->id],
            [
                'predicted_1' => $predicted_1,
                'predicted_X' => $predicted_X,
                'predicted_2' => $predicted_2,
            ]
        );

        $event= EventFootball::findOrFail($eventId);
        if ($event->home_score>$event->away_score && $predicted_1) {
            $prediction->value = true;
            User::find($userId)->increment('points', $event->quote_1);
        } elseif ($event->home_score<$event->away_score && $predicted_2) {
            $prediction->value = true;
            User::find($userId)->increment('points', $event->quote_2);
        } elseif ($event->home_score==$event->away_score && $predicted_X) {
            $prediction->value = true;
            User::find($userId)->increment('points', $event->quote_X);
        } else {
            $prediction->value = false;
        }
        $prediction->save();
    }
}