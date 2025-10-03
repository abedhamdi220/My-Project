<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Servicses\Admin\ServiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    /**
     * Display a listing of services (Web Route)
     */
    public function index(Request $request)
    {
        $services = $this->serviceService->getForAdmin($request->all());
        return view('admin.services.index', compact('services'));
    }

    /**
     * Display the specified service (Web Route)
     */
    public function show($id)
    {
        $service = $this->serviceService->findById((int)$id);
        return view('admin.services.show', compact('service'));
    }

    /**
     * Update service status (Web Route)
     */
    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status', 'inactive');
        DB::transaction(function () use ($id, $status) {
            $this->serviceService->updateStatus((int)$id, $status);
        });

        return redirect()->back()->with('success', 'Service status updated.');
    }
}
