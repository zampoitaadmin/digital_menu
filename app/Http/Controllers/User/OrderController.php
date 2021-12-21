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
    
    class OrderController extends Controller{
        
        /** get-order-user-id */
            public function get_order_user_id(Request $request){
                $user_id = _cart_user_id();
                
                if($user_id != null && $user_id != ''){
                    return response()->json(['code' => 200, 'data' => $user_id]);
                }else{
                    return response()->json(['code' => 201]);
                }
            }
        /** get-order-user-id */
        
        /** total-order-meal */
            public function total_order_meal(Request $request){
                
                $meals_per_day = $request->meals_per_day ?? '';
                $days_per_week = $request->days_per_week ?? '';
                $weeks_per_month = $request->weeks_per_month ?? '';
                $selected_donation = $request->selected_donation ?? 'FALSE';
                $donation_amount = $request->donation_amount ?? '';
                $vip_selected = $request->vip_selected ?? 'FALSE';
                $packet_number = $request->packet_number ?? '';
                $other_info = $request->other_info ?? '';
                $total_amount_sides = $request->total_amount_sides ?? '';
                $total_amount_sides_qty = $request->total_amount_sides_qty ?? '';
                $preference_category = $request->preference_category ?? '';
                $primary_category = $request->primary_category ?? '';
                $allergy_category = isset($request->allergy_category) ? implode(',', $request->allergy_category) : '';
               
                $crud = [
                            'meals_per_day' => $meals_per_day,
                            'days_per_week' => $days_per_week,
                            'weeks_per_month' => $weeks_per_month,
                            'selected_donation' => $selected_donation,
                            'donation_amount' => $donation_amount,
                            'vip_selected' => $vip_selected,
                            'packet_number' => $packet_number,
                            'other_info' => $other_info,
                            'total_amount_sides' => $total_amount_sides,
                            'total_amount_sides_qty' => $total_amount_sides_qty,
                            'preference_category' => $preference_category,
                            'primary_category' => $primary_category,
                            'allergy_category' => $allergy_category
                        ];
                        
                $user = Auth::user();
                if($user)
                    $user_id = $user->id;
                else
                    $user_id = _generate_bespoke_me_cart_id();

                $exst_rec = \DB::table('total-meal-order')->select('id')->where(['user_id' => $user_id])->first();

                if($exst_rec){
                    \DB::table('total-meal-order')->where(['id' => $exst_rec->id])->update($crud);   
                }else{
                    $crud['user_id'] = $user_id;
                    \DB::table('total-meal-order')->insertGetId($crud);
                }
            }
        /** total-order-meal */
        
        /** get-bespoke-me-ajax */
            public function get_bespoke_me_ajax(Request $request){
            
                $user_id = _get_bespoke_me_cart_id();
            
                $action = $request->action;
                $category_id = $request->category;
                $tag = $request->tag;
                $goal = $request->goal;
                $package_identity = $request->package_identity;
                
                $whereCategoryId = '';
                $category = \DB::table('category')->select('id')->where('slug', $category_id)->first();
                if($category){
                    $whereCategoryId = "WHERE find_in_set(".$category->id.", pd.category_ids) <> 0 ";
                }
                
                if($tag[0] == 'allergyNone'){
                    $whereAllergyIds = '';
                }elseif($tag == null){
                    $whereAllergyIds = '';
                }else{
                    $whereAllergyIds = '';
                    
                    foreach($tag as $ac){
                        $tag = \DB::table('tags')->select('id')->where('slug', $ac)->first();
                        
                        if($tag){
                            $whereAllergyIds .= $tag->id.', ';
                        }
                    }
                    $whereAllergyIds = rtrim($whereAllergyIds, ', ');
                    $whereAllergyIds = " AND pd.tags IN($whereAllergyIds)";
                }
                                
                $product_url = url('uploads/product');

                $products = \DB::select("SELECT pd.id, pd.category_ids, pd.name, pd.price, pd.quantity, pd.currency_id, pd.description,
                                            pd.tags,
                                            CONCAT(".'"'.$product_url.'"'.", '/', ".'pd.image'.") as image
                                        FROM product AS pd
                                        $whereCategoryId
                                        $whereAllergyIds
                                        AND pd.is_deleted = 'N' AND status = 'Active'
                                        ");
                
                foreach($products as $row){
                    $cart_data = \DB::table('cart')->select('quantity')->where(['user_id' => $user_id, 'product_id' => $row->id])->first();
                    
                    if($cart_data){
                        if($cart_data->quantity > 0){
                            $row->count = $cart_data->quantity;
                        }else{
                            $row->count = 0;
                        }
                    }else{
                        $row->count = 0;
                    }
                }
                
                echo view('front.views.subview.products', compact('products'));
            }
        /** get-bespoke-me-ajax */
        
        /** get-bespoke-me-sides-ajax */
            public function get_bespoke_me_sides_ajax(Request $request){
               
                $sides_id = _get_sides_category_id();
                                
                if($sides_id != false){
                    
                    $user_id = _get_bespoke_me_cart_id();
                                    
                    $product_url = url('uploads/product');
    
                    $products = \DB::select("SELECT pd.id, pd.category_ids, pd.name, pd.price, pd.quantity, pd.currency_id, pd.description,
                                                pd.tags,
                                                CONCAT(".'"'.$product_url.'"'.", '/', ".'pd.image'.") as image
                                            FROM product AS pd
                                            WHERE find_in_set(".$sides_id.", pd.category_ids) <> 0 
                                            AND pd.is_deleted = 'N' AND status = 'Active'
                                            ");
                    
                    foreach($products as $row){
                        $cart_data = \DB::table('cart')->select('quantity')->where(['user_id' => $user_id, 'product_id' => $row->id])->first();
                        
                        if($cart_data){
                            if($cart_data->quantity > 0){
                                $row->count = $cart_data->quantity;
                            }else{
                                $row->count = 0;
                            }
                        }else{
                            $row->count = 0;
                        }
                    }
                    
                    echo view('front.views.subview.products_sides', compact('products'));
                }else{
                    echo view('front.views.subview.products_sides');
                }
            }
        /** get-bespoke-me-sides-ajax */
        
        /** get-your-section */
            public function get_your_section(Request $request){
                $data = _cart_data();
                return json_encode($data);
            }
        /** get-your-section */
        
        /** get-your-section-sides */
            public function get_your_section_sides(Request $request){
                $data = _cart_data(true);
                return json_encode($data);
            }
        /** get-your-section-sides */
        
        /** update-meal-picker */
            public function update_meal_picker(Request $request){

                $is_side = $request->is_side ?? false;
                $product_id = $request->product_id;
                $quantity = $request->quantity;
                $type = $request->type;
                $total_meals_choice = _get_bespoke_me_total_meal();
                
                $total_quantity = $quantity + _get_total_cart_products_sum($product_id);
                
                if($is_side == false){
                    if($total_quantity > $total_meals_choice){
                        return json_encode(['status' => 0, 'message' => 'You can\'t exceed your meal limit.']);
                    }
                }
                
                if($type === 'add'){
                    $user = Auth::user();
                    
                    if(!empty($user)){
                        $user_id = $user->id;
                    }else{
                        $user_id = _generate_bespoke_me_cart_id();
                    }
                                    
                    $product = _cart_data_by_product($user_id, $product_id);
                    
                    if($product == false){
                        $change_data = _add_cart_data($user_id, $product_id, $quantity);
                    }else{
                        $change_data = _update_cart_data($user_id, $product_id, $quantity);
                    }
                    
                    if($change_data == true){
                        return json_encode($change_data);
                    }else{
                        return json_encode(['status' => 0]);
                    }
                }elseif($type === 'remove'){
                    $user = Auth::user();
                    
                    if(!empty($user)){
                        $user_id = $user->id;
                    }else{
                        $user_id = _generate_bespoke_me_cart_id();
                    }
                                    
                    $product = _cart_data_by_product($user_id, $product_id);
                    
                    if($product == false){
                        return json_encode(['status' => 0]);
                    }else{
                        $change_data = _update_cart_data($user_id, $product_id, $quantity);
                    }
                    
                    if($change_data == true){
                        return json_encode($change_data);
                    }else{
                        return json_encode(['status' => 0]);
                    }
                }elseif($type === 'input'){
                    $user = Auth::user();
                    
                    if(!empty($user)){
                        $user_id = $user->id;
                    }else{
                        $user_id = _generate_bespoke_me_cart_id();
                    }
                                    
                    $product = _cart_data_by_product($user_id, $product_id);
                    
                    if($product == false){
                        $change_data = _add_cart_data($user_id, $product_id, $quantity);
                    }else{
                        $change_data = _update_cart_data($user_id, $product_id, $quantity);
                    }
                    
                    if($change_data == true){
                        return json_encode($change_data);
                    }else{
                        return json_encode(['status' => 0]);
                    }
                }                
            }
        /** update-meal-picker */
        
        /** open-macro */
            public function open_macro(Request $request){
                $id = $request->product_id;
                
                $product_url = url('uploads/product');
                $data = DB::table('product as pd')
                                ->select('pd.id', 'pd.name', 'pd.price', 'pd.quantity', 'pd.description', 'pd.status', 
                                            'pd.tags', 'pd.category_ids',
                                            \DB::Raw("CONCAT(".'"'.$product_url.'"'.", '/', ".'pd.image'.") as image"),
                                        )
                                ->where(['pd.id' => $id])
                                ->first();
                                
                echo view('front.views.subview.macro', compact('data'));
            }
        /** open-macro */
        
        /** set-bespoke-me-total-meal */
            public function set_bespoke_me_total_meal(Request $request){
                _set_bespoke_me_total_meal($request->total);
                
                $check = _get_bespoke_me_total_meal();
                if($check != ''){
                    return true;
                }else{
                    return false;
                }
            }
        /** set-bespoke-me-total-meal */
        
        /** clear-cart */
            public function clear_cart(){
                $clear = _clear_cart();
                
                if($clear == true)
                    return true;
                else
                    return true;            
            }
        /** clear-cart */
    }