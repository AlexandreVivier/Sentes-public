<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Event;
use Symfony\Component\HttpFoundation\Response;

class MustBeOrganizer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $eventRequested = $request->route('event');
        $event = Event::findOrFail($eventRequested);

        if ($event->author_id != auth()->id()) {
            abort(403, 'Tu dois être l\'organisateur de ce GN pour le modifier.');
        }

        return $next($request);
    }
}
