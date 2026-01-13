<?php

namespace App\Http\Controllers;

use App\Services\OddsApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * OddsController handles the odds update functionality.
 * It interacts with the OddsApiService to fetch and update odds for various leagues.
 */
class OddsController extends Controller
{

    protected $oddsService;

    /**
     * OddsController constructor.
     *
     * @param OddsApiService $oddsService
     */
    public function __construct(OddsApiService $oddsService)
    {
        $this->oddsService = $oddsService;
    }

    /**
     * Display the odds update view.
     *
     * @return \Illuminate\View\View
     */
    private function getLeagues() {
        
        $leagues = [
        'soccer_fifa_club_world_cup',          // FIFA Club World Cup

        'soccer_epl',                          // Inghilterra: English Premier League
        'soccer_france_ligue_one',             // Francia: Ligue 1
        'soccer_germany_bundesliga',           // Germania: Bundesliga - Germany
        'soccer_italy_serie_a',                // Italia: Serie A
        'soccer_spain_la_liga',                // Spagna: La Liga

        'soccer_argentina_primera_division',   // Argentina: Primera División
        'soccer_australia_aleague',            // Australia: A-League
        'soccer_austria_bundesliga',           // Austria: Austrian Football Bundesliga
        'soccer_belgium_first_div',            // Belgio: Belgium First Div
        'soccer_brazil_campeonato',            // Brasile: Brazil Série A
        'soccer_brazil_serie_b',               // Brasile: Brazil Série B
        'soccer_chile_campeonato',             // Cile: Primera División - Chile
        'soccer_china_superleague',            // Cina: Super League - China
        'soccer_conmebol_copa_libertadores',   // Colombia: Copa Libertadores
        'soccer_denmark_superliga',           // Danimarca: Denmark Superliga
        'soccer_efl_champ',                    // Inghilterra: Championship
        'soccer_england_league1',              // Inghilterra: League 1
        'soccer_england_league2',              // Inghilterra: League 2
        'soccer_fa_cup',                       // Inghilterra: FA Cup
        'soccer_france_ligue_two',             // Francia: Ligue 2
        'soccer_germany_bundesliga2',          // Germania: Bundesliga 2 - Germany
        'soccer_germany_liga3',                // Germania: 3. Liga - Germany
        'soccer_greece_super_league',          // Grecia: Super League - Greece
        'soccer_italy_serie_b',                // Italia: Serie B
        'soccer_japan_j_league',               // Giappone: J League
        'soccer_korea_kleague1',               // Corea del Sud: K League 1
        'soccer_league_of_ireland',            // Irlanda: League of Ireland
        'soccer_mexico_ligamx',                // Messico: Liga MX
        'soccer_netherlands_eredivisie',       // Paesi Bassi: Dutch Eredivisie
        'soccer_norway_eliteserien',           // Norvegia: Eliteserien - Norway
        'soccer_poland_ekstraklasa',           // Polonia: Ekstraklasa - Poland
        'soccer_portugal_primeira_liga',       // Portogallo: Primeira Liga - Portugal
        'soccer_spain_segunda_division',       // Spagna: La Liga 2
        'soccer_spl',                          // Scozia: Premiership - Scotland
        'soccer_sweden_allsvenskan',           // Svezia: Allsvenskan - Sweden
        'soccer_sweden_superettan',            // Svezia: Superettan - Sweden
        'soccer_switzerland_superleague',      // Svizzera: Swiss Superleague
        'soccer_turkey_super_league',          // Turchia: Turkey Super League
        'soccer_uefa_champs_league',           // UEFA: UEFA Champions League
        'soccer_uefa_champs_league_women',     // UEFA: UEFA Champions League Women
        'soccer_uefa_europa_conference_league',// UEFA: UEFA Europa Conference League
        'soccer_uefa_europa_league',           // UEFA: UEFA Europa League
        'soccer_uefa_nations_league'           // UEFA: UEFA Nations League
        ];

        return array_slice($leagues, 0, 1);
    }

    /**
     * Update odds for the active leagues.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateOdds()
    {
        $totalUpdated = 0;
        $totalAvailable = 0;
        $totalMatchedByTeams = 0;
        $errors = [];
        $activeLeagues =  $this->getLeagues();
        

        foreach ($activeLeagues as $league) {
            $result = $this->oddsService->updateEventsOdds($league);
            
            $totalUpdated += $result['updated'] ?? 0;
            $totalAvailable += $result['api_events'] ?? 0;
            
            if (isset($result['matched_by_teams'])) {
                $totalMatchedByTeams += $result['matched_by_teams'];
            }
            
            if (isset($result['error'])) {
                $errors[] = "{$league}: {$result['error']}";
            }
        }
        
        if ($totalAvailable === 0) {
            $message = __('predictionList.no_matches_found');
            return redirect()->back()->with('error', $message);
        } elseif ($totalUpdated === 0 ) {
            $message = __('predictionList.no_matches_updated');
            return redirect()->back()->with('error', $message);
        } else {
            $message = __('predictionList.matches_updated', ['count' => $totalUpdated]);
            return redirect()->back()->with('success', $message);
        }    
    }

    /**
     * Update matches for the active leagues.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateMatches() {
        $totalUpdated = 0;
        $totalAvailable = 0;
        $totalMatchedByTeams = 0;
        $errors = [];
        $activeLeagues =  $this->getLeagues();

        foreach ($activeLeagues as $league) {
            $result = $this->oddsService->addTodayEvents($league);

            $totalUpdated += $result['added'] ?? 0;
            $totalAvailable += $result['api_events'] ?? 0;
        }
        Log::info("Total updated matches: {$totalUpdated}");    
        Log::info("Total available matches: {$totalAvailable}");

        if ($totalAvailable === 0) {
            $message = __('predictionList.no_matches_found');
            return redirect()->back()->with('error', $message);
        } elseif ($totalUpdated === 0 ) {
            $message = __('predictionList.no_matches_updated');
            return redirect()->back()->with('error', $message);
        } else {
            $message = __('predictionList.matches_updated', ['count' => $totalUpdated]);
            return redirect()->back()->with('success', $message);
        }
    }
}