<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('guest');
        $this->userService = $userService;
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RegisterRequest $request)
    {
        $validate = $request->validated();
        $register = $this->userService->store($validate);

        if ($register){
            return response()->json([
                'success' => true,
                'message' => "registration was successful",
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => "registration failed",
            ],500);
        }
    }
}
