<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\CreateRequest;
use App\Http\Requests\Orders\UpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(title="API", version="1.0.0")
 */
class OrdersController extends Controller
{
    use ResponseTrait;

    const PER_PAGE = 10;

    /**
     * Get orders list
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/v1/orders",
     *     summary="Get orders list",
     *     description="Get orders list",
     *     operationId="list",
     *     tags={"Orders"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         ref="#/components/schemas/OrderResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * );
     */
    public function index(
        OrderService $service,
        $page = 1,
        $perPage = self::PER_PAGE,
    ): JsonResponse {
        return $this->responseOk(OrderResource::collection($service->getList($page, $perPage)));
    }

    /**
     * Create order
     *
     * @return JsonResponse
     * @OA\Post(
     *     path="/api/v1/orders",
     *     summary="Create order",
     *     description="Create order",
     *     operationId="create-order",
     *     tags={"Orders"},
     *
     *     @OA\Parameter(
     *         in="query",
     *         name="count",
     *         required=true,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Created"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable entity"
     *     )
     * )
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $order = Order::create($request->validated());

        return $this->responseCreated(new OrderResource($order));
    }

    /**
     * Get order
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/v1/orders/{ORDER_ID}",
     *     summary="Get order",
     *     description="Get order",
     *     operationId="get-order",
     *     tags={"Orders"},
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
     *         @OA\JsonContent(ref="#/components/schemas/OrdersOrderResource"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function show(Order $order): JsonResponse
    {
        return $this->responseOk(new OrderResource($order));
    }

    /**
     * Update order
     *
     * @return JsonResponse
     * @OA\Put(
     *     path="/api/v1/orders/{ID}",
     *     summary="Update order",
     *     description="Update order",
     *     operationId="update-order",
     *     tags={"Orders"},
     *
     *     @OA\SecurityScheme(
     *         securityScheme="Bearer",
     *         type="apiKey",
     *         name="Authorization",
     *         in="header"
     *     ),
     *
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="count",
     *         required=false,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     ),
     * )
     */
    public function update(
        Order $order,
        UpdateRequest $request,
    ): JsonResponse {
        $order->update($request->validated());

        return $this->responseOk(new OrderResource($order));
    }

    /**
     * Delete order
     *
     * @return JsonResponse
     * @OA\Delete(
     *     path="/api/v1/orders/{ORDER_ID}",
     *     summary="Delete order",
     *     description="Delete order",
     *     operationId="delete-order",
     *     tags={"Orders"},
     *
     *     @OA\SecurityScheme(
     *         securityScheme="Bearer",
     *         type="apiKey",
     *         name="Authorization",
     *         in="header"
     *     ),
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
     *         description="Successfully deleted",
     *         @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/OrdersOrderResource"
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function delete(Order $order): JsonResponse
    {
        $order->delete();

        return $this->responseNoContent();
    }

}
