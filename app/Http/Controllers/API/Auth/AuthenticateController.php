<?php

namespace App\Http\Controllers\API\AUTH;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
{
    private  $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function login(LoginRequest $request)
    {
        try {

            $user = $this->userRepository->findByEmail($request->email);;
            if ($user) {

                if (!Hash::check($request->password, $user->password)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'These credentials do not match our records.',
                    ], 401);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'User logged in successfully',
                    'data' => ['token' => $user->createToken('auth_token', ['*'], now()->addMinutes(262800))->plainTextToken,],
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'These credentials do not match our records.',
            ], 401);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'something went wrong!'/*$th->getMessage()*/
            ], 500);
        }
    }

    public function logout()
    {
        $this->userRepository->logout();
        try {
            return response()->json([
                'status' => true,
                'message' => 'User logged out successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'something went wrong!'/*$th->getMessage()*/
            ], 500);
        }
    }
}
