<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventFootball;

/**
 * Class EventSeeder
 *
 * Seeder for populating the events table with football events.
 */
class EventSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        $this->runEventFootball();
    }

    /**
     * Run the football events seeder.
     *
     * This method creates several football events with their details.
     */
    private function runEventFootball(): void
    {

        $event1=Event::create([
            'type' => 'football',
            'start_time' => '2025-05-09 20:45:00',
            'status' => 'in_progress',
        ]);

        $event2=Event::create([
            'type' => 'football',
            'start_time' => '2025-05-09 21:00:00',
            'status' => 'in_progress',

        ]);

        $event3=Event::create([
            'type' => 'football',
            'start_time' => '2025-05-09 21:00:00',
            'status' => 'in_progress',

        ]);

        $event4=Event::create([
            'type' => 'football',
            'start_time' => '2025-05-11 15:00:00',
            'status' => 'in_progress',

        ]);
        $event5=Event::create([
            'type' => 'football',
            'start_time' => '2025-05-11 18:00:00',
            'status' => 'in_progress',

        ]);
        $event6=Event::create([
            'type' => 'football',
            'start_time' => '2025-05-12 20:30:00',
            'status' => 'in_progress',
        ]);

        $event7=Event::create([
            'type' => 'football',
            'start_time' => '2025-05-12 20:45:00',
            'status' => 'in_progress',
        ]);

        $event8=Event::create([
            'type' => 'football',
            'start_time' => '2025-05-13 21:00:00',
            'status' => 'in_progress',
        ]);

        EventFootball::create([
            'id' => $event1->id,
            'home_team' => 'Genoa',
            'away_team' => 'AC Milan',
            'home_score' => 1,
            'away_score' => 2,
            'start_time' => $event1->start_time,
            'competition' => 'Serie A',
            'season' => '24/25',
            'stadium' => 'Stadio Luigi Ferraris',
            'city' => 'Genova',
            'country' => 'Italia',
            'status' => $event1->status,
            'quote_2' => 1.8,
            'quote_X' => 3.5,
            'quote_1' => 4.2,
        ]);

        EventFootball::create([
            'id' => $event2->id,
            'home_team' => 'Crystal Palace',
            'away_team' => 'Nottingham Forest',
            'home_score' => 1,
            'away_score' => 1,
            'start_time' => $event2->start_time,
            'competition' => 'Premier League',
            'season' => '24/25',
            'stadium' => 'Selhurst Park',
            'city' => 'Londra',
            'country' => 'Inghilterra',
            'status' => $event2->status,
            'quote_2' => 1.8,
            'quote_X' => 3.5,
            'quote_1' => 4.2,
        ]);

        EventFootball::create([
            'id' => $event3->id,
            'home_team' => 'Girona',
            'away_team' => 'Mallorca',
            'home_score' => 1,
            'away_score' => 0,
            'start_time' => $event3->start_time,
            'competition' => 'La Liga',
            'season' => '24/25',
            'stadium' => 'Estadi Montilivi',
            'city' => 'Girona',
            'country' => 'Spagna',
            'status' => $event3->status,
            'quote_2' => 1.8,
            'quote_X' => 3.5,
            'quote_1' => 4.2,
        ]);
        EventFootball::create([
            'id' => $event4->id,
            'home_team' => 'Bologna',
            'away_team' => 'Napoli',
            'home_score' => 1,
            'away_score' => 0,
            'start_time' => $event4->start_time,
            'competition' => 'Serie A',
            'season' => '24/25',
            'stadium' => 'Stadio Renato Dall\'Ara',
            'city' => 'Bologna',
            'country' => 'Italia',
            'status' => $event4->status,
            'quote_2' => 1.8,
            'quote_X' => 3.5,
            'quote_1' => 4.2,
        ]);
        EventFootball::create([
            'id' => $event5->id,
            'home_team' => 'Real Madrid',
            'away_team' => 'Barcelona',
            'home_score' => 3,
            'away_score' => 4,
            'start_time' => $event5->start_time,
            'competition' => 'La Liga',
            'season' => '24/25',
            'stadium' => 'Santiago Bernabeu',
            'city' => 'Madrid',
            'country' => 'Spagna',
            'status' => $event5->status,
            'quote_2' => 1.8,
            'quote_X' => 3.5,
            'quote_1' => 4.2,
        ]);
        EventFootball::create([
            'id' => $event6->id,
            'home_team' => 'Manchester United',
            'away_team' => 'Liverpool',
            'home_score' => 2,
            'away_score' => 2,
            'start_time' => $event6->start_time,
            'competition' => 'Premier League',
            'season' => '24/25',
            'stadium' => 'Old Trafford',
            'city' => 'Manchester',
            'country' => 'Inghilterra',
            'status' => $event6->status,
            'quote_2' => 1.8,
            'quote_X' => 3.5,
            'quote_1' => 4.2,
        ]);

        EventFootball::create([
            'id' => $event7->id,
            'home_team' => 'Inter',
            'away_team' => 'Juventus',
            'home_score' => 2,
            'away_score' => 0,
            'start_time' => $event7->start_time,
            'competition' => 'Serie A',
            'season' => '24/25',
            'stadium' => 'San Siro',
            'city' => 'Milano',
            'country' => 'Italia',
            'status' => $event7->status,
            'quote_2' => 1.8,
            'quote_X' => 3.5,
            'quote_1' => 4.2,
        ]);

        EventFootball::create([
            'id' => $event8->id,
            'home_team' => 'Bayern Munich',
            'away_team' => 'Borussia Dortmund',
            'home_score' => 3,
            'away_score' => 1,
            'start_time' => $event8->start_time,
            'competition' => 'Bundesliga',
            'season' => '24/25',
            'stadium' => 'Allianz Arena',
            'city' => 'Monaco',
            'country' => 'Germania',
            'status' => $event8->status,
            'quote_2' => 1.8,
            'quote_X' => 3.5,
            'quote_1' => 4.2,
        ]);
    }
}