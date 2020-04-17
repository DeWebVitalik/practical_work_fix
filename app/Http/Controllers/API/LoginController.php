<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ApiLoginRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public $successStatus = 200;

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ApiLoginRequest $request)
    {
        if ($authToken = $this->auth($request)) {
            $success['token'] = $authToken;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * Authorization and generation access token
     * @param ApiLoginRequest $request
     * @return string
     */
    protected function auth(ApiLoginRequest $request): string
    {
        $auth = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if (!$auth) {
            return false;
        }
        $user = Auth::user();

        return $user->createToken('LaravelDrive')->accessToken;
    }

}