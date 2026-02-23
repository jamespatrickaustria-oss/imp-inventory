<?php

namespace App\Services;

use App\Models\categories;
use Illuminate\Support\Str;

class CategoryService
{
    public function getAll($search = null, $includeArchived = false) {
        $query = categories::withCount('products');
        
        if (!$includeArchived) {
            $query->whereNull('deleted_at');
        }
        
        return $query->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('slug', 'like', "%{$search}%");
            })
            ->latest()
            ->get();
    }

    public function getAllCount() {
        return categories::whereNull('deleted_at')->count();
    }

    public function store(array $data) {
        $data['slug'] = Str::slug($data['name']);
        return categories::create($data);
    }

    public function update($id, array $data) {
        $category = categories::whereNull('deleted_at')->findOrFail($id);
        if(isset($data['name'])) $data['slug'] = Str::slug($data['name']);
        return $category->update($data);
    }

    public function delete($id) {
        $category = categories::whereNull('deleted_at')->findOrFail($id);
        if($category->products()->count() > 0) return false;
        return $category->delete();
    }

    public function archive($id) {
        $category = categories::whereNull('deleted_at')->findOrFail($id);
        if($category->products()->count() > 0) return false;
        return $category->delete();
    }

    public function restore($id) {
        return categories::withTrashed()->findOrFail($id)->restore();
    }

    public function permanentDelete($id) {
        $category = categories::withTrashed()->findOrFail($id);
        if($category->products()->count() > 0) return false;
        return $category->forceDelete();
    }

    public function getArchived($search = null) {
        return categories::onlyTrashed()
            ->withCount('products')
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('slug', 'like', "%{$search}%");
            })
            ->latest()
            ->get();
    }

    public function getCategoryWithProducts($id) {
        return categories::with('products')->findOrFail($id);
    }
}