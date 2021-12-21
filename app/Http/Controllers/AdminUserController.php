<?php

    namespace App\Http\Controllers;
    
    use Illuminate\Http\Request;
    use App\User, App\Country, App\UserGovernmentId;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Mail;
    use File, URL, Hash;
    // use Illuminate\Routing\Route; // Wrong
    use Illuminate\Support\Facades\Route; // Right
    use Maatwebsite\Excel\Facades\Excel;
    use App\Exports\UsersExport;
    use App\Exports\StaffExport;
    use Datatables;
    
    class AdminUserController extends Controller{
    
        /** customer */
            
            /** list */
                public function user_list(Request $request){
                    return view("admin.views.users.list_user");
                }
            /** list */
            
            /** lists */
                public function user_lists(Request $request){

                    $users = User::where('user_role_id', '=', config('constants.user_roles.USER_ROLE_ID'))
                                    ->orderBy('created_at','desc')
                                    ->get();
                    
                    return Datatables::of($users)
                            ->addIndexColumn()
                            ->editColumn("action", function($users) {
                                return '<a href="'.route('user-profile', ['user_id' => base64_encode($users->id)]).'"><i class="fas fa-eye text-success"></i></a>'.
                                    ' &nbsp; '.
                                    '<a href="'.route('admin-edit-user', ['user_id' => base64_encode($users->id)]).'"><i class="fas fa-pencil-alt text-primary"></i></a>'.
                                    ' &nbsp; '.
                                    '<div class="dropdown" style="display: inline;">'.
                                        '<a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-bars text-secondary"></i>'.
                                        '</a>'.
                                        '<ul class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: top, left; top: 20px; left: -142px;">'.
                                            '<li class="ms-dropdown-list">'.
                
                                                '<a class="dropdown-item badge-gradient-success" href="javascript:void( 0);" onclick="change_status(this);" data-status="'.config('constants.user_status.ACTIVE').'" data-id="'.$users->id.'">'.config('constants.user_status.ACTIVE').'</a>'.
                
                                                '<a class="dropdown-item badge-gradient-warning" href="javascript:void(0);" onclick="change_status(this);" data-status="'.config('constants.user_status.INACTIVE').'" data-id="'.$users->id.'">'.config('constants.user_status.INACTIVE').'</a>'.
                                    
                                                '<a class="dropdown-item badge-gradient-danger" href="javascript:void(0);" onclick="change_status(this);" data-status="'.config('constants.user_status.DELETED').'" data-id="'.$users->id.'">'.config('constants.user_status.DELETED').'</a>'.
                                                
                                                '<a class="dropdown-item badge-gradient-secondary" href="javascript:void(0);" onclick="change_status(this);" data-status="'.config('constants.user_status.VERIFIED').'" data-id="'.$users->id.'">'.config('constants.user_status.VERIFIED').'</a>'.
                
                                            '</li>'.
                                        '</ul>'.
                                    '</div>'.
                                '';
                            })
                            ->editColumn("status", function($users) {
                                if($users->status == config('constants.user_status.ACTIVE'))
                                {
                                    return '<span class="badge badge-gradient-success">'.config('constants.user_status.ACTIVE').'</span>';
                                }
                                else if($users->status == config('constants.user_status.INACTIVE'))
                                {
                                    return '<span class="badge badge-gradient-warning">'.config('constants.user_status.INACTIVE').'</span>';
                                }
                                else if($users->status == config('constants.user_status.DELETED'))
                                {
                                    return '<span class="badge badge-gradient-danger">'.config('constants.user_status.DELETED').'</span>';
                                }
                                else if($users->status == config('constants.user_status.VERIFIED'))
                                {
                                    return '<span class="badge badge-gradient-secondary">'.config('constants.user_status.VERIFIED').'</span>';
                                }
                                else
                                {
                                    return '-';
                                }
                            })
                
                            ->editColumn("profile_image",function($users){
                                if($users->profile_image != '' OR !empty($users->profile_image)){
                                    $image = $users->profile_image;
                                    return '<img src="'.url("uploads/customer/$image").'" border="0" width="40" />';
                                }else{
                                    
                                    return '<img src="'.url("uploads/customer/default.png").'" border="0" width="40" />';
                                }
                            })
                            ->rawColumns(["action", "status","profile_image"])
                            ->make(true);
                }
            /** lists */
        
            /** add */
                public function user_add(Request $request){
                    return view("admin.views.users.crud_user");
                }
            /** add */
        
            /** insert */
                public function user_insert(Request $request){
                    $this->validate(request(), [
                        'first_name' => ['required', 'string', 'max:255'],
                        'last_name' => ['required', 'string', 'max:255'],
                        'email' => ['required', 'string', 'max:255', 'email:rfc', 'unique:users']
                    ]);
            
                    $first_name = $request->first_name;
                    $last_name = $request->last_name;
                    $email = $request->email;
            
                    if(!empty($request->profile_image)){
                        $image = $request->file('profile_image');
                        $image_name = $request->file('profile_image')->getClientOriginalName();
                        
                        $destinationPath = 'uploads/customer';
                        $image->move($destinationPath,$image->getClientOriginalName());
                    }else{
                        $image_name = null;
                    }
            
                    $crud_data = array(
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'profile_image' => $image_name,
                        'user_role_id' => config('constants.user_roles.USER_ROLE_ID'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'status' => config('constants.user_status.ACTIVE'),
                    );
            
                    $last_inserted_id = DB::table('users')->insertGetId($crud_data);
            
                    if($last_inserted_id > 0){
                        $user_unique_id = date('Ym')."-".$last_inserted_id;
            
                        $verification_code = md5($user_unique_id);
            
                        $crud_data = array(
                            'user_unique_id' => $user_unique_id,
                            'verification_code' => $verification_code,
                        );
            
                        DB::table('users')->where('id', $last_inserted_id)->update($crud_data);
            
                        return redirect()->route('admin-users')->with('success', 'Record added successfully.');
                    }else{
                        return redirect()->route('admin-add-user')->with('error', 'Failed to add record.')->withInput();
                    }
                }
            /** insert */
        
            /** edit */
                public function user_edit(Request $request, $user_id){
                    $user_id = base64_decode($user_id);
                    $user = User::find($user_id);
            
                    return view("admin.views.users.crud_user", ["user" => $user, "user_id" => $user_id]);
                }
            /** edit */
        
            /** update */
                public function user_update(Request $request, $id){
                    $this->validate(request(), [
                        'first_name' => ['required', 'string', 'max:255'],
                        'last_name' => ['required', 'string', 'max:255'],
                        'email' => 'required|string|max:255|email:rfc|unique:users,email,'.$id
                   
                    ]);
                    
                    $first_name = $request->first_name;
                    $last_name = $request->last_name;
                    $email = $request->email;
            
                    if(!empty($request->file('profile_image'))){
                        $image = $request->file('profile_image');
                        $image_name = $request->file('profile_image')->getClientOriginalName();
                        
                        $destinationPath = 'uploads/customer';
                        $image->move($destinationPath,$image->getClientOriginalName());
                    }else{
                        $image_name = $request->hidden_image;
                    }
            
                    $crud_data = array(
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'profile_image' => $image_name,
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
            
                    $user_update_response = DB::table('users')->where('id', $id)->limit(1)->update($crud_data);
            
                    if($user_update_response){
                        return redirect()->route('admin-users')->with('success', 'Record updated successully.');
                    }else{
                        return redirect()->back()->with('error', 'Failed to updated record.')->withInput();
                    }
                }
            /** update */
        
            /** change-status */
                public function user_change_status(Request $request){
                    if(!$request->ajax()){
                        exit('No direct script access allowed');
                    }
            
                    if(!empty($request->all())){
                        $status = $request->status;
                        $id = $request->id;
            
                        $crud_data = ['status' => $status, 'updated_at' => data('Y-m-d H:i:s')];
                        
                        $update_result = User::where('id', $id)->update($crud_data);
            
                        if($update_result){
                            echo json_encode(array("status" => "success"));
                            exit;
                        }else{
                            echo json_encode(array("status" => "failed"));
                            exit;
                        }
                    }else{
                        echo json_encode(array("status" => "failed"));
                        exit;
                    }
                }
            /** change-status */
            
            /** profile */
                public function user_profile(Request $request, $user_id){
                    $user_id = base64_decode($user_id);
            
                    $user = DB::table('users')
                                    ->select('users.first_name','users.user_unique_id','users.last_name','users.email','users.profile_image','users.status','user_roles.role')
                                    ->leftjoin('user_roles','users.user_role_id','user_roles.id')
                                    ->where('users.id','=' ,$user_id)
                                    ->first();
            
                    return view("admin.views.users.user_profile", ["user" => $user]);
                }
            /** profile */
        
            /** remove-image */
                public function user_remove_image(Request $request){
                    if(!$request->ajax()){
                        exit('No direct script access allowed');
                    }
            
                    if(!empty($request->all())){
                        $id = $request->encoded_id;
            
                        $user_id = base64_decode($id);
            
                        $user = DB::table('users')->find($user_id);
            
                        if($user){
                            if($user->profile_image != ''){
                                if(File::exists(public_path('uploads/customer/'.$user->profile_image))){
                                    @unlink(public_path('uploads/customer/'.$user->profile_image));
                                }
            
                                $user_update_response = DB::table('users')->where('id', $user_id)->limit(1)->update(array('profile_image' => ''));
            
                                if($user_update_response){
                                    echo json_encode(array('FLASH_STATUS' => 'S', 'FLASH_MESSAGE' => 'Deleted Successfully.'));
                                    exit;
                                }else{
                                    echo json_encode(array('FLASH_STATUS' => 'E', 'FLASH_MESSAGE' => 'Failed To Delete.'));
                                    exit;
                                }
                            }
                        }else{
                            echo json_encode(array('FLASH_STATUS' => 'E', 'FLASH_MESSAGE' => 'Failed To Delete.'));
                            exit;
                        }
                    }else{
                        echo json_encode(array("status" => "failed"));
                        exit;
                    }
                }
            /** remove-image */
        
            /** export */
                public function user_export() {
                    return Excel::download(new UsersExport, 'Users.CSV');
                }
            /** export */
            
        /** customer */
    
        /** admin */
            //admin-listing
            public function admin_list()
            {
                return view("admin.views.users.list_admin");
            }
        
            //Admin fetch list
            public function list_fetch_admin(Request $request)
            {
                // view, edit, status menu, delete
                // DB::enableQueryLog();
                $users = DB::table('admins')->get();
                // dd(DB::getQueryLog());
                return Datatables::of($users)
                    ->addIndexColumn()
                    ->editColumn("action", function($users) {
                        return '<a href="'.route('admin-profile', ['admin_id' => base64_encode($users->id)]).'"><i class="fas fa-eye text-success"></i></a>'.
                            ' &nbsp; '.
                            '<a href="'.route('admin-edit-admin', ['user_id' => base64_encode($users->id)]).'"><i class="fas fa-pencil-alt text-primary"></i></a>'.
                            ' &nbsp; '.
                            '<div class="dropdown" style="display: inline;">'.
                                '<a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-bars text-secondary"></i>'.
                                '</a>'.
                                '<ul class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: top, left; top: 20px; left: -142px;">'.
                                    '<li class="ms-dropdown-list">'.
        
                                        '<a class="dropdown-item badge-gradient-success" href="javascript:void( 0);" onclick="change_status(this);" data-status="'.config('constants.user_status.ACTIVE').'" data-id="'.$users->id.'">'.config('constants.user_status.ACTIVE').'</a>'.
        
                                        '<a class="dropdown-item badge-gradient-warning" href="javascript:void(0);" onclick="change_status(this);" data-status="'.config('constants.user_status.INACTIVE').'" data-id="'.$users->id.'">'.config('constants.user_status.INACTIVE').'</a>'.
                            
                                        '<a class="dropdown-item badge-gradient-danger" href="javascript:void(0);" onclick="change_status(this);" data-status="'.config('constants.user_status.DELETED').'" data-id="'.$users->id.'">'.config('constants.user_status.DELETED').'</a>'.
                                        
                                        '<a class="dropdown-item badge-gradient-secondary" href="javascript:void(0);" onclick="change_status(this);" data-status="'.config('constants.user_status.VERIFIED').'" data-id="'.$users->id.'">'.config('constants.user_status.VERIFIED').'</a>'.
        
                                    '</li>'.
                                '</ul>'.
                            '</div>'.
                        '';
                    })
                    ->editColumn("status", function($users) {
                        if($users->status == config('constants.user_status.ACTIVE'))
                        {
                            return '<span class="badge badge-gradient-success">'.config('constants.user_status.ACTIVE').'</span>';
                        }
                        else if($users->status == config('constants.user_status.INACTIVE'))
                        {
                            return '<span class="badge badge-gradient-warning">'.config('constants.user_status.INACTIVE').'</span>';
                        }
                        else if($users->status == config('constants.user_status.DELETED'))
                        {
                            return '<span class="badge badge-gradient-danger">'.config('constants.user_status.DELETED').'</span>';
                        }
                        else if($users->status == config('constants.user_status.VERIFIED'))
                        {
                            return '<span class="badge badge-gradient-secondary">'.config('constants.user_status.VERIFIED').'</span>';
                        }
                        else
                        {
                            return '-';
                        }
                    })
                    ->editColumn("profile_image",function($users){
                        if($users->profile_image != '' OR !empty($users->profile_image)){
                            $profile_image = $users->profile_image;
                            return '<img src="'.url("uploads/admin/$profile_image").'" border="0" width="40" />';
                        }else{
                            
                            return '<img src="'.url("uploads/admin/default.png").'" border="0" width="40" />';
                        }
                    })
                    ->rawColumns(["action", "status","profile_image"])
                    ->make(true);
            }
        
        
            //Admin Profile
            public function admin_profile(Request $request, $admin_id)
            {
                // if($user_id == '')
                // {
                //     return redirect()->route('admin-dashboard');
                // }
        
                $user_id = base64_decode($admin_id);
        
                $user = DB::table('admins')->find($user_id);
                $user_role = "Admin";
                return view("admin.views.users.admin_profile", ["user" => $user , "user_role" =>$user_role]);
            }
        
        
            //Edit Admin
            public function edit_admin(Request $request, $user_id)
            {
                $user_id_encoded = $user_id;
                
                $user_id = base64_decode($user_id);
        
                $user = DB::table('admins')->find($user_id);
        
                return view("admin.views.users.crud_admin", ["user" => $user, "user_id" => $user_id, "user_id_encoded" => $user_id_encoded]);
            }
        
        
            //Add Admin
            public function add_admin(Request $request)
            {
                return view("admin.views.users.crud_admin");
            }
        
        
            //Add Admin Post
            public function add_admin_post(Request $request)
            {
                $this->validate(request(), [
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'max:255', 'email:rfc', 'unique:users']
                ]);
        
                $first_name = $request->first_name;
                $last_name = $request->last_name;
                $email = $request->email;
        
                if(!empty($request->profile_image)){
                    $image = $request->file('profile_image');
                    $image_name = $request->file('profile_image')->getClientOriginalName();
                    
                    $destinationPath = 'uploads/admin';
                    $image->move($destinationPath,$image->getClientOriginalName());
                }else{
                    $image_name = null;
                }
        
                $crud_data = array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'profile_image' => $image_name,
                    'created_at' => date('Y-m-d H:i:s'),
                    'status' => config('constants.user_status.INACTIVE'),
                );
        
                $last_inserted_id = DB::table('admins')->insertGetId($crud_data);
        
                if($last_inserted_id > 0)
                {
                    return redirect()->route('admin-list')->with('success', __('Admin added successfully'));
                }
                else
                {
                    return redirect()->route('admin-add-admin')->with('error', __('FAILED_TO_ADD_ADMIN'))->withInput();
                }
            }
        
        
            //Update Admin Post
            public function update_admin_post(Request $request, $id)
            {
                $this->validate(request(), [
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'email' => 'required|string|max:255|email:rfc|unique:users,email,'.$id
                ]);
                
                $first_name = $request->first_name;
                $last_name = $request->last_name;
                $email = $request->email;
                if(!empty($request->file('profile_image'))){
                    $image = $request->file('profile_image');
                    $image_name = $request->file('profile_image')->getClientOriginalName();
                    
                    $destinationPath = 'uploads/admin';
                    $image->move($destinationPath,$image->getClientOriginalName());
                }else{
                    $image_name = $request->hidden_image;
                }
        
        
                $crud_data = array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'profile_image' =>$image_name,
                    'updated_at' => date('Y-m-d H:i:s'),
                );
        
                $user_update_response = DB::table('admins')->where('id', $id)->limit(1)->update($crud_data);
        
                if($user_update_response)
                {
                    return redirect()->route('admin-list')->with('success', __('Admin updated successfully'));
                }
                else
                {
                    return redirect()->back()->with('error', __('FAILED_TO_UPDATE_ADMIN'))->withInput();
                }
            }
        
        
            //Change Admin Status
            public function change_admin_status(Request $request)
            {
                if(!$request->ajax())
                {
                    exit('No direct script access allowed');
                }
        
                if(!empty($request->all()))
                {
                    $status = $request->status;
                    $id = $request->id;
        
                    $crud_data = array(
                        'status' => $status
                    );
                    
                    $update_result = DB::table('admins')->where('id', $id)->update($crud_data);
        
                    if($update_result)
                    {
                        echo json_encode(array("status" => "success"));
                        exit;
                    }
                    else
                    {
                        echo json_encode(array("status" => "failed"));
                        exit;
                    }
                }
                else
                {
                    echo json_encode(array("status" => "failed"));
                    exit;
                }
            }
        
        
            //Remove Admin Profile Image
            public function remove_admin_profile_image(Request $request)
            {
                if(!$request->ajax())
                {
                    exit('No direct script access allowed');
                }
        
                if(!empty($request->all()))
                {
                    $id = $request->encoded_id;
        
                    $user_id = base64_decode($id);
        
                    $user = DB::table('admins')->find($user_id);
        
                    if($user)
                    {
                        if($user->profile_image != '')
                        {
                            if(File::exists(public_path('uploads/admin/'.$user->profile_image)))
                            {
                                @unlink(public_path('uploads/admin/'.$user->profile_image));
                            }
        
                            $user_update_response = DB::table('admins')->where('id', $user_id)->limit(1)->update(array('profile_image' => ''));
        
                            if($user_update_response)
                            {
                                echo json_encode(array('FLASH_STATUS' => 'S', 'FLASH_MESSAGE' => 'Deleted Successfully.'));
                                exit;
                            }
                            else
                            {
                                echo json_encode(array('FLASH_STATUS' => 'E', 'FLASH_MESSAGE' => 'Failed To Delete.'));
                                exit;
                            }
                        }
                    }
                    else
                    {
                        echo json_encode(array('FLASH_STATUS' => 'E', 'FLASH_MESSAGE' => 'Failed To Delete.'));
                        exit;
                    }
                }
                else
                {
                    echo json_encode(array("status" => "failed"));
                    exit;
                }
            }
    
        /** admin */
        
        /** staff */
            
            /** list */
                public function staff_list(Request $request){
                    return view("admin.views.users.staff.list");
                }
            /** list */
    
            /** lists */
                public function staff_lists(Request $request){
                    $data = User::where(['user_role_id' => config('constants.user_roles.STAFF_ROLE_ID')])
                                    ->orderBy('created_at','desc')
                                    ->get();
                    
                    return Datatables::of($data)
                            ->addIndexColumn()
                            ->editColumn('action', function($data) {
                                return '<a href="'.route('admin-staff-profile', ['id' => base64_encode($data->id)]).'"><i class="fas fa-eye text-success"></i></a> &nbsp; '.
                                        '<a href="'.route('admin-staff-edit', ['id' => base64_encode($data->id)]).'"><i class="fas fa-pencil-alt text-primary"></i></a> &nbsp; '.
                                        '<div class="dropdown" style="display: inline;">'.
                                            '<a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-bars text-secondary"></i>'.
                                            '</a>'.
                                            '<ul class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: top, left; top: 20px; left: -142px;">'.
                                                '<li class="ms-dropdown-list">'.
                                                    '<a class="dropdown-item badge-gradient-success" href="javascript:void(0);" onclick="change_status(this);" data-status="'.config('constants.user_status.ACTIVE').'" data-id="'.$data->id.'">'.config('constants.user_status.ACTIVE').'</a>'.
                                                    '<a class="dropdown-item badge-gradient-warning" href="javascript:void(0);" onclick="change_status(this);" data-status="'.config('constants.user_status.INACTIVE').'" data-id="'.$data->id.'">'.config('constants.user_status.INACTIVE').'</a>'.
                                                    '<a class="dropdown-item badge-gradient-danger" href="javascript:void(0);" onclick="change_status(this);" data-status="'.config('constants.user_status.DELETED').'" data-id="'.$data->id.'">'.config('constants.user_status.DELETED').'</a>'.
                                                    '<a class="dropdown-item badge-gradient-secondary" href="javascript:void(0);" onclick="change_status(this);" data-status="'.config('constants.user_status.VERIFIED').'" data-id="'.$data->id.'">'.config('constants.user_status.VERIFIED').'</a>'.
                                                '</li>'.
                                            '</ul>'.
                                        '</div>';
                            })
                            
                            ->editColumn("status", function($data) {
                                if($data->status == config('constants.user_status.ACTIVE')){
                                    return '<span class="badge badge-gradient-success">'.config('constants.user_status.ACTIVE').'</span>';
                                }else if($data->status == config('constants.user_status.INACTIVE')){
                                    return '<span class="badge badge-gradient-warning">'.config('constants.user_status.INACTIVE').'</span>';
                                }else if($data->status == config('constants.user_status.DELETED')){
                                    return '<span class="badge badge-gradient-danger">'.config('constants.user_status.DELETED').'</span>';
                                }else if($data->status == config('constants.user_status.VERIFIED')){
                                    return '<span class="badge badge-gradient-secondary">'.config('constants.user_status.VERIFIED').'</span>';
                                }else{
                                    return '-';
                                }
                            })
            
                            ->editColumn('profile_image', function($data){
                                if($data->profile_image != '' OR !empty($data->profile_image)){
                                    $profile_image = $data->profile_image;
                                    return '<img src="'.url("uploads/staff/$profile_image").'" border="0" width="40" />';
                                }else{
                                    
                                    return '<img src="'.url("uploads/staff/default.png").'" border="0" width="40" />';
                                }
                            })
                            
                            ->rawColumns(["action", "status","profile_image"])
                            ->make(true);
                }
            /** lists */
    
            /** add */
                public function staff_add(Request $request){
                    return view("admin.views.users.staff.crud");
                }
            /** add */
    
            /** insert */
                public function staff_insert(Request $request){
                    $this->validate(request(), [
                        'first_name' => ['required', 'string', 'max:255'],
                        'last_name' => ['required', 'string', 'max:255'],
                        'email' => ['required', 'string', 'max:255', 'email:rfc', 'unique:users']
                    ]);
            
                    $first_name = $request->first_name;
                    $last_name = $request->last_name;
                    $email = $request->email;
            
                    if(!empty($request->profile_image)){
                        $image = $request->file('profile_image');
                        $image_name = $request->file('profile_image')->getClientOriginalName();
                        
                        $destinationPath = 'uploads/staff';
                        $image->move($destinationPath,$image->getClientOriginalName());
                    }else{
                        $image_name = null;
                    }
                    
                    $crud = array(
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'profile_image' => $image_name,
                        'user_role_id' => config('constants.user_roles.STAFF_ROLE_ID'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'status' => config('constants.user_status.ACTIVE'),
                    );
            
                    $last_id = DB::table('users')->insertGetId($crud);
            
                    if($last_id > 0){
                        $user_unique_id = date('Ym')."-".$last_id;
            
                        $verification_code = md5($user_unique_id);
            
                        $crud_data = array(
                            'user_unique_id' => $user_unique_id,
                            'verification_code' => $verification_code,
                        );
            
                        DB::table('users')->where('id', $last_id)->update($crud_data);
            
                        return redirect()->route('admin-staff-list')->with('success', 'Record added successfully.');
                    }else{
                        return redirect()->route('admin-add-staff')->with('error', 'Failed to add record.')->withInput();
                    }
                }
            /** insert */
    
            /** edit */
                public function staff_edit(Request $request, $id){
                    $id = base64_decode($id);
                    $data = DB::table('users')->find($id);
                
                    return view("admin.views.users.staff.crud", ["data" => $data, "id" => $id]);
                }
            /** edit */
    
            /** update */
                public function staff_update(Request $request, $id){
                    $this->validate(request(), [
                        'first_name' => ['required', 'string', 'max:255'],
                        'last_name' => ['required', 'string', 'max:255'],
                        'email' => 'required|string|max:255|email:rfc|unique:users,email,'.$id
                    ]);
                    
                    $first_name = $request->first_name;
                    $last_name = $request->last_name;
                    $email = $request->email;
            
                    if(!empty($request->file('profile_image'))){
                        $image = $request->file('profile_image');
                        $image_name = $request->file('profile_image')->getClientOriginalName();
                        
                        $destinationPath = 'uploads/staff';
                        $image->move($destinationPath,$image->getClientOriginalName());
                    }else{
                        $image_name = $request->hidden_image;
                    }
            
                    $crud = array(
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'profile_image' =>$image_name,
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
            
                    $update = DB::table('users')->where('id', $id)->limit(1)->update($crud);
            
                    if($update){
                        return redirect()->route('admin-staff-list')->with('success', 'Record updated successfully.');
                    }else{
                        return redirect()->back()->with('error', 'Record update failed.')->withInput();
                    }
                }
            /** update */
    
            /** profile */
                public function staff_profile(Request $request, $id){
                    $id = base64_decode($id);
            
                    $data = DB::table('users')
                                    ->select('users.*', 'user_roles.role')
                                    ->leftjoin('user_roles', 'user_roles.id', 'users.user_role_id')
                                    ->where(['users.id' => $id])
                                    ->first();
            
                    return view("admin.views.users.staff.profile", ["data" => $data]);
                }
            /** profile */
    
            /** change_status */
                public function staff_change_status(Request $request){
                    if(!$request->ajax()){
                        exit('No direct script access allowed');
                    }
            
                    if(!empty($request->all())){
                        $status = $request->status;
                        $id = $request->id;
            
                        $crud = ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')];
                        
                        $update = User::where('id', $id)->update($crud);
            
                        if($update){
                            echo json_encode(['code' => '200']);
                            exit;
                        }else{
                            echo json_encode(['code' => '201']);
                            exit;
                        }
                    }else{
                        echo json_encode(['code' => '201']);
                        exit;
                    }
                }   
            /** change_status */
    
            /** remove-image */
                public function staff_remove_image(Request $request){
                    if(!$request->ajax()){
                        exit('No direct script access allowed');
                    }
            
                    if(!empty($request->all())){
                        $id = $request->encoded_id;
                        $id = base64_decode($id);
            
                        $data = DB::table('users')->find($id);
            
                        if($data){
                            if($data->profile_image != ''){
                                if(File::exists(public_path('uploads/staff/'.$data->profile_image)))
                                {
                                    @unlink(public_path('uploads/staff/'.$data->profile_image));
                                }
            
                                $update = DB::table('users')->where('id', $id)->limit(1)->update(['profile_image' => '']);
            
                                if($update){
                                    echo json_encode(['code' => '200', 'message' => 'Deleted Successfully.']);
                                    exit;
                                }else{
                                    echo json_encode(['code' => '201', 'message' => 'Failed to delete.']);
                                    exit;
                                }
                            }else{
                                echo json_encode(['code' => '200', 'message' => 'Deleted Successfully.']);
                                exit;
                            }
                        }else{
                            echo json_encode(['code' => '201', 'message' => 'Failed to delete.']);
                            exit;
                        }
                    }else{
                        echo json_encode(['code' => '201', 'message' => 'Failed to delete.']);
                        exit;
                    }
                }
            /** remove-image */
        
            /** export */
                public function staff_export() {
                    return Excel::download(new StaffExport, 'Staff.CSV');
                }
            /** export */
    
        /** staff */
    
        /** award */
            //Award Index
           public function award(){
            return view('admin.views.users.list_award');
           }
        
           //Award List
            public function award_list(Request $request)
            {
                   $users = DB::table('award')->get();
        
                // dd(DB::getQueryLog());
                return Datatables::of($users)
                    ->addIndexColumn()
                    ->editColumn("action", function($users) {
                        return 
                            '<a href="'.route('admin-edit-award', ['user_id' => base64_encode($users->id)]).'"><i class="fas fa-pencil-alt text-primary"></i></a>'.
                            ' &nbsp; '.
                            '<a href="'.route('admin-delete-award', ['user_id' => base64_encode($users->id)]).'"><i class="material-icons md-18">delete</i></a>'.
                            ' &nbsp; '.
                            
                            '<div class="dropdown" style="display: inline;">'.
                                '<a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-bars text-secondary"></i>'.
                                '</a>'.
                                '<ul class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: top, left; top: 20px; left: -142px;">'.
                                    '<li class="ms-dropdown-list">'.
        
                                        '<a class="dropdown-item badge-gradient-success" href="javascript:void( 0);" onclick="change_status(this);" data-status="'.'published'.'" data-id="'.$users->id.'">'.'published'.'</a>'.
        
                                        
                                        
                                        '<a class="dropdown-item badge-gradient-secondary" href="javascript:void(0);" onclick="change_status(this);" data-status="'.'unpublished'.'" data-id="'.$users->id.'">'.'unpublished'.'</a>'.
        
                                    '</li>'.
                                '</ul>'.    
                            '</div>'.
                        '';
                    })
                    ->editColumn("status", function($users) {
                        if($users->status == "published")
                        {
                            return '<span class="badge badge-gradient-success">'.'published'.'</span>';
                        }
                        
                        else if($users->status == "unpublished")
                        {
                            return '<span class="badge badge-gradient-secondary">'.'unpublished'.'</span>';
                        }
                        else
                        {
                            return '-';
                        }
                    })
        
                    ->editColumn("image",function($user){
                        if($user->image != '' OR !empty($user->image)){
                            $image = $user->image;
                            return '<img src="'.url("uploads/award/$image").'" border="0" width="40" />';
                        }else{
                            
                            return '<img src="'.url("uploads/award/default.png").'" border="0" width="40" />';
                        }
                    })
        
        
                    ->rawColumns(["action", "status","image"])
                    ->make(true);
            }
        
        
            //Edit Award
             public function edit_award(Request $request, $user_id)
            {
                $user_id = base64_decode($user_id);
        
                $user = DB::table('award')->find($user_id);
        
                return view("admin.views.users.crud_award", ["user" => $user, "user_id" => $user_id]);
            }
        
        
            //Add Award
            public function add_award(Request $request)
            {
                return view("admin.views.users.crud_award");
            }
        
        
            //Add Award Post
             public function add_award_post(Request $request)
            {
                $this->validate(request(), [
                    'name' => ['required', 'string', 'max:255']
                ]);
        
                $client_name = $request->name;
        
                if(!empty($request->profile_image)){
                    $image = $request->file('profile_image');
                    $image_name = $request->file('profile_image')->getClientOriginalName();
                    
                    $destinationPath = 'uploads/award';
                    $image->move($destinationPath,$image->getClientOriginalName());
                }else{
                    $image_name = null;
                }
        
                $crud_data = array(
                    'name' => $client_name,
                    'image' => $image_name,
                    'status' => 'published'
                );
        
                $last_inserted_id = DB::table('award')->insertGetId($crud_data);
        
                if($last_inserted_id > 0)
                {
                   
        
                    return redirect()->route('award-list')->with('success', __('message_lang.AWARD_ADDED_SUCCESSFULLY'));
                }
                else
                {
                    return redirect()->route('admin-add-award')->with('error', __('message_lang.FAILED_TO_ADD_AWARD'))->withInput();
                }
            }
        
        
            //Update Award Post
            public function update_award_post(Request $request, $id)
            {
                $this->validate(request(), [
                    'name' => ['required', 'string', 'max:255']
                ]);
                
               
                $name = $request->name;
                $text = $request->text;
                
                if(!empty($request->file('profile_image'))){
                    $image = $request->file('profile_image');
                    $image_name = $request->file('profile_image')->getClientOriginalName();
                    
                    $destinationPath = 'uploads/award';
                    $image->move($destinationPath,$image->getClientOriginalName());
                }else{
                    $image_name = $request->hidden_image;
                }
                
        
                $crud_data = array(
                    'name' => $name,
                    'image' =>$image_name,
                    
                );
        
                $user_update_response = DB::table('award')->where('id', $id)->limit(1)->update($crud_data);
        
                if($user_update_response)
                {
                    return redirect()->route('award-list')->with('success', __('message_lang.AWARD_UPDATED_SUCCESSFULLY'));
                }
                else
                {
                    return redirect()->back()->with('error', __('message_lang.FAILED_TO_UPDATE_AWARD'))->withInput();
                }
            }
        
        
            //Award Status
            public function award_status(Request $request)
            {
                if(!$request->ajax())
                {
                    exit('No direct script access allowed');
                }
        
                if(!empty($request->all()))
                {
                    $status = $request->status;
                    $id = $request->id;
        
                    $crud_data = array(
                        'status' => $status
                    );
                    
                    $update_result = DB::table('award')->where('id',$id)->update($crud_data);
        
                    if($update_result)
                    {
                        echo json_encode(array("status" => "success"));
                        exit;
                    }
                    else
                    {
                        echo json_encode(array("status" => "failed"));
                        exit;
                    }
                }
                else
                {
                    echo json_encode(array("status" => "failed"));
                    exit;
                }
            }
        
        
            //Remove Award Profile Image
            public function remove_award_profile_image(Request $request)
            {
                if(!$request->ajax())
                {
                    exit('No direct script access allowed');
                }
        
                if(!empty($request->all()))
                {
                    $id = $request->encoded_id;
        
                    $user_id = base64_decode($id);
        
                    $user = DB::table('award')->find($user_id);
        
                    if($user)
                    {
                        if($user->image != '')
                        {
                            if(File::exists(public_path('uploads/award/'.$user->image)))
                            {
                                @unlink(public_path('uploads/award/'.$user->image));
                            }
        
                            $user_update_response = DB::table('award')->where('id', $user_id)->limit(1)->update(array('image' => ''));
        
                            if($user_update_response)
                            {
                                echo json_encode(array('FLASH_STATUS' => 'S', 'FLASH_MESSAGE' => 'Deleted Successfully.'));
                                exit;
                            }
                            else
                            {
                                echo json_encode(array('FLASH_STATUS' => 'E', 'FLASH_MESSAGE' => 'Failed To Delete.'));
                                exit;
                            }
                        }
                    }
                    else
                    {
                        echo json_encode(array('FLASH_STATUS' => 'E', 'FLASH_MESSAGE' => 'Failed To Delete.'));
                        exit;
                    }
                }
                else
                {
                    echo json_encode(array("status" => "failed"));
                    exit;
                }
            }
        
        
            //Award Delete
            public function award_delete(Request $request,$user_id)
            {
        
                $user_id = base64_decode($user_id);
                $delete=DB::table('award')->where('id',$user_id)->delete();
                return redirect()->Route('award-list');
            }
            
        /** award */
    
        /** blog */
        
            //Blog Index
            public function blog(Request $request){
                return view('admin.views.users.list_blog');
            }
        
            //List Blog
            public function list_fetch_blog(Request $request)
            {
                   $blog = DB::table('blog')->get();
                   // dd($blog);
                // dd(DB::getQueryLog());
                return Datatables::of($blog)
                    ->addIndexColumn()
                    ->editColumn("action", function($blog) {
                        return 
                            '<a href="'.route('admin-edit-blog', ['user_id' => base64_encode($blog->id)]).'"><i class="fas fa-pencil-alt text-primary"></i></a>'.
                            ' &nbsp; '.
                            '<a href="'.route('admin-delete-blog', ['user_id' => base64_encode($blog->id)]).'"><i class="material-icons md-18">delete</i></a>'.
                            ' &nbsp; '.
                            
                            '<div class="dropdown" style="display: inline;">'.
                                '<a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-bars text-secondary"></i>'.
                                '</a>'.
                                '<ul class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: top, left; top: 20px; left: -142px;">'.
                                    '<li class="ms-dropdown-list">'.
        
                                        '<a class="dropdown-item badge-gradient-success" href="javascript:void( 0);" onclick="change_status(this);" data-status="'.'Active'.'" data-id="'.$blog->id.'">'.'Active'.'</a>'.
        
                                        
                                        
                                        '<a class="dropdown-item badge-gradient-secondary" href="javascript:void(0);" onclick="change_status(this);" data-status="'.'Deactive'.'" data-id="'.$blog->id.'">'.'Deactive'.'</a>'.
        
                                    '</li>'.
                                '</ul>'.    
                            '</div>'.
                        '';
                    })
                    ->editColumn("status", function($blog) {
                        if($blog->status == "Active")
                        {
                            return '<span class="badge badge-gradient-success">'.'Active'.'</span>';
                        }
                        
                        else if($blog->status == "Deactive")
                        {
                            return '<span class="badge badge-gradient-secondary">'.'Deactive'.'</span>';
                        }
                        else
                        {
                            return '-';
                        }
                    })
        
                    ->editColumn("image",function($blog){
                        if($blog->image != '' OR !empty($blog->image)){
                            $image = $blog->image;
                            return '<img src="'.url("uploads/blog/$image").'" border="0" width="40" />';
                        }else{
                            
                            return '<img src="'.url("uploads/blog/default.png").'" border="0" width="40" />';
                        }
                    })
        
                    
                    ->rawColumns(["action", "status","image"])
                    ->make(true);
            }
        
            //Add Blog
            public function add_blog(Request $request)
            {
                return view("admin.views.users.crud_blog");
            }
        
            //Insert Blog
            public function add_blog_post(Request $request)
            {
                $this->validate(request(), [
                    'first_name' => ['required', 'string', 'max:255']
                ]);
        
                $client_name = $request->first_name;
                $text = $request->text;
                
                if(!empty($request->profile_image)){
                    $image = $request->file('profile_image');
                    $image_name = $request->file('profile_image')->getClientOriginalName();
                    
                    $destinationPath = 'uploads/blog';
                    $image->move($destinationPath,$image->getClientOriginalName());
                }else{
                    $image_name = null;
                }
                // dd($request->file('profile_image'));
                $crud_data = array(
                    'title' => $client_name,
                    'blog_containt' => $text,
                    'image'=>$image_name,
                    'status' => 'Active',
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                );
        
                $last_inserted_id = DB::table('blog')->insertGetId($crud_data);
        
                if($last_inserted_id > 0)
                {
                   
        
                    return redirect()->route('blog-list')->with('success', __('message_lang.BLOG_ADDED_SUCCESSFULLY'));
                }
                else
                {
                    return redirect()->route('admin-add-blog')->with('error', __('message_lang.FAILED_TO_ADD_BLOG'))->withInput();
                }
            }
        
            //Update Blog
            public function update_blog_post(Request $request, $id)
            {
        
                $this->validate(request(), [
                    'first_name' => ['required', 'string', 'max:255'],
                    'text' => ['required'],
                ]);
                
                
                $client_name = $request->first_name;
                $text = $request->text;
                
                if(!empty($request->file('profile_image'))){
                    $image = $request->file('profile_image');
                    $image_name = $request->file('profile_image')->getClientOriginalName();
                    
                    $destinationPath = 'uploads/blog';
                    $image->move($destinationPath,$image->getClientOriginalName());
                }else{
                    $image_name = $request->hidden_image;
                }
        
                $crud_data = array(
                    'title' => $client_name,
                    'blog_containt' => $text,
                    'image'=>$image_name,
                    'status' => 'Active',
                    'updated_at'=>date('Y-m-d H:i:s'),
                    
                );
        
                $user_update_response = DB::table('blog')->where('id', $id)->limit(1)->update($crud_data);
        
                if($user_update_response)
                {
                    return redirect()->route('blog-list')->with('success', __('message_lang.BLOG_UPDATED_SUCCESSFULLY'));
                }
                else
                {
                    return redirect()->back()->with('error', __('message_lang.FAILED_TO_UPDATE_BLOG'))->withInput();
                }
            }
        
        
            //Edit Blog
            public function edit_blog(Request $request, $user_id)
            {
                $user_id = base64_decode($user_id);
        
                $blog = DB::table('blog')->find($user_id);
        
                return view("admin.views.users.crud_blog", ["blog" => $blog, "user_id" => $user_id]);
            }
        
        
            //Delete Blog
             public function blog_delete(Request $request,$user_id)
            {
        
                $user_id = base64_decode($user_id);
                $delete=DB::table('blog')->where('id',$user_id)->delete();
                return redirect()->Route('blog-list');
            }
        
            //Change Blog Status
             public function blog_status(Request $request)
            {
                if(!$request->ajax())
                {
                    exit('No direct script access allowed');
                }
        
                if(!empty($request->all()))
                {
                    $status = $request->status;
                    $id = $request->id;
        
                    $crud_data = array(
                        'status' => $status
                    );
                    
                    $update_result = DB::table('blog')->where('id',$id)->update($crud_data);
        
                    if($update_result)
                    {
                        echo json_encode(array("status" => "success"));
                        exit;
                    }
                    else
                    {
                        echo json_encode(array("status" => "failed"));
                        exit;
                    }
                }
                else
                {
                    echo json_encode(array("status" => "failed"));
                    exit;
                }
            }
        
        /** blog */
    
    }
