<?php
namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use App\Services\ProductService;
use App\Services\CategoryService;

class Dashboard extends Component
{
    public function render(ProductService $productService, CategoryService $categoryService)
    {
        $totoalProducts = $productService->getAllCount();
        $totalLowstock = $productService->getLowStockCount();

        return view('livewire.pages.admin.dashboard', [
            'lowStockProducts'    => $productService->getLowStock(),
            'recentProducts'      => $productService->getAll(),
            'totoalProducts'      => $totoalProducts,
            'totalCategories'     => $categoryService->getAllCount(), // Assuming Service has this
            'totalLowstock'       => $totalLowstock,
            'getRevenue'          => $productService->getRevenue(),
            'PercentageItemstock' => $productService->calculateStockPercentage($totoalProducts, $totalLowstock)
        ])->layout('layouts.admin');
    }
}