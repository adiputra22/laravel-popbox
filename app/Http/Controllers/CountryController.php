<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use JWTAuth;
use JWTAuthException;
use App\Country;

class CountryController extends Controller
{

    public function index(Request $request){
        $countries = Country::all();

        $response_message = "FAIL";
        $response_internal = "FAIL";
        $total_data = 0;
        $data = [];
        if(count($countries) > 0) {
            $response_message = "OK";
            $response_internal = "OK";
            $response_code = 200;
            $total_data = count($countries);
            
            $data = $countries;
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