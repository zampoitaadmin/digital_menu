<?php

namespace App\Http\Controllers\Api;
#use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\ApiController;
use App\Category;
use App\Employee;
use App\OrgMeta;
use App\Organization;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
class CategoryController extends ApiController
{
    protected $objCategory;
    protected $product_m;
    public function __construct()
    {
        parent::__construct();
        $this->objCategory = new Category();
        $this->product_m = new Product();
        #dd($this->useToken);
    }
    public function index(Request $request)
    {
        try{
            $input = $request->only('parentCategoryId');
            $parentCategoryId = (isset($input['parentCategoryId']) && ($input['parentCategoryId'] != '')) ? $input['parentCategoryId'] : 0;
            $listCategory = $this->objCategory->getCategoryListByOrgId($this->organizationId,$parentCategoryId);
            $returnData = array();
            $returnData['categoryList'] = $listCategory;
            if(empty($listCategory)){
                return response()->json([
                    'success' => true,
                    'message' => 'Record(s) not available.',
                    'data' => $returnData
                ]);
            }else{
                foreach($listCategory as $key=>$value){
                    $value->totalProduct = $this->product_m->totalCategoryProduct($value->categoryId);
                    $subCategoryList = $this->objCategory->getCategoryListByOrgId($this->organizationId,$value->categoryId);
                    $value->totalSubCategoryCount = count($subCategoryList);

                    if(!empty($subCategoryList)){
                        foreach($subCategoryList as $subCatRow){
                            $totalSubCatProduct = $this->product_m->totalCategoryProduct($subCatRow->categoryId);
                            $value->totalProduct = $value->totalProduct+$totalSubCatProduct;
                        }
                    }
                }
                $returnData['categoryList'] = $listCategory;
                return response()->json([
                    'success' => true,
                    'message' => '',
                    'data' => $returnData
                ]);
            }
        }catch (Exception $e) {
            $code = ($e->getCode() == 0) ? Response::HTTP_INTERNAL_SERVER_ERROR : $e->getCode();
            return response()->json([
                'success' => ($e->getCode() == 200) ? true : false,
                'error' => $e->getMessage(),
            ], $code);
        }
    }
    public function show($id)
    {
        try{
            $detailCategory = $this->objCategory->getCategoryDetailById($this->organizationId,$id);
            $returnData['categoryData'] = $detailCategory;
            if (!$detailCategory) {
                throw new Exception('Sorry, category with id ' . $id . ' cannot be found',Response::HTTP_NOT_FOUND);
            }else{
                return response()->json([
                    'success' => true,
                    'message' => '',
                    'data' => $returnData
                ]);
            }
        }catch (Exception $e) {
            $code = ($e->getCode() == 0) ? Response::HTTP_INTERNAL_SERVER_ERROR : $e->getCode();
            return response()->json([
                'success' => ($e->getCode() == 200) ? true : false,
                'error' => $e->getMessage(),
            ], $code);
        }
    }

