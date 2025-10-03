<?php

namespace App\Http\Servicses\Provider;

use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ServiceService
{
    /**
     * Get my services without pagination
     *
     * @param int $providerId
     * @return Collection
     */
    public function getMyServicesList(int $providerId): Collection
    {
        return Service::with('category')->where('provider_id', $providerId)->get();
    }

    /**
     * Get service by ID (for provider)
     *
     * @param int $id
     * @param int $providerId
     * @return Service
     */
    public function findByIdForProvider(int $id, int $providerId): Service
    {
        return Service::with('category')->where('provider_id', $providerId)->findOrFail($id);
    }

    /**
     * Create a new service
     *
     * @param array $data
     * @return Service
     */
    public function createService(array $data): Service
    {
        $payload = Arr::only($data, ['name','description','price','provider_id','category_id','status']);
        return Service::create($payload);
    }

    /**
     * Update existing service
     */
    public function updateService(int $id, array $data, int $providerId): Service
    {
        $service = $this->findByIdForProvider($id, $providerId);
        $payload = Arr::only($data, ['name','description','price','category_id','status']);
        $service->update($payload);
        return $service;
    }

    /**
     * Delete service
     */
    public function deleteService(int $id, int $providerId): bool
    {
        $service = $this->findByIdForProvider($id, $providerId);
        return (bool) $service->delete();
    }
}
