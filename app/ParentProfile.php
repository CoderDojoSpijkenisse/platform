<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParentProfile extends Model
{
    use SoftDeletes;

    /**
     * Defines attributes that should not be settable by the user.
     *
     * @var string[]
     */
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function children()
    {
        return $this->belongsToMany('App\NinjaProfile')->withPivot('relation');
    }

    public function childrenOrderedByName()
    {
        return $this->children()
            ->join('users', 'users.id', '=', 'ninja_profiles.user_id')
            ->orderBy('users.name');
    }

    public function registrationsForEvent(Event $event)
    {
        $children = $this->children->pluck('user.id');

        return EventRegistration::where('event_id', $event->id)->whereIn('user_id', $children)->get();
    }
}
