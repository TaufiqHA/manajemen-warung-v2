<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_can_be_accessed()
    {
        $warung = \App\Models\Warung::factory()->create();
        $user = \App\Models\User::factory()->create(['warung_id' => $warung->id]);
        $response = $this->actingAs($user)->get('/products');
        
        $response->assertStatus(200);
        $response->assertViewIs('pages.product');
    }

    public function test_product_can_be_stored()
    {
        $warung = \App\Models\Warung::factory()->create(['id' => 1]); // Assuming Warung 1 exists since it's hardcoded for fallback
        $user = \App\Models\User::factory()->create(['warung_id' => $warung->id]);

        $response = $this->actingAs($user)->post('/products', [
            'name' => 'Produk Baru',
            'price' => 10000,
            'stock' => 50,
            'unit' => 'pcs'
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Produk Baru',
            'price' => 10000,
        ]);
    }

    public function test_product_can_be_updated()
    {
        $warung = \App\Models\Warung::factory()->create();
        $user = \App\Models\User::factory()->create(['warung_id' => $warung->id]);
        $product = \App\Models\Product::create([
            'warung_id' => $warung->id,
            'name' => 'Produk Lama',
            'price' => 5000,
        ]);

        $response = $this->actingAs($user)->put('/products/' . $product->id, [
            'name' => 'Produk Update',
            'price' => 15000,
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Produk Update',
            'price' => 15000,
        ]);
    }

    public function test_product_can_be_deleted()
    {
        $warung = \App\Models\Warung::factory()->create();
        $user = \App\Models\User::factory()->create(['warung_id' => $warung->id]);
        $product = \App\Models\Product::create([
            'warung_id' => $warung->id,
            'name' => 'Produk Akan Dihapus',
            'price' => 5000,
        ]);

        $response = $this->actingAs($user)->delete('/products/' . $product->id);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
