<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon, App\UserGovernmentId, App\TransactionSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Datatables;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->ObjCoupon = new Coupon(); 
    }

    public function couponList()
    {	
        return view("admin.views.coupon.coupon_list");
    } 

    public function couponListFetch(Request $request)
    {
        
        $coupon = $this->ObjCoupon->getAllCouponData();
        return Datatables::of($coupon)
            ->addIndexColumn()
            ->editColumn("status", function($coupon) {
                if($coupon->status == config('constants.coupon_status.ACTIVE'))
                {
                    return '<span class="badge badge-gradient-success">'.config('constants.coupon_status.ACTIVE').'</span>';
                }
                else if($coupon->status == config('constants.coupon_status.INACTIVE'))
                {
                    return '<span class="badge badge-gradient-warning">'.config('constants.coupon_status.INACTIVE').'</span>';
                }
                else
                {
                    return '-';
                }
            })
            ->editColumn("action",function($coupon){
                 return '<a href="'.route('admin-coupon-edit',['id' => base64_encode($coupon->id)]).'"><i class="fas fa-edit text-primary"></i></a> &nbsp; '.
                        '<div class="dropdown" style="display: inline;">'.
                            '<a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-bars text-secondary"></i>'.
                            '</a>'.
                            '<ul class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: top, left; top: 20px; left: -142px;">'.
                                '<li class="ms-dropdown-list">'.
                                    '<a class="dropdown-item badge-gradient-success" href="javascript:void(0);" onclick="change_status(this);" data-status="'.config('constants.coupon_status.ACTIVE').'" data-id="'.$coupon->id.'">'.config('constants.coupon_status.ACTIVE').'</a>'.
                                    '<a class="dropdown-item badge-gradient-warning"  href="javascript:void(0);" onclick="change_status(this);" data-status="'.config('constants.coupon_status.INACTIVE').'" data-id="'.$coupon->id.'">'.config('constants.coupon_status.INACTIVE').'</a>'.
                                '</li>'.
                            '</ul>'.
                        '</div>'.
                    '';
            })
            ->rawColumns(["status","action"])
            ->make(true);

    }
    
    public function couponAdd()
    {
    	return view("admin.views.coupon.coupon_crud");
    }

    public function couponInsert(Request $request)
    {
        // dd($request->all());
    	$this->validate(request(), [
            'coupon_code' => ['required', 'string', 'max:255'],
            'type' => ['required'],
            'amount' => ['required'],
            'description' => ['required'],
            'limit_of_use' => ['required','numeric'],
            'expiry_date' => ['required'],
            'status' => ['required'],
        ]);

        $couponCode = $request->coupon_code;
        $type = $request->type;
        $description = $request->description;
        $amount = $request->amount;
        $limitOfUse = $request->limit_of_use;
        $expiryDate = $request->expiry_date;
        $status = $request->status;


        $crud = array(
            'coupon_code' => $couponCode,
            'type' => $type,
            'description' => $description,
            'amount' => $amount,
            'limit_of_use' => $limitOfUse,
            'expiry_date' => $expiryDate,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s'),
        );

        $lastInsertedId = $this->ObjCoupon->insertCoupon($crud);

        if($lastInsertedId > 0)
        {
            return redirect()->route('admin-coupon-list')->with('success', __('message_lang.COUPON_ADDED_SUCCESSFULLY'));
        }
        else
        {
            return redirect()->route('admin-add-coupon')->with('error', __('message_lang.FAILD_TO_ADD_COUPON'))->withInput();
        }

    }
    //-----------Edit Coupon-------------//
    public function couponEdit($id)
    {
        $id = base64_decode($id);
        $coupon = DB::table('coupon')->where('id',$id)->first();

        return view("admin.views.coupon.coupon_crud",compact('id','coupon'));
    }

    //-----------Update Coupon-------------//
    public function couponUpdate(Request $request ,$id)
    {
        // dd($request->all());
        $id = base64_decode($id);
        // dd($id);
    	$this->validate(request(), [
            'coupon_code' => ['required', 'string', 'max:255'],
            'type' => ['required'],
            'description' => ['required'],
            'amount' => ['required'],
            'product_ids' => '',
            'limit_of_use' => ['required','numeric'],
            'expiry_date' => ['required'],
            'status' => ['required'],
        ]);
        
        $couponCode = $request->coupon_code;
        $type = $request->type;
        $description = $request->description;
        $amount = $request->amount;
        $limitOfUse = $request->limit_of_use;
        $expiryDate = $request->expiry_date;
        $status = $request->status;


        $crud = array(
            'coupon_code' => $couponCode,
            'type' => $type,
            'description' => $description,
            'amount' => $amount,
            'product_ids' => '',
            'limit_of_use' => $limitOfUse,
            'expiry_date' => $expiryDate,
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $where = array(
                'id'=> $id,
            );

        $update = $this->ObjCoupon->updateCoupon($where,$crud);

        if($update)
        {
            return redirect()->route('admin-coupon-list')->with('success', __('message_lang.COUPON_UPDATED_SUCCESSFULLY'));
        }
        else
        {
            return redirect()->back()->with('error', __('message_lang.FAILD_TO_UPDATE_COUPON'))->withInput();
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
