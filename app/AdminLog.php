<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class AdminLog extends Model
{
    //
    protected $guarded = [];

    public function getAdminLogsByUserGroup($userGroup)
    {
        $query = AdminLog::join('users','users.id', '=', 'admin_logs.user_id')->where('users.user_group_id', $userGroup)->latest()->take(50)->get()->toArray();
        return $query;
    }

    
    public function insertLogs($insertData)
    {
        $result = AdminLog::insert($insertData); // return false or true
        return $result;
    }
}
