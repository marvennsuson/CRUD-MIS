<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
class AdminController extends Controller
{

    public function Profile(){
        $user = User::findOrFail(Auth::user()->id);
        // $data['user_groups'] = $user_groups;
        $data['main_page'] = 'profile';
        $data['sub_page'] = 'profile';
        $data['user'] = $user;
        return view('admin.profile.profile',$data);
    }

    public function UpdateProfile(Request $request){

        $input = $request->all();


        $validator = Validator::make($request->all(),
            [
                // 'username' => 'required',
                'useravatar' => 'mimes:jpeg,jpg,png,gif|max:100000',
                'email' => 'required|email|unique:users,email,'.Auth::user()->id,

            ]
        );
        if($validator->fails()){
            // return back()->withErrors($validator)->withInput();
            $response = ['status' => false, 'msg' =>$validator->errors()->all()];
            return response()->json($response);
        }else{
           if ($request->hasFile('useravatar')) {
              if ($request->file('useravatar')->isValid()) {
                $file = $request->useravatar;
          $image_name = rand(10,10000).'_'.time() . '.' . $file->getClientOriginalExtension();
          $file->move(public_path('images/'), $image_name);
                $data = [
                'username' => $input['username'],
                'email' => $input['email'],
                'firstname' => $input['firstname'],
                'middlename' => $input['middlename'],
                'lastname' => $input['lastname'],
                'exname' => $input['exname'],
                'gender' => $input['gender'],
                'age' => $input['age'],
                'dob' => $input['dob'],
                'address' => $input['address'],
                'mobile'=> $input['mobile'],
                'province' => $input['province'],
                'city' => $input['city'],
                'postalcode' => $input['postalcode'],
                'barangay' => $input['barangay'],
                'housenumber' => $input['housenumber'],
                'streetname' => $input['streetname'],
                'otherinfo' => $input['otherinfo'],
                'avatar' => $image_name,

                ];

             
                User::where('id', Auth::user()->id)->update($data);
              }
           }
           $data = [
           'username' => $input['username'],
           'email' => $input['email'],
           'firstname' => $input['firstname'],
           'middlename' => $input['middlename'],
           'lastname' => $input['lastname'],
           'exname' => $input['exname'],
           'gender' => $input['gender'],
           'age' => $input['age'],
           'dob' => $input['dob'],
           'address' => $input['address'],
           'mobile'=> $input['mobile'],
           'province' => $input['province'],
           'city' => $input['city'],
           'postalcode' => $input['postalcode'],
           'barangay' => $input['barangay'],
           'housenumber' => $input['housenumber'],
           'streetname' => $input['streetname'],
           'otherinfo' => $input['otherinfo'],


           ];

           User::where('id', Auth::user()->id)->update($data);
            $response = ['status' => true, 'msg' => 'Successfull'];
            return response()->json($response);
        }
    }
}
