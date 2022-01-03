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

    /* Insert in merchant_fixed_menu_data
    Update in user_category
    Insert in products
    Insert in product_allergies */
    public function store(Request $request){
        // _pre($request->all());
        $data = $request->only('changeCategoryName', 'menuDescriptionConditions', 'fixedMenuPrice', 'starterData', 'mainCourseData', 'desertData');
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
        $mainCourseData = ($request->mainCourseData);
        $desertData = ($request->desertData);
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
                        if(!empty($allergyId)){
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
            if(!empty($mainCourseData)){
                foreach ($mainCourseData as $mainCourseDataKey => $mainCourseInfo) {
                    $allergyId = $mainCourseInfo['allergyId'];
                    $productDescription = trim($mainCourseInfo['productDescription']);
                    $productName = trim($mainCourseInfo['productName']);
                    $mainCourseProductMainImage = $mainCourseInfo['mainCourseProductMainImage'];
                    $crudData = array(
                        'category_id' => $categoryId,
                        'user_id' => $userId,
                        'product_type' => 'course',
                        'product_name' => $productName,
                        'product_description' => $productDescription,
                        'status' => 'Active',
                        'created_at' => $currentDateTime,
                    );
                    $createdID = $this->objProduct->createRecord($crudData);
                    if($createdID){
                        $insertRecords = array();
                        if(!empty($allergyId)){
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
            if(!empty($desertData)){
                foreach ($desertData as $desertDataKey => $desertInfo) {
                    $allergyId = $desertInfo['allergyId'];
                    $productDescription = trim($desertInfo['productDescription']);
                    $productName = trim($desertInfo['productName']);
                    $desertProductMainImage = $desertInfo['desertProductMainImage'];
                    $crudData = array(
                        'category_id' => $categoryId,
                        'user_id' => $userId,
                        'product_type' => 'desert',
                        'product_name' => $productName,
                        'product_description' => $productDescription,
                        'status' => 'Active',
                        'created_at' => $currentDateTime,
                    );
                    $createdID = $this->objProduct->createRecord($crudData);
                    if($createdID){
                        $insertRecords = array();
                        if(!empty($allergyId)){
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
        // _pre($merchantFixedMenuData,0);
        // _pre($request->all());
        // exit;
        // _pre($product->user_id);
        if($merchantFixedMenuData){
            $userId = $this->user->id;
            if($merchantFixedMenuData->user_id == $userId){
                $data = $request->only('changeCategoryName', 'menuDescriptionConditions', 'fixedMenuPrice', 'starterData', 'mainCourseData', 'desertData');
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
                $mainCourseData = ($request->mainCourseData);
                $desertData = ($request->desertData);
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
                    $crudData = array(
                        'change_category_name' => $changeCategoryName,
                        'updated_at' => $currentDateTime
                    );
                    $where = array( 'user_id' => $userId, 'category_id' => $categoryId );
                    $this->objUserCategory->updateRecord($crudData,$where);
                    $this->updateStarter($categoryId, $starterData, $currentDateTime);
                    $this->updateMainCourse($categoryId, $mainCourseData, $currentDateTime);
                    $this->updateDesert($categoryId, $desertData, $currentDateTime);
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
            // 'data' => $responseProduct,
        ], $this->statusCode);
    }

    private function updateStarter($categoryId, $starterData, $currentDateTime){
        $userId = $this->user->id;
        /* Get Current Starter Product Ids */
        $starterProductData = $this->objProduct->getProductByProductType($userId,$categoryId,'starter');
        $currStarterProductIdArr = array();
        if(!$starterProductData->isEmpty()){
            foreach ($starterProductData as $key => $value) {
                array_push($currStarterProductIdArr, (int)$value->product_id);
            }
        }

        /* Get New Starter Product Ids */
        $newStarterProductIdArr = array();
        if(!empty($starterData)){
            foreach ($starterData as $key => $value) {
                array_push($newStarterProductIdArr, (int)$value["productId"]);
            }
        }

        $needDeleteArr = array_diff($currStarterProductIdArr,$newStarterProductIdArr);
        $needUpdateArr = array_intersect($currStarterProductIdArr,$newStarterProductIdArr);

        /*
            1 2 3 4 5 6 Current
            1 2 5 6 7 8 New
            Remove 3 4 -> Also remove from product allergy
            New Add 7 8 -> Add
            Update 1 2 5 6
                  Suppose for product 1 Update For Product Allergy
                  1 2 3 4 5 6 -> Current Product Allergy
                  1 2 5 6 7 8 -> New Product Allergy
                  REMOVE 3 4
                  ADD 7 8
        */

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
                        if(!empty($allergyId)){
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
        }

        /* Starter Update (Exist in Both Current And New) */
        if(!empty($needUpdateArr)){
            $needUpdateArr = array_values(array_filter($needUpdateArr));
            foreach ($starterData as $starterDataKey => $starterInfo) {
                $productId = (int)$starterInfo['productId'];
                $allergyId = $starterInfo['allergyId'];
                if($allergyId && !empty($allergyId)){
                    $allergyId = array_values(array_filter($allergyId));
                }else{
                    $allergyId = array();
                }
                $productDescription = trim($starterInfo['productDescription']);
                $productName = trim($starterInfo['productName']);
                // $starterProductMainImage = $starterInfo['starterProductMainImage'];
                if(in_array($productId, $needUpdateArr)){
                    $currAllergyIdArr = $this->objProduct->getProductAllergyIds($productId);
                    $newAllergyIdArr = array_map('intval', $allergyId);
                    $needDeleteArr = array_diff($currAllergyIdArr,$newAllergyIdArr);
                    $needDeleteArr = array_values($needDeleteArr);
                    $needInsertArr = array_diff($newAllergyIdArr,$currAllergyIdArr);
                    $needInsertArr = array_values($needInsertArr);
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
                        if(!empty($needDeleteArr)){
                            $this->objProduct->deleteProductAllergy($productId, $needDeleteArr); // Delete
                        }
                        if(!empty($needInsertArr)){                                        
                            $insertRecords = array();
                            for($i=0; $i < count($needInsertArr); $i++){
                                $insertRecords[] = array(
                                    'product_id' => $productId,
                                    'allergy_id' => $needInsertArr[$i],
                                    'created_at' => $currentDateTime
                                );
                            }
                            $responseBulkInsert = $this->objProduct->createBulkRecord($insertRecords); // Insert
                            if($responseBulkInsert){
                            }else{
                            }
                        }
                    }
                    else{
                        // $this->status = false;
                        // $this->message = __('api.common_update_error',['module'=> __('api.module_product')]);
                    }
                }
            }
        }
        // return response
    }

    private function updateMainCourse($categoryId, $mainCourseData, $currentDateTime){
        $userId = $this->user->id;
        /* Get Current MainCourse Product Ids */
        $mainCourseProductData = $this->objProduct->getProductByProductType($userId,$categoryId,'course');
        $currMainCourseProductIdArr = array();
        if(!$mainCourseProductData->isEmpty()){
            foreach ($mainCourseProductData as $key => $value) {
                array_push($currMainCourseProductIdArr, (int)$value->product_id);
            }
        }

        /* Get New MainCourse Product Ids */
        $newMainCourseProductIdArr = array();
        if(!empty($mainCourseData)){
            foreach ($mainCourseData as $key => $value) {
                array_push($newMainCourseProductIdArr, (int)$value["productId"]);
            }
        }

        $needDeleteArr = array_diff($currMainCourseProductIdArr,$newMainCourseProductIdArr);
        $needUpdateArr = array_intersect($currMainCourseProductIdArr,$newMainCourseProductIdArr);

        /* MainCourse Delete (Exist in Current But Not in New) */
        if(!empty($needDeleteArr)){
            $needDeleteArr = array_values(array_filter($needDeleteArr));
            $this->objProduct->deleteProduct($categoryId, $userId, $needDeleteArr); // Delete
            $this->objProduct->deleteProductAllergyByProductId($needDeleteArr); // Delete
        }

        /* MainCourse Insert (Not in Current But Exist in New) */
        if(!empty($mainCourseData)){
            foreach ($mainCourseData as $mainCourseDataKey => $mainCourseInfo) {
                $productId = $mainCourseInfo['productId'];
                if(empty($productId)){
                    $allergyId = $mainCourseInfo['allergyId'];
                    $productDescription = trim($mainCourseInfo['productDescription']);
                    $productName = trim($mainCourseInfo['productName']);
                    $mainCourseProductMainImage = $mainCourseInfo['mainCourseProductMainImage'];
                    $crudData = array(
                        'category_id' => $categoryId,
                        'user_id' => $userId,
                        'product_type' => 'course',
                        'product_name' => $productName,
                        'product_description' => $productDescription,
                        'status' => 'Active',
                        'created_at' => $currentDateTime,
                    );
                    $createdID = $this->objProduct->createRecord($crudData);
                    if($createdID){
                        $insertRecords = array();
                        if(!empty($allergyId)){
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
        }

        /* MainCourse Update (Exist in Both Current And New) */
        if(!empty($needUpdateArr)){
            $needUpdateArr = array_values(array_filter($needUpdateArr));
            foreach ($mainCourseData as $mainCourseDataKey => $mainCourseInfo) {
                $productId = (int)$mainCourseInfo['productId'];
                $allergyId = $mainCourseInfo['allergyId'];
                if($allergyId && !empty($allergyId)){
                    $allergyId = array_values(array_filter($allergyId));
                }else{
                    $allergyId = array();
                }
                $productDescription = trim($mainCourseInfo['productDescription']);
                $productName = trim($mainCourseInfo['productName']);
                // $mainCourseProductMainImage = $mainCourseInfo['mainCourseProductMainImage'];
                if(in_array($productId, $needUpdateArr)){
                    $currAllergyIdArr = $this->objProduct->getProductAllergyIds($productId);
                    $newAllergyIdArr = array_map('intval', $allergyId);
                    $needDeleteArr = array_diff($currAllergyIdArr,$newAllergyIdArr);
                    $needDeleteArr = array_values($needDeleteArr);
                    $needInsertArr = array_diff($newAllergyIdArr,$currAllergyIdArr);
                    $needInsertArr = array_values($needInsertArr);
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
                        if(!empty($needDeleteArr)){                                        
                            $this->objProduct->deleteProductAllergy($productId, $needDeleteArr); // Delete
                        }
                        if(!empty($needInsertArr)){                                        
                            $insertRecords = array();
                            for($i=0; $i < count($needInsertArr); $i++){
                                $insertRecords[] = array(
                                    'product_id' => $productId,
                                    'allergy_id' => $needInsertArr[$i],
                                    'created_at' => $currentDateTime
                                );
                            }
                            $responseBulkInsert = $this->objProduct->createBulkRecord($insertRecords); // Insert
                            if($responseBulkInsert){
                            }else{
                            }
                        }
                    }
                    else{
                        // $this->status = false;
                        // $this->message = __('api.common_update_error',['module'=> __('api.module_product')]);
                    }
                }
            }
        }
        // return response
    }

    private function updateDesert($categoryId, $desertData, $currentDateTime){
        $userId = $this->user->id;
        /* Get Current Desert Product Ids */
        $desertProductData = $this->objProduct->getProductByProductType($userId,$categoryId,'desert');
        $currDesertProductIdArr = array();
        if(!$desertProductData->isEmpty()){
            foreach ($desertProductData as $key => $value) {
                array_push($currDesertProductIdArr, (int)$value->product_id);
            }
        }

        /* Get New Desert Product Ids */
        $newDesertProductIdArr = array();
        if(!empty($desertData)){
            foreach ($desertData as $key => $value) {
                array_push($newDesertProductIdArr, (int)$value["productId"]);
            }
        }

        $needDeleteArr = array_diff($currDesertProductIdArr,$newDesertProductIdArr);
        $needUpdateArr = array_intersect($currDesertProductIdArr,$newDesertProductIdArr);

        /* Desert Delete (Exist in Current But Not in New) */
        if(!empty($needDeleteArr)){
            $needDeleteArr = array_values(array_filter($needDeleteArr));
            $this->objProduct->deleteProduct($categoryId, $userId, $needDeleteArr); // Delete
            $this->objProduct->deleteProductAllergyByProductId($needDeleteArr); // Delete
        }

        /* Desert Insert (Not in Current But Exist in New) */
        if(!empty($desertData)){
            foreach ($desertData as $desertDataKey => $desertInfo) {
                $productId = $desertInfo['productId'];
                if(empty($productId)){
                    $allergyId = $desertInfo['allergyId'];
                    $productDescription = trim($desertInfo['productDescription']);
                    $productName = trim($desertInfo['productName']);
                    $desertProductMainImage = $desertInfo['desertProductMainImage'];
                    $crudData = array(
                        'category_id' => $categoryId,
                        'user_id' => $userId,
                        'product_type' => 'desert',
                        'product_name' => $productName,
                        'product_description' => $productDescription,
                        'status' => 'Active',
                        'created_at' => $currentDateTime,
                    );
                    $createdID = $this->objProduct->createRecord($crudData);
                    if($createdID){
                        $insertRecords = array();
                        if(!empty($allergyId)){
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
        }

        /* Desert Update (Exist in Both Current And New) */
        if(!empty($needUpdateArr)){
            $needUpdateArr = array_values(array_filter($needUpdateArr));
            foreach ($desertData as $desertDataKey => $desertInfo) {
                $productId = (int)$desertInfo['productId'];
                $allergyId = $desertInfo['allergyId'];
                if($allergyId && !empty($allergyId)){
                    $allergyId = array_values(array_filter($allergyId));
                }else{
                    $allergyId = array();
                }
                $productDescription = trim($desertInfo['productDescription']);
                $productName = trim($desertInfo['productName']);
                // $desertProductMainImage = $desertInfo['desertProductMainImage'];
                if(in_array($productId, $needUpdateArr)){
                    $currAllergyIdArr = $this->objProduct->getProductAllergyIds($productId);
                    $newAllergyIdArr = array_map('intval', $allergyId);
                    $needDeleteArr = array_diff($currAllergyIdArr,$newAllergyIdArr);
                    $needDeleteArr = array_values($needDeleteArr);
                    $needInsertArr = array_diff($newAllergyIdArr,$currAllergyIdArr);
                    $needInsertArr = array_values($needInsertArr);
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
                        if(!empty($needDeleteArr)){                                        
                            $this->objProduct->deleteProductAllergy($productId, $needDeleteArr); // Delete
                        }
                        if(!empty($needInsertArr)){                                        
                            $insertRecords = array();
                            for($i=0; $i < count($needInsertArr); $i++){
                                $insertRecords[] = array(
                                    'product_id' => $productId,
                                    'allergy_id' => $needInsertArr[$i],
                                    'created_at' => $currentDateTime
                                );
                            }
                            $responseBulkInsert = $this->objProduct->createBulkRecord($insertRecords); // Insert
                            if($responseBulkInsert){
                            }else{
                            }
                        }
                    }
                    else{
                        // $this->status = false;
                        // $this->message = __('api.common_update_error',['module'=> __('api.module_product')]);
                    }
                }
            }
        }
        // return response
    }
}
