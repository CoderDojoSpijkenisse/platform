<?php
namespace App\Http\Controllers;

use App\Event;
use App\EventRegistration;
use Illuminate\Http\Request;

class ChildrenController extends Controller
{
    public function index(Request $request)
    {
        return view('children.index');
    }

    public function updateRegistrations(Request $request)
    {
        $upcomingEvent = Event::upcoming();

        if (is_null($upcomingEvent)) {
            dd('Could not find an event!');
        } elseif (!\Auth::user()->hasParentProfile()) {
            dd('You\'re not a parent!');
        } else {
            $children = \Auth::user()->parentProfile->children()->with('user')->get();
            $newRegistrations = collect($request->get('registrations', []));

            $createEventRegistrationForUserIds = [];
            $deleteEventRegistrationForUserIds = [];

            foreach ($children as $child) {
                if ($newRegistrations->contains($child->user->id)) {
                    if ($upcomingEvent->registrations()->where('user_id', $child->user->id)->exists()) {
                        // Do nothing.
                    } else {
                        $createEventRegistrationForUserIds[] = $child->user->id;
                    }
                } else {
                    if ($upcomingEvent->registrations()->where('user_id', $child->user->id)->exists()) {
                        $deleteEventRegistrationForUserIds[] = $child->user->id;
                    } else {
                        // Do nothing.
                    }
                }
            }

            // Verify that there are enough tickets left.
            $ticketsRemaining = $upcomingEvent->capacity - $upcomingEvent->registrations->count() + count($deleteEventRegistrationForUserIds);
            if ($ticketsRemaining < count($createEventRegistrationForUserIds)) {
                return redirect()->route('parent.children')->with('error', 'There are not enough tickets left to register all your selected children!');
            }

            // Delete obsolete registrations.
            $upcomingEvent->registrations()->whereIn('user_id', $deleteEventRegistrationForUserIds)->get()->each(function(EventRegistration $registration) {
                $registration->delete();
            });

            // Create new registrations.
            foreach ($createEventRegistrationForUserIds as $userId) {
                $upcomingEvent->registrations()->create([
                    'user_id' => $userId,
                    'parent_will_pick_up' => \Auth::user()->parentProfile->will_pickup_children,
                    'check_in_token' => \Uuid::generate(4)->string,
                ]);
            }
        }

        return redirect()->route('parent.children')->with('status', 'Registrations updated!');
    }
}
