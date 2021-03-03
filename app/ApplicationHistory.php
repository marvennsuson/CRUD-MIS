<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationHistory extends Model
{
    //
    protected $guarded = [];



    public function userAppHistoryList($fields = array(),$condition  = array(), $type)
    {   
        if ($type == "admin") {
            $histories =  ApplicationHistory::join('users', 'application_histories.admin_id', '=', 'users.id');
        }else{
            $histories =  ApplicationHistory::join('residents', 'application_histories.user_id', '=', 'residents.id');
        }
      
        
       if (!empty($fields)) {
        $histories->select($fields);
       }
       if (!empty($condition)) {
        $histories->where($condition);
       }
       
       
       return $histories->latest()->get()->toArray();
    }

    
    public function newHistory($insertData)
    {
        return ApplicationHistory::create($insertData);
    }
}
