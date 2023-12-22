<?php

namespace App\Http\Controllers;

use App\Events\UpdateState;
use Illuminate\Http\Request;
use App\Models\Req;
use Auth;

class ReqController extends Controller
{

    public function addReq(Request $request)
    {
        $request->validate([
            'products.*.id' => 'required|exists:medications,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);
        $price = 0;
        for ($i = 0; $i < count($request->products); $i++) {

            $price += $request->products[$i]["price"] * $request->products[$i]["quantity"];

        }
        $Phar = Auth::guard("api")->user();
        $req = $Phar->requests()->create([
            "phar_id" => $Phar->id,
            "price" => $price
        ]);

        foreach ($request->products as $productInfo) {

            $req->medications()->attach($productInfo["id"], [
                "quantity" => $productInfo["quantity"]
            ]);

        }
        return response()->json([
            "status" => true,
            "message" => "your order is saved ",
            "statusNumber" => 200

        ]);
    }

    public function showRequests()
    {

        $user = Auth::guard("api")->user();

        return response()->json([
            "status" => true,
            "message" => "done",
            "statusNumber" => 200,
            "requests" => $user->requests->makeHidden(["id", "phar_id"])
        ]);

    }

    public function allRequests()
    {

        $requests = Req::get();
        // return response()->json([
        //     "status" => true,
        //     "message" => "done",
        //     "statusNumber" => 200,
        //     "requests" =>$requests->makeHidden(["id","phar_id"])
        // ]);

        return view("table", compact("requests"));
    }


    public function changeState(Request $request)
    {

        $payment_state = array_filter($request->payment_state);
        $receive_state = array_filter($request->receive_state);
        foreach ($payment_state as $key => $pay) {

            Req::find($key)->update([
                "payment_state" => $payment_state[$key]
            ]);

        }

        foreach ($receive_state as $key => $rec) {

            $req = Req::find($key);
            $isUpdated = $req->isUpdated;

            if ($receive_state[$key] == "مستلمة" && !$isUpdated) {
                $req->update([
                    "isUpdated" => true,
                    "receive_state" => $receive_state[$key]
                ]);
                UpdateState::dispatch($req);
            }
            $req->update([
                "receive_state" => $receive_state[$key]
            ]);

        }
        return "data is updated ";
    }
}
