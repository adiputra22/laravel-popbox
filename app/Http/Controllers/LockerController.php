<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use JWTAuth;
use JWTAuthException;
use App\Locker;
use Validator;

class LockerController extends Controller
{

    public function index(Request $request){
        $lockers = Locker::all();

        $response_message = "FAIL";
        $response_internal = "FAIL";
        $total_data = 0;
        $data = [];
        if(count($lockers) > 0) {
            $response_message = "OK";
            $response_internal = "OK";
            $response_code = 200;
            $total_data = count($lockers);
            
            $data = $lockers;
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

    public function getByCity(Request $request) {
        $validator = Validator::make($request->all(), [
            'city_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => [
                    'code' => '401',
                    'message' => $validator->errors()
                ]
            ]);
        } else {
            $lockers = Locker::where('city_id', $request->city_id)->get();

            $response_message = "FAIL";
            $response_internal = "FAIL";
            $total_data = 0;
            $data = [];
            if(count($lockers) > 0) {
                $response_message = "OK";
                $response_internal = "OK";
                $response_code = 200;
                $total_data = count($lockers);
                
                $data = $lockers;
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

    public function getByPosition(Request $request) {
        $validator = Validator::make($request->all(), [
            'longitude' => 'required',
            'latitude' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => [
                    'code' => '401',
                    'message' => $validator->errors()
                ]
            ]);
        } else {
            // longitude dan latitude diambil dari current location gps device
            // harusnya query lokasi terdekat
            $lockers = Locker::where('longitude', $request->longitude)
                        ->where('latitude', $request->latitude)
                        ->get();

            $response_message = "FAIL";
            $response_internal = "FAIL";
            $total_data = 0;
            $data = [];
            if(count($lockers) > 0) {
                $response_message = "OK";
                $response_internal = "OK";
                $response_code = 200;
                $total_data = count($lockers);
                
                $data = $lockers;
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