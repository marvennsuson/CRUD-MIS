<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password', 'user_group_id','user_level','visibility'
    // ];

    protected $guarded = [];

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

    public function user_groups()
    {
        return $this->belongsTo('App\UserGroup', 'user_group_id', 'id');
    }

    public function applications()
    {
        return $this->hasMany('App\Application');
    }



    public function getAuthUserInfo()
    {
        $authUser = Auth::user();
        $condition = [
            'id' => $authUser->id,
            'user_group_id' => $authUser->user_group_id
        ];

        $user = User::with('user_groups')->where($condition)->first();

        return $user;
    }
    public function readUser($id)
    {
        $user = User::with('user_groups')->where('id', $id)->first();
        return $user;
    }

    // public function getAdminUsers()
    // {
    //     $user = User::with('user_groups')->where('user_level', '!=', '1')->where('id','!=', Auth::user()->id)->where('visibility', '1')->get()->toArray();
    //     return $user;
    // }
}
