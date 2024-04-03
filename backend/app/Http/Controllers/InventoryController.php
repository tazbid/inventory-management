<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryRequests\CreateInventoryRequest;
use App\Http\Requests\InventoryRequests\GetAllInventoriesRequest;
use App\Http\Requests\InventoryRequests\UpdateInventoryRequest;
use App\Http\Services\InventoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        //dependency injection
        $this->inventoryService = $inventoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\InventoryRequests\GetAllInventoriesRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(GetAllInventoriesRequest $request): JsonResponse {
        $page = $request->integer('page', 1);
        $perPage = $request->integer('perPage', 10);

        return $this->inventoryService->get($page, $perPage, auth()->user()->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $inventoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getById(int $inventoryId): JsonResponse {
        return $this->inventoryService->getById($inventoryId);
    }

    /**
     * Store a newly created resource in database.
     *
     * @param \App\Http\Requests\InventoryRequests\CreateInventoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateInventoryRequest $request): JsonResponse {
        $data = $request->json()->all();
        $data['user_id'] = auth()->user()->id;

        return $this->inventoryService->create($data);
    }

    /**
     * Update the specified resource in database.
     *
     * @param \App\Http\Requests\InventoryRequests\UpdateInventoryRequest $request, int $id
     * @param int $inventoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateInventoryRequest $request, int $inventoryId): JsonResponse {
        $data = $request->json()->all();

        return $this->inventoryService->update($inventoryId, $data);
    }

    /**
     * Remove the specified resource from database.
     *
     * @param int $inventoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $inventoryId): JsonResponse {
        return $this->inventoryService->delete($inventoryId);
    }
}
