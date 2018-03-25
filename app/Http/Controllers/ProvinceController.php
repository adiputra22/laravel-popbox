<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use JWTAuth;
use JWTAuthException;
use App\Province;
use Validator;

class ProvinceController extends Controller
{

    public function index(Request $request){
        $provinces = Province::all();

        $response_message = "FAIL";
        $response_internal = "FAIL";
        $total_data = 0;
        $data = [];
        if(count($provinces) > 0) {
            $response_message = "OK";
            $response_internal = "OK";
            $response_code = 200;
            $total_data = count($provinces);
            
            $data = $provinces;
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

    public function getByCountry(Request $request) {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => [
                    'code' => '401',
                    'message' => $validator->errors()
                ]
            ]);
        } else {
            $provinces = Province::where('country_id', $request->country_id)->get();

            $response_message = "FAIL";
            $response_internal = "FAIL";
            $total_data = 0;
            $data = [];
            if(count($provinces) > 0) {
                $response_message = "OK";
                $response_internal = "OK";
                $response_code = 200;
                $total_data = count($provinces);
                
                $data = $provinces;
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