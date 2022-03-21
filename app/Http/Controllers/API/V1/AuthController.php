<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\RegisterRequest;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request['username'])
                ->orWhere('username', $request['username'])
                ->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['error' => 'Invalid Credentials'], 401);
            }
        } catch(Exception $e) {
            return response()->json(['error' => 'Could Not Create Token'], 500);
        }

        $token = $user->createToken('Token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'message' => 'Successfully logged in'
        ], 200);
    }

    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role_id = $request->role_id;
        $user->save();

        $user_info = null;

        if ($request->role_id === 1) {
            $user_info = new Admin();
            $user_info->is_verified = 0;
        } else {
            $user_info = new Customer();
        }

        $user_info->user_id = $user->id;
        $user_info->firstname = $request->firstname;
        $user_info->middlename = $request->middlename;
        $user_info->lastname = $request->lastname;
        $user_info->gender = $request->gender;
        $user_info->birthday = $request->birthday;
        $user_info->contact_no = $request->contact_no;
        $user_info->save();

        return response()->json([
            'status' => true,
            'message' => 'Successfully Registered.',
        ], 200);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out.',
        ], 200);
    }
}
