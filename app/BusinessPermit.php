<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessPermit extends Model
{
    protected $table = "businesspermits";
    protected $guarded = [];
    public function createBusinessPermit($data)
    {

        $affected = BusinessPermit::create($data);

       if ($affected) {
          return true;
       }else{
          return false;
       }

    }

    public function readBusinessPermitInfo($id)
    {
        $applications = BusinessPermit::where('app_id', $id)->first();
        return $applications;
    }

    public function updateBusinessPermit($data,$id)
    {
        $applications = BusinessPermit::where('app_id', $id)->update($data);
        return $applications;
    }


    public function countTypeOfBusinessPermits()
    {
        $new =  BusinessPermit::join('applications', 'applications.app_id', '=', 'businesspermits.app_id')->where('businesspermits.permit_type', 'New')->where('applications.status','!=', 0)->count();
        $renewal =  BusinessPermit::join('applications', 'applications.app_id', '=', 'businesspermits.app_id')->where('businesspermits.permit_type', 'Renewal')->where('applications.status','!=', 0)->count();
        $too =  BusinessPermit::join('applications', 'applications.app_id', '=', 'businesspermits.app_id')->where('businesspermits.permit_type', 'Transfer of Business Ownership')->where('applications.status','!=', 0)->count();
        $tobl =  BusinessPermit::join('applications', 'applications.app_id', '=', 'businesspermits.app_id')->where('businesspermits.permit_type', 'Transfer of Business Location')->where('applications.status','!=', 0)->count();

        $data = [
            'new' => $new,
            'renewal' => $renewal,
            'too' => $too,
            'tobl' => $tobl
        ];
        
        return $data;
    }


    public function businessPermitList($fields = array(),$condition  = array())
    {

       $bpList =  BusinessPermit::join('applications', 'applications.app_id', '=', 'businesspermits.app_id');
       $bpList->join('residents', 'residents.id', '=', 'applications.user_id');
        
       
       if (!empty($condition)) {
          $bpList->where($condition);
       }else{
           $bpList->where('applications.status', '>' , '0');
       }
       

       if (!empty($fields)) {
           $bpList->select($fields);
       }


       return $bpList->get()->toArray();

    }
    

    

}
