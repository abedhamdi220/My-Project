<?php

namespace App\Http\Servicses\Admin;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CategoryService
{
    /**
     * Get all categories without pagination
     *
     * @return Collection
     */
    public function getAllCategoriesList(): Collection
    {
        $categories = Category::withCount("children")->get();
        return $categories;
   
    }

    /**
     * Get all categories with parent relation
     *
     * @return Collection
     */
    public function getAllCategoriesWithParent(): Collection
    {
        return Category::with('parent')->get();
    }

    /**
     * Get category by ID with relationships
     *
     * @param int $id
     * @return Category
     */
    public function findById(int $id): Category
    {
        return Category::with(['parent', 'children'])->findOrFail($id);
    }

    /**
     * Create a new category
     *
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category
    {
        // Allow passing parent_id as null or integer
        $payload = Arr::only($data, ['name', 'parent_id']);
        return Category::create($payload);
    }

    /**
     * Update an existing category
     *
     * @param int $id
     * @param array $data
     * @return Category
     */
    public function update(int $id, array $data): Category
    {
        $category = Category::findOrFail($id);
        $payload = Arr::only($data, ['name', 'parent_id']);
        $category->update($payload);
        return $category;
    }

    /**
     * Delete a category
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $category = Category::findOrFail($id);
        return (bool) $category->delete();
    }

    /**
     * Get parent categories (categories without parent)
     *
     * @return Collection
     */
    public function getParentCategories(): Collection
    {
        return Category::whereNull('parent_id')->get();
    }

    /**
     * Check if category has children
     *
     * @param int $id
     * @return bool
     */
    public function hasChildren(int $id): bool
    {
        return Category::where('parent_id', $id)->exists();
    }

    /**
     * Get categories for API with ordering, filtering, and search
     *
     * @param array $params
     * @return LengthAwarePaginator
     */
    // public function getForApi(array $params = []): LengthAwarePaginator
    // {
    //     $perPage = isset($params['per_page']) ? (int)$params['per_page'] : 10;
    //     $orderBy = $params['order_by'] ?? 'id';
    //     $orderDirection = in_array(strtolower($params['order_direction'] ?? 'desc'), ['asc','desc']) ? $params['order_direction'] : 'desc';

    //     $query = Category::query()->with(['parent', 'children']);

    //     if (isset($params['parent_id']) && $params['parent_id'] !== '') {
    //         $query->where('parent_id', $params['parent_id']);
    //     }

    //     if (!empty($params['search'])) {
    //         $q = $params['search'];
    //         $query->where('name', 'like', "%{$q}%");
    //     }

    //     $query->orderBy($orderBy, $orderDirection);

    //     return $query->paginate($perPage);
    // }
}
