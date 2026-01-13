<?php

namespace App\Services;

use App\Models\EventFootball;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Event;
use Carbon\Carbon;

/**
 * OddsApiService interacts with the Odds API to fetch and update football event odds.
 * It provides methods to retrieve odds for specific leagues and update events in the database.
 */
class OddsApiService
{
    /**
     * Recupera le quote per gli eventi di calcio
     *
     * @param string $league
     * @return array
     */
    public function getFootballOdds($league)
    {
        try {
            $baseUrl = env('FOOTBALL_API_BASE_URL');
            $apiKey = env('FOOTBALL_API_KEY');

            if (!$baseUrl || !$apiKey) {
                Log::error('Base URL or API key not set in environment variables');
                return [];
            }

            $response = Http::get($baseUrl . '/' . $league . '/odds', [
                'api_key' => $apiKey,
                'regions' => 'eu',
                'markets' => 'h2h,spreads,totals',
                'dateFormat' => 'iso'
            ]);

            if ($response->successful()) {
                return $response->json();
            }
            
            Log::error('Errore API quote: ' . $response->status() . ' - ' . $response->body());
            return [];
        } catch (\Exception $e) {
            Log::error('Errore nel recupero delle quote: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Aggiorna le quote degli eventi di calcio nel database
     *
     * @param string $league
     * @return array
     */
    public function updateEventsOdds($league)
    {
        Log::info('Inizio aggiornamento quote per la lega: ' . $league);
        $apiData = $this->getFootballOdds($league);
        $updatedCount = 0;
        $matchedByTeams = 0;
        $foundApiEvents = count($apiData);

        Log::info('Eventi trovati dall\'API: ' . $foundApiEvents);

        if (empty($apiData)) {
            Log::error('Nessun dato ricevuto dall\'API');
            return [
                'updated' => 0,
                'api_events' => 0,
                'matched_by_teams' => 0,
                'db_events' => EventFootball::count(),
                'error' => 'Nessun dato ricevuto dall\'API'
            ];
        }

        $allEvents = EventFootball::where('status', 'scheduled')->get();
        Log::info('Eventi trovati nel database: ' . $allEvents->count());
        foreach ($allEvents as $event) {
            $homeTeam = $event->home_team;
            $awayTeam = $event->away_team;
                        
            $matchingApiEvent = collect($apiData)->first(function($apiEvent) use ($homeTeam, $awayTeam) {
            return $apiEvent['home_team'] === $homeTeam && $apiEvent['away_team'] === $awayTeam;
            });
            
            if ($matchingApiEvent) {
            $matchedByTeams++;
            $odds = $this->calculateAverageOdds($matchingApiEvent, $homeTeam, $awayTeam);
            
            $event->quote_1 = $odds['quote1'];
            $event->quote_X = $odds['quoteX'];
            $event->quote_2 = $odds['quote2'];
            $event->save();
            
            $updatedCount++;
            Log::info("Quote aggiornate per l'evento: $homeTeam vs $awayTeam");
            } else {
            Log::info("Nessun dato API trovato per l'evento: $homeTeam vs $awayTeam");
            }
        }

        return [
            'updated' => $updatedCount,
            'api_events' => $foundApiEvents,
            'matched_by_teams' => $matchedByTeams,
            'db_events' => $allEvents->count()
        ];
    }


    /**
     * Calcola la media delle quote dai dati dell'API
     *
     * @param array $eventData
     * @param string $homeTeam
     * @param string $awayTeam
     * @return array
     */
    private function calculateAverageOdds($eventData, $homeTeam, $awayTeam)
    {
        $quote1 = $quoteX = $quote2 = 0;
        $count1 = $countX = $count2 = 0;
        
        foreach ($eventData['bookmakers'] as $bookmaker) {
            if (!isset($bookmaker['markets'])) {
                continue;
            }
            
            foreach ($bookmaker['markets'] as $market) {
                if ($market['key'] != 'h2h' || !isset($market['outcomes'])) {
                    continue;
                }
                
                foreach ($market['outcomes'] as $outcome) {

                    if ($outcome['name'] == $homeTeam) {
                        $quote1 += $outcome['price'];
                        $count1++;
                    } elseif ($outcome['name'] == 'Draw') {
                        $quoteX += $outcome['price'];
                        $countX++;
                    } elseif ($outcome['name'] == $awayTeam) {
                        $quote2 += $outcome['price'];
                        $count2++;
                    }
                }
            }
        }

        $avgQuote1 = $count1 > 0 ? $quote1 / $count1 : 0;
        $avgQuoteX = $countX > 0 ? $quoteX / $countX : 0;
        $avgQuote2 = $count2 > 0 ? $quote2 / $count2 : 0;
        
        return [
            'quote1' => $avgQuote1,
            'quoteX' => $avgQuoteX,
            'quote2' => $avgQuote2,
        ];
    }

    /**
     * Aggiunge gli eventi di oggi per una lega specifica
     *
     * @param string $league
     * @return array
     */
    public function addTodayEvents($league)
    {
        Log::info('Inizio aggiunta eventi di oggi per la lega: ' . $league);
        $apiData = $this->getFootballOdds($league);
        $addedCount = 0;
        

        if (empty($apiData)) {
            Log::error('Nessun dato ricevuto dall\'API');
            return [
                'added' => 0,
                'api_events' => 0,
                'error' => 'Nessun dato ricevuto dall\'API'
            ];
        }
        $foundApiEvents = count($apiData);


        foreach ($apiData as $eventData) {
            $dateOdds = $eventData['commence_time'];
                $utcDate = Carbon::parse($dateOdds)->setTimezone('UTC');
            $dateOddsRome = $utcDate->setTimezone('Europe/Rome');

            if ($dateOddsRome > now() && $dateOddsRome < now()->copy()->addHours(96) ) {
                Log::info('Aggiunta evento: ' . $eventData['home_team'] . ' vs ' . $eventData['away_team'] . ' alle ' . $dateOddsRome);
                $event = EventFootball::where('home_team', $eventData['home_team'])
                ->where('away_team', $eventData['away_team'])
                ->where('status', 'scheduled')
                ->first();

                if (!$event) {
                    $ev = new Event();
                    $ev->type = 'football';
                    $ev->start_time = $dateOddsRome;
                    $ev->status = 'scheduled';
                    $ev->save();

                    switch ($league) {
                        case 'soccer_epl':
                            $competition = 'Premier League';
                            $country = 'England';
                            break; 
                        case 'soccer_serie_a':
                            $competition = 'Serie A';
                            $country = 'Italy';
                            break;
                        case 'soccer_bundesliga':
                            $competition = 'Bundesliga';
                            $country = 'Germany';
                            break;
                        case 'soccer_laliga':
                            $competition = 'La Liga';
                            $country = 'Spain';
                            break;
                        case 'soccer_ligue_1':
                            $competition = 'Ligue 1';
                            $country = 'France';
                            break;
                        case 'soccer_fifa_club_world_cup':
                            $competition = 'FIFA Club World Cup';
                            $country = 'USA';
                            break;
                        default:
                            $competition = '';
                            $country = '';
                        }

                    $event = EventFootball::create(
                        [
                            'id' => $ev->id,
                            'home_team' => $eventData['home_team'],
                            'away_team' => $eventData['away_team'],
                            'start_time' => $ev->start_time,
                            'competition' => $competition,
                            'home_score' => 0,
                            'away_score' => 0,
                            'stadium' => '',
                            'country' =>  $country,
                            'city' =>  '',
                            'season' => '24/25',
                            'status' => $ev->status,
                            'quote_1' => 1.01,
                            'quote_X' => 1.01,
                            'quote_2' => 1.01,
                        ]
                    );
                $addedCount++;
                }
            }
        }

        return [
            'added' => $addedCount,
            'api_events' => $foundApiEvents,
        ];
    }
}