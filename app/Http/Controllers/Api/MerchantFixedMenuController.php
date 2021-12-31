<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\UserCategory;
use App\Models\Product;
use App\Models\MerchantFixedMenuData;
use App\Models\Allergy;
use Illuminate\Http\Request;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class MerchantFixedMenuController extends ApiController
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
        $this->objMerchantFixedMenuData = new MerchantFixedMenuData();
        $this->objAllergy = new Allergy();
        $this->user = JWTAuth::parseToken()->authenticate();
        $this->productMainImagePath = public_path('uploads/product/');
    }

    public function getMerchantFixedMenu(Category $category){
        $responseData= array();
        try {
            if($category){
                $userId = $this->user->id;

                $categoryInfo = $category->toArray();
                $categoryId = $categoryInfo['id'];
                $userCategoryInfo = $this->objUserCategory->getUserCategoryByCategoryIdUserId($userId,$categoryId);
                $fixedMenuInfo = $this->objMerchantFixedMenuData->getFixedMenuByCategoryIdUserId($userId,$categoryId);
                $starterProductData = $this->objProduct->getProductByProductType($userId,$categoryId,'starter');
                if(!$starterProductData->isEmpty()){
                    foreach ($starterProductData as $key => $value) {
                        $productId = $value->product_id;
                        $productAllergies = $this->objProduct->getProductAllergies($productId);
                        $allergyIdArr = $this->objProduct->getProductAllergyIds($productId);
                        $starterProductData[$key]->productAllergies = $productAllergies;
                        $starterProductData[$key]->allergyIdArr = $allergyIdArr;
                    }
                }
                $courseProductData = $this->objProduct->getProductByProductType($userId,$categoryId,'course');
                if(!$courseProductData->isEmpty()){
                    foreach ($courseProductData as $key => $value) {
                        $productId = $value->product_id;
                        $productAllergies = $this->objProduct->getProductAllergies($productId);
                        $allergyIdArr = $this->objProduct->getProductAllergyIds($productId);
                        $courseProductData[$key]->productAllergies = $productAllergies;
                        $courseProductData[$key]->allergyIdArr = $allergyIdArr;
                    }
                }
                $desertProductData = $this->objProduct->getProductByProductType($userId,$categoryId,'desert');
                if(!$desertProductData->isEmpty()){
                    foreach ($desertProductData as $key => $value) {
                        $productId = $value->product_id;
                        $productAllergies = $this->objProduct->getProductAllergies($productId);
                        $allergyIdArr = $this->objProduct->getProductAllergyIds($productId);
                        $desertProductData[$key]->productAllergies = $productAllergies;
                        $desertProductData[$key]->allergyIdArr = $allergyIdArr;
                    }
                }

                $responseData = array(
                    'categoryInfo' => $categoryInfo,
                    'userCategoryInfo' => $userCategoryInfo,
                    'fixedMenuInfo' => $fixedMenuInfo,
                    'starterProductData' => $starterProductData,
                    'courseProductData' => $courseProductData,
                    'desertProductData' => $desertProductData,
                );

                return response()->json([
                    'status' => $this->status,
                    'message' => $this->message,
                    'data' => $responseData
                ], $this->statusCode);
            }
            else{
                $this->status = false;
                $this->message = __('api.common_not_found',['module'=> __('api.module_product')]);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => __('api.common_error_500'),
            ], 500);
        }
    }

    public function store(Request $request){
        //_pre($request->all());
        $data = $request->only('changeCategoryName', 'menuDescriptionConditions', 'fixedMenuPrice', 'starterData');
        $validator = Validator::make($data, [
            'menuDescriptionConditions' => 'required',
            'fixedMenuPrice' => 'required',
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
        $categoryId = trim($request->categoryId);
        $categoryName = trim($request->categoryName);
        $changeCategoryName = trim($request->changeCategoryName);
        $menuDescriptionConditions = trim($request->menuDescriptionConditions);
        $fixedMenuPrice = trim($request->fixedMenuPrice);
        $starterData = ($request->starterData);
        $currentDateTime = getCurrentDateTime();

        $crudData = array(
        	'user_id' => $userId,
        	'category_id' => $categoryId,
        	'price' => $fixedMenuPrice,
        	'menu_description_conditions' => $menuDescriptionConditions,
        	'created_at' => $currentDateTime
        );
        $createdID = $this->objMerchantFixedMenuData->createRecord($crudData);
        if($createdID){
			if(!empty($changeCategoryName)){
				$crudData = array(
					'change_category_name' => $changeCategoryName,
					'updated_at' => $currentDateTime
				);
				$where = array( 'user_id' => $userId, 'category_id' => $categoryId );
				$this->objUserCategory->updateRecord($crudData,$where);
			}
			if(!empty($starterData)){
				foreach ($starterData as $starterDataKey => $starterInfo) {
					$allergyId = $starterInfo['allergyId'];
					$productDescription = trim($starterInfo['productDescription']);
					$productName = trim($starterInfo['productName']);
					$starterProductMainImage = $starterInfo['starterProductMainImage'];
					$crudData = array(
						'category_id' => $categoryId,
						'user_id' => $userId,
						'product_type' => 'starter',
						'product_name' => $productName,
						'product_description' => $productDescription,
						'status' => 'Active',
						'created_at' => $currentDateTime,
					);
					$createdID = $this->objProduct->createRecord($crudData);
					if($createdID){
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
					}
				}
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
            'createdID' => $createdID
            //'data' => $category
        ], Response::HTTP_OK);
    }

    public function update(MerchantFixedMenuData $merchantFixedMenuData,Request $request){
        _pre($merchantFixedMenuData,0);
        _pre($request->all());
        // exit;
        // _pre($product->user_id);
        if($merchantFixedMenuData){
            $userId = $this->user->id;
            if($merchantFixedMenuData->user_id == $userId){
                $data = $request->only('changeCategoryName', 'menuDescriptionConditions', 'fixedMenuPrice', 'starterData');
                $validator = Validator::make($data, [
                    'menuDescriptionConditions' => 'required',
                    'fixedMenuPrice' => 'required',
                ]);
                //Send failed response if request is not valid
                if ($validator->fails()) {
                    $this->status = false;
                    $this->statusCode = Response::HTTP_BAD_REQUEST;
                    $this->message = _lvValidations($validator->messages()->get('*'));
                    $responseData = array('status'=>$this->status,'message'=>$this->message,'statusCode'=>$this->statusCode,'data'=>array());
                    return response()->json($responseData,$this->statusCode);
                }
                $categoryId = trim($request->categoryId);
                $categoryName = trim($request->categoryName);
                $changeCategoryName = trim($request->changeCategoryName);
                $menuDescriptionConditions = trim($request->menuDescriptionConditions);
                $fixedMenuPrice = trim($request->fixedMenuPrice);
                $starterData = ($request->starterData);
                $currentDateTime = getCurrentDateTime();
                $crudData = array(
                    'user_id' => $userId,
                    'category_id' => $categoryId,
                    'price' => $fixedMenuPrice,
                    'menu_description_conditions' => $menuDescriptionConditions,
                    'updated_at' => $currentDateTime
                );
                $where = array('id' => $merchantFixedMenuData->id);
                /* Update MerchantFixedMenuData */
                $responseUpdate = $this->objMerchantFixedMenuData->updateRecord($crudData,$where);
                if($responseUpdate){

                    /* Get Current Starter Products */
                    $starterProductData = $this->objProduct->getProductByProductType($userId,$categoryId,'starter');
                    if(!$starterProductData->isEmpty()){
                        foreach ($starterProductData as $key => $value) {
                            array_push($currStarterProductIdArr, (int)$value->product_id);
                        }
                    }
                    else{
                        $currStarterProductIdArr = array();
                    }

                    /* Get New Starter Products */
                    if(!empty($starterData)){
                        foreach ($starterData as $key => $value) {
                            array_push($newStarterProductIdArr, (int)$value["productId"]);
                        }
                    }
                    else{
                        $newStarterProductIdArr = array();
                    }

                    $needDeleteArr = array_diff($currStarterProductIdArr,$newStarterProductIdArr);
                    $needUpdateArr = array_intersect($currStarterProductIdArr,$newStarterProductIdArr);

                    /* Starter Delete (Exist in Current But Not in New) */
                    if(!empty($needDeleteArr)){
                        $needDeleteArr = array_values(array_filter($needDeleteArr));
                        $this->objProduct->deleteProduct($categoryId, $userId, $needDeleteArr); // Delete
                        $this->objProduct->deleteProductAllergyByProductId($needDeleteArr); // Delete
                    }

                    /* Starter Insert (Not in Current But Exist in New) */
                    if(!empty($starterData)){
                        foreach ($starterData as $starterDataKey => $starterInfo) {
                            $productId = $starterInfo['productId'];
                            if(empty($productId)){
                                $allergyId = $starterInfo['allergyId'];
                                $productDescription = trim($starterInfo['productDescription']);
                                $productName = trim($starterInfo['productName']);
                                $starterProductMainImage = $starterInfo['starterProductMainImage'];
                                $crudData = array(
                                    'category_id' => $categoryId,
                                    'user_id' => $userId,
                                    'product_type' => 'starter',
                                    'product_name' => $productName,
                                    'product_description' => $productDescription,
                                    'status' => 'Active',
                                    'created_at' => $currentDateTime,
                                );
                                $createdID = $this->objProduct->createRecord($crudData);
                                if($createdID){
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
                                }
                            }
                        }
                    }

                    /* Starter Update (Exist in Both Current And New) */
                    if(!empty($needUpdateArr)){
                        $needUpdateArr = array_values(array_filter($needUpdateArr));
                        foreach ($starterData as $starterDataKey => $starterInfo) {
                            $productId = (int)$starterInfo['productId'];
                            $allergyId = $starterInfo['allergyId'];
                            $productDescription = trim($starterInfo['productDescription']);
                            $productName = trim($starterInfo['productName']);
                            $starterProductMainImage = $starterInfo['starterProductMainImage'];
                            if(in_array($productId, $needUpdateArr)){
                                $where = array(
                                    'product_id' => $productId,
                                    'category_id' => $categoryId,
                                    'user_id' => $userId,
                                );
                                $crudData = array(
                                    'product_name' => $productName,
                                    'product_description' => $productDescription,
                                    'updated_at' => $currentDateTime,
                                );
                                $responseUpdate = $this->objProduct->updateRecord($crudData,$where);
                                if($responseUpdate){
                                    //
                                }
                                else{
                                    $this->status = false;
                                    $this->message = __('api.common_update_error',['module'=> __('api.module_product')]);
                                }
                            }
                        }
                    }


                    //

                    $responseProduct = $this->objProduct->getProductInfo($product->product_id);
                    if($responseProduct){

                        $productMainImageList = [];
                        $productMainImage = $responseProduct->product_main_image;
                        if(!empty($productMainImage)){
                            $filePath = $this->productMainImagePath.$productMainImage;
                            if(file_exists($filePath)){
                                $size = filesize($filePath);
                                $fileUrl = url('uploads/product/').'/'.$productMainImage;
                                $productMainImageList[] = ['name'=>$productMainImage, 'size'=>$size, 'path'=>$filePath, 'url'=>$fileUrl, 'id'=>$responseProduct->product_id];
                            }
                        }

                        $responseProduct->productMainImageList = $productMainImageList;
                        $responseProduct->product_price = _number_format($responseProduct->product_price);
                        $responseProduct->product_topa = _number_format($responseProduct->product_topa);
                        $responseProduct->product_1r = _number_format($responseProduct->product_1r);
                        $responseProduct->product_12r = _number_format($responseProduct->product_12r);
                        $responseAllergies = $this->objAllergy->getProductAllergies($responseProduct->product_id);
                        $allergyIdArray = array();
                        if($responseAllergies){
                            foreach ($responseAllergies as $allergyKey => $allergyInfo){
                                array_push($allergyIdArray, (string)$allergyInfo->allergy_id);
                            }
                        }
                        $responseProduct->responseAllergies = $responseAllergies;
                        $responseProduct->allergyIdArray = $allergyIdArray;
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
            'data' => $responseProduct,
        ], $this->statusCode);
    }
}
