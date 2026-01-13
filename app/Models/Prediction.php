<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 *  Prediction model represents a user's prediction for a specific event.
 *  It contains properties such as user ID, event ID, and the predicted value.
 *  It defines relationships with the User and Event models, as well as a specific prediction for football events.
 */
class Prediction extends Model
{
    use HasFactory;

    protected $table = 'predictions';
    // protected primaryKey = 'id'
    protected $fillable = [
        'user_id',
        'event_id',
        'value',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'id', 'event_id');
    }

    public function predictionFootball()
    {
        return $this->hasOne(PredictionFootball::class, 'id', 'id');
    }
}
