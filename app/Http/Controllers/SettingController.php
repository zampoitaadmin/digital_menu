<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use DB;
	use Datatables; 

	class SettingController extends Controller{
	
		/** setting list */
		public function setting_list(){

			$logo_url = url('uploads/logo'); 

			$generals = \DB::table('setting')->select('setting_id as id', 'keys', 'key_title', 'value')->where(['type' => 'General'])->get();
			$emails = \DB::table('setting')->select('setting_id as id', 'keys', 'key_title', 'value')->where(['type' => 'Email'])->get();
			$socials = \DB::table('setting')->select('setting_id as id', 'keys', 'key_title', 'value')->where(['type' => 'Social'])->get();
			$smss = \DB::table('setting')->select('setting_id as id', 'keys', 'key_title', 'value')->where(['type' => 'SMS'])->get();
			$payments = \DB::table('setting')->select('setting_id as id', 'keys', 'key_title', 'value')->where(['type' => 'Payment'])->get();
			$logos = \DB::table('setting')->select('setting_id as id', 'keys', 'key_title', \DB::Raw("CONCAT("."'$logo_url'".", '/', ".'value'.") as value"))->where(['type' => 'Logo'])->get();
			$pizza_delivery = \DB::table('setting')->select('setting_id as id', 'keys', 'key_title', 'value')->where(['type' => 'Pizza_Delivery'])->get();
			
			return view('admin.views.settings.settings_list', compact('generals', 'emails', 'smss', 'payments', 'logos', 'socials', 'pizza_delivery'));
		}
		
		/** setting update */
		public function setting_update(Request $request){
			
			$all = $request->all();
			unset($all['_token']);
			
			if(!empty($all) && count($all) > 0){
				
				\DB::beginTransaction();
				try {
					$i = 0;
					
					foreach($all as $key => $value){
						DB::table('setting')->where('setting_id', $key)->limit(1)->update(['value' => $value]);
						$i++;
					}
					
					if($i == count($all)){
						\DB::commit();
						return redirect()->back()->with('success', "Record Updated Successfully");
					}else{
						\DB::rollback();
						return redirect()->back()->with('error', "Faild To Update Record");
					}			
				} catch (\Throwable $th) {
					\DB::rollback();
					return redirect()->back()->with('error', "Faild To Update Record");
				}
			}else{
				return redirect()->back()->with('error', "Please select vaida data.");
			}
		}

		/** setting logo update */
		public function setting_logo_update(Request $request){
			
			$all = $request->all();
			unset($all['_token']);
			
			if(!empty($all) && isset($all)){
				$data = [];
				foreach($all as $key => $value){
					$image = $request->file($key);
					$image_name = time()."_".rand(1, 999).".".request()->$key->getClientOriginalExtension();
					$data[$key] = $image_name;
				}

				\DB::beginTransaction();
				try {
					if(!empty($data)){
						$i = 0;

						foreach($data as $k => $v){
							DB::table('setting')->where('keys', $k)->limit(1)->update(['value' => $v]);
							$i++;
						}

						if($i == count($all)){
							foreach($data as $k => $v){
								$image = $request->file($k);
								$destinationPath = 'uploads/logo';
								$image->move($destinationPath, $v);
							}
							\DB::commit();
							return redirect()->back()->with('success', "Record Updated Successfully");
						}else{
							\DB::rollback();
							return redirect()->back()->with('error', "Faild To Update Record");
						}
					}
				}catch(\Throwable $th) {
					\DB::rollback();
					return redirect()->back()->with('error', "Faild To Update Record");
				}
			}else{
				return redirect()->back()->with('error', "Please select vaida data.");
			}
		}

		public function general_setting_fetch(Request $request){
			$general_setting = DB::table('setting')
							->select('setting.setting_id','setting.keys','setting.key_title','setting.value','setting.setting_status')
							->where([
										['type','=','General']
									])
							->orderBy('setting_id' ,'desc')
							->get();
			return Datatables::of($general_setting)
			->addIndexColumn()
			->editColumn("action", function($general_setting){
				return 
						'<a href="'.route('edit-general-setting',['setting_id'=>$general_setting->setting_id]).'"><i class="fas fa-pencil-alt text-success"></i></a>'.
						' &nbsp; '.

						'<a href="'.route('delete-setting',['setting_id'=>$general_setting->setting_id]).'"><i class="fas fa-trash text-danger"></i></a>'.
						' &nbsp; '.''
						;
			})
			->editColumn("setting_status",function($general_setting){
					if($general_setting->setting_status =='Active')
					{
						return '<span class="badge badge-gradient-success">Active</span>';
					}
					else if($general_setting->setting_status == 'Deactive')
					{
						return '<span class="badge badge-gradient-warning">Inactive</span>';
					}
					else
					{
						return '-';
					}
				
			})
			->rawColumns(['action',"setting_status"])
			->make(true);
		}

		public function email_setting_fetch(Request $request){
			$general_setting = DB::table('setting')
							->select('setting.setting_id','setting.keys','setting.key_title','setting.value','setting.setting_status')
							->where([
										['type','=','Email']
									])
							->orderBy('setting_id','desc')
							->get();
			return Datatables::of($general_setting)
			->addIndexColumn()
			->editColumn("action", function($general_setting){
				return 
						'<a href="'.route('edit-email-setting',['setting_id'=>$general_setting->setting_id]).'"><i class="fas fa-pencil-alt text-success"></i></a>'.
						' &nbsp; '.

						'<a href="'.route('delete-setting',['setting_id'=>$general_setting->setting_id]).'"><i class="fas fa-trash text-danger"></i></a>'.
						' &nbsp; '.''
						;
			})
			->editColumn("setting_status",function($general_setting){
					if($general_setting->setting_status =='Active')
					{
						return '<span class="badge badge-gradient-success">Active</span>';
					}
					else if($general_setting->setting_status == 'Deactive')
					{
						return '<span class="badge badge-gradient-warning">Inactive</span>';
					}
					else
					{
						return '-';
					}
				
			})
			->rawColumns(['action',"setting_status"])
			->make(true);
		}

		public function sms_setting_fetch(Request $request){
			$general_setting = DB::table('setting')
							->select('setting.setting_id','setting.keys','setting.key_title','setting.value','setting.setting_status')
							->where([
										['type','=','SMS']
									])
							->orderBy('setting_id','desc')
							->get();
			return Datatables::of($general_setting)
			->addIndexColumn()
			->editColumn("action", function($general_setting){
				return 
						'<a href="'.route('edit-sms-setting',['setting_id'=>$general_setting->setting_id]).'"><i class="fas fa-pencil-alt text-success"></i></a>'.
						' &nbsp; '.

						'<a href="'.route('delete-setting',['setting_id'=>$general_setting->setting_id]).'"><i class="fas fa-trash text-danger"></i></a>'.
						' &nbsp; '.''
						;
			})
			->editColumn("setting_status",function($general_setting){
					if($general_setting->setting_status =='Active')
					{
						return '<span class="badge badge-gradient-success">Active</span>';
					}
					else if($general_setting->setting_status == 'Deactive')
					{
						return '<span class="badge badge-gradient-warning">Inactive</span>';
					}
					else
					{
						return '-';
					}
				
			})
			->rawColumns(['action',"setting_status"])
			->make(true);
		}

		public function payment_setting_fetch(Request $request){
			$general_setting = DB::table('setting')
							->select('setting.setting_id','setting.keys','setting.key_title','setting.value','setting.setting_status')
							->where([
										['type','=','Payment']
									])
							->orderBy('setting_id','desc')
							->get();
			return Datatables::of($general_setting)
			->addIndexColumn()
			->editColumn("action", function($general_setting){
				return 
						'<a href="'.route('edit-payment-setting',['setting_id'=>$general_setting->setting_id]).'"><i class="fas fa-pencil-alt text-success"></i></a>'.
						' &nbsp; '.

						'<a href="'.route('delete-setting',['setting_id'=>$general_setting->setting_id]).'"><i class="fas fa-trash text-danger"></i></a>'.
						' &nbsp; '.''
						;
			})
			->editColumn("setting_status",function($general_setting){
					if($general_setting->setting_status =='Active')
					{
						return '<span class="badge badge-gradient-success">Active</span>';
					}
					else if($general_setting->setting_status == 'Deactive')
					{
						return '<span class="badge badge-gradient-warning">Inactive</span>';
					}
					else
					{
						return '-';
					}
				
			})
			->rawColumns(['action',"setting_status"])
			->make(true);
		}

		public function add_general_setting(Request $request){
			return view('admin.views.settings.general_setting_crud');
		}

		public function add_general_setting_post(Request $request){
			
			$title = $request->key_title;
			$keys = str_replace(' ','_',$title);
			$value = $request->value;
			$element_type = $request->element_type;
			$type = "General";
			$setting_desc = $request->setting_desc;
			

			$crud_data = array(
				"keys" => $keys,
				"key_title"=>$title,
				"value" =>$value,
				"element_type" => $element_type,
				"type" => $type,
				"description" => $setting_desc
			);

			$setting_post = DB::table('setting')->insertGetId($crud_data);

			if($setting_post > 0){
				return redirect('admin/settings')->with('success',"Record Insert Success");
			}else{
				return redirect('admin/settings')->with('error',"Faild To Insert Record");
			}
		}

		public function edit_general_setting(Request $request,$id){
			$setting = DB::table('setting')->where('setting_id','=',$id)->first();

			return view('admin.views.settings.general_setting_crud')->with('setting',$setting);
		}

		public function update_general_setting_post(Request $request,$id){
			// dd('uiu');
			$id = $request->setting_id;
			$title = $request->key_title;
			$keys = str_replace(' ','_',$title);
			$value = $request->value;
			$element_type = $request->element_type;
			$type = "General";
			$setting_desc = $request->setting_desc;
			

			$crud_data = array(
				"keys" => $keys,
				"key_title"=>$title,
				"value" =>$value,
				"element_type" => $element_type,
				"type" => $type,
				"description" => $setting_desc
			);

			$setting_post = DB::table('setting')->where('setting_id', $id)->limit(1)->update($crud_data);
			if($setting_post){
				return redirect('admin/settings')->with('suceess',"Record Updated Successfully");
			}else{
				return redirect('admin/settings')->with('error',"Faild To Update Record");
			}
		}

		public function add_email_setting(){
			return view('admin.views.settings.email_setting_crud');
		}

		public function add_email_setting_post(Request $request){
			// dd('hiiihihui');
			$title = $request->key_title;
			$keys = str_replace(' ','_',$title);
			$value = $request->value;
			$element_type = $request->element_type;
			$type = "Email";
			$setting_desc = $request->setting_desc;
			

			$crud_data = array(
				"keys" => $keys,
				"key_title"=>$title,
				"value" =>$value,
				"element_type" => $element_type,
				"type" => $type,
				"description" => $setting_desc
			);

			$setting_post = DB::table('setting')->insertGetId($crud_data);

			if($setting_post > 0){
				return redirect('admin/settings')->with('success',"Record Insert Success");
			}else{
				return redirect('admin/settings')->with('error',"Faild To Insert Record");
			}
		}

		public function edit_email_setting(Request $request,$id){
			$setting = DB::table('setting')->where('setting_id','=',$id)->first();

			return view('admin.views.settings.email_setting_crud')->with('setting',$setting);
		}

		public function update_email_setting_post(Request $request,$id){
			$id = $request->setting_id;
			$title = $request->key_title;
			$keys = str_replace(' ','_',$title);
			$value = $request->value;
			$element_type = $request->element_type;
			$type = "Email";
			$setting_desc = $request->setting_desc;
			

			$crud_data = array(
				"keys" => $keys,
				"key_title"=>$title,
				"value" =>$value,
				"element_type" => $element_type,
				"type" => $type,
				"description" => $setting_desc
			);

			$setting_post = DB::table('setting')->where('setting_id', $id)->limit(1)->update($crud_data);
			if($setting_post){
				return redirect('admin/settings')->with('success',"Record Updated Successfully");
			}else{
				return redirect('admin/settings')->with('error',"Faild To Update Record");
			}    
		}
		
		public function add_sms_setting(){
			return view('admin.views.settings.sms_setting_crud');
		}

		public function add_sms_setting_post(Request $request){
			$title = $request->key_title;
			$keys = str_replace(' ','_',$title);
			$value = $request->value;
			$element_type = $request->element_type;
			$type = "SMS";
			$setting_desc = $request->setting_desc;
			

			$crud_data = array(
				"keys" => $keys,
				"key_title"=>$title,
				"value" =>$value,
				"element_type" => $element_type,
				"type" => $type,
				"description" => $setting_desc
			);

			$setting_post = DB::table('setting')->insertGetId($crud_data);

			if($setting_post > 0){
				return redirect('admin/settings')->with('success',"Record Insert Success");
			}else{
				return redirect('admin/settings')->with('error',"Faild To Insert Record");
			}
		}

		public function edit_sms_setting(Request $request,$id){
			$setting = DB::table("setting")->where('setting_id','=',$id)->first();
			return view('admin.views.settings.sms_setting_crud')->with('setting',$setting);
		}

		public function update_sms_setting_post(Request $request,$id){
			$id = $request->setting_id;
			$title = $request->key_title;
			$keys = str_replace(' ','_',$title);
			$value = $request->value;
			$element_type = $request->element_type;
			$type = "SMS";
			$setting_desc = $request->setting_desc;
			

			$crud_data = array(
				"keys" => $keys,
				"key_title"=>$title,
				"value" =>$value,
				"element_type" => $element_type,
				"type" => $type,
				"description" => $setting_desc
			);

			$setting_post = DB::table('setting')->where('setting_id', $id)->limit(1)->update($crud_data);
			if($setting_post){
				return redirect('admin/settings')->with('success',"Record Updated Successfully");
			}else{
				return redirect('admin/settings')->with('error',"Faild To Update Record");
			}	
		}

		public function add_payment_setting(){
			return view('admin.views.settings.payment_setting_crud');
		}

		public function add_payment_setting_post(Request $request){
			$title = $request->key_title;
			$keys = str_replace(' ','_',$title);
			$value = $request->value;
			$element_type = $request->element_type;
			$type = "Payment";
			$setting_desc = $request->setting_desc;
			

			$crud_data = array(
				"keys" => $keys,
				"key_title"=>$title,
				"value" =>$value,
				"element_type" => $element_type,
				"type" => $type,
				"description" => $setting_desc
			);

			$setting_post = DB::table('setting')->insertGetId($crud_data);

			if($setting_post > 0){
				return redirect('admin/settings')->with('success',"Record Insert Success");
			}else{
				return redirect('admin/settings')->with('error',"Faild To Insert Record");
			}
		}

		public function edit_payment_setting(Request $request,$id){
			$setting = DB::table('setting')->where('setting_id','=',$id)->first();
			return view('admin.views.settings.payment_setting_crud')->with('setting',$setting);
		}

		public function update_payment_setting_post(Request $request,$id){
			$id = $request->setting_id;
			$title = $request->key_title;
			$keys = str_replace(' ','_',$title);
			$value = $request->value;
			$element_type = $request->element_type;
			$type = "Payment";
			$setting_desc = $request->setting_desc;
			

			$crud_data = array(
				"keys" => $keys,
				"key_title"=>$title,
				"value" =>$value,
				"element_type" => $element_type,
				"type" => $type,
				"description" => $setting_desc
			);

			$setting_post = DB::table('setting')->where('setting_id', $id)->limit(1)->update($crud_data);
			if($setting_post){
				return redirect('admin/settings')->with('success',"Record Updated Successfully");
			}else{
				return redirect('admin/settings')->with('error',"Faild To Update Record");
			}	
		}

		public function setting_delete(Request $request,$id){
			
			$delete = DB::table('setting')->where('setting_id', $id)->delete();
			if($delete){
				return redirect('admin/settings')->with('success',"Record Deleted Successfully");
			}else{
				return redirect('admin/settings')->with('error',"Faild To Delete Record");
			}

		}
	}
