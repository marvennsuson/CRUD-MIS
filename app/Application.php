<?php

namespace App;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    // protected $fillable = [
    //     'app_id' ,
    //     'user_id',
    //     'status',
    //     'type' // 1 business permit , 2 Cedula, 3 Mayor's Permit
    // ];
    
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo('App\Resident', 'user_id');
    }


    
    public function createApplicationData($data)
    {
        $affected = Application::create($data);

        if ($affected) {
            return true;
        }else{
            return false;
        }
    }
    public function getBpApplications()
    {
        $applications = Application::where('user_id',Auth::guard('resident')->user()->id)->where('type','1')->where('status' , '!=' , 0)->first();
        return $applications;
    }

    public function readApplication($id)
    {
        $applications = Application::with('user')->where('app_id', $id)->first();
        return $applications;
    }

    public function updateApplication($data, $id)
    {
        $applications = Application::where('app_id', $id)->update($data);
        return $applications;
    }

    public function getAuthApplications()
    {
        $applications = Application::where('user_id', Auth::guard('resident')->user()->id)->where('status','!=', 0)->get()->toArray();
        return $applications;
    }

    public function getApplications($condition = array())
    {
    
        $applications = Application::with('user');

        
        if (!empty($condition)) {
            $applications->where($condition);
        }else{
            $applications->where('status','>', 0);
        }
        return $applications->get()->toArray();
    }


    public function searchApplications($fromDate, $toDate, $type = '', $status = '', $filter = '', $search ='')
    {
        $applications = Application::join('residents','residents.id','=', 'applications.user_id')->whereBetween('applications.created_at', [$fromDate,$toDate])->where('applications.status', '>', '0');

        if ($type != '') {
            $applications->where('applications.type', $type);
        }

        if ($status != '') {
            $applications->where('applications.status', $status);
        }
        
        if ($filter != '') {
            if ($filter == 'app_id') {
                $applications->where('applications.app_id', 'like' ,$search.'%');
            }else{
                $applications->where('users.username', 'like' ,$search.'%');
            }
            

        }

        return $applications->get()->toArray();
    }



  
}
