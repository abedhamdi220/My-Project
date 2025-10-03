<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\ServiceStoreRequest;
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

    /**
     * List provider's services (API)
     */
    public function index(Request $request)
    {
        $providerId = Auth::id();
        $services = $this->serviceService->getMyServicesList($providerId);
        return $this->success(['data' => ServiceResource::collection($services)], 'Services retrieved successfully.');
    }

    /**
     * Store a new service (API)
     */
    public function store(ServiceStoreRequest $request)
    {
        $providerId = Auth::id();
    $data = array_merge($request->validated(), ['provider_id' => $providerId]);

    $service = DB::transaction(function () use ($data) {
        return app(ServiceService::class)->createService($data);
    });

    return $this->success(new ServiceResource($service), 'Service created successfully.', 201);
    }
    /**
     * Show single service (API) - provider's own
     */
    public function show($id)
    {
        $providerId = Auth::id();
        $service = $this->serviceService->findByIdForProvider((int)$id, $providerId);
        return $this->success(new ServiceResource($service), 'Service retrieved successfully.');
    }

    /**
     * Update service (API)
     */
    public function update(ServiceStoreRequest $request, $id)
    {
        $providerId = Auth::id();
        $service = null;
        DB::transaction(function () use (&$service, $id, $request, $providerId) {
            $service = app(ServiceService::class)->updateService((int)$id, $request->validated(), $providerId);
        });
        return $this->success(new ServiceResource($service), 'Service updated successfully.');
    }

    /**
     * Delete service (API)
     */
    public function destroy($id)
    {
        $providerId = Auth::id();
        DB::transaction(function () use ($id, $providerId) {
            app(ServiceService::class)->deleteService((int)$id, $providerId);
        });
        return $this->success(null, 'Service deleted successfully.');
    }

}
