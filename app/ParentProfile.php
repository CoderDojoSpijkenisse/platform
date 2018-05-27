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
        return $this->belongsToMany('App\NinjaProfile');
    }

    public function registrations()
    {
        return $this->user->registrations;
    }
}
