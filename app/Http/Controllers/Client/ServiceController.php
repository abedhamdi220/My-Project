<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Http\Servicses\Client\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index(Request $request)
    {
        $services = $this->serviceService->getForClient($request->all());
        return $this->success(['data' => ServiceResource::collection($services)], 'Services retrieved successfully.');
    }

 
    public function show($id)
    {
        $service = $this->serviceService->getActiveServiceById((int)$id);
        return $this->success(new ServiceResource($service), 'Service retrieved successfully.');
    }

  
    public function byCategory(Request $request, $categoryId)
    {
        $params = array_merge($request->all(), ['category_id' => $categoryId]);
        $services = $this->serviceService->getForClient($params);
        return $this->success(['data' => ServiceResource::collection($services)], 'Services retrieved successfully.');
    }

    
    public function byProvider(Request $request, $providerId)
    {
        $params = array_merge($request->all(), ['provider_id' => $providerId]);
        $services = $this->serviceService->getForClient($params);
        return $this->success(['data' => ServiceResource::collection($services)], 'Services retrieved successfully.');
    }
}
