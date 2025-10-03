<?php

namespace App\Http\Servicses\Admin;

use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class ServiceService
{
    
    public function getAllServicesList(): Collection
    {
        return Service::with(['provider','category'])->get();
    }

    /**
     * Get all services for admin with pagination and filters
     *
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function getForAdmin(array $params = []): LengthAwarePaginator
    {
        $perPage = isset($params['per_page']) ? (int)$params['per_page'] : 10;
        $query = Service::with(['provider','category']);

        if (!empty($params['search'])) {
            $q = $params['search'];
            $query->where('name','like',"%{$q}%")->orWhere('description','like',"%{$q}%");
        }

        if (!empty($params['category_id'])) {
            $query->where('category_id', $params['category_id']);
        }

        if (!empty($params['provider_id'])) {
            $query->where('provider_id', $params['provider_id']);
        }

        $orderBy = $params['order_by'] ?? 'id';
        $direction = $params['order_direction'] ?? 'desc';
        $query->orderBy($orderBy, $direction);

        return $query->paginate($perPage);
    }

    /**
     * Get service by ID with relationships
     *
     * @param int $id
     * @return Service
     */
    public function findById(int $id): Service
    {
        return Service::with(['provider','category'])->findOrFail($id);
    }

    /**
     * Update service status
     *
     * @param int $id
     * @param string $status
     * @return Service
     */
    public function updateStatus(int $id, string $status): Service
    {
        $service = Service::findOrFail($id);
        $service->status = $status;
        $service->save();
        return $service;
    }
}
