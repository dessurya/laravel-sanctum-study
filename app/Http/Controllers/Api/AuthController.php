<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    public function allUsers()
    {
        return response()->json([
            'res' => true,
            'result' => [
                'User' => User::orderBy('email','ASC')->paginate(25),
            ]
        ]);
    }

    public function userMe()
    {
        $akses = [
            [ "label" => "LF-E011 SPAREPART", "url" => "/lfe011" ],
            [ "label" => "LF-E016 OLI", "url" => "/lfe016" ],
            [ "label" => "LF-B011 CO", "url" => "/lfb011" ]
        ];
        $akses = [
            'user' => true, 'lfb011' => true, 'lfe011' => false
        ];
        return response()->json([
            'res' => true,
            'user' => [
                'user' => User::find(auth('sanctum')->user()->id),
                'akses' => $akses
            ]
        ]);
    }

    public function FeedUser()
    {
        $user = User::create([
            'name' => 'Adam Surya Des',
            'email' => 'fourline66@gmail.com',
            'password' =>  'asdasd'
        ]);

        return response()->json([
            'res' => true,
            'result' => [
                'User' => User::find($user->id)
            ]
        ]);
    }

    public function TokenCreate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            $err = ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
            return response()->json([
                'res' => false,
                'err' => $err
            ],401);
        }

        $token = $user->createToken($request->email)->plainTextToken;

        Auth::loginUsingId($user->id);

        return response()->json([
            'res' => true,
            'result' => [
                'user' => $user, 
                'token' => $token,
                'token_type' => 'bearer'
            ]
        ]);
    }

    public function TokenDestroy(Request $request)
    {
        auth('sanctum')->user()->tokens()->delete();
        return response()->json([
            'res' => true,
            'msg' => 'success logout!'
        ]);
    }

    public function TokenRefresh(Request $request)
    {
        $user_auth_id = auth('sanctum')->user()->id;
        auth('sanctum')->user()->tokens()->delete();
        $user = User::find($user_auth_id);
        $token = $user->createToken($user->email)->plainTextToken;
        return response()->json([
            'res' => true,
            'result' => [
                'user' => $user, 
                'token' => $token,
                'token_type' => 'bearer'
            ]
        ]);
    }
}
