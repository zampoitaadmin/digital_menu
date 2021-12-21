<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category, App\UserGovernmentId, App\TransactionSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Datatables;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->ObjCategory = new Category(); 
    }

    public function list()
    {	
        return view("admin.views.category.list");
    } 

    public function listFetch(Request $request)
    {
        
        $category = $this->ObjCategory->getAllCategoryData();
        return Datatables::of($category)
            ->addIndexColumn()
            ->editColumn("action",function($category){
                 return '<a href="'.route('admin-category-edit',['id' => base64_encode($category->id)]).'"><i class="fas fa-edit text-primary"></i></a> &nbsp; '.'<a href="'.route('admin-category-delete',['id' => base64_encode($category->id)]).'"><i class="fas fa-trash  text-danger"></i></a>';
            })
            ->rawColumns(["action"])
            ->make(true);

    }
    
    public function add()
    {
    	return view("admin.views.category.crud");
    }

    public function insert(Request $request)
    {
        // dd($request->all());
    	$this->validate(request(), [
            'cat_name' => ['required', 'string', 'max:255'],
        ]);

        $crud = array(
            'cat_name' => $request->cat_name,
            'created_at' => date('Y-m-d H:i:s'),
        );

        $lastInsertedId = $this->ObjCategory->insertCategory($crud);

        if($lastInsertedId > 0)
        {
            return redirect()->route('admin-category-list')->with('success', __('message_lang.CATEGORY_ADDED_SUCCESSFULLY'));
        }
        else
        {
            return redirect()->route('admin-add-category')->with('error', __('message_lang.FAILED_TO_ADD_CATEGORY'))->withInput();
        }

    }
    //-----------Edit category-------------//
    public function edit($id)
    {
        $id = base64_decode($id);
        $category = $this->ObjCategory->getCategoryById($id);

        return view("admin.views.category.crud",compact('id','category'));
    }

    //-----------Update category-------------//
    public function update(Request $request ,$id)
    {
        // dd($request->all());
        $id = base64_decode($id);
        // dd($id);
    	$this->validate(request(), [
            'cat_name' => ['required', 'string', 'max:255'],
        ]);
        
        $cat_name = $request->cat_name;

        $crud = array(
            'cat_name' => $cat_name,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $where = array(
                'id'=> $id,
            );

        $update = $this->ObjCategory->updateCategory($where,$crud);

        if($update)
        {
            return redirect()->route('admin-category-list')->with('success', __('message_lang.CATEGORY_UPDATED_SUCCESSFULLY'));
        }
        else
        {
            return redirect()->back()->with('error', __('message_lang.FAILED_TO_UPDATE_CATEGORY'))->withInput();
        }
    }

    public function delete($id)
    {
        $id = base64_decode($id);
        // dd($id);
        $where = array(
                'id'=>$id,
            );
        $delete = $this->ObjCategory->deleteCategory($where);
        if($delete)
        {
            return redirect()->route('admin-category-list')->with('success', __('message_lang.CATEGORY_DELETED_SUCCESSFULLY'));
        }
        else
        {
            return redirect()->back()->with('error', __('message_lang.FAILED_TO_DELETE_CATEGORY'))->withInput();
        }
    }

    //-----------Coupon Status-------------//

    public function couponChangeStatus(Request $request)
    {
        if(!$request->ajax())
        {
            exit('No direct script access allowed');
        }

        if(!empty($request->all()))
        {
            $status = $request->status;
            $id = $request->id;

            $crud = array(
                'status' => $status
            );

            $where = array(
                'id'=> $id,
            );

            $update = $this->ObjCoupon->updateCoupon($where,$crud);

            if($update)
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


}