    public function store(Request $request)
    {

        $input = $request->only('name','parentCategoryId');
        $jwt_token = null;
        $validator = Validator::make($input, [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }else{
            try{
                $parentCategoryId = (isset($input['parentCategoryId']) && ($input['parentCategoryId'] != '')) ? $input['parentCategoryId'] : 0;

                if($parentCategoryId>0){ //validate Parent category Id with organizationId
                    $detailCategory = $this->objCategory->getCategoryDetailById($this->organizationId,$parentCategoryId);
                    if (!$detailCategory) {
                        throw new Exception('Sorry, parent category with id ' . $parentCategoryId . ' cannot be found',Response::HTTP_NOT_FOUND);
                    }
                }
                $input['parentCategoryId'] = $parentCategoryId;
                $input['organizationId'] = $this->organizationId;
                $input['employeeId'] = $this->employeeId;
                $affectedRows = $this->objCategory->addCategory($input);//AddCategory
                if($affectedRows){
                    return response()->json([
                        'success' => true,
                        'message' => 'Category added successfully',
                    ], Response::HTTP_OK);
                }else{
                    throw new Exception('Sorry, category could not be added',Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }
            catch (Exception $e) {
                $code = ($e->getCode() == 0) ? Response::HTTP_INTERNAL_SERVER_ERROR : $e->getCode();
                return response()->json([
                    'success' => ($e->getCode() == 200) ? true : false,
                    'error' => $e->getMessage(),
                ], $code);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $input = $request->only('name','parentCategoryId');
        $jwt_token = null;
        $validator = Validator::make($input, [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }else{
            try{
                $detailCategory = $this->objCategory->getCategoryDetailById($this->organizationId,$id);
                $returnData['categoryData'] = $detailCategory;
                if (!$detailCategory) {
                    throw new Exception('Sorry, category with id ' . $id . ' cannot be found',Response::HTTP_NOT_FOUND);
                }else{
                    $parentCategoryId = (isset($input['parentCategoryId']) && ($input['parentCategoryId'] != '')) ? $input['parentCategoryId'] : 0;
                    if($parentCategoryId>0){ //validate Parent category Id with organizationId
                        $detailCategory = $this->objCategory->getCategoryDetailById($this->organizationId,$parentCategoryId);
                        if (!$detailCategory) {
                            throw new Exception('Sorry, parent category with id ' . $parentCategoryId . ' cannot be found',Response::HTTP_NOT_FOUND);
                        }
                    }

                    $input['parentCategoryId'] = $parentCategoryId;
                    $input['organizationId'] = $this->organizationId;
                    $input['employeeId'] = $this->employeeId;
                    $affectedRows = $this->objCategory->updateCategory($input,$id);
                    if($affectedRows){
                        return response()->json([
                            'success' => true,
                            'message' => 'Category updated successfully',
                            #'data' => $returnData,
                        ], Response::HTTP_OK);
                    }else{
                        throw new Exception('Sorry, category could not be updated',Response::HTTP_INTERNAL_SERVER_ERROR);
                    }
                }
            }catch (Exception $e) {
                $code = ($e->getCode() == 0) ? Response::HTTP_INTERNAL_SERVER_ERROR : $e->getCode();
                return response()->json([
                    'success' => ($e->getCode() == 200) ? true : false,
                    'error' => $e->getMessage(),
                ], $code);
            }

        }
    }

    public function destroy(Request $request)
    {
        $categoryId = $request->route('categoryId');
        $categoryDetail = $this->objCategory->categoryDetail($this->organizationId, $categoryId);
        if (empty($categoryDetail)) {
            return response()->json([
                'success' => false,
                'message' => 'Category Detail not found',
            ], Response::HTTP_OK);
        }

        $totalCatProduct = $this->objCategory->totalCategoryProduct([$categoryId]);
        if ($totalCatProduct) {
            return response()->json([
                'success' => false,
                'message' => 'This category can not delete, because this category have products'
            ], Response::HTTP_OK);
        }

        $subCategoryList = $this->objCategory->subCategoryList($categoryId);
        if (!empty($subCategoryList)) {
            $subCatIds = [];
            foreach ($subCategoryList as $row) {
                $subCatIds[] = $row->categoryId;
            }

            $totalSubCatProduct = $this->objCategory->totalCategoryProduct($subCatIds);

            if ($totalSubCatProduct) {
                return response()->json([
                    'success' => false,
                    'message' => 'This category can not delete, because this category of subcategory have products'
                ], Response::HTTP_OK);
            }
            if(!empty($subCatIds)){
                $subCatAffectedRow = $this->objCategory->deleteCategory($subCatIds, $this->employeeId);
                if (!$subCatAffectedRow) {
                    return response()->json([
                        'success' => false,
                        'errors' => 'Sub Category not delete',
                    ], Response::HTTP_OK);
                }
            }
        }

        $catAffectedRow = $this->objCategory->deleteCategory([$categoryId], $this->employeeId);
        if (!$catAffectedRow) {
            return response()->json([
                'success' => false,
                'errors' => 'Category not delete',
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => true,
            'message' => 'Category deleted Successfully',
        ], Response::HTTP_OK);
    }
}
