<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

class StorekeeperController extends Controller
{
    public function login(Request $request)
    {

        $validator = validator::make($request->all(), [
            "username" => "required ",
            "password" => "required"

        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors()->first(),
                "statusNumber" => 400
            ]);
        }

        $credentials = $request->only(["username", "password"]);
        if (Auth::attempt($credentials)) {
            return response()->json([
                "user" => Auth::user()->makeHidden("created_at")
            ]);
        }

        return response()->json([

            "status" => false
        ]);
    }

    public function logout()
    {

        Auth::logout();
        return response()->json([

            "status" => true,
            "message" => "you are logged-out seccessfully",
            "statusNember" => 200
        ]);


    }
}
