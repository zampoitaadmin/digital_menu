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
        $this->brandLogoPath = public_path('uploads/menu_branding/');
    }

    public function getOneByUserId(){
        $responseData= array();
        try {
            $userId = $this->user->id;
            $responseBranding = $this->objMenuBranding->getOneByUserId($userId);
            if($responseBranding){
                unset($responseBranding->user_id);
                if(!empty($responseBranding->brand_logo)){
                    $responseBranding->brandLogoUrl = url('uploads/menu_branding/').'/'.$responseBranding->brand_logo;
                }
                else{
                    $responseBranding->brandLogoUrl = "";
                }
                $responseData['branding'] = $responseBranding;
            }else{
                $responseBranding = $this->createDefault();
                $responseData['branding'] = $responseBranding;
            }
            $brandLogo = $responseBranding->brand_logo;
            $menuBrandingId = $responseBranding->menu_branding_id;
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
    public function update(Request $request){
        // _pre($request->all());
        $data = $request->only('brandLogo', 'fontColor', 'mainColor', 'secondaryColor', 'thirdColor');
        $userId = $this->user->id;
        $id = trim($request->id);
        $menuBranding = $this->objMenuBranding->getById($id);
        if($menuBranding){
            if($menuBranding->user_id == $userId){
                $appLanguage = trim($request->appLanguage);
                $brandLogo = ($request->brandLogo);
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
                if( isset($brandLogo) ){
                    if( !empty($brandLogo) ){
                        if(!$brandLogo->isValid())
                        {
                            $this->status = false;
                            $this->statusCode = Response::HTTP_BAD_REQUEST;
                            $this->message = 'Error on upload file: '.$brandLogo->getErrorMessage();
                            $responseData = array('status'=>$this->status,'message'=>$this->message,'statusCode'=>$this->statusCode,'data'=>array());
                            return response()->json($responseData,$this->statusCode);
                        }

                        $fileName = $brandLogo->getClientOriginalName(); // 3b8ad2c7b1be2caf24321c852103598a.jpg
                        $fileExtension = $brandLogo->getClientOriginalExtension(); // jpg
                        $fileRealPath = $brandLogo->getRealPath(); // C:\xampp\tmp\phpAC2F.tmp
                        $fileSize = $brandLogo->getSize(); // 951640
                        $fileMimeType = $brandLogo->getMimeType(); // image/jpeg

                        $storeFileName = time().'-'.$fileName;
                        $brandLogo->move($this->brandLogoPath,$storeFileName);

                        $crudData["brand_logo"] = $storeFileName;

                        if(!empty($menuBranding->brand_logo)){
                            $currentBrandLogo = $menuBranding->brand_logo;
                            @unlink($this->brandLogoPath.$currentBrandLogo);
                        }
                    }
                }
                $responseUpdate = $this->objMenuBranding->updateRecord($crudData,$where);
                if($responseUpdate){
                    $this->message = __('api.common_update',['module'=> __('api.module_branding', [], $appLanguage)], $appLanguage);
                }else{
                    $this->status = false;
                    $this->message = __('api.common_update_error',['module'=> __('api.module_branding', [], $appLanguage)], $appLanguage);
                }
            }else{
                $this->status = false;
                $this->message = __('api.common_error_access_denied', [], $appLanguage);
            }
        }
        else{
            $this->status = false;
            $this->message = __('api.common_not_found',['module'=> __('api.module_branding', [], $appLanguage)], $appLanguage);
        }
        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
        ], $this->statusCode);
    }
    public function revertToDefault(Request $request,$id=0){

        $appLanguage = $request->appLanguage;
        if($id){
            $userId = $this->user->id;
            $menuBranding = $this->objMenuBranding->getById($id);
            if($menuBranding->user_id == $userId){
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
                    if(!empty($menuBranding->brand_logo)){
                        $currentBrandLogo = $menuBranding->brand_logo;
                        @unlink($this->brandLogoPath.$currentBrandLogo);
                    }
                    $this->message = __('api.api_branding_revert_default', [], $appLanguage);
                }else{
                    $this->status = false;
                    $this->message = __('api.api_branding_revert_default_error', [], $appLanguage);
                }
            }else{
                $this->status = false;
                $this->message = __('api.common_error_access_denied', [], $appLanguage);
            }
        }else{
            #$this->statusCode = Response::HTTP_NOT_FOUND;
            $this->status = false;
            $this->message = __('api.common_not_found',['module'=> __('api.module_branding', [], $appLanguage)], $appLanguage);
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

    public function removeBrandingLogo(MenuBranding $menuBranding){
        if($menuBranding){
            $userId = $this->user->id;
            if($menuBranding->user_id == $userId){
                $currentDateTime = getCurrentDateTime();
                $currentBrandLogo = $menuBranding->brand_logo;
                if(!empty($menuBranding->brand_logo)){
                    $where = array(
                        'menu_branding_id' => $menuBranding->menu_branding_id,
                    );
                    $crudData = array(
                        'brand_logo' => NULL,
                        'updated_at' => $currentDateTime,
                    );
                    $responseUpdate = $this->objMenuBranding->updateRecord($crudData,$where);
                    if($responseUpdate){
                        if(!empty($menuBranding->brand_logo)){
                            @unlink($this->brandLogoPath.$currentBrandLogo);
                        }
                        $this->message = __('api.common_update',['module'=> __('api.module_branding')]);
                    }
                    else{
                        $this->status = false;
                        $this->message = __('api.common_update_error',['module'=> __('api.module_branding')]);
                    }
                }
                else{
                    $this->status = false;
                    $this->message = __('api.common_not_found',['module'=> __('api.module_branding')]);
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
}
