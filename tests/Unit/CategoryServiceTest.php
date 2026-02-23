<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CategoryService;
use PHPUnit\Framework\Attributes\Test; // <--- Zid hada

class CategoryServiceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(CategoryService::class);
    }

   #[Test]
    public function it_can_access_real_categories_from_database()
    {
        $categories = app(CategoryService::class)->getAll();
        $this->assertNotEmpty($categories);
    }

    #[Test]
    public function it_calculates_product_counts_from_real_data()
    {
        $categories = $this->service->getAll();
        foreach($categories as $category) {
            $this->assertIsInt($category->products_count);
        }
    }
}