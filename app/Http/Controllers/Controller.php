<?php

namespace App\Http\Controllers;

use App\Event;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Controller
 *
 * @author Sander van den Oever <sander@coderdojo-spijkenisse.nl>
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $events;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->middleware(
            function ($request, $next) {
                $this->events = Event::where('time_end', '>', Carbon::now())
                    ->orderBy('time_start')
                    ->limit(5)
                    ->with('registrations')
                    ->get();

                view()->share('nextDojo', $this->events->shift());
                view()->share('upcomingDojos', $this->events);

                return $next($request);
            }
        );
    }
}
