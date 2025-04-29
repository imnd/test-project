<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ResponseTrait;

    /**
     * Register new user
     *
     * @return JsonResponse
     * @OA\Post(
     *     path="/api/v1/auth/register",
     *     summary="Register user",
     *     description="Register new user",
     *     operationId="register",
     *     tags={"Auth"},
     *
     *     @OA\Parameter(
     *         in="query",
     *         name="email",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="password",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Created"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable entity"
     *     )
     * )
     */
    public function register(
        RegisterRequest $request,
        UserService $userService,
    ): JsonResponse {
        $data = $request->validated();
        if ($user = $userService->find($data)) {
            $user->restore();
            $userService->update($user, $request->all(['name', 'email']));
        } elseif (!$user = $userService->create($data)) {
            return $this->responseBadRequest();
        }

        return $this->responseCreated(['token' => $user->getToken()]);
    }


    /**
     * User login
     *
     * @return JsonResponse
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     summary="User login",
     *     description="User login",
     *     operationId="login",
     *     tags={"Auth"},
     *
     *     @OA\Parameter(
     *         in="query",
     *         name="email",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="password",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *               @OA\Property(
     *                   property="user",
     *                   type="User",
     *               ),
     *               @OA\Property(
     *                   property="authorization",
     *                   type="object",
     *                   @OA\Property(
     *                       property="token",
     *                       type="string",
     *                       example="7335bd7759da1195a0c2b38a9cb1606270bf848b1c7d1ca2297479b32f935599",
     *                   ),
     *                   @OA\Property(
     *                       property="type",
     *                       type="string",
     *                       example="bearer",
     *                   )
     *               )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable entity"
     *     )
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->responseUnauthorized('Invalid email or password');
        }

        return $this->responseOk(['token' => Auth::user()->getToken()]);
    }

    /**
     * User logout
     *
     * @return JsonResponse
     * @OA\Post(
     *     path="/api/v1/users/logout",
     *     summary="User logout",
     *     description="User logout",
     *     operationId="logout",
     *     tags={"Auth"},
     *
     *     @OA\SecurityScheme(
     *         securityScheme="Bearer",
     *         type="apiKey",
     *         name="Authorization",
     *         in="header"
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Successfully logged out",
     *              ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();
        Auth::guard('web')->logout();

        return $this->responseOk([
            'message' => 'Successfully logged out',
        ]);
    }

    /**
     * Refresh token
     *
     * @return JsonResponse
     * @OA\Post(
     *     path="/api/v1/user/refresh",
     *     summary="Refresh token",
     *     description="Refresh token",
     *     operationId="refresh",
     *     tags={"Auth"},
     *
     *     @OA\SecurityScheme(
     *         securityScheme="Bearer",
     *         type="apiKey",
     *         name="Authorization",
     *         in="header"
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                 property="token",
     *                 type="string",
     *                 example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vYm91cWV0L2FwaS92MS91c2Vycy9tZS9zZXNzaW9uIiwiaWF0IjoxNzEwOTAzOTgyLCJleHAiOjE3MTA5MDc1ODIsIm5iZiI6MTcxMDkwMzk4MiwianRpIjoiNXduZ3ZzMUp1ZVA2WDcwaiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.Wci1wDugk51QydQRgcBR9XHJ5j6OkjSMmZ7eSkZUGt0",
     *              ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function refresh(): JsonResponse
    {
        return $this->responseOk([
            'token' => Auth::refresh(),
        ]);
    }
}
