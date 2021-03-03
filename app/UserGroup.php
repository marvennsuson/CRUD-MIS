<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = 'user_groups';
    // protected $fillable = [
    //     'user_group'
    // ];
    protected $guarded =[];
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // public function getUserGroupsWithoutSuperAdmin(){

    //     $userGroups = UserGroup::where('id','!=', 1)->where('id', '!=', 3)->get()->toArray();
    //     return $userGroups;


    // }
    public function readUserGroup($id)
    {
        $userGroup = UserGroup::where('id', $id)->first();
        return $userGroup;
    }


    public function getAllUserGroups()
    {
        $userGroups = UserGroup::get()->toArray();
        return $userGroups;
    }
}
