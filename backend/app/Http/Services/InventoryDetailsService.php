<?php

namespace App\Http\Services;

use App\Models\InventoryDetailsModel;
use App\Traits\ApiResponderTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class InventoryDetailsService {
    use ApiResponderTrait;

    /**
     * Get inventory details
     *
     * @param int $inventoryId, int $page, int $perPage
     * @return JsonResponse
     */
    public function get(int $inventoryId, int $page, int $perPage): JsonResponse {
        try {
            $inventory = InventoryDetailsModel::where('inventory_id', $inventoryId)->paginate($perPage, ['*'], 'page', $page);

            if ($inventory->isEmpty())
                return $this->successResponse(data: $inventory, message: 'No inventory details found', code: Response::HTTP_NO_CONTENT);

            return $this->successResponse(data: $inventory, message: 'Inventory details retrieved successfully', code: Response::HTTP_OK);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get inventory details by id
     *
     * @param int $inventoryDetailsId
     * @return JsonResponse
     */
    public function getById(int $inventoryDetailsId): JsonResponse {
        try {
            $inventory = InventoryDetailsModel::findOrFail($inventoryDetailsId);

            return $this->successResponse(data: $inventory, message: 'Inventory details retrieved successfully', code: Response::HTTP_OK);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Create inventory details
     *
     * @param array $data
     * @return JsonResponse
     */
    public function create(array $data): JsonResponse {
        try {
            $inventory = InventoryDetailsModel::create($data);

            return $this->successResponse(data: $inventory, message: 'Inventory details created successfully', code: Response::HTTP_CREATED);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update inventory details
     *
     * @param array $data
     * @param int $inventoryDetailsId
     * @return JsonResponse
     */
    public function update(array $data, int $inventoryDetailsId): JsonResponse {
        try {
            $inventoryDetails = InventoryDetailsModel::findOrFail($inventoryDetailsId);
            $inventoryDetails->update($data);

            return $this->successResponse(data: $inventoryDetails, message: 'Inventory details updated successfully', code: Response::HTTP_OK);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete inventory details
     *
     * @param int $inventoryDetails
     * @return JsonResponse
     */
    public function delete(int $inventoryDetails): JsonResponse {
        try {
            InventoryDetailsModel::findOrFail($inventoryDetails)->delete();

            return $this->successResponse(message: 'Inventory details deleted successfully', code: Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
