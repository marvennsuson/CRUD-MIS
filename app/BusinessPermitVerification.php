<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessPermitVerification extends Model
{
    //
    protected $guarded = [];

    public function readVerification($id)
    {
        return BusinessPermitVerification::where('app_id', $id)->first();
        
    }

    public function bpvCreate($data)
    {
        return BusinessPermitVerification::create($data);
    }

    public function bpvUpdate($data, $id)
    {
        return BusinessPermitVerification::where('app_id', $id)->update($data);
    }
}
