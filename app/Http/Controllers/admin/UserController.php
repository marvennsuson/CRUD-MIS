<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Use App\UserGroup;
use DB;
use App\Resident;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{

public function index()
{
$data['main_page'] = 'users';
$data['sub_page'] = 'normalUser';
$data['user_groups'] = UserGroup::all();
//   $data['users'] =  User::with('user_groups')->where('user_level','=', '1')->where('id','<>', Auth::id())->where('visibility','=','1')->get();
return view('admin.users.index',$data);
}


public function create(Request $request)
{

$validator =Validator::make($request->all(),[
   'Profileimage' => 'mimes:jpeg,jpg,png,gif|max:100000',
   'firstName' => 'required',
   'lastName' => 'required',
   'email' => 'required|email|unique:users|unique:residents',
   'custompassword' => 'required',
   'Customconfirmpassword' => 'required|same:custompassword',
   'streetname' => 'required',
   'houseno' => 'required',
   'city' => 'required',
   'barangay' => 'required',
   'province' => 'required',
   'postalcode' => 'required',
   'Customstatus' => 'required',
]);

if ($validator->fails()) {
   return response()->json(['status' => false, 'msg'=>$validator->errors()]);
}else{
   if ($request->hasFile('Profileimage')) {
       if ($request->file('Profileimage')->isValid()) {
         $file = $request->Profileimage;
         $image_name = rand(10,10000).'_'.time() . '.' . $file->getClientOriginalExtension();
         $file->move(public_path('images/'), $image_name);

         $data = [
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
            'verify' => $request->Customstatus,
            'avatar' => $image_name,
            'visibility' => 1
         ];
         
         try {
            Resident::create($data);
         } catch (\Throwable $th) {
            $response = ['status' => false, 'msg' => $th];
            return response()->json($response);
         }


       }
   }else{
      $data = [
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
         'verify' => $request->Customstatus,
         'visibility' => 1
      ];
      
      try {
         Resident::create($data);
      } catch (\Throwable $th) {
         $response = ['status' => false, 'msg' => $th];
         return response()->json($response);
      }
   }

}


$response = ['status' => true, 'msg' => 'Create User Successfully'];
return response()->json($response);
}
///end of Creation Residents


public function show($id){
   $data['main_page'] = 'users';
   $data['sub_page'] = 'normalUser';
   $data['user'] = Resident::findOrFail($id);
     return view('admin.users.edit.edit_resident',$data);
}

        public function updateUser(Request $request)
        {
            $validator =Validator::make($request->all(),[
               'useravatar' => 'mimes:jpeg,jpg,png,gif|max:100000',
                'email' => 'required|unique:residents,email,'.$request->id.'|email',
                'password' => 'nullable|min:5',
                'cpassword' => 'nullable|min:5|same:password',

            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false ,'msg'=>$validator->errors()]);
            }
            if ($request->hasFile('useravatar')) {
                if ($request->file('useravatar')->isValid()) {
                  $file = $request->useravatar;
                  $image_name = rand(10,10000).'_'.time() . '.' . $file->getClientOriginalExtension();
                  $file->move(public_path('images/'), $image_name);
                  $data = [
                     'email' => $request->email,
                     'firstname' => $request->firstname,
                     'middlename' => $request->middlename,
                     'lastname' => $request->lastname,
                     'password' => Hash::make($request->password),
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
               
                  Resident::where('id',  $request->id)->update($data);
                }
            }
            $data = [
                'email' => $request->email,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'password' => Hash::make($request->password),
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
               Resident::where('id', $request->id)->update($data);
            } catch (\Throwable $th) {
                $response = ['status' => false, 'msg' => $th];
                return response()->json($response);
            }

            $response = ['status' => true, 'msg' => 'Update User Successfully'];
            return response()->json($response);
        }


        public function deleteUser(Request $request)
        {
            $data['visibility'] = 0;
            try {
               Resident::where('id', $request->id)->update($data);
            } catch (\Throwable $th) {
                $response = ['status' => false, 'msg' => 'Delete User Failed'];
                return response()->json($response);
            }

            $response = ['status' => true, 'msg' => 'Delete User Successfully'];
            return response()->json($response);
        }


        public function generatedData(Request $request){
          $draw = $request->get('draw');
          $start = $request->get("start");
          $rowperpage = $request->get("length");

         //  $count = Resident::with('user_groups')->where('user_level','=', '1')->where('id','<>', Auth::id())->where('visibility', '1')->count();
           $users = Resident::where('visibility', '1')->get();
          // Fetch records

          $data_arr = array();

          foreach($users as $record){
             $data_arr[] = array(
               $record['firstname'].' '.$record['lastname'],
               $record['email'],
               "Residents",
               "1",
              '<div class="text-right">
               <a href="' .route("user.resident.show").'/'.$record['id'].'"><button type="button" class="btn btn-link btn-warning btn-just-icon edit" ><i class="material-icons">dvr</i></button></a>
               <button type="button" class="btn btn-link btn-danger btn-just-icon remove" data-userid ="'.$record['id'].'"><i class="material-icons">close</i></button>
              </div>'
             );
          }

          $response = array(
             "draw" => intval($draw),
             "recordsTotal" =>  $users->count(),
             "recordsFiltered" => $users->count(),
             "data" => $data_arr
          );

          echo json_encode($response);
          exit;
        }


        public function GetFiltered(Request $request){

            if($request->filter === "0"){
                if (!empty($request->textname) && empty($request->textdatefrom) && empty($request->textdateto)) {

                $draw = $request->get('draw');
                $start = $request->get("start");
                $rowperpage = $request->get("length");
                  // $count = User::where('username', $request->textname)->where('visibility','=','1')->where('user_level','=', '1')->where('id','<>', Auth::id());
                  $users = Resident::where('visibility','1')
                  ->where('lastname', 'LIKE', '%'.$request->textname.'%')->orWhere('firstname', 'LIKE','%'.$request->textname.'%')->get();

                  $data_arr = array();
                  foreach($users as $record){
                     $data_arr[] = array(
                       $record->firstname.' '.$record->lastname,
                       $record->email,
                        'Residents',
                       '1',
                      '<div class="text-right">
                      <a href="' .route("user.resident.show").'/'.$record->id.'"><button type="button" class="btn btn-link btn-warning btn-just-icon edit" ><i class="material-icons">dvr</i></button></a>
            <button type="button" class="btn btn-link btn-danger btn-just-icon remove" data-action="" data-userid ="'.$record->id.'"><i class="material-icons">close</i></button>
                      </div>'
                     );
                  }

                  $response = array(
                     "draw" => intval($draw),
                     "recordsTotal" => $users->count(),
                     "recordsFiltered" => $users->count(),
                     "data" => $data_arr
                  );

                  echo json_encode($response);
                  exit;

                }elseif(!empty($request->textname) && !empty($request->textdatefrom) && !empty($request->textdateto)){

                  $draw = $request->get('draw');
                  $start = $request->get("start");
                  $rowperpage = $request->get("length");
                  
                  $users = Resident::whereBetween("created_at",[$request->textdatefrom , $request->textdateto])
                  ->where('lastname',  'LIKE', '%'.$request->textname.'%')
                  ->where('visibility','1')
                  ->get();

                    $data_arr = array();
                    foreach($users as $record){
                     $data_arr[] = array(
                        $record->firstname.' '.$record->lastname,
                        $record->email,
                         'Residents',
                        '1',
                       '<div class="text-right">
                       <a href="' .route("user.resident.show").'/'.$record->id.'"><button type="button" class="btn btn-link btn-warning btn-just-icon edit" ><i class="material-icons">dvr</i></button></a>
             <button type="button" class="btn btn-link btn-danger btn-just-icon remove" data-action="" data-userid ="'.$record->id.'"><i class="material-icons">close</i></button>
                       </div>'
                      );
                    }

                    $response = array(
                       "draw" => intval($draw),
                       "recordsTotal" => $users->count(),
                       "recordsFiltered" => $users->count(),
                       "data" => $data_arr
                    );

                    echo json_encode($response);
                    exit;
                }else{
                  $draw = $request->get('draw');
                  $start = $request->get("start");
                  $rowperpage = $request->get("length");

                  // $count = User::with('user_groups')->where('user_level','=', '1')->where('id','<>', Auth::id())->where('visibility', '1')->count();
                   $users = Resident::whereBetween("created_at",[$request->textdatefrom , $request->textdateto])
                   ->where('visibility', '1')->orderBy('created_at', 'desc')->get();
                  // Fetch records

                  $data_arr = array();
                  foreach($users as $record){
                     $data_arr[] = array(
                        $record->firstname.' '.$record->lastname,
                        $record->email,
                         'Residents',
                        '1',
                       '<div class="text-right">
                       <a href="' .route("user.resident.show").'/'.$record->id.'"><button type="button" class="btn btn-link btn-warning btn-just-icon edit" ><i class="material-icons">dvr</i></button></a>
             <button type="button" class="btn btn-link btn-danger btn-just-icon remove" data-action="" data-userid ="'.$record->id.'"><i class="material-icons">close</i></button>
                       </div>'
                      );
                    } 

                  $response = array(
                     "draw" => intval($draw),
                     "recordsTotal" => $users->count(),
                     "recordsFiltered" => $users->count(),
                     "data" => $data_arr
                  );

                  echo json_encode($response);
                  exit;
                }

            }elseif($request->filter === "name"){
              if (!empty($request->textname) && empty($request->textdatefrom) && empty($request->textdateto)) {

              $draw = $request->get('draw');
              $start = $request->get("start");
              $rowperpage = $request->get("length");
                // $count = User::where('username', $request->textname)->where('visibility','=','1')->where('user_level','=', '1')->where('id','<>', Auth::id());
                $users = Resident::where('lastname', 'LIKE', '%'.$request->textname.'%')->orWhere('firstname', 'LIKE','%'.$request->textname.'%')
                ->where('visibility','=','1')
                ->orderBy('lastname', 'asc')
                ->get();
                $data_arr = array();
                foreach($users as $record){
                  $data_arr[] = array(
                     $record->firstname.' '.$record->lastname,
                     $record->email,
                      'Residents',
                     '1',
                    '<div class="text-right">
                    <a href="' .route("user.resident.show").'/'.$record->id.'"><button type="button" class="btn btn-link btn-warning btn-just-icon edit" ><i class="material-icons">dvr</i></button></a>
          <button type="button" class="btn btn-link btn-danger btn-just-icon remove" data-action="" data-userid ="'.$record->id.'"><i class="material-icons">close</i></button>
                    </div>'
                   );
                 } 

                $response = array(
                   "draw" => intval($draw),
                   "recordsTotal" => $users->count(),
                   "recordsFiltered" => $users->count(),
                   "data" => $data_arr
                );

                echo json_encode($response);
                exit;

              }elseif(!empty($request->textname) && !empty($request->textdatefrom) && !empty($request->textdateto)){

                $draw = $request->get('draw');
                $start = $request->get("start");
                $rowperpage = $request->get("length");

                $users = Resident::whereBetween("created_at",[$request->textdatefrom , $request->textdateto])
                ->where('lastname', 'LIKE', $request->textname.'%')
                ->where('visibility','=','1')
                ->orderBy('lastname', 'asc')
                ->get();
                
                  $data_arr = array();
                  foreach($users as $record){
                     $data_arr[] = array(
                        $record->firstname.' '.$record->lastname,
                        $record->email,
                         'Residents',
                        '1',
                       '<div class="text-right">
                       <a href="' .route("user.resident.show").'/'.$record->id.'"><button type="button" class="btn btn-link btn-warning btn-just-icon edit" ><i class="material-icons">dvr</i></button></a>
             <button type="button" class="btn btn-link btn-danger btn-just-icon remove" data-action="" data-userid ="'.$record->id.'"><i class="material-icons">close</i></button>
                       </div>'
                      );
                    } 

                  $response = array(
                     "draw" => intval($draw),
                     "recordsTotal" => $users->count(),
                     "recordsFiltered" => $users->count(),
                     "data" => $data_arr
                  );

                  echo json_encode($response);
                  exit;
              }else{
                $draw = $request->get('draw');
                $start = $request->get("start");
                $rowperpage = $request->get("length");

                // $count = User::with('user_groups')->where('user_level','=', '1')->where('id','<>', Auth::id())->where('visibility', '1')->count();
                 $users = Resident::whereBetween("created_at",[$request->textdatefrom , $request->textdateto])
                 ->where('visibility', '1')
                 ->orderBy('lastname', 'desc')
                 ->get();
                // Fetch records

                $data_arr = array();

                foreach($users as $record){
                  $data_arr[] = array(
                     $record->firstname.' '.$record->lastname,
                     $record->email,
                      'Residents',
                     '1',
                    '<div class="text-right">
                    <a href="' .route("user.resident.show").'/'.$record->id.'"><button type="button" class="btn btn-link btn-warning btn-just-icon edit" ><i class="material-icons">dvr</i></button></a>
          <button type="button" class="btn btn-link btn-danger btn-just-icon remove" data-action="" data-userid ="'.$record->id.'"><i class="material-icons">close</i></button>
                    </div>'
                   );
                 } 

                $response = array(
                   "draw" => intval($draw),
                   "recordsTotal" => $users->count(),
                   "recordsFiltered" => $users->count(),
                   "data" => $data_arr
                );

                echo json_encode($response);
                exit;
              }

            }elseif($request->filter === "email"){
              if (!empty($request->textname) && empty($request->textdatefrom) && empty($request->textdateto)) {

              $draw = $request->get('draw');
              $start = $request->get("start");
              $rowperpage = $request->get("length");
                // $count = User::where('username', $request->textname)->where('visibility','=','1')->where('user_level','=', '1')->where('id','<>', Auth::id());
                $users = Resident::where('email', $request->textname)
                ->where('visibility','=','1')
                ->orderBy('email', 'asc')
                ->get();
                $data_arr = array();
                foreach($users as $record){
                  $data_arr[] = array(
                     $record->firstname.' '.$record->lastname,
                     $record->email,
                      'Residents',
                     '1',
                    '<div class="text-right">
                    <a href="' .route("user.resident.show").'/'.$record->id.'"><button type="button" class="btn btn-link btn-warning btn-just-icon edit" ><i class="material-icons">dvr</i></button></a>
          <button type="button" class="btn btn-link btn-danger btn-just-icon remove" data-action="" data-userid ="'.$record->id.'"><i class="material-icons">close</i></button>
                    </div>'
                   );
                 } 

                $response = array(
                   "draw" => intval($draw),
                   "recordsTotal" => $users->count(),
                   "recordsFiltered" => $users->count(),
                   "data" => $data_arr
                );

                echo json_encode($response);
                exit;

              }elseif(!empty($request->textname) && !empty($request->textdatefrom) && !empty($request->textdateto)){

                $draw = $request->get('draw');
                $start = $request->get("start");
                $rowperpage = $request->get("length");

                $users = Resident::whereBetween("created_at",[$request->textdatefrom , $request->textdateto])
                ->where('email', 'LIKE', $request->textname.'%')
                ->where('visibility','=','1')
                ->orderBy('email', 'asc')
                ->get();
                  $data_arr = array();
                  foreach($users as $record){
                     $data_arr[] = array(
                        $record->firstname.' '.$record->lastname,
                        $record->email,
                         'Residents',
                        '1',
                       '<div class="text-right">
                       <a href="' .route("user.resident.show").'/'.$record->id.'"><button type="button" class="btn btn-link btn-warning btn-just-icon edit" ><i class="material-icons">dvr</i></button></a>
             <button type="button" class="btn btn-link btn-danger btn-just-icon remove" data-action="" data-userid ="'.$record->id.'"><i class="material-icons">close</i></button>
                       </div>'
                      );
                    } 

                  $response = array(
                     "draw" => intval($draw),
                     "recordsTotal" => $users->count(),
                     "recordsFiltered" => $users->count(),
                     "data" => $data_arr
                  );

                  echo json_encode($response);
                  exit;
              }else{
                $draw = $request->get('draw');
                $start = $request->get("start");
                $rowperpage = $request->get("length");

                // $count = User::with('user_groups')->where('user_level','=', '1')->where('id','<>', Auth::id())->where('visibility', '1')->count();
                 $users = Resident::whereBetween("created_at",[$request->textdatefrom , $request->textdateto])
                 ->where('visibility', '1')
                 ->orderBy('email', 'desc')
                 ->get();
                // Fetch records

                $data_arr = array();

                foreach($users as $record){
                  $data_arr[] = array(
                     $record->firstname.' '.$record->lastname,
                     $record->email,
                      'Residents',
                     '1',
                    '<div class="text-right">
          <a href="' .route("user.resident.show").'/'.$record->id.'"><button type="button" class="btn btn-link btn-warning btn-just-icon edit" ><i class="material-icons">dvr</i></button></a>
          <button type="button" class="btn btn-link btn-danger btn-just-icon remove" data-action="" data-userid ="'.$record->id.'"><i class="material-icons">close</i></button>
                    </div>'
                   );
                 } 

                $response = array(
                   "draw" => intval($draw),
                   "recordsTotal" => $users->count(),
                   "recordsFiltered" => $users->count(),
                   "data" => $data_arr
                );

                echo json_encode($response);
                exit;
              }

            }elseif($request->filter === "date"){
              if (!empty($request->textname) && empty($request->textdatefrom) && empty($request->textdateto)) {

              $draw = $request->get('draw');
              $start = $request->get("start");
              $rowperpage = $request->get("length");
                // $count = User::where('username', $request->textname)->where('visibility','=','1')->where('user_level','=', '1')->where('id','<>', Auth::id());
                $users = Resident::where('lastname', 'LIKE', '%'.$request->textname.'%')->orWhere('firstname', 'LIKE','%'.$request->textname.'%')
                ->where('visibility','=','1')
                ->orderBy('created_at', 'desc')
                ->get();
                $data_arr = array();
                foreach($users as $record){
                  $data_arr[] = array(
                     $record->firstname.' '.$record->lastname,
                     $record->email,
                      'Residents',
                     '1',
                    '<div class="text-right">
          <a href="' .route("user.resident.show").'/'.$record->id.'"><button type="button" class="btn btn-link btn-warning btn-just-icon edit" ><i class="material-icons">dvr</i></button></a>
          <button type="button" class="btn btn-link btn-danger btn-just-icon remove" data-action="" data-userid ="'.$record->id.'"><i class="material-icons">close</i></button>
                    </div>'
                   );
                 }

                $response = array(
                   "draw" => intval($draw),
                   "recordsTotal" => $users->count(),
                   "recordsFiltered" => $users->count(),
                   "data" => $data_arr
                );

                echo json_encode($response);
                exit;

              }elseif(!empty($request->textname) && !empty($request->textdatefrom) && !empty($request->textdateto)){

                $draw = $request->get('draw');
                $start = $request->get("start");
                $rowperpage = $request->get("length");

                $users = Resident::whereBetween("created_at",[$request->textdatefrom , $request->textdateto])
                ->where('lastname', 'LIKE', $request->textname.'%')
                ->where('visibility','=','1')
                ->orderBy('created_at', 'desc')
                ->get();
                  $data_arr = array();
                  foreach($users as $record){
                     $data_arr[] = array(
                        $record->firstname.' '.$record->lastname,
                        $record->email,
                         'Residents',
                        '1',
                       '<div class="text-right">
             <a href="' .route("user.resident.show").'/'.$record->id.'"><button type="button" class="btn btn-link btn-warning btn-just-icon edit" ><i class="material-icons">dvr</i></button></a>
             <button type="button" class="btn btn-link btn-danger btn-just-icon remove" data-action="" data-userid ="'.$record->id.'"><i class="material-icons">close</i></button>
                       </div>'
                      );
                    }

                  $response = array(
                     "draw" => intval($draw),
                     "recordsTotal" => $users->count(),
                     "recordsFiltered" => $users->count(),
                     "data" => $data_arr
                  );

                  echo json_encode($response);
                  exit;
              }else{

                $draw = $request->get('draw');
                $start = $request->get("start");
                $rowperpage = $request->get("length");

                // $count = User::with('user_groups')->where('user_level','=', '1')->where('id','<>', Auth::id())->where('visibility', '1')->count();
                 $users = Resident::whereBetween("created_at",[$request->textdatefrom , $request->textdateto])
                 ->where('visibility', '1')
                 ->orderBy('created_at', 'asc')
                 ->get();
                // Fetch records

                $data_arr = array();

                foreach($users as $record){
                  $data_arr[] = array(
                     $record->firstname.' '.$record->lastname,
                     $record->email,
                      'Residents',
                     '1',
                    '<div class="text-right">
          <a href="' .route("user.resident.show").'/'.$record->id.'"><button type="button" class="btn btn-link btn-warning btn-just-icon edit" ><i class="material-icons">dvr</i></button></a>
          <button type="button" class="btn btn-link btn-danger btn-just-icon remove" data-action="" data-userid ="'.$record->id.'"><i class="material-icons">close</i></button>
                    </div>'
                   );
                 }

                $response = array(
                   "draw" => intval($draw),
                   "recordsTotal" => $users->count(),
                   "recordsFiltered" => $users->count(),
                   "data" => $data_arr
                );

                echo json_encode($response);
                exit;
                
              }

            }
        }
}
