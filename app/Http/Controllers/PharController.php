<?php

namespace App\Http\Controllers;

use App\Models\Phar;
use Illuminate\Http\Request;
use Validator;
use Hash;

class PharController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [

            "username" => "unique:Phars,username|| max:12 ||min:4 || required",
            "password" => "min:8 ||max:15 || required",
            "phone_number" => "required|digits:10"
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
    }

    public function login(Request $request)
    {

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


    }
}
