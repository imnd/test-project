<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(title="API", version="1.0.0")
 */
class UsersController extends Controller
{
    use ResponseTrait;

    const PER_PAGE = 10;

    public function __construct(private UserService $service)
    {
    }

    /**
     * Get users list
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/v1/users",
     *     summary="Get users list",
     *     description="Get users list",
     *     operationId="list",
     *     tags={"Users"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         ref="#/components/schemas/UserResource")
     *     ),
     * );
     */
    public function index(
        $page = 1,
        $perPage = self::PER_PAGE,
    ): JsonResponse {
        return $this->responseOk([
            UserResource::collection($this->service->getList($page, $perPage)),
        ]);
    }

    /**
     * Get user
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/v1/users/{ORDER_ID}",
     *     summary="Get user",
     *     description="Get user",
     *     operationId="get-user",
     *     tags={"Users"},
     *
     *     @OA\Parameter(
     *         in="path",
     *         name="ORDER_ID",
     *         required=true,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/UsersUserResource"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function show(User $user): JsonResponse
    {
        return $this->responseOk(new UserResource($user));
    }
}
