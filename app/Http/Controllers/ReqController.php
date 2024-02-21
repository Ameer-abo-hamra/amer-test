<?php

namespace App\Http\Controllers;

use App\Events\UpdateState;
use Illuminate\Http\Request;
use App\Models\Req;
use Auth;
use Illuminate\Support\Carbon;

class ReqController extends Controller
{

    public function addReq(Request $request)
    {
        $request->validate([
            'products.*.id' => 'required|exists:medications,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:1',
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
        if ($requests) {
            return response()->json([
                "status" => true,
                "message" => "done",
                "statusNumber" => 200,
                "requests" => $requests->makeHidden(["id", "phar_id", "isUpdated"])
            ]);

        }
        return response()->json([
            "status" => false,
            "message" => "there are no requests yet ",
            "statusNumber" => 400
        ]);

    }


    public function changeState(Request $request)
    {

        $requests_ids = $request->requests_ids;
        $payment_state = $request->payment_state;
        $receive_state = $request->receive_state;
        foreach ($requests_ids as $key => $request_id) {
            $req = Req::find($request_id);
            $isUpdated = $req->isUpdated;
            $req->update([
                "payment_state" => $payment_state[$key],
                "receive_state" => $receive_state[$key]
            ]);
            if ($receive_state[$key] == "received" && !$isUpdated) {
                $req->update([
                    "isUpdated" => true,
                ]);
                UpdateState::dispatch($req);
            }

        }

        return response()->json([
            "status" => true,
            "message" => "data is updated "
            ,
            "statusNumber" => 200
        ]);
    }

    public function paymentsReport()
    {
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays(14);
        $requests = Req::where("payment_state", "paid")->whereBetween("created_at", ["$startDate", "$endDate"])->get();

        if (count($requests)) {
            $income = 0;
            foreach ($requests as $request) {

                $income += $request->price;
            }
            return response()->json([
                "status" => true,
                "statusNumber" => 200,
                "incoming" => $income
            ]);
        }
        return response()->json([
            "status" => false,
            "statusNumber" => 400,
            "message" => "there are no payments yet"
        ]);
    }

    public function requestOwner($id)
    {

        $req = Req::find($id);
        return $req->pharmacist->makeVisible("created_at");

    }
}
