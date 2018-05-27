<?php

namespace App;

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

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function parents()
    {
        return $this->belongsToMany('App\ParentProfile');
    }

    public function badges()
    {
        return $this->belongsToMany('App\Badge');
    }

    public function registrations()
    {
        return $this->user->registrations;
    }
}
