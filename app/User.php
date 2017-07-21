<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'surname',
        'givenname',
        'username',
        'birthday',
        'gender',
        'bio',
        'role_id',
        'first_login',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role () {
      return $this->belongsTo('App\Role');
    }

    public function socialProviders () {
      return $this->hasMany('App\SocialProvider');
    }

    public function isAdmin() {
      if($this->role->name == "Admin" && $this->is_active == 1) {
        return true;
      }
      return false;
    }

    public function isUser() {
      if($this->role->name == "User" && $this->is_active == 1) {
        return true;
      }
      return false;
    }

    public function assets(){
      return $this->morphMany('App\Asset', 'assetable');
    }

    public function profileimage() {
      return $this->assets()->where('usage', 'PROFILE')->first();
    }
}
