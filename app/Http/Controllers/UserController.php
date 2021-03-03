<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserGroup;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    protected $users;
    protected $userGroups;

    public function __construct()
    {
        $this->users = new User;
        $this->userGroups = new UserGroup;
    }

    public function userList()
    {

        $data['user_groups'] = UserGroup::all();;
        $data['main_page'] = 'users';
        $data['sub_page'] = 'users_list';
        return view('admin.users.users',$data);
    }

    public function userCreate(Request $request)
    {
      
        $validator =Validator::make($request->all(),[
            'Profileimage' => 'mimes:jpeg,jpg,png,gif|max:100000',
            'user_group' => 'required|numeric',
            'email' => 'required|email|unique:users|unique:residents',
            'custompassword' => 'required',
            'Customconfirmpassword' => 'required|same:custompassword',
            'firstName' => 'required',
            'lastName' => 'required',
            'streetname' => 'required',
            'houseno' => 'required',
            'city' => 'required',
            'barangay' => 'required',
            'province' => 'required',
            'postalcode' => 'required',
            'Customstatus' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false,'msg'=>$validator->errors()]);
        }else{

            if ($request->hasFile('Profileimage')) {
                if ($request->file('Profileimage')->isValid()) {
                  
                    $file = $request->Profileimage;
                    $image_name = rand(10,10000).'_'.time() . '.' . $file->getClientOriginalExtension();
                    // $max = User::max('id');
                    // $addid = $max + 1; 
                    // $filename = time();
                    $file->move(public_path('images/'), $image_name);
                        $usergroupid =  UserGroup::where('level',$request->user_group)->first();
                    
                    $data = [
                        'user_group_id' => $usergroupid['id'] ,
                        'user_level' => $request->user_group,
                        'email' => $request->email,
                        'password' => Hash::make($request->custompassword),
                        'firstname' => $request->firstName,
                        'lastname' => $request->lastName,
                        'streetname' => $request->streetname,
                        'housenumber' => $request->houseno,
                        'city' => $request->city,
                        'barangay' => $request->barangay,
                        'province' => $request->province,
                        'postalcode' => $request->postalcode,
                        'isVerified' => $request->Customstatus,
                        'avatar' => $image_name,
                        'visibility' => 1
                    ];
                  
                    try {
                      User::create($data);
                     
                    } catch (\Throwable $th) {
                        $response = ['status' => false, 'msg' => $th];
                        return response()->json($response);
                    }
    
                }
            }else{
                $usergroupid =  UserGroup::where('level',$request->user_group)->first();
                $data = [
                    'user_group_id' => $usergroupid['id'],
                    'user_level' => $request->user_group,
                    'firstname' => $request->firstName,
                    'lastname' => $request->lastName,
                    'email' => $request->email,
                    'password' => Hash::make($request->custompassword),
                    'streetname' => $request->streetname,
                    'housenumber' => $request->houseno,
                    'city' => $request->city,
                    'barangay' => $request->barangay,
                    'province' => $request->province,
                    'postalcode' => $request->postalcode,
                    'isVerified' => $request->Customstatus,
                    'visibility' => 1
                ];
        
                try {
                    User::create($data);
                } catch (\Throwable $th) {
                    $response = ['status' => false, 'msg' => $th];
                    return response()->json($response);
                }
            }
    
         
    
            $response = ['status' => true, 'msg' => 'Create User Successfully'];
            return response()->json($response);
        }




    }

    public function showEditForm($id)
    {
        
        if ($id) {
          
            $data['user'] = User::findOrFail($id);
            if(Auth::user()->user_level >= $data['user']['user_level']){
            
            }else{
                return back();
            }
            $data['user_groups'] = UserGroup::all();;
            $data['main_page'] = 'users';
            $data['sub_page'] = 'users_list';
            return view('admin.users.edit.edit_admin',$data);
        }
    }

    public function updateUser(Request $request)
    {
       
        $validator =Validator::make($request->all(),[
            // 'edit_user_group' => 'required|numeric',
            // 'username' => 'bail|required|min:2|max:255',
            'useravatar' => 'mimes:jpeg,jpg,png,gif|max:100000',
            'email' => 'required|unique:users,email,'.$request->id.'|email',
            'password' => 'nullable|min:5',
            'cpassword' => 'nullable|min:5|same:password',

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false,'msg'=>$validator->errors()]);
        }

        if ($request->hasFile('useravatar')) {
            if ($request->file('useravatar')->isValid()) {

                $file = $request->useravatar;
                $image_name = rand(10,10000).'_'.time() . '.' . $file->getClientOriginalExtension();


                $file->move(public_path('images/'), $image_name);
                // $usergroupid =  UserGroup::where('level',$request->usergroups)->first();
                
             
        $data = [
            'user_group_id' => $request->usergroups,
            'user_level' => $request->userlevel,
            'username' => $request->username,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
            // 'isVerified' => $request->editstatus,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'exname' => $request->exname,
            'gender' => $request->gender,
            'age' => $request->age,
            'dob' => $request->dob,
            'address' => $request->address,
            'mobile' => $request->mobile,
            'province' => $request->province,
            'city' => $request->city,
            'postalcode' => $request->postalcode,
            'barangay' => $request->barangay,
            'housenumber' => $request->housenumber,
            'streetname' => $request->streetname,
            'otherinfo' => $request->otherinfo,
            'avatar' => $image_name,
        ];
        
        if(empty($request->password)){
            unset($data['password']);
        }

                try {
                    User::where('id', $request->id)->update($data);
                } catch (\Throwable $th) {
                    $response = ['status' => false, 'msg' => 'Update User Failed'];
                    return response()->json($response);
                }
            }
        }
        // $usergroupid =  UserGroup::where('level',$request->usergroups)->first();
        $data = [
            'user_group_id' =>  $request->usergroups,
            'user_level' => $request->userlevel,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'isVerified' => $request->editstatus,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'exname' => $request->exname,
            'gender' => $request->gender,
            'age' => $request->age,
            'dob' => $request->dob,
            'address' => $request->address,
            'mobile' => $request->mobile,
            'province' => $request->province,
            'city' => $request->city,
            'postalcode' => $request->postalcode,
            'barangay' => $request->barangay,
            'housenumber' => $request->housenumber,
            'streetname' => $request->streetname,
            'otherinfo' => $request->otherinfo,
        ];
        if(empty($request->password)){
            unset($data['password']);
        }
     
        try {
            User::where('id', $request->id)->update($data);
        } catch (\Throwable $th) {
            $response = ['status' => false, 'msg' => 'Update User Failed'];
            return response()->json($response);
        }

        $response = ['status' => true, 'msg' => 'Update User Successfully'];
        return response()->json($response);


    }


    public function deleteUser(Request $request)
    {
        $data['visibility'] = 0;
        try {
            User::where('id', $request->id)->update($data);
        } catch (\Throwable $th) {
            $response = ['status' => false, 'msg' => 'Delete User Failed'];
            return response()->json($response);
        }

        $response = ['status' => true, 'msg' => 'Delete User Successfully'];
        return response()->json($response);
    }

    public function GetFilteredAdminlist(Request $request){

      $usersdata = User::where('username', $request->textname)->where('visibility','=','1')->where('user_level','<>', '1');
      $data = DB::table('users')->whereBetween("created_at",[$request->textdatefrom , $request->textdateto])->union($usersdata)->where('visibility','=','1')->where('user_level','<>', '1')->get();
      $response = ['status' => true, 'data' => $data];
    return  response()->json($response);


    }

    public function AdmingeneratedData(Request $request){
      $draw = $request->get('draw');
      $start = $request->get("start");
      $rowperpage = $request->get("length");

      $count = User::with('user_groups')->where('user_level','<>', '1')->where('user_level','<=', Auth::user()->user_level)->whereNotNull('user_group_id')->where('visibility', '1')->count();
       $users = User::with('user_groups')->where('user_level','<>', '1')->where('user_level','<=', Auth::user()->user_level)->whereNotNull('user_group_id')->where('visibility', '1')->get();
      // Fetch records
      $data_arr = array();

      foreach($users as $record){
         $data_arr[] = array(
           $record['firstname'].' '.$record['lastname'],
           $record['email'],
          $record['user_groups']['user_group'],
           $record['user_level'],
          '<div class="text-right">
<a href="'.route('admin.users.show').'/'.$record['id'].'"><button type="button" class="btn btn-link btn-warning btn-just-icon edit" ><i class="material-icons">dvr</i></button></a>
<button type="button" class="btn btn-link btn-danger btn-just-icon remove" data-action="" data-userid ="' .  $record['id'] .'"><i class="material-icons">close</i></button>
          </div>'
         );
      }

      $response = array(
         "draw" => intval($draw),
         "recordsTotal" => $count,
         "recordsFiltered" => $count,
         "data" => $data_arr
      );

      echo json_encode($response);
      exit;
    }


}
