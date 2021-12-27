<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\UserCategory;
use App\Models\Product;
use App\Models\Allergy;
use Illuminate\Http\Request;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends ApiController
{
    public $statusCode;
    public $status;
    public $message;
    public function __construct()
    {
        $this->status = TRUE;
        $this->statusCode = Response::HTTP_OK;
        $this->message = '';
        $this->objCategory = new Category();
        $this->objUserCategory = new UserCategory();
        $this->objProduct = new Product();
        $this->objAllergy = new Allergy();
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function getUserSelectedCategoriesProducts(){
        $responseData= array();
        try {
            $userId = $this->user->id;
            $responseCategories = $this->objUserCategory->getUserSelectedCategories($userId);
            if($responseCategories){
                foreach($responseCategories as $key => $categoryInfo)
                {
                    $responseCategories[$key]->slug = _generateSeoURL($categoryInfo->name);
                    $responseProducts = $this->objProduct->getProductData($categoryInfo->category_id, $userId);

                    if($responseProducts){
                        foreach ($responseProducts as $productKey => $productInfo)
                        {
                            $responseProducts[$productKey]->product_price = _number_format($productInfo->product_price);
                            $responseProducts[$productKey]->product_topa = _number_format($productInfo->product_topa);
                            $responseProducts[$productKey]->product_1r = _number_format($productInfo->product_1r);
                            $responseProducts[$productKey]->product_12r = _number_format($productInfo->product_12r);
                            $responseAllergies = $this->objAllergy->getProductAllergies($productInfo->product_id);
                            $allergyIdArray = array();
                            if($responseAllergies){
                                foreach ($responseAllergies as $allergyKey => $allergyInfo){
                                    array_push($allergyIdArray, (string)$allergyInfo->allergy_id);
                                }
                            }
                            $responseProducts[$productKey]->responseAllergies = $responseAllergies;
                            $responseProducts[$productKey]->allergyIdArray = $allergyIdArray;
                        }
                    }

                    $responseCategories[$key]->responseProducts = $responseProducts;
                }
                // _pre($responseCategories);
                $responseData['products'] = $responseCategories;
            }else{
                $this->status = false;
                $this->message = __('api.common_empty',['module' => __('api.module_product')]);
            }
            return response()->json([
                'status' => $this->status,
                'message' => $this->message,
                'data' => $responseData
            ], $this->statusCode);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => __('api.common_error_500'),
            ], 500);
        }
    }

    public function store(Request $request){
        // _pre($request->all());
        $data = $request->only('categoryId', 'productName', 'productDescription', 'productTopa', 'product1r', 'product12r', 'productPrice', 'allergyId', 'status');
        $validator = Validator::make($data, [
            'categoryId' => 'required',
            'productName' => 'required',
            'productDescription' => 'required',
            'productTopa' => 'required',
            'product1r' => 'required',
            'product12r' => 'required',
            'productPrice' => 'required',
            'allergyId' => [
                'required','array',function ($attribute, $value, $fail){
                    $value = array_filter($value);
                    if(empty($value)){
                        $fail($attribute. ' is required.');
                    }
                },
            ],
            'status' => 'required',
        ]);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            $this->status = false;
            $this->statusCode = Response::HTTP_BAD_REQUEST;
            $this->message = _lvValidations($validator->messages()->get('*'));
            $responseData = array('status'=>$this->status,'message'=>$this->message,'statusCode'=>$this->statusCode,'data'=>array());
            return response()->json($responseData,$this->statusCode);
        }
        $userId = $this->user->id;
        //Request is valid, create new category
        $categoryId = trim($request->categoryId);
        $productName = trim($request->productName);
        $productDescription = trim($request->productDescription);
        $productTopa = trim($request->productTopa);
        $product1r = trim($request->product1r);
        $product12r = trim($request->product12r);
        $productPrice = trim($request->productPrice);
        $allergyId = ($request->allergyId);
        $status = trim($request->status);
        $currentDateTime = getCurrentDateTime();

        $crudData = array(
            'category_id' => $categoryId,
            'user_id' => $userId,
            'product_type' => NULL,
            'product_name' => $productName,
            'product_description' => $productDescription,
            'product_main_image' => NULL,
            'product_price' => $productPrice,
            'product_topa' => $productTopa,
            'product_1r' => $product1r,
            'product_12r' => $product12r,
            'product_multiple_image' => NULL,
            'product_order' => NULL,
            'status' => $status,
            'created_at' => $currentDateTime,
        );
        $createdID = $this->objProduct->createRecord($crudData);
        if($createdID){
            $crudData = array( 'product_order' => $createdID, 'updated_at' => $userId );
            $where = array('product_id' => $createdID);
            $responseUpdate = $this->objProduct->updateRecord($crudData,$where);
            if($responseUpdate){
                $insertRecords = array();
                for($i=0; $i < count($allergyId); $i++){
                    $insertRecords[] = array(
                        'product_id' => $createdID,
                        'allergy_id' => $allergyId[$i],
                        'created_at' => $currentDateTime
                    );
                }
                $responseBulkInsert = $this->objProduct->createBulkRecord($insertRecords);
                if($responseBulkInsert){
                }else{
                }
            }else{
            }
            $this->message = __('api.common_add',['module'=>__('api.module_product')]);
        }else{
            //$this->statusCode = http_response_code(500);
            $this->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $this->status = false;
            $this->message = __('api.common_add_error',['module'=> __('api.module_product')]);
        }

        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
            //'data' => $category
        ], Response::HTTP_OK);
    }
    public function update(Product $product,Request $request){
        // _pre($product);
        // _pre($request->all());
        // exit;
        // _pre($product->user_id);
        if($product){
            $userId = $this->user->id;
            if($product->user_id == $userId){
                $data = $request->only('categoryId', 'productName', 'productDescription', 'productTopa', 'product1r', 'product12r', 'productPrice', 'allergyId', 'status');
                $validator = Validator::make($data, [
                    'categoryId' => 'required',
                    'productName' => 'required',
                    'productDescription' => 'required',
                    'productTopa' => 'required',
                    'product1r' => 'required',
                    'product12r' => 'required',
                    'productPrice' => 'required',
                    'allergyId' => [
                        'required','array',function ($attribute, $value, $fail){
                            $value = array_filter($value);
                            if(empty($value)){
                                $fail($attribute. ' is required.');
                            }
                        },
                    ],
                    'status' => 'required',
                ]);
                //Send failed response if request is not valid
                if ($validator->fails()) {
                    $this->status = false;
                    $this->statusCode = Response::HTTP_BAD_REQUEST;
                    $this->message = _lvValidations($validator->messages()->get('*'));
                    $responseData = array('status'=>$this->status,'message'=>$this->message,'statusCode'=>$this->statusCode,'data'=>array());
                    return response()->json($responseData,$this->statusCode);
                }
                //Request is valid, create new category
                $categoryId = trim($request->categoryId);
                $productName = trim($request->productName);
                $productDescription = trim($request->productDescription);
                $productTopa = trim($request->productTopa);
                $product1r = trim($request->product1r);
                $product12r = trim($request->product12r);
                $productPrice = trim($request->productPrice);
                $allergyId = ($request->allergyId);
                $status = trim($request->status);
                $currentDateTime = getCurrentDateTime();
                $crudData = array(
                    'category_id' => $categoryId,
                    'user_id' => $userId,
                    'product_type' => NULL,
                    'product_name' => $productName,
                    'product_description' => $productDescription,
                    'product_main_image' => NULL,
                    'product_price' => $productPrice,
                    'product_topa' => $productTopa,
                    'product_1r' => $product1r,
                    'product_12r' => $product12r,
                    'product_multiple_image' => NULL,
                    'product_order' => NULL,
                    'status' => $status,
                    'updated_at' => $currentDateTime,
                );
                $where = array('product_id' => $product->product_id);
                $responseUpdate = $this->objProduct->updateRecord($crudData,$where);
                if($responseUpdate){
                    $currAllergyIdArr = $this->objProduct->getProductAllergyIds($product->product_id);
                    $newAllergyIdArr = array_map('intval', $allergyId);
                    $needDeleteArr = array_diff($currAllergyIdArr,$newAllergyIdArr);
                    $needInsertArr = array_diff($newAllergyIdArr,$currAllergyIdArr);
                    if(!empty($needDeleteArr)){
                        $needDeleteArr = array_values($needDeleteArr);
                        $this->objProduct->deleteProductAllergy($product->product_id, $needDeleteArr); // Delete
                    }
                    if(!empty($needInsertArr)){
                        $needInsertArr = array_values($needInsertArr);
                        $insertRecords = array();
                        for($i=0; $i < count($needInsertArr); $i++){
                            $insertRecords[] = array(
                                'product_id' => $product->product_id,
                                'allergy_id' => $needInsertArr[$i],
                                'created_at' => $currentDateTime
                            );
                        }
                        $responseBulkInsert = $this->objProduct->createBulkRecord($insertRecords); // Insert
                        if($responseBulkInsert){
                        }else{
                        }
                    }
                    $this->message = __('api.common_update',['module'=> __('api.module_product')]);
                }else{
                    $this->status = false;
                    $this->message = __('api.common_update_error',['module'=> __('api.module_product')]);
                }
            }else{
                $this->status = false;
                $this->message = __('api.common_error_access_denied');
            }
        }else{
            #$this->statusCode = Response::HTTP_NOT_FOUND;
            $this->status = false;
            $this->message = __('api.common_not_found',['module'=> __('api.module_product')]);
        }
        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
        ], $this->statusCode);
    }
    public function destroy(Product $product)
    {
        if($product){
            $userId = $this->user->id;
            if($product->user_id == $userId){
                $responseDelete = $product->delete();
                $this->objProduct->deleteRecordByProductId($product->product_id);
                $this->message = __('api.common_delete',['module'=> __('api.module_product')]);
            }else{
                $this->status = false;
                $this->message = __('api.common_error_access_denied');
            }
        }else{
            #$this->statusCode = Response::HTTP_NOT_FOUND;
            $this->status = false;
            $this->message = __('api.common_not_found',['module'=> __('api.module_product')]);
        }
        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
            //'data' => $category
        ], $this->statusCode);
        //$product->delete();

        /*return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ], Response::HTTP_OK);*/
    }
}
