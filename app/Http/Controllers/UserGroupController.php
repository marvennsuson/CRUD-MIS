<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class UserGroupController extends Controller
{
    protected $userGroups;
    public function __construct()
    {
        $this->userGroups = new UserGroup;
    }
    public function list()
    {
        $user_groups = UserGroup::all();

        $data['user_groups'] = $user_groups;
        $data['main_page'] = 'users';
        $data['sub_page'] = 'usergroup';
        return view('admin.usergroups.usergroups', $data);

    }

    public function add(Request $request)
    {   
        $validator =Validator::make($request->all(),[
            'user_group' => 'bail|required|min:3|max:255',
            'description' =>  'required|min:3|max:255',
            'grouplevel' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()]);
        }

        $data = [
            'user_group' => $request->user_group,
            'description' => $request->description,
            'level' => $request->grouplevel,
        ];
        
        try {
            UserGroup::create($data);
        } catch (\Throwable $th) {
            dd($th);
            $response = ['status' => false, 'msg' => 'Create User Group Failed'];
            return response()->json($response);
        }

        $response = ['status' => true, 'msg' => 'Create User Group Successfully'];
        return response()->json($response);

    }

    public function showEditForm(Request $request)
    {

        if ($request->id) {
            // $userGroups = $this->userGroups->getUserGroupsWithoutSuperAdmin();
            // $userGroupInfo = $this->userGroups->readUserGroup($request->id);
            $userGroupInfo = UserGroup::findOrFail($request->id);
            $data['usergroup_info'] = $userGroupInfo;
            // return view('admin.users.response._edit_response',$data);
            $response = ['status' => true, 'msg' => 'Show Edit form for User Group Successfully', 'data' => $data];
            return response()->json($response);
        }
    }


    
    public function update(Request $request)
    {
        
        $validator =Validator::make($request->all(),[
            'edit_user_group' => 'bail|required|min:3|max:255',
            'editdescription' => 'required',
            'editlevel' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()]);
        }

        $data = [
            'user_group' => $request->edit_user_group,
            'description' => $request->editdescription,
            'level' => $request->editlevel,
        ];

        try {
            UserGroup::where('id', $request->usergroup_id)->update($data);
        } catch (\Throwable $th) {
            $response = ['status' => false, 'msg' => 'Update User Group Failed'];
            return response()->json($response);
        }

        $response = ['status' => true, 'msg' => 'Update User Group Successfully'];
        return response()->json($response);


    }

    public function delete(Request $request)
    {
        try {
            UserGroup::where('id', $request->id)->delete();
        } catch (\Throwable $th) {
            $response = ['status' => false, 'msg' => 'Delete User Group Failed'];
            return response()->json($response);
        }
        $response = ['status' => true, 'msg' => 'Delete User Group Successfully'];
        return response()->json($response);
    }

    
}
