<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $user = Auth::where('email', $request->email)->first();
        if ($user || Hash::check('password', $request->password)) {
            return $user->createToken($request->email)->plainTextToken;
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        return $this->sendResponse($success, 'User login successfully.');
    }
}
