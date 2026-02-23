<?php

namespace Database\Seeders;

use App\Services\InventoryService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CsvDataSeeder extends Seeder
{
    public $inventoryService;

   
    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

public function run(): void
{
    // Seeding Categories
    $categories = $this->parse(database_path('data/categories.csv'));
    foreach ($categories as $cat) {
        // Kan-choufo b-l-slug, ila makanch kan-creyiw
        $this->inventoryService->category->firstOrCreate(
            ['slug' => $cat['slug'] ?? \Illuminate\Support\Str::slug($cat['name'])],
            $cat
        );
    }

    // Seeding Products
    $products = $this->parse(database_path('data/products.csv'));
    foreach ($products as $prod) {
        // Kan-choufo b-l-name (awla sku ila 3ndek unique), ila makanch kan-creyiw
        $this->inventoryService->product->firstOrCreate(
            ['name' => $prod['name']], 
            $prod
        );
    }
}

  
    private function parse($path): array
    {
        if (!File::exists($path)) return [];
        
        $rows = str_getcsv(File::get($path), "\n");
        $header = str_getcsv(array_shift($rows), ",");
        $data = [];
        
        foreach ($rows as $row) {
            $data[] = array_combine($header, str_getcsv($row, ","));
        }
        
        return $data;
    }
}