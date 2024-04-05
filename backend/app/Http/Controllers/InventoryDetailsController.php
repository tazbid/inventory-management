<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryDetailsRequests\CreateInventoryDetailsRequest;
use App\Http\Requests\InventoryDetailsRequests\GetInventoryDetailsRequest;
use App\Http\Requests\InventoryDetailsRequests\UpdateInventoryDetailsRequest;
use App\Http\Services\InventoryDetailsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InventoryDetailsController extends Controller
{
    //dependency injection
    protected $inventoryDetailsService;

    public function __construct(InventoryDetailsService $inventoryDetailsService)
    {
        $this->inventoryDetailsService = $inventoryDetailsService;
    }

    /**
     * Get inventory details
     *
     * @param int $inventoryId
     * @param \App\Http\Requests\InventoryDetailsRequests\GetInventoryDetailsRequest $request
     * @return JsonResponse
     */
    public function get(int $inventoryId, GetInventoryDetailsRequest $request): JsonResponse {
        $page = $request->integer('page', 1);
        $perPage = $request->integer('perPage', 10);
        return $this->inventoryDetailsService->get($inventoryId, $page, $perPage);
    }

    /**
     * Get inventory details by id
     *
     * @param int $inventoryId
     * @param int $inventoryDetailsId
     * @return JsonResponse
     */
    public function getById(int $inventoryId, int $inventoryDetailsId): JsonResponse {
        return $this->inventoryDetailsService->getById($inventoryDetailsId, $inventoryId);
    }

    /**
     * Create inventory details
     *
     * @param int $inventoryId
     * @param \App\Http\Requests\InventoryDetailsRequests\CreateInventoryDetailsRequest $request
     * @return JsonResponse
     */
    public function create(int $inventoryId, CreateInventoryDetailsRequest $request): JsonResponse {
        $data = $request->json()->all();
        $data['inventory_id'] = $inventoryId;
        return $this->inventoryDetailsService->create($data);
    }

    /**
     * update inventory details
     *
     * @param int $inventoryId
     * @param int $inventoryDetailsId
     * @param \App\Http\Requests\InventoryDetailsRequests\UpdateInventoryDetailsRequest $request
     * @return JsonResponse
     */
    public function update(int $inventoryId,int $inventoryDetailsId, UpdateInventoryDetailsRequest $request): JsonResponse {
        $data = $request->json()->all();
        return $this->inventoryDetailsService->update($data, $inventoryDetailsId, $inventoryId);
    }

    /**
     * delete inventory details
     *
     * @param int $inventoryId
     * @param int $inventoryDetailsId
     * @return JsonResponse
     */
    public function delete(int $inventoryId, int $inventoryDetailsId): JsonResponse {
        return $this->inventoryDetailsService->delete($inventoryDetailsId);
    }
}
