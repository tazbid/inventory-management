<?php

//inventory service
namespace App\Http\Services;

use App\Models\InventoryModel;
use App\Traits\ApiResponderTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class InventoryService {
    use ApiResponderTrait;
    /**
     * Get all inventories
     *
     * @param int $page, int $perPage, int $authUserId
     * @return JsonResponse
     * @throws \Exception
     */
    public function get(int $page, int $perPage, int $authUserId): JsonResponse
    {
        try{
            $inventories = InventoryModel::where('user_id', $authUserId)->paginate($perPage, ['*'], 'page', $page);

            if($inventories->isEmpty())
                return $this->successResponse(data: $inventories, message: 'No inventories found', code: Response::HTTP_NO_CONTENT);

            return $this->successResponse(data: $inventories, message: 'Inventories retrieved successfully', code: Response::HTTP_OK);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get inventory by inventoryId
     *
     * @param int $inventoryId
     * @return JsonResponse
     * @throws \Exception
     */
    public function getById(int $inventoryId): JsonResponse {
        try {
            $inventory = InventoryModel::with('inventoryDetails:id,inventory_id,name,description,quantity')
            ->findOrFail($inventoryId);

            return $this->successResponse(data: $inventory, message: 'Inventory retrieved successfully', code: Response::HTTP_OK);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Create inventory
     *
     * @param array $data
     * @return JsonResponse
     * @throws \Exception
     */
    public function create(array $data): JsonResponse {
        try {
            $inventory = InventoryModel::create($data);

            return $this->successResponse(data: $inventory, message: 'Inventory created successfully', code: Response::HTTP_CREATED);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update inventory
     *
     * @param int $inventoryId, array $data
     * @return JsonResponse
     * @throws \Exception
     */
    public function update(int $inventoryId, array $data): JsonResponse {
        try {
            $inventory = InventoryModel::findOrFail($inventoryId);
            $inventory->update($data);

            return $this->successResponse(data: $inventory, message: 'Inventory updated successfully', code: Response::HTTP_OK);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete inventory
     *
     * @param int $inventoryId
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(int $inventoryId): JsonResponse {
        try {
            DB::beginTransaction();

            $inventory = InventoryModel::findOrFail($inventoryId);
            $inventory->inventoryDetails()->delete();
            $inventory->delete();

            DB::commit();

            return $this->successResponse(message: 'Inventory deleted successfully', code: Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
