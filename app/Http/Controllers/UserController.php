<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use JWTAuth;
use JWTAuthException;
use App\User;
use Validator;
use Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->user = new User;
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => [
                    'code' => '401',
                    'message' => $validator->errors()
                ]
            ]);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'response' => [
                    'code' => '200',
                    'message' => 'OK'
                ],
                'token' => $token
            ]);
        }
    }
    
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required'
        ]);
            
        $phone = $request->phone;
        $password = $request->password;
        
        $user = User::where('phone', $phone)->first();
        $token = null;
        
        if(count($user) > 0) {
            $email = $user->email;
            $credentials = ['email'=> $user->email, 'password'=>$request->password];
            
            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json([
                        'response' => [
                            'code' => '402',
                            'message' => "Invalid user"
                        ],
                    ]);
                }
            } catch (JWTAuthException $e) {
                return response()->json([
                    'response' => [
                        'code' => '402',
                        'message' => "Error"
                    ],
                ]);
            }

            return response()->json([
                'response' => [
                    'code' => '200',
                    'message' => "OK"
                ],
                'data' => [
                    'token' => $token,
                ],
            ]);

        } else {
            return response()->json([
                'response' => [
                    'code' => '404',
                    'message' => "Not found"
                ],
            ]);
        }

    }

}