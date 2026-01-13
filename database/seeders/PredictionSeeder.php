<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prediction;
use App\Models\PredictionFootball;
use App\Models\Event;
use App\Models\User;
use App\Models\EventFootball;

/**
 * Class PredictionSeeder
 *
 * Seeder for populating the predictions table with user predictions for events.
 */
class PredictionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id')->toArray();
        $eventIds = Event::pluck('id')->toArray();

        $combinations = collect($userIds) 
            ->crossJoin($eventIds) 
            ->shuffle();

        foreach ($combinations as [$userId, $eventId]) {
            $prediction = Prediction::create([
                'user_id' => $userId,
                'event_id' => $eventId,
            ]);

            $event = Event::find($eventId);
            if ($event->type === 'football') {
                $predictionFootball = PredictionFootball::factory()->create(['id' => $prediction->id]);

                $eventFootball = EventFootball::find($eventId);
                if ($eventFootball->home_score > $eventFootball->away_score) {
                    if ($predictionFootball->predicted_1){
                        $prediction->value=true;
                    } else{
                        $prediction->value=false;
                    }
                } elseif ($eventFootball->home_score < $eventFootball->away_score) {
                    if ($predictionFootball->predicted_2){
                        $prediction->value=true;
                    } else{
                        $prediction->value=false;
                    }
                } elseif ($eventFootball->home_score = $eventFootball->away_score) {
                    if ($predictionFootball->predicted_X){
                        $prediction->value=true;
                    } else{
                        $prediction->value=false;
                    }
                }
                $prediction->save();
            }

            // Aggiungi qui altre condizioni per altri tipi di eventi, con le rispettive factory
        }
    }
}