<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Medication;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function addMedicine(Request $request)
    {

        $validator = validator::make($request->all(), [

            "scientific_name" => "unique:medications| required",
            "commercial_name" => "unique:medications| required",
            "cat" => "required",
            "manufacturer" => "required",
            "quantity" => "required | numeric |integer",
            "expire_date" => "required|date",
            "price" => "required|numeric |min:1"

        ]);

        if ($validator->fails()) {

            return response()->json([

                "status" => false,
                "message" => $validator->errors()->first(),
                "statusNumber" => 400

            ]);
        }

        Medication::create([
            "scientific_name" => $request->scientific_name,
            "commercial_name" => $request->commercial_name,
            "cat" => $request->cat,
            "manufacturer" => $request->manufacturer,
            "quantity" => $request->quantity,
            "expire_date" => $request->expire_date,
            "price" => $request->price

        ]);
        return response()->json([

            "status" => true,
            "message" => "your data is saved",
            "statusNumber" => 200

        ]);

    }

    public function browseMedications()
    {

        $medicines = Medication::get()->groupBy("cat");
        return response()->json([

            "status" => true,
            "message" => "done",
            "statusNumber" => 200,
            "medicines" => $medicines

        ]);

    }

    public function search(Request $request)
    {

        $key = $request->key;

        $med = Medication::where("cat", "LIKE", "%$key%")
            ->orwhere("commercial_name", "LIKE", "%$key%")
            ->orwhere("scientific_name", "LIKE", "%$key%")->get();
        if ($med) {
            return response()->json([

                "status" => true,
                "message" => "done",
                "statusNumber" => 200,
                "medicines" => $med->makeHidden(["expire_date", "quantity", "manufacturer", "commercial_name"])

            ]);
        }

        return response()->json([

            "status" => false,
            "message" => "Oops",
            "statusNumber" => 400
        ]);
    }

    public function showDetails($id)
    {

        $med = Medication::find($id);
        if ($med) {
            return response()->json([
                "status" => true,
                "message" => "done",
                "statusNumber" => 200,
                "details" => $med
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => "Oops",
            "statusNumber" => 400,

        ]);
    }
}
