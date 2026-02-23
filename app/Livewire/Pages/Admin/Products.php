<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Services\ProductService;
use App\Services\CategoryService;

class Products extends Component
{
    use WithPagination, WithFileUploads;
    
    public $search = '';
    public $showArchived = false;
    
    // Form properties
    public $editingId = null;
    
    public function toggleArchived()
    {
        $this->showArchived = !$this->showArchived;
        $this->resetPage();
    }
    public $name = '';
    public $sku = '';
    public $category_id = '';
    public $price = '';
    public $quantity = '';
    public $min_stock = '';
    public $image = null;
    public $existingImage = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'sku' => 'required|string|unique:products,sku',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'min_stock' => 'required|integer|min:0',
        'image' => 'nullable|image|max:2048',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->name = '';
        $this->sku = '';
        $this->category_id = '';
        $this->price = '';
        $this->quantity = '';
        $this->min_stock = '';
        $this->image = null;
        $this->existingImage = null;
        $this->resetValidation();
    }

    public function editProduct($id, ProductService $productService)
    {
        $product = \App\Models\products::findOrFail($id);
        
        $this->editingId = $product->id;
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->category_id = $product->category_id;
        $this->price = $product->price;
        $this->quantity = $product->quantity;
        $this->min_stock = $product->min_stock;
        $this->existingImage = $product->image_path;
    }

    public function store(ProductService $productService)
    {
        if ($this->editingId) {
            $this->rules['sku'] = 'required|string|unique:products,sku,' . $this->editingId;
        }
        
        $this->validate();

        $data = [
            'name' => $this->name,
            'sku' => $this->sku,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'min_stock' => $this->min_stock,
        ];

        // Handle image upload
        if ($this->image) {
            $imagePath = $this->image->store('products', 'public');
            $data['image_path'] = $imagePath;
        }

        if ($this->editingId) {
            $productService->update($this->editingId, $data);
            session()->flash('success', 'Product updated successfully.');
        } else {
            $productService->store($data);
            session()->flash('success', 'Product created successfully.');
        }

        $this->resetForm();
        $this->dispatch('closeModal');
    }

    public function deleteProduct($id, ProductService $productService)
    {
        $productService->archive($id);
        session()->flash('success', 'Product archived successfully.');
    }

    public function archiveProduct($id, ProductService $productService)
    {
        $productService->archive($id);
        session()->flash('success', 'Product archived successfully.');
    }

    public function restoreProduct($id, ProductService $productService)
    {
        $productService->restore($id);
        session()->flash('success', 'Product restored successfully.');
    }

    public function permanentDeleteProduct($id, ProductService $productService)
    {
        $productService->permanentDelete($id);
        session()->flash('success', 'Product permanently deleted.');
    }

    public function removeImage()
    {
        $this->image = null;
        $this->image_path = null;
        $this->existingImage = null;
    }

    public function render(ProductService $productService, CategoryService $categoryService)
    {
        if ($this->showArchived) {
            $products = $productService->getArchived($this->search);
        } else {
            $products = $productService->getAll($this->search);
        }
        
        $categories = $categoryService->getAll();
        
        return view('livewire.pages.admin.product-index', compact('products', 'categories'))->layout('layouts.admin'); 
    }
}

