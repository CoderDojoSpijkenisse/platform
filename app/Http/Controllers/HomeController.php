<?php

namespace App\Http\Controllers;

use App\Event;
use App\Lesson;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $upcomingEvents = Event::where('time_end', '>', Carbon::now())->limit(5)->with('registrations')->get();
        $nextDojo = $upcomingEvents->pop();
        $lessons = Lesson::all();

        return view('home', compact('nextDojo', 'upcomingEvents', 'lessons'));
    }
}
