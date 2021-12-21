<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin, App\Product, App\Cart, App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Session;
use DB;
use Hash;

class UserController extends Controller
{
    /** user save postcode */
        public function user_save_postcode(Request $request)
        {
            $postcode = $request->postcode;
    
            session(["postcode" => $postcode]);
    
            $get_post_code = session('postcode');
    
            if(!empty($get_post_code) || $get_post_code != ''){
                return response()->json(['code' => '200']);
            }else{
                return response()->json(['code' => '201']);
            }
        }
    /** user save postcode */

    /** take away page */
        public function take_away(Request $request)
        {
            $cat_image_url = url('uploads/category/');
            $pd_image_url = url('uploads/product/');
    
            $data = \DB::select("SELECT cat.id, cat.cat_name, cat.cat_desc, CONCAT('".$cat_image_url."', '/', cat.cat_image) as cat_image
                                    FROM category as cat
                                    WHERE cat.status = 'Active' AND cat.is_deleted = 'N' AND cat.parent_cat_id = '0'
                                "); 
            
            if(!empty($data) && $data != null){
                foreach($data as $row){
                    $product = \DB::select("SELECT pd.id, pd.product_name, pd.product_price, pd.product_qty, pd.currency_id, pd.product_desc,
                                                CONCAT('".$pd_image_url."', '/', pd.product_image) as product_image,
                                                CASE 
                                                    WHEN DATE(pd.created_at) > (NOW() - INTERVAL 7 DAY) THEN '1'
                                                ELSE
                                                    '0'
                                                END as 'now'
                                            FROM product as pd
                                            WHERE pd.status = 'Active' AND pd.is_deleted = 'N' AND pd.cat_id = $row->id
                                            ORDER BY created_at DESC
                                        ");
                    
                    $row->product = $product;
                }
            }
            
            return view('front.views.take-away.take-away', compact('data'));
        }
    /** take away page */

        public function add_to_cart(Request $request)
        {
            if(!$request->ajax())
            {
                return response()->json(['FLASH_STATUS'=>'E', 'error'=>"Something went wrong."]);
            }
    
            // $validator = Validator::make($request->all(), [
            //     'product_id' => 'required'
            // ]);
    
            // if($validator->passes())
            {
                $product_id = $request->product_id;
    
                if($product_id == '') // returns all products from cart
                {
                    // var_dump(Auth::check());exit;
                    if(Auth::check()) // carts table
                    {
                        $carts_data = DB::table('carts')
                                ->where('user_id', Auth::user()->id)
                                ->select('carts.*')
                                ->get();
    
                        if(!$carts_data->isEmpty())
                        {
                            $cart_data = $carts_data->toArray();
                            $cart_data = array_map(function ($value) {
                                return (array)$value;
                            }, $cart_data);
                        }
                        else
                        {
                            $cart_data = array();
                        }
    
                        // _pre($cart_data);
    
                        $order_summary_html = view("front.views.take-away._order_summary", compact('cart_data'))->render();
    
                        return response()->json(['FLASH_STATUS'=>'S', 'success'=>"", 'order_summary_html'=>$order_summary_html]);
                    }
                    else // cookie
                    {
                        if(isset($_COOKIE["shopping_cart"]))
                        {
                            $cookie_data = stripslashes($_COOKIE['shopping_cart']);
                            $cart_data = json_decode($cookie_data, true);
                        }
                        else
                        {
                            $cart_data = array();
                        }
    
                        $cart_product_data = json_encode($cart_data);
                        setcookie('shopping_cart', $cart_product_data, time() + (86400 * 30));
    
                        $order_summary_html = view("front.views.take-away._order_summary", compact('cart_data'))->render();
    
                        return response()->json(['FLASH_STATUS'=>'S', 'success'=>"", 'order_summary_html'=>$order_summary_html]);
                    }
                }
                else // adds particular product and returns all products from cart
                {
                    $product = Product::where('id', '=', $product_id)->first();
                    if($product)
                    {
                        $id = $product->id;
                        $cat_id = $product->cat_id;
                        $product_name = $product->product_name;
                        $product_price = $product->product_price;
                        $product_qty = $product->product_qty;
                        $currency_id = $product->currency_id;
    
                        if(Auth::check()) // carts table
                        {
                            $cart_info = Cart::where('product_id', '=', $product_id)
                                ->where('product_id', '=', $product_id)
                                ->where('user_id', Auth::user()->id)
                                ->first();
    
                            if($cart_info) // update quantity
                            {
                                $product_qty = intval($cart_info->quantity) + 1;
    
                                $crud_data = array(
                                    'ip_address' => getUserIpAddress(),
                                    'product_id' => $product_id,
                                    'product_name' => $product_name,
                                    'quantity' => $product_qty,
                                    'product_price' => $product_price,
                                    'updated_at' => date('Y-m-d H:i:s'),
                                );
    
                                DB::table('carts')
                                    ->where('cart_id', $cart_info->cart_id)
                                    ->limit(1)
                                    ->update($crud_data);
                            }
                            else // add product
                            {
                                $crud_data = array(
                                    'user_id' => Auth::user()->id,
                                    'ip_address' => getUserIpAddress(),
                                    'product_id' => $product_id,
                                    'product_name' => $product_name,
                                    'quantity' => 1,
                                    'product_price' => $product_price,
                                    'created_at' => date('Y-m-d H:i:s'),
                                );
                                // _pre($crud_data);
                                DB::table('carts')->insert($crud_data);
                            }
    
                            $carts_data = DB::table('carts')
                                    ->where('user_id', Auth::user()->id)
                                    ->select('carts.*')
                                    ->get();
    
                            if(!$carts_data->isEmpty())
                            {
                                $cart_data = $carts_data->toArray();
                                $cart_data = array_map(function ($value) {
                                    return (array)$value;
                                }, $cart_data);
                            }
                            else
                            {
                                $cart_data = array();
                            }
    
                            $order_summary_html = view("front.views.take-away._order_summary", compact('cart_data'))->render();
    
                            return response()->json(['FLASH_STATUS'=>'S', 'success'=>"Product added successfully.", 'order_summary_html'=>$order_summary_html]);
                        }
                        else // cookie
                        {
                            if(isset($_COOKIE["shopping_cart"]))
                            {
                                $cookie_data = stripslashes($_COOKIE['shopping_cart']);
                                $cart_data = json_decode($cookie_data, true);
                            }
                            else
                            {
                                $cart_data = array();
                            }
    
                            $cart_product_id_list = array_column($cart_data, 'product_id');
    
                            if(in_array($product_id, $cart_product_id_list))
                            {
                                foreach($cart_data as $keys => $values)
                                {
                                    if($cart_data[$keys]["product_id"] == $product_id)
                                    {
                                        $cart_data[$keys]["quantity"] = $cart_data[$keys]["quantity"] + 1;
                                    }
                                }
                            }
                            else
                            {
                                $cart_product_array = array(
                                    'product_id' => $product_id,
                                    'product_name' => $product_name,
                                    'product_price' => $product_price,
                                    'quantity' => 1
                                );
                                $cart_data[] = $cart_product_array;
                            }
                            
                            $cart_product_data = json_encode($cart_data);
                            setcookie('shopping_cart', $cart_product_data, time() + (86400 * 30));
    
                            $order_summary_html = view("front.views.take-away._order_summary", compact('cart_data'))->render();
    
                            return response()->json(['FLASH_STATUS'=>'S', 'success'=>"Product added successfully.", 'order_summary_html'=>$order_summary_html]);
                        }
                    }
                    else
                    {
                        return response()->json(['FLASH_STATUS'=>'E', 'error'=>"Product not found."]);
                    }
                }
    
            }
    
            // $error_message = "";
            // if(!empty($validator->errors()->all()))
            // {
            //     $error_message = implode("<br>", $validator->errors()->all());
            // }
            // return response()->json(['FLASH_STATUS'=>'E', 'error'=>$error_message]);
        }

        public function account_dashboard(Request $request)
        {
            return view('front.views.account-dashboard');
        }

        public function account_orders(Request $request)
        {
            return view('front.views.account-orders');
        }

        public function account_vouchers(Request $request)
        {
            return view('front.views.account-vouchers');
        }

        public function account_addresses(Request $request)
        {
            return view('front.views.account-addresses');
        }

        public function account_account(Request $request)
        {
            $user = DB::table('users')->where('id', Auth::user()->id)->first();
            return view('front.views.account-account', compact('user'));
        }

    public function account_billing_addresses(Request $request)
    {
        return view('front.views.account-billing-addresses');
    }

    public function account_addresses_create(Request $request)
    {
        $user_delivery_addresses_info = DB::table('user_delivery_addresses')->where('user_id', Auth::user()->id)->first();
        $user_billing_addresses_info = DB::table('user_billing_addresses')->where('user_id', Auth::user()->id)->first();
        return view('front.views.account-addresses-create', compact('user_delivery_addresses_info', 'user_billing_addresses_info'));
    }

    public function add_delivery_address(Request $request)
    {
        return view('front.views.crud-delivery-address');
    }

    public function add_delivery_address_post(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'company_name' => 'required',
            'telephone' => 'required',
            'house' => 'required',
            'street' => 'required',
            'estate' => 'required',
            'county' => 'required',
            'postcode' => 'required',
        ]);
        
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $company_name = $request->company_name;
        $telephone = $request->telephone;
        $house = $request->house;
        $street = $request->street;
        $estate = $request->estate;
        $county = $request->county;
        $postcode = $request->postcode;

        $crud_data = array(
            'user_id' => Auth::user()->id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => Auth::user()->email,
            'company_name' => $company_name,
            'telephone' => $telephone,
            'house' => $house,
            'street' => $street,
            'estate' => $estate,
            'county' => $county,
            'postcode' => $postcode,
            'created_at' => date('Y-m-d H:i:s'),
        );

        DB::table('user_delivery_addresses')->insert($crud_data);

        return redirect(route('account-addresses-create'))->with('success', __('Delivery address added successfully.'));
    }

