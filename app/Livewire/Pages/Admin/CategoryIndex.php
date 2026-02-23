<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Services\CategoryService;
use App\Models\categories;
use Illuminate\Support\Str;

class CategoryIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $showArchived = false;
    public $name = '';
    
    public function toggleArchived()
    {
        $this->showArchived = !$this->showArchived;
        $this->resetPage();
    }
    public $slug = '';
    public $description = '';
    public $image_path = '';
    public $editingId = null;
    public $viewingCategoryId = null;
    public $viewingCategoryProducts = [];
    public $image = null;
    public $existingImage = null;

    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'slug' => 'required|string|unique:categories,slug' . ($this->editingId ? ',' . $this->editingId : ''),
            'image' => 'nullable|image|max:2048',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->reset(['name', 'slug', 'description', 'image_path', 'editingId', 'image', 'existingImage']);
        $this->resetValidation();
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function editCategory($id)
    {
        $category = categories::find($id);
        if ($category) {
            $this->editingId = $id;
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->description = $category->description ?? '';
            $this->image_path = $category->image_path ?? '';
            $this->existingImage = $category->image_path;
        }
    }

    public function store(CategoryService $categoryService)
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image_path' => $this->image_path,
        ];

        // Handle image upload
        if ($this->image) {
            $imagePath = $this->image->store('categories', 'public');
            $data['image_path'] = $imagePath;
        }

        if ($this->editingId) {
            $categoryService->update($this->editingId, $data);
            session()->flash('success', 'Category updated successfully!');
        } else {
            $categoryService->store($data);
            session()->flash('success', 'Category created successfully!');
        }

        $this->resetForm();
    }

    public function deleteCategory($id, CategoryService $categoryService)
    {
        $result = $categoryService->archive($id);
        if ($result) {
            session()->flash('success', 'Category archived successfully!');
        } else {
            session()->flash('error', 'Cannot archive category with products!');
        }
    }

    public function archiveCategory($id, CategoryService $categoryService)
    {
        $result = $categoryService->archive($id);
        if ($result) {
            session()->flash('success', 'Category archived successfully!');
        } else {
            session()->flash('error', 'Cannot archive category with products!');
        }
    }

    public function restoreCategory($id, CategoryService $categoryService)
    {
        $categoryService->restore($id);
        session()->flash('success', 'Category restored successfully!');
    }

    public function permanentDeleteCategory($id, CategoryService $categoryService)
    {
        $result = $categoryService->permanentDelete($id);
        if ($result) {
            session()->flash('success', 'Category permanently deleted!');
        } else {
            session()->flash('error', 'Cannot delete category with products!');
        }
    }

    public function viewCategory($id, CategoryService $categoryService)
    {
        $category = $categoryService->getCategoryWithProducts($id);
        $this->viewingCategoryId = $id;
        $this->viewingCategoryProducts = $category->products->toArray();
    }

    public function closeViewModal()
    {
        $this->viewingCategoryId = null;
        $this->viewingCategoryProducts = [];
    }

    public function removeImage()
    {
        $this->image = null;
        $this->image_path = null;
        $this->existingImage = null;
    }

    public function render(CategoryService $categoryService)
    {
        if ($this->showArchived) {
            $categories = $categoryService->getArchived($this->search);
        } else {
            $categories = $categoryService->getAll($this->search);
        }
        
        return view('livewire.pages.admin.category-index', compact('categories'))->layout('layouts.admin');
    }
}

