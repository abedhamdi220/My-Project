<?php

namespace App\Http\Servicses\Client;

use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ServiceService
{
    /**
     * Get all active services without pagination
     *
     * @return Collection
     */
    public function getAllActiveServicesList(): Collection
    {
        return Service::with(['provider','category'])->where('status','active')->get();
    }

    /**
     * Get active services for clients with pagination and filters
     */
    public function getForClient(array $params = [])
    {
        $perPage = isset($params['per_page']) ? (int)$params['per_page'] : 10;
        $query = Service::with(['provider','category'])->where('status','active');

        if (!empty($params['category_id'])) {
            $query->where('category_id', $params['category_id']);
        }

        if (!empty($params['provider_id'])) {
            $query->where('provider_id', $params['provider_id']);
        }

        if (!empty($params['search'])) {
            $q = $params['search'];
            $query->where('name','like',"%{$q}%")->orWhere('description','like',"%{$q}%");
        }

        $orderBy = $params['order_by'] ?? 'id';
        $direction = $params['order_direction'] ?? 'desc';
        $query->orderBy($orderBy, $direction);

        return $query->paginate($perPage);
    }

    /**
     * Get service by ID (only active services)
     *
     * @param int $id
     * @return Service
     */
    public function getActiveServiceById(int $id): Service
    {
        return Service::with(['provider','category'])->where('status','active')->findOrFail($id);
    }

}
