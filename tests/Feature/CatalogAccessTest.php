<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_customers_cannot_open_catalog_administration(): void
    {
        $customer = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($customer)->get(route('products.index'));

        $response->assertRedirect(route('home'));
    }

    public function test_administrators_can_open_catalog_administration(): void
    {
        $administrator = User::factory()->create(['role' => 'admin']);

        $this->actingAs($administrator)
            ->get(route('products.index'))
            ->assertOk();

        $this->actingAs($administrator)
            ->get(route('categories.index'))
            ->assertOk();
    }
}
