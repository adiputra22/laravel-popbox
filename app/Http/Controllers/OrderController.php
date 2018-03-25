<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use JWTAuth;
use JWTAuthException;
use App\Order;
use Validator;

class OrderController extends Controller
{

    public function save(Request $request) {
        $validator = Validator::make($request->all(), [
            'delivery_type' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => [
                    'code' => '401',
                    'message' => $validator->errors()
                ]
            ]);
        } else {
            $user = JWTAuth::toUser($request->token);        
            
            $order = new Order();
            
            # reference code?
            $order->reference = date("dmy-") . rand(0,99999);

            # develiry_type:
            # PLA: Origin Locker -> Destination Address
            # PAL: Origin Address -> Destination Locker
            # PLL: Origin Locker -> Destionation Locker (locker to locker)
            $order->delivery_type = $request->delivery_type;
            
            $order->origin_id = $request->origin_id; # bisa locker id atau address_id (user_addreses)
            $order->origin_name = $request->origin_name; # bisa locker name atau address name (user_addreses)
            $order->origin_address = $request->origin_address; # bisa locker address atau address (user_addreses)
            $order->destination_id = $request->destination_id; # bisa locker id atau address_id (user_addreses)
            $order->destination = $request->destination; # bisa locker name atau address name (user_addreses)
            $order->user_id = $user->id;
            $order->contact = $user->phone;
            $order->status = "OPEN";
            $order->notes = $request->notes;
            $order->save();

            return response()->json([
                'response' => [
                    'code' => '200',
                    'message' => "OK"
                ],
                'data' => [
                    'order_id' => $order->id,
                    'reference' => $order->reference
                ]
            ]);
        }
    }

    public function detail(Request $request) {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => [
                    'code' => '401',
                    'message' => $validator->errors()
                ]
            ]);
        } else {
            $user = JWTAuth::toUser($request->token);        
            $order = Order::where('user_id', $user->id)
                        ->where('id', $request->order_id)
                        ->first();

            return response()->json([
                'response' => [
                    'code' => '200',
                    'message' => $validator->errors()
                ],
                'data' => $order
            ]);
        }
    }

    public function history(Request $request) {
        $user = JWTAuth::toUser($request->token);        
        $order = Order::where('user_id', $user->id)->get();
        
        return response()->json([
            'response' => [
                'code' => '200',
                'message' => "OK"
            ],
            'total_data' => count($order),
            'data' => $order
        ]);
    }
}