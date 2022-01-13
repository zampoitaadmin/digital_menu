<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use JWTAuth;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends ApiController
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
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('sso');

        //valid credential
        $validator = Validator::make($credentials, [
            'sso' => 'required'
        ]);

          /*

            */
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        /*$user = User::where('email', '=', $credentials['email'])->first();
        #dd($user );
        $jwt_token = JWTAuth::customClaims([])->fromUser($user);
        #_pre($jwt_token);
        //$jwt_token = JWTAuth::fromUser($user,$payloadable);
        return response()->json([
            'success' => true,
            #'data' => array('userData'=>$loginUserDetail),
            'data' => $user,
            'token' => @$jwt_token,
        ]);*/

        #_pre($credentials);
        //Request is validated
        //Crean token
        $token = '';
        try {
            $onjUserToken = new UserToken();
            $responseUserSSO = $onjUserToken->checkSSO($credentials['sso']);
            if($responseUserSSO){
                $responseUser = User::where('id', '=', $responseUserSSO->user_id)->first();
                if($responseUser){
                    $token = JWTAuth::customClaims([])->fromUser($responseUser);
                    //Token created, return with success response and jwt token
                    return response()->json([
                        'success' => true,
                        'token' => $token,
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => __('api.api_credentials_invalid'),
                    ], 400);
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => __('api.api_credentials_invalid'),
                ], 400);
            }
            /*if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }*/
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => __('api.common_error_500'),
            ], 500);
        }


    }

    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated, do logout
        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_user(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }

    public function getMenu(User $slug, $appLanguage='en'){
        _pre($slug);
    }
}