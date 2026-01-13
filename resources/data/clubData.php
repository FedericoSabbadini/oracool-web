<?php
// This file contains the data for football clubs, teams, countries, competitions, cities, and stadiums.

return [

    'teams' => [
    'Premier League' => ['Arsenal', 'Aston Villa', 'Bournemouth', 'Brentford', 'Brighton and Hove Albion', 'Chelsea', 'Crystal Palace', 'Everton', 'Fulham', 'Liverpool', 'Manchester City', 'Manchester United', 'Newcastle United', 'Nottingham Forest', 'Tottenham Hotspur', 'West Ham United', 'Wolverhampton Wanderers', 'Ipswich Town', 'Leicester City', 'Southampton'],
    'Serie A' => ['Atalanta BC', 'Bologna', 'Cagliari', 'Como', 'Empoli', 'Fiorentina', 'Genoa', 'Hellas Verona', 'Inter Milan', 'Juventus', 'Lazio', 'AC Milan', 'Monza', 'Napoli', 'Parma', 'AS Roma', 'Torino', 'Udinese', 'Venezia', 'Lecce'],
    'Bundesliga' => ['Augsburg', 'Bayer Leverkusen', 'Bayern Munich', '1. FC Heidenheim', 'Borussia Dortmund', 'Borussia Monchengladbach', 'Eintracht Frankfurt', 'FC St. Pauli', 'FSV Mainz 05', 'Holstein Kiel', 'RB Leipzig', 'SC Freiburg', 'TSG Hoffenheim', 'Union Berlin', 'VfB Stuttgart', 'VfL Bochum', 'VfL Wolfsburg', 'Werder Bremen'],
    'La Liga' => ['Alavés', 'Athletic Bilbao', 'Atlético Madrid', 'Barcelona', 'CA Osasuna', 'Celta Vigo', 'Espanyol', 'Getafe', 'Girona', 'Las Palmas', 'Leganés', 'Mallorca', 'Rayo Vallecano', 'Real Betis', 'Real Madrid', 'Real Sociedad', 'Sevilla', 'Valencia', 'Valladolid', 'Villarreal'],
    'Ligue 1' => ['Angers', 'AS Monaco', 'Auxerre', 'Brest', 'Le Havre', 'RC Lens', 'Lille', 'Lyon', 'Marseille', 'Montpellier', 'Nantes', 'Nice', 'Paris Saint Germain', 'Rennes', 'Saint Etienne', 'Stade de Reims', 'Strasbourg', 'Toulouse'],
    'FIFA Club World Cup' => ['Manchester City', 'Chelsea', 'Real Madrid', 'Bayern Munich', 'Paris Saint Germain', 'Inter Milan', 'Benfica', 'Al Ahly FC', 'Wydad AC', 'Espérance Sportive de Tunis', 'Mamelodi Sundowns  F.C.', 'Urawa Red Diamonds','Al-Hilal Saudi FC', 'Al Ittihad', 'Auckland City FC', 'León', 'Monterrey', 'Seattle Sounders FC', 'Palmeiras', 'Flamengo','Fluminense', 'River Plate', 'Botafogo', 'FC Porto', 'Juventus', 'Borussia Dortmund', 'RB Salzburg', 'Atlético Madrid', 'Inter Miami CF', 'Los Angeles FC', 'Boca Juniors', 'Al Ain FC', 'Ulsan Hyundai', 'Pachuca']
    ],

    'countries' => [
        'Premier League'=> 'England',
        'Serie A'=> 'Italy',
        'Bundesliga'=> 'Germany',
        'La Liga'=> 'Spain',
        'Ligue 1'=> 'France',
        'FIFA Club World Cup'=> 'USA'
    ],

    'competitions' => [
        'Premier League',
        'Serie A',
        'Bundesliga',
        'La Liga',
        'Ligue 1',
        'FIFA Club World Cup'
    ],

    'cities' => [
        // Premier League
        'Arsenal'=> 'London', 'Aston Villa'=> 'Birmingham', 'Bournemouth'=> 'Bournemouth', 'Brentford'=> 'London', 'Brighton and Hove Albion'=> 'Brighton', 'Chelsea'=> 'London', 'Crystal Palace'=> 'London', 'Everton'=> 'Liverpool', 'Fulham'=> 'London','Liverpool'=> 'Liverpool', 'Manchester City'=> 'Manchester', 'Manchester United'=> 'Manchester', 'Newcastle United'=> 'Newcastle', 'Nottingham Forest'=> 'Nottingham', 'Tottenham Hotspur'=> 'London', 'West Ham United'=> 'London','Wolverhampton Wanderers'=> 'Wolverhampton', 'Ipswich Town'=> 'Ipswich', 'Leicester City'=> 'Leicester', 'Southampton'=> 'Southampton',
        // Serie A
        'Atalanta BC'=> 'Bergamo', 'Bologna'=> 'Bologna', 'Cagliari'=> 'Cagliari', 'Como'=> 'Como', 'Empoli'=> 'Empoli', 'Fiorentina'=> 'Florence', 'Genoa'=> 'Genoa', 'Hellas Verona'=> 'Verona', 'Inter Milan'=> 'Milan', 'Juventus'=> 'Turin', 'Lazio'=> 'Rome', 'AC Milan'=> 'Milan', 'Monza'=> 'Monza', 'Napoli'=> 'Naples', 'Parma'=> 'Parma', 'AS Roma'=> 'Rome', 'Torino'=> 'Turin', 'Udinese'=> 'Udine', 'Venezia'=> 'Venice', 'Lecce'=> 'Lecce',
        // Bundesliga
        'Augsburg'=> 'Augsburg', 'Bayer Leverkusen'=> 'Leverkusen', 'Bayern Munich'=> 'Munich', '1. FC Heidenheim'=> 'Heidenheim', 'Borussia Dortmund'=> 'Dortmund', 'Borussia Monchengladbach'=> 'Mönchengladbach', 'Eintracht Frankfurt'=> 'Frankfurt', 'FC St. Pauli'=> 'Hamburg', 'FSV Mainz 05'=> 'Mainz', 'Holstein Kiel'=> 'Kiel', 'RB Leipzig'=> 'Leipzig', 'SC Freiburg'=> 'Freiburg', 'TSG Hoffenheim'=> 'Sinsheim', 'Union Berlin'=> 'Berlin', 'VfB Stuttgart'=> 'Stuttgart', 'VfL Bochum'=> 'Bochum', 'VfL Wolfsburg'=> 'Wolfsburg', 'Werder Bremen'=> 'Bremen',
        // La Liga
        'Alavés'=> 'Vitoria-Gasteiz', 'Athletic Bilbao'=> 'Bilbao', 'Atlético Madrid'=> 'Madrid', 'Barcelona'=> 'Barcelona', 'CA Osasuna'=> 'Pamplona', 'Celta Vigo'=> 'Vigo', 'Espanyol'=> 'Barcelona', 'Getafe'=> 'Getafe', 'Girona'=> 'Girona', 'Las Palmas'=> 'Las Palmas', 'Leganés'=> 'Leganés', 'Mallorca'=> 'Palma', 'Rayo Vallecano'=> 'Madrid', 'Real Betis'=> 'Seville', 'Real Madrid'=> 'Madrid', 'Real Sociedad'=> 'San Sebastián', 'Sevilla'=> 'Seville', 'Valencia'=> 'Valencia', 'Valladolid'=> 'Valladolid', 'Villarreal'=> 'Villarreal',
        // Ligue 1
        'Angers'=> 'Angers', 'AS Monaco'=> 'Monaco', 'Auxerre'=> 'Auxerre', 'Brest'=> 'Brest', 'Le Havre'=> 'Le Havre', 'RC Lens'=> 'Lens', 'Lille'=> 'Lille', 'Lyon'=> 'Lyon', 'Marseille'=> 'Marseille', 'Montpellier'=> 'Montpellier', 'Nantes'=> 'Nantes', 'Nice'=> 'Nice', 'Paris Saint Germain'=> 'Paris', 'Rennes'=> 'Rennes', 'Saint Etienne'=> 'Saint-Étienne', 'Stade de Reims'=> 'Reims', 'Strasbourg'=> 'Strasbourg', 'Toulouse'=> 'Toulouse'
    ],

    'stadiums' => [
        // Premier League
        'Arsenal'=> 'Emirates Stadium', 'Aston Villa'=> 'Villa Park', 'Bournemouth'=> 'Vitality Stadium', 'Brentford'=> 'Gtech Community Stadium', 'Brighton and Hove Albion'=> 'Amex Stadium', 'Chelsea'=> 'Stamford Bridge', 'Crystal Palace'=> 'Selhurst Park', 'Everton'=> 'Goodison Park', 'Fulham'=> 'Craven Cottage', 'Liverpool'=> 'Anfield', 'Manchester City'=> 'Etihad Stadium', 'Manchester United'=> 'Old Trafford', 'Newcastle United'=> 'St James\' Park', 'Nottingham Forest'=> 'City Ground', 'Tottenham Hotspur'=> 'Tottenham Hotspur Stadium', 'West Ham United'=> 'London Stadium', 'Wolverhampton Wanderers'=> 'Molineux Stadium', 'Ipswich Town'=> 'Portman Road', 'Leicester City'=> 'King Power Stadium', 'Southampton'=> 'St Mary\'s Stadium',       
        // Serie A
        'Atalanta BC'=> 'Gewiss Stadium', 'Bologna'=> 'Stadio Renato Dall\'Ara', 'Cagliari'=> 'Unipol Domus', 'Como'=> 'Stadio Giuseppe Sinigaglia', 'Empoli'=> 'Stadio Carlo Castellani', 'Fiorentina'=> 'Stadio Artemio Franchi', 'Genoa'=> 'Stadio Luigi Ferraris', 'Hellas Verona'=> 'Stadio Marcantonio Bentegodi', 'Inter Milan'=> 'San Siro', 'Juventus'=> 'Allianz Stadium', 'Lazio'=> 'Stadio Olimpico', 'AC Milan'=> 'San Siro', 'Monza'=> 'Stadio Brianteo', 'Napoli'=> 'Stadio Diego Armando Maradona', 'Parma'=> 'Stadio Ennio Tardini', 'AS Roma'=> 'Stadio Olimpico', 'Torino'=> 'Stadio Olimpico Grande Torino', 'Udinese'=> 'Dacia Arena', 'Venezia'=> 'Stadio Pier Luigi Penzo', 'Lecce'=> 'Stadio Via del Mare',
        // Bundesliga
        'Augsburg'=> 'WWK Arena', 'Bayer Leverkusen'=> 'BayArena', 'Bayern Munich'=> 'Allianz Arena', '1. FC Heidenheim'=> 'Voith-Arena', 'Borussia Dortmund'=> 'Signal Iduna Park', 'Borussia Monchengladbach'=> 'Borussia-Park', 'Eintracht Frankfurt'=> 'Deutsche Bank Park', 'FC St. Pauli'=> 'Millerntor-Stadion', 'FSV Mainz 05'=> 'MEWA Arena', 'Holstein Kiel'=> 'Holstein-Stadion', 'RB Leipzig'=> 'Red Bull Arena', 'SC Freiburg'=> 'Europa-Park Stadion', 'TSG Hoffenheim'=> 'PreZero Arena', 'Union Berlin'=> 'Stadion An der Alten Försterei', 'VfB Stuttgart'=> 'MHP Arena', 'VfL Bochum'=> 'Vonovia Ruhrstadion', 'VfL Wolfsburg'=> 'Volkswagen Arena', 'Werder Bremen'=> 'Weserstadion',
        // La Liga
        'Alavés'=> 'Mendizorrotza Stadium', 'Athletic Bilbao'=> 'San Mamés Stadium', 'Atlético Madrid'=> 'Metropolitano Stadium', 'Barcelona'=> 'Camp Nou', 'CA Osasuna'=> 'El Sadar Stadium', 'Celta Vigo'=> 'Abanca-Balaídos', 'Espanyol'=> 'RCDE Stadium', 'Getafe'=> 'Coliseum Alfonso Pérez', 'Girona'=> 'Montilivi Stadium', 'Las Palmas'=> 'Estadio de Gran Canaria', 'Leganés'=> 'Estadio Municipal Butarque', 'Mallorca'=> 'Son Moix Stadium', 'Rayo Vallecano'=> 'Campo de Fútbol de Vallecas', 'Real Betis'=> 'Benito Villamarín Stadium', 'Real Madrid'=> 'Santiago Bernabéu Stadium', 'Real Sociedad'=> 'Reale Arena', 'Sevilla'=> 'Ramón Sánchez Pizjuán Stadium', 'Valencia'=> 'Mestalla Stadium', 'Valladolid'=> 'José Zorrilla Stadium', 'Villarreal'=> 'Estadio de la Cerámica',
        // Ligue 1
        'Angers'=> 'Stade Raymond Kopa', 'AS Monaco'=> 'Stade Louis II', 'Auxerre'=> 'Stade Abbé-Deschamps', 'Brest'=> 'Stade Francis-Le Blé', 'Le Havre'=> 'Stade Océane', 'RC Lens'=> 'Stade Bollaert-Delelis', 'Lille'=> 'Stade Pierre-Mauroy', 'Lyon'=> 'Groupama Stadium', 'Marseille'=> 'Orange Vélodrome', 'Montpellier'=> 'Stade de la Mosson', 'Nantes'=> 'Stade de la Beaujoire', 'Nice'=> 'Allianz Riviera', 'Paris Saint Germain'=> 'Parc des Princes', 'Rennes'=> 'Roazhon Park', 'Saint Etienne'=> 'Stade Geoffroy-Guichard', 'Stade de Reims'=> 'Stade Auguste-Delaune', 'Strasbourg'=> 'Stade de la Meinau', 'Toulouse'=> 'Stadium de Toulouse',
    ],


    // FIFA Club World Cup USA Cities and Stadiums
    // The cities and stadiums are based on the venues selected for the 2025 FIFA
    'club_world_cup_usa_cities' => [
        'Lincoln Financial Field' => 'Philadelphia',
        'MetLife Stadium' => 'New York City',
        'Rose Bowl' => 'Los Angeles',
        'Hard Rock Stadium' => 'Miami',
        'Lumen Field' => 'Seattle',
        'Mercedes-Benz Stadium' => 'Atlanta',
        'Audi Field' => 'Washington D.C.',
        'Camping World Stadium' => 'Orlando',
        'Inter&Co Stadium' => 'Orlando',
        'Bank of America Stadium' => 'Charlotte',
        'TQL Stadium' => 'Cincinnati',
        'GEODIS Park' => 'Nashville',
    ],
    'club_world_cup_usa_stadiums' => [
        'Lincoln Financial Field',
        'MetLife Stadium',
        'Rose Bowl',
        'Hard Rock Stadium',
        'Lumen Field',
        'Mercedes-Benz Stadium',
        'Audi Field',
        'Camping World Stadium',
        'Inter&Co Stadium',
        'Bank of America Stadium',
        'TQL Stadium',
        'GEODIS Park'
    ]
];