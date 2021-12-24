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
                    $responseCategories[$key]->responseProducts = $responseProducts;

                    if($responseProducts){
                        foreach ($responseProducts as $productKey => $productInfo)
                        {
                            $responseAllergies = $this->objAllergy->getProductAllergies($productInfo->product_id);
                            $responseCategories[$key]->responseProducts[$productKey]->responseAllergies = $responseAllergies;
                        }
                    }
                }
                // _pre($responseCategories);
                $responseData['products'] = $responseCategories;
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
}
