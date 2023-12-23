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
        if ($validator->failed()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors()->first(),
                "statusNumber" => 400
            ]);
        }

        $credentials = $request->only(["username", "password"]);
        if($token = Auth::attempt($credentials)){
            return  Auth::user()->makeHidden("created_at");
        }
    }

    public function logout() {

      Auth::logout();

      return redirect()->to("/");

    }
}
