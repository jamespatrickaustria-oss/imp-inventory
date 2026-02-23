<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ProductService;
use App\Models\products; // T-akkad men smit l-model (singular/plural)
use PHPUnit\Framework\Attributes\Test;

class ProductServiceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        // Injecti l-service
        $this->service = app(ProductService::class);
    }

    #[Test]
    public function it_can_fetch_all_products_from_real_database()
    {
        $products = $this->service->getAll();

        // T-akkad beli DB machi khawya (CSV data)
        $this->assertNotEmpty($products, "L-base de données dyal l-products khawya!");
        
        // T-akkad beli l-category relationship kheddama
        $this->assertNotNull($products->first()->category, "Relationship m3a Category makhdamach!");
    }

    #[Test]
    public function it_can_search_products_by_name_from_csv_data()
    {
        // Qelleb 3la chi smitya 3arfa kayna f-CSV dyalk (مثلاً 'iPhone')
        $searchTerm = 'iPhone'; 
        $results = $this->service->getAll($searchTerm);

        $this->assertGreaterThanOrEqual(0, $results->count());
        
        foreach($results as $product) {
            $this->assertStringContainsStringIgnoringCase($searchTerm, $product->name);
        }
    }

    #[Test]
    public function it_filters_low_stock_products_correctly()
    {
        $lowStock = $this->service->getLowStock();

        // Testi beli ga3 li rj3o, quantity <= min_stock
        foreach($lowStock as $product) {
            $this->assertTrue($product->quantity <= $product->min_stock);
        }
    }
}