<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = Auth::guard('tenant-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => Auth::guard('tenant-api')->factory()->getTTL() * 60,
            'user'         => Auth::guard('tenant-api')->user(),
        ]);
    }

    public function me()
    {
        return response()->json(Auth::guard('tenant-api')->user());
    }

    public function logout()
    {
        Auth::guard('tenant-api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
