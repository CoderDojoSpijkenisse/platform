<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->hasMentorProfile()) {
            if ($request->get('presence', '') === 'true') {
                EventRegistration::create([
                    'event_id' => Event::upcoming()->id,
                    'user_id' => \Auth::user()->id,
                    'parent_will_pick_up' => false,
                    'check_in_token' => '',
                ]);
            } elseif ($request->get('presence', '') === 'false') {
                $registration = EventRegistration::where('user_id', \Auth::user()->id)
                    ->where('event_id', Event::upcoming()->id)
                    ->first();

                if (is_null($registration)) {
                    // There was no registration yet?
                } else {
                    $registration->delete();
                }
            } else {
                return redirect()->back()->with(
                    'error',
                    vsprintf('Unrecognised input: "%s"', [$request->get('presence', '')])
                );
            }

            return redirect()->back()->with('status', 'Successfully updated presence');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EventRegistration  $eventRegistration
     * @return \Illuminate\Http\Response
     */
    public function show(EventRegistration $eventRegistration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EventRegistration  $eventRegistration
     * @return \Illuminate\Http\Response
     */
    public function edit(EventRegistration $eventRegistration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EventRegistration  $eventRegistration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventRegistration $eventRegistration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EventRegistration  $eventRegistration
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventRegistration $eventRegistration)
    {
        //
    }
}
