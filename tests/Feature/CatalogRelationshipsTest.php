<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_belong_to_a_category(): void
    {
        $category = Category::create([
            'name' => 'Outerwear',
            'image' => 'categories/outerwear.webp',
        ]);

        $product = Product::create([
            'name' => 'Maestro Jacket',
            'price' => 749000,
            'description' => 'A catalog fixture for relationship coverage.',
            'image' => 'products/maestro-jacket.webp',
            'category_id' => $category->id,
        ]);

        $this->assertTrue($product->category->is($category));
        $this->assertTrue($category->products->contains($product));
    }
}
