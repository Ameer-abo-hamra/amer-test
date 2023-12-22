<?php

namespace App\Http\Controllers;

use App\Models\Phar;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Illuminate\Support\Facades\Config;

use Hash;
use Auth;
use JWT;

class PharController extends Controller
{
    public function register(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [

                "username" => "unique:Phars,username|| max:12 ||min:4 || required",
                "password" => "min:8 ||max:15 || required",
                "phone_number" => "required|digits:10 | unique:Phars"
            ]);

            if ($validator->fails()) {

                return response()->json([
                    "status" => false,
                    "message" => $validator->errors()->first(),
                    "statusNumber" => 400
                ]);
            }

            Phar::create([

                "username" => $request->username,
                "password" => Hash::make($request->password),
                "phone_number" => $request->phone_number

            ]);

            return response()->json([
                "status" => true,
                "message" => " your data is saved succussfully",
                "statusNumber" => 200
            ]);
        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "statusNumber" => 400

            ]);
        }
    }

    public function login(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [

                "phone_number" => "required | digits:10",
                "password" => "required| min:8 | max:15"
            ]);


            if ($validator->failed()) {
                return response()->json([
                    "status" => false,
                    "message" => $validator->errors()->first(),
                    "statusNumber" => 400
                ]);
            }

            $credentials = $request->only(["phone_number", "password"]);

            if ($token = Auth::guard('api')->attempt($credentials)) {


                $user = Auth::guard("api")->user();
                $user->token = $token;
                return response()->json([
                    "status" => true,
                    "message" => "you are logged-in succussfully",
                    "statusNumber" => 200,
                    "data" => $user
                ]);
            }
            return response()->json([

                "status" => false,
                "message" => "your data is invalid",
                "satusNumber" => 400
            ]);

        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "statusNumber" => 400

            ]);
        }

    }
    public function logout(Request $request)
    {

            // $user = Auth::guard("api")->user();
            // return $user;
        try {
            $token = $request->bearerToken();
            if ($token) {
                $jwtAuth = JWTAuth::setToken($token);

                $jwtAuth->invalidate();

                return response()->json([
                    'status' => true,
                    'message' => "you are logged-out ",
                    "statusNumber" => 200
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => "smth wrong",
                "statusNumber" => 400
            ]);
        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "statusNumber" => 400

            ]);
        }
    }


}