    public function edit_delivery_address(Request $request)
    {
        $user_delivery_addresses_info = DB::table('user_delivery_addresses')->where('user_id', Auth::user()->id)->first();
        if(!$user_delivery_addresses_info)
        {
            return redirect(route('account-addresses-create'));
        }
        return view('front.views.crud-delivery-address', compact('user_delivery_addresses_info'));
    }

    public function edit_delivery_address_post(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'company_name' => 'required',
            'telephone' => 'required',
            'house' => 'required',
            'street' => 'required',
            'estate' => 'required',
            'county' => 'required',
            'postcode' => 'required',
        ]);
        
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $company_name = $request->company_name;
        $telephone = $request->telephone;
        $house = $request->house;
        $street = $request->street;
        $estate = $request->estate;
        $county = $request->county;
        $postcode = $request->postcode;

        $crud_data = array(
            'user_id' => Auth::user()->id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => Auth::user()->email,
            'company_name' => $company_name,
            'telephone' => $telephone,
            'house' => $house,
            'street' => $street,
            'estate' => $estate,
            'county' => $county,
            'postcode' => $postcode,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        DB::table('user_delivery_addresses')->where('user_id', Auth::user()->id)->limit(1)->update($crud_data);

        return redirect(route('account-addresses-create'))->with('success', __('Delivery address updated successfully.'));
    }

    public function add_billing_address(Request $request)
    {
        return view('front.views.crud-billing-address');
    }

    public function add_billing_address_post(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'company_name' => 'required',
            'telephone' => 'required',
            'house' => 'required',
            'street' => 'required',
            'estate' => 'required',
            'county' => 'required',
            'postcode' => 'required',
        ]);
        
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $company_name = $request->company_name;
        $telephone = $request->telephone;
        $house = $request->house;
        $street = $request->street;
        $estate = $request->estate;
        $county = $request->county;
        $postcode = $request->postcode;

        $crud_data = array(
            'user_id' => Auth::user()->id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => Auth::user()->email,
            'company_name' => $company_name,
            'telephone' => $telephone,
            'house' => $house,
            'street' => $street,
            'estate' => $estate,
            'county' => $county,
            'postcode' => $postcode,
            'created_at' => date('Y-m-d H:i:s'),
        );

        DB::table('user_billing_addresses')->insert($crud_data);

        return redirect(route('account-addresses-create'))->with('success', __('Billing address added successfully.'));
    }

    public function edit_billing_address(Request $request)
    {
        $user_billing_addresses_info = DB::table('user_billing_addresses')->where('user_id', Auth::user()->id)->first();
        if(!$user_billing_addresses_info)
        {
            return redirect(route('account-addresses-create'));
        }
        return view('front.views.crud-billing-address', compact('user_billing_addresses_info'));
    }

    public function edit_billing_address_post(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'company_name' => 'required',
            'telephone' => 'required',
            'house' => 'required',
            'street' => 'required',
            'estate' => 'required',
            'county' => 'required',
            'postcode' => 'required',
        ]);
        
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $company_name = $request->company_name;
        $telephone = $request->telephone;
        $house = $request->house;
        $street = $request->street;
        $estate = $request->estate;
        $county = $request->county;
        $postcode = $request->postcode;

        $crud_data = array(
            'user_id' => Auth::user()->id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => Auth::user()->email,
            'company_name' => $company_name,
            'telephone' => $telephone,
            'house' => $house,
            'street' => $street,
            'estate' => $estate,
            'county' => $county,
            'postcode' => $postcode,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        DB::table('user_billing_addresses')->where('user_id', Auth::user()->id)->limit(1)->update($crud_data);

        return redirect(route('account-addresses-create'))->with('success', __('Billing address updated successfully.'));
    }

    public function my_account_post(Request $request)
    {
        // _pre($request->all());
        
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
        );

        if($request->current_password != "")
        {
            $rules['current_password'] = 'required';
            $rules['password'] = 'required|min:7';
            $rules['password_confirmation'] = 'required|same:password';
        }

        $this->validate($request, $rules);

        $crud_data = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
        );

        if($request->password != "")
        {
            $user_info = User::where('id', '=', Auth::user()->id)->first();

            $current_password_db = $user_info->password;

            $current_password = $request->current_password;

            if(!Hash::check($current_password, $current_password_db))
            {
                return redirect(route('account-account'))->with('error', __('Your current password does not match. Please enter correct one.'));
            }

            $password = $request->password;

            if(Hash::check($password, $current_password_db))
            {
               return redirect(route('account-account'))->with('error', __('Your new password is same as your current password.'));
            }

            $crud_data['password'] = Hash::make($request->password);

            $result = DB::table('users')->where('id', Auth::user()->id)->update($crud_data);

            if($result)
            {
                return redirect(route('account-account'))->with('success', __('Congratulation!! Your password changed successfully.'));
            }
            else
            {
                return redirect(route('account-account'))->with('error', __('Oops, something went wrong.<br>Looks like we\'re a little hung up. <br>We\'re working on it - check back soon!<br>[Error Code:2002]'));
            }
        }

        DB::table('users')->where('id', Auth::user()->id)->limit(1)->update($crud_data);

        return redirect(route('account-account'));
    }
    
}