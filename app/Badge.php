<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents an achievement that can be rewarded to the participants of a Dojo.
 *
 * @package App
 */
class Badge extends Model
{
    use SoftDeletes;

    /**
     * Defines attributes that should not be settable by the user.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * Return the NinjaProfiles of those that have achieved this Badge.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ninjas()
    {
        return $this->belongsToMany('App\NinjaProfile');
    }
}
