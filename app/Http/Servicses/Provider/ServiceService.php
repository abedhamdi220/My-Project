<?php

namespace App\Http\Servicses\Provider;

use Storage;
use App\Models\Service;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;

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
    public function getIndex($provider)
    {

        return $provider->services()->with('media', 'category')->latest()->paginate(10);
    }
    public function createService(array $data, $provider) {
        $service=$provider->services()->create($data);
        if(isset($data['image'])) {
            $file= $data['image'];
            $path= $file->store('services','public');
            $service->media()->create([
                'file_name'=> $file->getClientOriginalName(),
                'file_path'=> $path,
                'mime_type'=> $file->getMimeType(),
            ]);
        }
        return $service;
    }

    /**
     * Update existing service
     */
    public function updateService( Service $service,array $data): Service
    {
     $service->update($data);
        if(isset($data['image'])) {
            if($service->media()->exist()) {
              //  \Storage::disk('public')->delete($service->media()->first()->file_path);
            }

        }

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
