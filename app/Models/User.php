<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Models\Blog;
use App\Models\Post;
use App\Models\PlanUser;
use App\Models\Profile;
use App\Traits\Orderable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, Orderable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasCreatedProfile() {
        return Profile::where('user_id', $this->id)->count() === 1;
    }

    public function hasCreatedRoutine() {
        return Routine::where('user_id', $this->id)->count() === 1;
    }

    public function ownsProfile(Profile $profile) {
        return $this->id === $profile->user->id;
    }

    public function ownsRoutines(Routine $routine) {
        return $this->id === $routine->user->id;
    }

    public function profile() {
        return $this->hasOne('App\Models\Profile');
    }

    public function OauthAcessToken(){
        return $this->hasMany('\App\Models\OauthAccessToken');
    }

    public function routine() {
        return $this->hasOne(Routine::class);
    }

    public function heights() {
        return $this->hasMany(Weight::class);
    }

    public function workouts() {
        return $this->hasMany(WorkoutHistory::class);
    }
}
