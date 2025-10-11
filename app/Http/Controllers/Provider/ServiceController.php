<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ServiceResource;
use App\Http\Requests\ServiceUpdateRequest;
use App\Http\Servicses\Provider\ServiceService;
use App\Http\Requests\Provider\ServiceStoreRequest;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }
    public function index()
    {
        $provider = Auth::user();
        $services = $this->serviceService->getIndex($provider);
        return $this->success(ServiceResource::collection($services), 'your collection of services', 200);
    }
    public function store(ServiceStoreRequest $request)
    {
        $provider = Auth::user();
        $service = $this->serviceService->createService($request->validated(), $provider);
        return $this->success(new ServiceResource($service), 'service created successfully', 201);
    }

    public function show($id)
    {
        $providerId = Auth::id();
        $service = $this->serviceService->findByIdForProvider((int) $id, $providerId);
        return $this->success(new ServiceResource($service), 'service retrieved successfully', 200);
    }
    public function update(ServiceUpdateRequest $request, $id)
    {
        $providerId = Auth::id();
        $service = $this->serviceService->findByIdForProvider((int) $id, $providerId);
        $updated = $this->serviceService->updateService($service, $request->validated());
        return $this->success(new ServiceResource($service), 'service updated successfully', 200);
    }
    public function destroy($id){
        $providerId = Auth::id();
        DB::transaction(function () use ($id, $providerId) {
            $this->serviceService->deleteService((int)$id, $providerId);
        });
        return $this->success(null,'service deleted successfully',200);
    }
    }

