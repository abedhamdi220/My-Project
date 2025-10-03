<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Servicses\Admin\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of categories (Web Route)
     */
    public function index(Request $request)
    {
        // use dependency injected service to fetch paginated categories
        $categories = $this->categoryService->getAllCategoriesList();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category (Web Route)
     */
    public function create()
    {
        $parents = $this->categoryService->getParentCategories();
        return view('admin.categories.create', compact('parents'));
    }

    /**
     * Store a newly created category (Web Route)
     */
    public function store(CategoryStoreRequest $request)
    {
        DB::transaction(function () use ($request) {
            $this->categoryService->create($request->validated());
        });

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified category (Web Route)
     */
    public function show($id)
    {
        $category = $this->categoryService->findById((int)$id);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category (Web Route)
     */
    public function edit($id)
    {
        $category = $this->categoryService->findById((int)$id);
        $parents = $this->categoryService->getParentCategories();
        return view('admin.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified category (Web Route)
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $this->categoryService->update((int)$id, $request->validated());
        });

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category (Web Route)
     */
    public function destroy($id)
    {
        // prevent deleting if has children
        if ($this->categoryService->hasChildren((int)$id)) {
            return redirect()->route('categories.index')->with('error', 'Cannot delete category that has child categories.');
        }

        DB::transaction(function () use ($id) {
            $this->categoryService->delete((int)$id);
        });

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
