<?php

namespace App\Http\Servicses\Provider;

use App\Http\Servicses\Global\MediaService;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class ServiceService
{
protected $MediaService;
    public function __construct(MediaService $service){
$this->MediaService = $service;
    }
    public function getIndex($provider)
    {
        return $provider->services()
            ->with(["media", 'category'])
            ->latest()->paginate(10);
    }
    public function createService(array $data, $provider)
    {
        $service = $provider->services()->create($data);
        if (isset($data['image'])) {
            $this->MediaService->storeMedia($service, $data['image'],'services');
        }
        return $service->load(['media', 'category']);
    }
    public function updateService(Service $service, array $data)
    {
        $service->update($data);
        if (isset($data['image'])) {
           $this->MediaService->updateMedia($service, $data['image'],'services');
        }
        return $service->load(['media', 'category']);
    }
    public function deleteService(int $id, int $providerId)
    {
        $service = $this->findByIdForProvider($id, $providerId);
        $this->MediaService->deleteOldMedia($service);
        return (bool)$service->delete();
    }
    public function findByIdForProvider(int $id, int $providerId)
    {
        return Service::with(['media', 'category'])
            ->where('provider_id', $providerId)->findOrFail($id);
    }
    // protected function storeMedia(Service $service, $file)
    // {
    //     $path = $file->store('services', 'public');
    //     $service->media()->create([
    //         'file_name' => $file->getProviderOriginalName(),
    //         'file_path' => $path,
    //         'mime_type' => $file->getMimeType(),
    //     ]);
    // }
    // protected function deleteOldMedia(Service $service)
    // {
    //     $oldMedia = $service->media()->first();
    //     if ($oldMedia) {
    //         Storage::disk('public')->delete($oldMedia->file_path);
    //         $oldMedia->delete();
    //     }
    
}
