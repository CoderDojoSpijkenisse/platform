<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * Defines attributes that should be settable by the user.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * Defines attributes that should be hidden for the user.
     *
     * @var string[]
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Defines the relationships to eager load when accessing this model.
     *
     * @var string[]
     */
    protected $with = [
        'ninjaProfile',
        'mentorProfile',
        'parentProfile',
    ];

    /**
     * Retrieve the NinjaProfile for this User or return null if the User does not have one.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ninjaProfile()
    {
        return $this->hasOne('App\NinjaProfile');
    }

    /**
     * Return whether the User has a NinjaProfile.
     *
     * @return bool
     */
    public function hasNinjaProfile()
    {
        return !is_null($this->ninjaProfile);
    }

    /**
     * Retrieve the MentorProfile for this User or return null if the User does not have one.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mentorProfile()
    {
        return $this->hasOne('App\MentorProfile');
    }

    /**
     * Return whether the User has a MentorProfile.
     *
     * @return bool
     */
    public function hasMentorProfile()
    {
        return !is_null($this->mentorProfile);
    }

    /**
     * Retrieve the ParentProfile for this User or return null if the User does not have one.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parentProfile()
    {
        return $this->hasOne('App\ParentProfile');
    }

    /**
     * Return whether the User has a ParentProfile.
     *
     * @return bool
     */
    public function hasParentProfile(): bool
    {
        return !is_null($this->parentProfile);
    }

    /**
     * Return all profiles for the User; returns an array including the NinjaProfile, MentorProfile and ParentProfile.
     *
     * @return mixed[]
     */
    public function profiles()
    {
        $allProfiles = [];

        $ninjaProfile = $this->ninjaProfile;
        $mentorProfile = $this->mentorProfile;
        $parentProfile = $this->parentProfile;

        if (!is_null($ninjaProfile)) {
            $allProfiles[] = $ninjaProfile;
        }

        if (!is_null($mentorProfile)) {
            $allProfiles[] = $mentorProfile;
        }

        if (!is_null($parentProfile)) {
            $allProfiles[] = $parentProfile;
        }

        return $allProfiles;
    }

    public function registrations()
    {
        return $this->hasMany('App\EventRegistration');
    }
}
