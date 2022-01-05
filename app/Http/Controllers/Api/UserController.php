<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\MenuBranding;
use App\Models\User;
use App\Models\UserCategory;
use Illuminate\Http\Request;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{
    public $statusCode;
    public $status;
    public $message;
    public function __construct()
    {
        $this->status = TRUE;
        $this->statusCode = Response::HTTP_OK;
        $this->message = '';
        $this->objUser = new User();
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function getSettingByUser(){
        $responseData= array();
        try {

            $userId = $this->user->id;
            $responseUser = $this->objUser->getSettingByUserId($userId);
            if($responseUser){
                $responseData['userSetting'] = array(
                    'is_actv_mnu' => $responseUser->is_actv_mnu,
                    'standard_delivery_charge' => _number_format($responseUser->standard_delivery_charge),
                    'min_order_delivery_charge' => _number_format($responseUser->min_order_delivery_charge),
                    'free_delivery_charge_order' => _number_format($responseUser->free_delivery_charge_order),
                    'website_url' => url('/')."/menu/"  .trim($responseUser->slug),
                );
            }else{
                $responseData['userSetting'] = array(
                    'is_actv_mnu' => 0,
                    'standard_delivery_charge' => '0.00',
                    'min_order_delivery_charge' => '0.00',
                    'free_delivery_charge_order' => '0.00',
                    'website_url' => ''
                );
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
    public function updateSetting(Request $request){
        $userId = $this->user->id;
        $data = $request->only('isActiveWebsiteTemplate', 'fontColor', 'standardDeliveryCharge', 'minimumDeliveryCharge', 'freeDeliveryCharge');
        $appLanguage = trim($request->appLanguage);
        $isActiveWebsiteTemplate = trim($request->isActiveWebsiteTemplate);
        $standardDeliveryCharge = trim($request->standardDeliveryCharge);
        $minimumDeliveryCharge = trim($request->minimumDeliveryCharge);
        $freeDeliveryCharge = trim($request->freeDeliveryCharge);
        $crudData = array(
            'is_actv_mnu' => $isActiveWebsiteTemplate,
            'standard_delivery_charge' => $standardDeliveryCharge,
            'min_order_delivery_charge' => $minimumDeliveryCharge,
            'free_delivery_charge_order' => $freeDeliveryCharge,
            'updated_on' => getCurrentDateTime(),
            'updated_by' => $userId,
        );
        $where = array('id' => $userId);
        $responseUpdate = $this->objUser->updateUserSettingRecord($crudData,$where);
        if($responseUpdate){
            $this->message = __('api.common_update',['module'=> __('api.module_setting', [], $appLanguage)], $appLanguage);
        }else{
            $this->status = false;
            $this->message = __('api.common_update_error',['module'=> __('api.module_setting', [], $appLanguage)], $appLanguage);
        }

        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
        ], $this->statusCode);
    }
}
