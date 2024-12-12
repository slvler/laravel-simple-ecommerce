<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class LogoutController extends Controller
{
    public function __construct()
    {}

    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json([
            'success' => true,
            'message' => "exit was successful",
        ], 200);
    }
}
