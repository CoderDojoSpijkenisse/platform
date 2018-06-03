<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    /**
     * Defines attributes that should not be settable by the user.
     *
     * @var string[]
     */
    protected $guarded = [];

    protected $dates = ['time_start', 'time_end'];

    public function registrations()
    {
        return $this->hasMany('App\EventRegistration');
    }

    public static function upcoming()
    {
        return Event::where('time_end', '>', Carbon::now())->with('registrations')->orderBy('time_start')->first();
    }
}
