<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Commodities\CreateRequest;
use App\Http\Requests\Commodities\UpdateRequest;
use App\Http\Resources\CommodityResource;
use App\Models\Commodity;
use App\Services\CommodityService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(title="API", version="1.0.0")
 */
class CommoditiesController extends Controller
{
    use ResponseTrait;

    const PER_PAGE = 10;

    /**
     * Get commodities list
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/v1/commodities",
     *     summary="Get commodities list",
     *     description="Get commodities list",
     *     operationId="list",
     *     tags={"Commodities"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         ref="#/components/schemas/CommodityResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * );
     */
    public function index(
        CommodityService $service,
        $page = 1,
        $perPage = self::PER_PAGE,
    ): JsonResponse {
        return $this->responseOk(CommodityResource::collection($service->getList($page, $perPage)));
    }

    /**
     * Create commodity
     *
     * @return JsonResponse
     * @OA\Post(
     *     path="/api/v1/commodities",
     *     summary="Create commodity",
     *     description="Create commodity",
     *     operationId="create-commodity",
     *     tags={"Commodities"},
     *
     *     @OA\Parameter(
     *         in="query",
     *         name="name",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="description",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="price",
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
        $commodity = Commodity::create($request->validated());

        return $this->responseCreated(new CommodityResource($commodity));
    }

    /**
     * Get commodity
     *
     * @return JsonResponse
     * @OA\Get(
     *     path="/api/v1/commodities/{COMMODITY_ID}",
     *     summary="Get commodity",
     *     description="Get commodity",
     *     operationId="get-commodity",
     *     tags={"Commodities"},
     *
     *     @OA\Parameter(
     *         in="path",
     *         name="COMMODITY_ID",
     *         required=true,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/CommoditiesCommodityResource"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function show(Commodity $commodity): JsonResponse
    {
        return $this->responseOk(new CommodityResource($commodity));
    }

    /**
     * Update commodity
     *
     * @return JsonResponse
     * @OA\Put(
     *     path="/api/v1/commodities/{ID}",
     *     summary="Update commodity",
     *     description="Update commodity",
     *     operationId="update-commodity",
     *     tags={"Commodities"},
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
     *         name="name",
     *         required=false,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="description",
     *         required=false,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="price",
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
        Commodity $commodity,
        UpdateRequest $request,
    ): JsonResponse {
        $commodity->update($request->validated());

        return $this->responseOk(new CommodityResource($commodity));
    }

    /**
     * Delete commodity
     *
     * @return JsonResponse
     * @OA\Delete(
     *     path="/api/v1/commodities/{COMMODITY_ID}",
     *     summary="Delete commodity",
     *     description="Delete commodity",
     *     operationId="delete-commodity",
     *     tags={"Commodities"},
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
     *         name="COMMODITY_ID",
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
     *              ref="#/components/schemas/CommoditiesCommodityResource"
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
    public function delete(Commodity $commodity): JsonResponse
    {
        $commodity->delete();

        return $this->responseNoContent();
    }
}
