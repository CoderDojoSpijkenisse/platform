<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    /**
     * Defines attributes that should not be settable by the user.
     *
     * @var string[]
     */
    protected $guarded = [];
}
