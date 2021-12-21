<?php
    
    namespace App\Http\Controllers;
    
    use Illuminate\Http\Request;
    use App\EmailTemplate, App\UserGovernmentId, App\TransactionSetting;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Mail;
    use Datatables;
    
    class EmailTemplateController extends Controller{
        public function email_list(){
            return view("admin.views.email.email_list");
        }
    
        public function list_fetch_email(Request $request){
            $users = DB::table('email_templates')->orderBy('id','desc')->get();
            
            return Datatables::of($users)
                ->addIndexColumn()
                ->editColumn("action", function($users) {
                    return '<a href="'.route('admin-email-view', ['email_id' => base64_encode($users->id)]).'"><i class="fas fa-eye text-success"></i></a>'.
                        ' &nbsp; '.
                        '<a href="'.route('admin-edit-email', ['email_id' => base64_encode($users->id)]).'"><i class="fas fa-pencil-alt text-primary"></i></a>'.
                        ' &nbsp; '.'';
                })
                ->rawColumns(["action"])
                ->make(true);
        }
    
        public function edit_email(Request $request, $cat_id){
            $cat_id_encoded = $cat_id;
            $cat_id = base64_decode($cat_id);
            $cat = DB::table('email_templates')->find($cat_id);
    
            return view("admin.views.email.email_crud", ["user" => $cat, "user_id" => $cat_id,"user_id_encoded" => $cat_id_encoded]);
        }
    
        public function update_email_post(Request $request ,$id){
        	$this->validate(request(), [
                'email_title' => ['required', 'string', 'max:255'],
                'email_subject' => ['required'],
                'email_html' => ['required'],
            ]);
            
            $email_title = $request->email_title;
            $email_subject = $request->email_subject;
            $email_html = $request->email_html;
    
            $crud_data = array(
                'email_title' => $email_title,
                'email_subject' => $email_subject,
                'email_html' => $email_html,
            );
    
            $user_update_response = DB::table('email_templates')->where('id', $id)->limit(1)->update($crud_data);
    
            if($user_update_response){
                return redirect()->route('email-list')->with('success', __('message_lang.EMAIL_TEMPLATE_UPDATED_SUCCESSFULLY'));
            }else{
                return redirect()->back()->with('error', __('message_lang.FAILD_TO_UPDATE_EMAIL_TEMPLATE'))->withInput();
            }
        }
    
        public function view_email(Request $request, $cat_id){   
            $cat_id = base64_decode($cat_id);
            $email = DB::table('email_templates')->find($cat_id);
            $email->logo_url = _get_site_logo();
            $email->footer_text = 'Slate Sign';
            
            return view('admin.views.email.email_view', ["email" => $email,]);
        }
        
        public function ingredients_addons_status(Request $request){
            if(!$request->ajax()){
                exit('No direct script access allowed');
            }
    
            if(!empty($request->all())){
                $status = $request->status;
                $id = $request->id;
    
                if($status == 'Deleted'){
                    $crud_data = array('is_deleted' => "Y");
                }else{
                    $crud_data = array('status' => $status);
                }
                
                $update_result = DB::table('ingredients_addons')->where('id', $id)->update($crud_data);
    
                if($update_result){
                    echo json_encode(array("status" => "success")); exit;
                }else{
                    echo json_encode(array("status" => "failed")); exit;
                }
            }else{
                echo json_encode(array("status" => "failed")); exit;
            }
        }
    }
