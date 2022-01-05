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
            $brandLogo = $responseBranding->brand_logo;
            $menuBrandingId = $responseBranding->menu_branding_id;
            $fileList = [];
            $targetDir = public_path('uploads/menu_branding/');
            if(!empty($brandLogo)){
                $filePath = $targetDir.$brandLogo;
                if(file_exists($filePath)){
                    $size = filesize($filePath);
                    $fileUrl = url('uploads/menu_branding/').'/'.$brandLogo;
                    $fileList[] = ['name'=>$brandLogo, 'size'=>$size, 'path'=>$filePath, 'url'=>$fileUrl, 'id'=>$menuBrandingId];
                }
            }
            $responseData['fileList'] = $fileList;
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
                $appLanguage = trim($request->appLanguage);
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
                    $this->message = __('api.common_update',['module'=> __('api.module_branding', [], $appLanguage)], $appLanguage);
                }else{
                    $this->status = false;
                    $this->message = __('api.common_update_error',['module'=> __('api.module_branding', [], $appLanguage)], $appLanguage);
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
    public function revertToDefault(Request $request,$id=0){

        $appLanguage = $request->appLanguage;
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
    public function storeBrandingLogo(Request $request){
        $data = $request->only('menuBrandingId', 'brandLogo');

        $validator = Validator::make($data, [
            'menuBrandingId' => 'required',
            'brandLogo' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            $this->status = false;
            $this->statusCode = Response::HTTP_BAD_REQUEST;
            $this->message = _lvValidations($validator->messages()->get('*'));
            $responseData = array('status'=>$this->status,'message'=>$this->message,'statusCode'=>$this->statusCode,'data'=>array());
            return response()->json($responseData,$this->statusCode);
        }

        $menuBrandingId = $request->menuBrandingId;
        $menuBranding = $this->objMenuBranding->getById($menuBrandingId);
        if($menuBranding){
            $userId = $this->user->id;
            
            if($menuBranding->user_id == $userId){
                $brandLogo = $request->file('brandLogo');
        
                if (!$brandLogo->isValid()) {
                    $this->status = false;
                    $this->statusCode = Response::HTTP_BAD_REQUEST;
                    $this->message = 'Error on upload file: '.$image->getErrorMessage();
                    $responseData = array('status'=>$this->status,'message'=>$this->message,'statusCode'=>$this->statusCode,'data'=>array());
                    return response()->json($responseData,$this->statusCode);
                }

                if(!empty($menuBranding->brand_logo)){
                    $currentBrandLogo = $menuBranding->brand_logo;
                    $folderPath = public_path('uploads/menu_branding/');
                    @unlink($folderPath.$currentBrandLogo);
                }

                $fileName = $brandLogo->getClientOriginalName(); // 3b8ad2c7b1be2caf24321c852103598a.jpg
                $fileExtension = $brandLogo->getClientOriginalExtension(); // jpg
                $fileRealPath = $brandLogo->getRealPath(); // C:\xampp\tmp\phpAC2F.tmp
                $fileSize = $brandLogo->getSize(); // 951640
                $fileMimeType = $brandLogo->getMimeType(); // image/jpeg
                $storeFileName = time().'-'.$fileName;
                $destinationPath = 'uploads/menu_branding';
                $brandLogo->move($destinationPath,$storeFileName);

                $currentDateTime = getCurrentDateTime();
                $crudData = array( 'brand_logo' => $storeFileName, 'updated_at' => $currentDateTime );
                $where = array('menu_branding_id' => $menuBrandingId);
                $responseUpdate = $this->objMenuBranding->updateRecord($crudData,$where);
                if($responseUpdate){
                    $this->message = __('api.common_add',['module'=>__('api.module_branding')]);
                }else{
                    $this->status = false;
                    $this->message = __('api.common_add_error',['module'=> __('api.module_branding')]);
                }
            }
            else{
                $this->status = false;
                $this->message = __('api.common_error_access_denied');
            }
        }
        else{
            $this->status = false;
            $this->message = __('api.common_not_found',['module'=> __('api.module_branding')]);
        }

        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
        ], $this->statusCode);
    }
    public function removeBrandingLogo(Request $request,$id=0){
        if($id){
            $userId = $this->user->id;
            $menuBranding = $this->objMenuBranding->getById($id);
            if($menuBranding ->user_id == $userId){
                $crudData = array(
                    'brand_logo' => NULL,
                    'updated_at' => getCurrentDateTime(),
                );
                $where = array('menu_branding_id' => $menuBranding->menu_branding_id);
                $responseUpdate = $this->objMenuBranding->updateRecord($crudData,$where);
                if($responseUpdate){
                    $brandLogo = $menuBranding->brand_logo;
                    $path = public_path('uploads/menu_branding/');
                    @unlink($path.$brandLogo);
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
}
