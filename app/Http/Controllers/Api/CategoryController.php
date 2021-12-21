<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\UserCategory;
use Illuminate\Http\Request;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class CategoryController extends ApiController
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
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function getAllWithUser(){
        //sleep(1);
        $responseData= array();
        try {
            /*return response()->json([
                'success' => false,
                'message' => __('api.common_error_500'),
            ], 500);*/
            $userId = $this->user->id;
            $responseCategories = $this->objCategory->getAllWithUser($userId);
            $userCategoryIdsArray = $this->objUserCategory->getUserSelectedCategoryIds($userId);
            $userCreatedCategoryIdsArray = $this->objCategory->getCategoryIdsCreatedByUser($userId);
            if($responseCategories){
                $responseData['categories'] = $responseCategories;
                $responseData['userCategoryIdsArray'] = $userCategoryIdsArray;
                $responseData['userCreatedCategoryIdsArray'] = $userCreatedCategoryIdsArray;
            }else{
                $this->status = false;
                $this->message = __('api.common_empty',['module' => __('api.module_category')]);
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
    public function getAllOnlyByUser(){
        $responseData= array();
        try {
            /*return response()->json([
                'status' => false,
                'message' => __('api.common_error_500'),
            ], 500);*/
            $userId = $this->user->id;
            $responseCategories = $this->objCategory->getAllOnlyByUser($userId);
            if($responseCategories){
                $responseData['categories'] = $responseCategories;
            }else{
                $this->status = false;
                $this->message = __('api.common_empty',['module' => __('api.module_category')]);
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
    public function getUserSelectedCategories(){
        $responseData= array();
        try {
            $userId = $this->user->id;
            $responseCategories = $this->objUserCategory->getUserSelectedCategories($userId);
            if($responseCategories){
                $responseData['categories'] = $responseCategories;
            }else{
                $this->status = false;
                $this->message = __('api.common_empty',['module' => __('api.module_category')]);
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
        //Validate data
        /*return response()->json([
            'status' => false,
            'message' => __('api.common_error_500'),
            'statusCode' => 500,
        ],  Response::HTTP_BAD_REQUEST);*/
        $data = $request->only('categoryNameSp', 'categoryNameEn');
        $validator = Validator::make($data, [
            'categoryNameSp' => 'required',
            'categoryNameEn' => 'required',
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
        $categoryNameEn = trim($request->categoryNameEn);
        $categoryNameSp = trim($request->categoryNameSp);
        $crudData = array(
            'name' => $categoryNameEn ,
            'spanish' => $categoryNameSp,
            'category_type' => $this->objCategory->type['Normal'],
            'user_id' => $userId,
            'created_by' => $userId,
            'product_price' => 0.00,
            'status' => $this->objCategory->status['ACTIVE'],
            'created_on' => getCurrentDateTime(),
            #'updated_on' => getCurrentDateTime(),
        );
        $createdID = $this->objCategory->createRecord($crudData);
        if($createdID){
            #$userCategoryTotal = $this->objCategory->getTotalByUser($userId);
            /*$crudDataUC = array(
                'user_id' => $userId,
                #'user_category_order' => ($userCategoryTotal+1),
                'category_id' => $createdID,
                'created_at' => getCurrentDateTime(),
            );
            $responseCreate = $this->objUserCategory->createRecord($crudDataUC);*/
            $this->message = __('api.common_add',['module'=>__('api.module_category')]);
        }else{
            //$this->statusCode = http_response_code(500);
            $this->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $this->status = false;
            $this->message = __('api.common_add_error',['module'=> __('api.module_category')]);
        }

        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
            //'data' => $category
        ], Response::HTTP_OK);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category){
            $userId = $this->user->id;
            if($category->user_id == $userId){
                $responseDelete = $category->delete();
                $this->objUserCategory->deleteRecordByCategoryId($category->id,$userId);
                $this->message = __('api.common_delete',['module'=> __('api.module_category')]);
            }else{
                $this->status = false;
                $this->message = __('api.common_error_access_denied');
            }
        }else{
            #$this->statusCode = Response::HTTP_NOT_FOUND;
            $this->status = false;
            $this->message = __('api.common_not_found',['module'=> __('api.module_category')]);
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
    public function update(Category $category,Request $request){
        if($category){
            $userId = $this->user->id;
            if($category->user_id == $userId){
                $data = $request->only('categoryNameSp', 'categoryNameEn');
                $validator = Validator::make($data, [
                    'categoryNameSp' => 'required',
                    'categoryNameEn' => 'required',
                ]);
                //Send failed response if request is not valid
                if ($validator->fails()) {
                    $this->status = false;
                    $this->statusCode = Response::HTTP_BAD_REQUEST;
                    $this->message = _lvValidations($validator->messages()->get('*'));
                    $responseData = array('status'=>$this->status,'message'=>$this->message,'statusCode'=>$this->statusCode,'data'=>array());
                    return response()->json($responseData,$this->statusCode);
                }
                $categoryNameEn = trim($request->categoryNameEn);
                $categoryNameSp = trim($request->categoryNameSp);
                $crudData = array(
                    'name' => $categoryNameEn ,
                    'spanish' => $categoryNameSp,
                    'updated_by' => $userId,
                    //'created_on' => getCurrentDateTime(),
                    'updated_on' => getCurrentDateTime(),
                );
                $where = array('id' => $category->id);
                $responseUpdate = $this->objCategory->updateRecord($crudData,$where);
                if($responseUpdate){
                    $this->message = __('api.common_update',['module'=> __('api.module_category')]);
                }else{
                    $this->status = false;
                    $this->message = __('api.common_update_error',['module'=> __('api.module_category')]);
                }
            }else{
                $this->status = false;
                $this->message = __('api.common_error_access_denied');
            }
        }else{
            #$this->statusCode = Response::HTTP_NOT_FOUND;
            $this->status = false;
            $this->message = __('api.common_not_found',['module'=> __('api.module_category')]);
        }
        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
        ], $this->statusCode);
    }

    public function assignCategory(Request $request){
        $data = $request->only('selectedCategory');
        /*$validator = Validator::make($data, [
            'categoryNameSp' => 'required',
            'categoryNameEn' => 'required',
        ]);*/
        $userId = $this->user->id;
        if(isset($data['selectedCategory']) && !empty($data['selectedCategory'])){
            // Get Existing Selected Category FROM TABLE
            // FInd New selected category from selectedCategory Array
            // FInd category for delete FROM TABLE
            $userCategoryIdsArray = $this->objUserCategory->getAllUserSelectedCategoryIds($userId);
            #_pre($userCategoryIdsArray );
            #$userCreatedCategoryIdsArray = $this->objCategory->getCategoryIdsCreatedByUser($userId);
            #var_dump($userCategoryIdsArray);
            $insertRecords = array();
            if(empty($userCategoryIdsArray)){
                //Insert/assign all selectedCategory
                foreach($data['selectedCategory'] as $key => $row){
                    $insertRecords[] = array(
                        'user_id' => $userId,
                        'user_category_order' => ($key+1),
                        'category_id' => $row,
                        'created_at' => getCurrentDateTime(),
                    );
                }
                #_pre($insertRecords,0);
                #_pre($data['selectedCategory']);
                $responseBulkInsert = $this->objUserCategory->createBulkRecord($insertRecords);
                if($responseBulkInsert){
                    $this->message = __('api.api_category_assign');
                }else{
                    //$this->statusCode = http_response_code(500);
                    $this->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                    $this->status = false;
                    $this->message = __('api.api_category_assign_error');
                }
            }else{
                #TODO REORDER
                // FInd New selected category from selectedCategory Array
                $userCategoryIdsArray = array_unique($userCategoryIdsArray);
                $data['selectedCategory'] = array_unique($data['selectedCategory']);
                $newCategories = array_diff($data['selectedCategory'],$userCategoryIdsArray);
                // FInd category for delete FROM TABLE
                $deleteCategories = array_diff($userCategoryIdsArray, $data['selectedCategory']);
                if($newCategories){
                    //Insert/Assign New
                    foreach($newCategories as $key => $row){
                        $insertRecords[] = array(
                            'user_id' => $userId,
                            'user_category_order' => 0,
                            'category_id' => $row,
                            'created_at' => getCurrentDateTime(),
                        );
                    }
                    #_pre($insertRecords,0);
                    #_pre($data['selectedCategory']);
                    $responseBulkInsert = $this->objUserCategory->createBulkRecord($insertRecords);
                    /*if($responseBulkInsert){
                        $this->message = __('api.api_category_assign');
                    }else{
                        //$this->statusCode = http_response_code(500);
                        $this->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                        $this->status = false;
                        $this->message = __('api.api_category_assign_error');
                    }*/
                }
                if($deleteCategories ){
                    //delete categories
                    $this->objUserCategory->deleteBulkRecordByCategoryIds($deleteCategories,$userId);
                }
                if(empty($newCategories) && empty($deleteCategories)){
                    $this->message = __('api.api_category_assign_already');
                }else{
                    $this->message = __('api.api_category_assign');
                }
                #_pre($newCategories  ,0);
               # _pre(" ==== DELETE ===",0);
                #_pre($deleteCategories ,0);
            }
            # _pre($userCategoryIdsArray);
            #_pre($userCreatedCategoryIdsArray );
        }else if(empty($data['selectedCategory'])){
            //TODO DELETE ALL SELECTED CATEGORY
            $this->objUserCategory->deleteAllCategoryByUseId($userId);
        }

        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
            //'data' => $category
        ], Response::HTTP_OK);
    }
}
