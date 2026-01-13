<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Event;
use App\Models\EventFootball;

/**
 * PredictionStatus middleware updates the status of events and their associated football events.
 * It checks the current time against event start times to update statuses accordingly.
 */
class PredictionStatus
{
    /**
     * Handle an incoming request and update event statuses.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): \Illuminate\Http\Response  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response // 'scheduled', 'in_progress', 'ended', 'deleted'
    {

        $events = Event::all();
        foreach ($events as $event) {
            if ($event->start_time <= now() && $event->status === 'scheduled') {
                $event->status = 'in_progress';
                $event->save();
            }
            if ($event->start_time > now() && $event->status === 'in_progress') {
                $event->status = 'scheduled';
                $event->save();
            }
        }

        $eventsFootball = EventFootball::all();
        foreach ($eventsFootball as $eventFootball) {
            $eventFootball->status = Event::where('id', $eventFootball->id)->value('status');

            if ($eventFootball->status === 'scheduled') {
                $eventFootball->home_score = null;
                $eventFootball->away_score = null;
            } elseif ($eventFootball->status === 'in_progress') {
                if ($eventFootball->home_score === null || $eventFootball->away_score === null) {
                    $eventFootball->home_score = 0;
                    $eventFootball->away_score = 0;
                }
            }
            $eventFootball->save();
        }

        return $next($request);
    }
}