<?php

namespace App\Services;

use App\Models\categories;
use App\Models\products;
use Illuminate\Database\Eloquent\Collection;

class InventoryService
{
    public $product;
    public $category;
   public function __construct(products $product , categories $category){
        $this->product = $product;
        $this->category = $category;
   }


   public function listAllProducts(){
        $products = $this->product->with('categories')->get();
        return $products;
   }
}