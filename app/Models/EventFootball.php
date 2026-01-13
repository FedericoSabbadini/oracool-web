<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *  EventFootball model represents a football event in the application.
 *  It contains properties such as home team, away team, scores, start time, competition,
 *  season, stadium, city, country, status, live block, and betting quotes.
 *  It also defines a relationship with the Event model.
 */
class EventFootball extends Model
{
    protected $table = 'events_football';
    // protected primaryKey = 'id'
    protected $fillable = [
        'id', 
        'home_team',
        'away_team',
        'home_score',
        'away_score',
        'start_time',
        'competition',
        'season',
        'stadium',
        'city',
        'country',
        'status',
        'liveBlock',
        'quote_1',
        'quote_X',
        'quote_2',
    ];
    protected $casts = [
        'start_time' => 'datetime',
    ];
    public $timestamps = false; 

    public function event()
    {
        return $this->belongsTo(Event::class, 'id', 'id');
    }
}
