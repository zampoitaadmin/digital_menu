<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\MenuBranding;
use App\Models\UserCategory;
use Illuminate\Http\Request;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class BrandingController extends ApiController
{
    public $statusCode;
    public $status;
    public $message;
    public function __construct()
    {
        $this->status = TRUE;
        $this->statusCode = Response::HTTP_OK;
        $this->message = '';
        $this->objMenuBranding = new MenuBranding();
        $this->objUserCategory = new UserCategory();
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function getOneByUserId(){
        $responseData= array();
        try {

            $userId = $this->user->id;
            $responseBranding = $this->objMenuBranding->getOneByUserId($userId);
            if($responseBranding){
                unset($responseBranding->user_id);
                $responseData['branding'] = $responseBranding;
            }else{
                $responseBranding = $this->createDefault();
                $responseData['branding'] = $responseBranding;
                //CreateDefault
                //Send Default Colors
                #$this->status = false;
                #$this->message = __('api.common_empty',['module' => __('api.module_branding')]);
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
    public function update(Request $request,$id=0){
        if($id){
            $userId = $this->user->id;
            $menuBranding = $this->objMenuBranding->getById($id);
            if($menuBranding ->user_id == $userId){
                $data = $request->only('brandLogo', 'fontColor', 'mainColor', 'secondaryColor', 'thirdColor');
                /*$validator = Validator::make($data, [
                    'categoryNameSp' => 'required',
                    'categoryNameEn' => 'required',
                ]);*/
                //Send failed response if request is not valid
                /*if ($validator->fails()) {
                    $this->status = false;
                    $this->statusCode = Response::HTTP_BAD_REQUEST;
                    $this->message = _lvValidations($validator->messages()->get('*'));
                    $responseData = array('status'=>$this->status,'message'=>$this->message,'statusCode'=>$this->statusCode,'data'=>array());
                    return response()->json($responseData,$this->statusCode);
                }*/
                $brandLogo = trim($request->brandLogo);
                $fontColor = trim($request->fontColor);
                $mainColor = trim($request->mainColor);
                $secondaryColor = trim($request->secondaryColor);
                $thirdColor = trim($request->thirdColor);
                $crudData = array(
                    'brand_color' => $mainColor,
                    'secondary_color' => $secondaryColor,
                    'third_color' => $thirdColor,
                    'font_color' => $fontColor,
                    'updated_at' => getCurrentDateTime(),
                );
                $where = array('menu_branding_id' => $menuBranding->menu_branding_id);
                $responseUpdate = $this->objMenuBranding->updateRecord($crudData,$where);
                if($responseUpdate){
                    $this->message = __('api.common_update',['module'=> __('api.module_branding')]);
                }else{
                    $this->status = false;
                    $this->message = __('api.common_update_error',['module'=> __('api.module_branding')]);
                }
            }else{
                $this->status = false;
                $this->message = __('api.common_error_access_denied');
            }
        }else{
            #$this->statusCode = Response::HTTP_NOT_FOUND;
            $this->status = false;
            $this->message = __('api.common_not_found',['module'=> __('api.module_branding')]);
        }
        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
        ], $this->statusCode);
    }
    public function revertToDefault(Request $request,$id=0){

        if($id){
            $userId = $this->user->id;
            $menuBranding = $this->objMenuBranding->getById($id);
            if($menuBranding ->user_id == $userId){
                //$data = $request->only('brandLogo', 'fontColor', 'mainColor', 'secondaryColor', 'thirdColor');
                $crudData = array(
                    'brand_color' => '#a77337',
                    'secondary_color' => '#000000',
                    'third_color' => '#ffffff',
                    'font_color' => '#000000',
                    'brand_logo' => '',
                    'brand_banner_image' => '',
                    'updated_at' => getCurrentDateTime(),
                );
                $where = array('menu_branding_id' => $menuBranding->menu_branding_id);
                $responseUpdate = $this->objMenuBranding->updateRecord($crudData,$where);
                if($responseUpdate){
                    $this->message = __('api.api_branding_revert_default');
                }else{
                    $this->status = false;
                    $this->message = __('api.api_branding_revert_default_error');
                }
            }else{
                $this->status = false;
                $this->message = __('api.common_error_access_denied');
            }
        }else{
            #$this->statusCode = Response::HTTP_NOT_FOUND;
            $this->status = false;
            $this->message = __('api.common_not_found',['module'=> __('api.module_branding')]);
        }
        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
        ], $this->statusCode);
    }
    public function createDefault(){
        $userId = $this->user->id;
        $crudData = array(
            'user_id' => $userId,
            'brand_color' => '#a77337',
            'secondary_color' => '#000000',
            'third_color' => '#ffffff',
            'font_color' => '#000000',
            'status' => $this->objMenuBranding->status['ACTIVE'],
            'updated_at' => getCurrentDateTime(),
        );
        $responseCreate = $this->objMenuBranding->createRecord($crudData);
        $responseBranding = $this->objMenuBranding->getOneByUserId($userId);
        if($responseBranding ){
            unset($responseBranding->user_id);
        }
        return $responseBranding;
    }
}
