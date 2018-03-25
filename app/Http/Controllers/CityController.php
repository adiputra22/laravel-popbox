<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use JWTAuth;
use JWTAuthException;
use App\City;
use Validator;

class CityController extends Controller
{

    public function index(Request $request){
        $cities = City::all();

        $response_message = "FAIL";
        $response_internal = "FAIL";
        $total_data = 0;
        $data = [];
        if(count($cities) > 0) {
            $response_message = "OK";
            $response_internal = "OK";
            $response_code = 200;
            $total_data = count($cities);
            
            $data = $cities;
        }

        $response['response'] = [
            "code" => $response_code,
            "message" => $response_message,
            "message_internal" => $response_internal,
        ];
        $response['total_data'] = $total_data;
        $response['data'] = $data;

        return response()->json($response);
    }

    public function getBy(Request $request) {
        $validator = Validator::make($request->all(), [
            'province_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => [
                    'code' => '401',
                    'message' => $validator->errors()
                ]
            ]);
        } else {
            $cities = City::where('province_id', $request->province_id)->get();

            $response_message = "FAIL";
            $response_internal = "FAIL";
            $total_data = 0;
            $data = [];
            if(count($cities) > 0) {
                $response_message = "OK";
                $response_internal = "OK";
                $response_code = 200;
                $total_data = count($cities);
                
                $data = $cities;
            }

            $response['response'] = [
                "code" => $response_code,
                "message" => $response_message,
                "message_internal" => $response_internal,
            ];
            $response['total_data'] = $total_data;
            $response['data'] = $data;

            return response()->json($response);
        }
    }

}