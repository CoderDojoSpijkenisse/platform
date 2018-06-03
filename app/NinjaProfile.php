<?php
namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NinjaProfile extends Model
{
    use SoftDeletes;

    /**
     * Defines attributes that should not be settable by the user.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * Defines attributes that should be considered as dates / casted to Carbon instances.
     *
     * @var string[]
     */
    protected $dates = ['date_of_birth'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function parents()
    {
        return $this->belongsToMany('App\ParentProfile')->withPivot('relation');
    }

    public function badges()
    {
        return $this->belongsToMany('App\Badge');
    }

    public function registrations()
    {
        return $this->user->registrations;
    }

    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->age;
    }

    public function getNameAttribute(): string
    {
        return $this->user->name;
    }

    public function isRegisteredForUpcomingDojo(): bool
    {
        $upcomingEvent = Event::where('time_end', '>', Carbon::now())->limit(1)->orderBy('time_start')->first();

        if (is_null($upcomingEvent)) {
            return false;
        } else {
//            dd($upcomingEvent->id);
            return $upcomingEvent->registrations()->where('user_id', $this->user->id)->exists();
        }
    }
}
