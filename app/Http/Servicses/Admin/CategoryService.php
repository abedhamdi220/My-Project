<?php

namespace App\Http\Servicses\Admin;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CategoryService
{
  
    public function getAllCategoriesList(): Collection
    {
       
        return Category::with('parent')->withCount(['children', 'services'])->get();
    }


     

     
    public function getAllCategoriesWithParent(): Collection
    {
        return Category::with('parent')->get();
    }

  
    public function findById(int $id): Category
    {
        return Category::with(['parent', 'children'])
                       ->withCount(['children', 'services'])
                       ->findOrFail($id);
    }

    public function create(array $data): Category
    {
        // Allow passing parent_id as null or integer and include description
        $payload = Arr::only($data, ['name', 'parent_id', 'description']);
        return Category::create($payload);
    }

  
    public function update(int $id, array $data): Category
    {
        $category = Category::findOrFail($id);
        $payload = Arr::only($data, ['name', 'parent_id', 'description']);
        $category->update($payload);
        return $category;
    }

    public function delete(int $id): bool
    {
        $category = Category::findOrFail($id);
        return (bool) $category->delete();
    }

  
    public function getParentCategories(): Collection
    {
        return Category::whereNull('parent_id')->get();
    }

    
    public function hasChildren(int $id): bool
    {
        return Category::where('parent_id', $id)->exists();
    }

    /**
     * Get categories for API with ordering, filtering, and search
     *
     * @param array $params
     * @return LengthAwarePaginator
    



    
     * Get categories for API with ordering, filtering, and search
     *
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function getForApi(array $params = []): LengthAwarePaginator
    {
        $perPage = isset($params['per_page']) ? (int)$params['per_page'] : 10;
        $orderBy = $params['order_by'] ?? 'id';
        $orderDirection = in_array(strtolower($params['order_direction'] ?? 'desc'), ['asc','desc']) ? $params['order_direction'] : 'desc';

        $query = Category::query()->with(['parent', 'children']);

        if (isset($params['parent_id']) && $params['parent_id'] !== '') {
            $query->where('parent_id', $params['parent_id']);
        }

        if (!empty($params['search'])) {
            $q = $params['search'];
            $query->where('name', 'like', "%{$q}%");
        }

        $query->orderBy($orderBy, $orderDirection);

        return $query->paginate($perPage);
    }
}
