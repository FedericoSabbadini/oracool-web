<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/** 
 * PredictionFootball model represents a football prediction in the application.
 * It contains properties for predicted scores and defines a relationship with the Prediction model.
 */ 
class PredictionFootball extends Model
{
    use HasFactory;

    protected $table = 'predictions_football';
    // protected primaryKey = 'id'
    protected $fillable = [
        'id',
        'predicted_1',
        'predicted_X',
        'predicted_2',
    ];
    public $timestamps = false;

    public function prediction()
    {
        return $this->belongsTo(Prediction::class , 'id', 'id');
    }
}