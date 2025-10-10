<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\ServiceStoreRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Http\Resources\ServiceResource;
use App\Http\Servicses\Provider\ServiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }


    public function index(Request $request)
    {
        $provider = Auth::id();
        $services = $this->serviceService->getIndex($provider);
        return $this->success(['data' => ServiceResource::collection($services)], 'Services retrieved successfully.');
    }


    public function store(ServiceStoreRequest $request)
    {
        $provider = Auth::user();
        $service = $this->serviceService->createService( $request->validated(),$provider);
        return $this->success(new ServiceResource($service), 'Service created successfully.', 201);
    }

    public function show($id)
    {
        $providerId = Auth::id();
        $service = $this->serviceService->findByIdForProvider((int)$id, $providerId);
        return $this->success(new ServiceResource($service), 'Service retrieved successfully.');
    }


    public function update(ServiceUpdateRequest $request, $id)
    {
        

        //return $this->success(new ServiceResource(), 'Service updated successfully.');
    }


    public function destroy($id)
    {
        $providerId = Auth::id();

        DB::transaction(function () use ($id, $providerId) {
            $this->serviceService->deleteService((int)$id, $providerId);
        });

        return $this->success(null, 'Service deleted successfully.');
    }
}
