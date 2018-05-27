<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonProgress extends Model
{
    use SoftDeletes;

    /**
     * Defines attributes that should not be settable by the user.
     *
     * @var string[]
     */
    protected $guarded = [];

    public function ninjaProfile()
    {
        return $this->hasOne('App\NinjaProfile');
    }

    public function lesson()
    {
        return $this->hasOne('App\Lesson');
    }
}
