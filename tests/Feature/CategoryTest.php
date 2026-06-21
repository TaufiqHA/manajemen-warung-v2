<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Category;
use App\Models\Warung;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test untuk memastikan proses create data berhasil masuk database.
     */
    public function test_can_create_category_in_database(): void
    {
        // Buat dummy warung dulu untuk foreign key
        $warung = Warung::create([
            'name' => 'Warung Dummy'
        ]);

        // Data dummy untuk kategori
        $categoryData = [
            'warung_id' => $warung->id,
            'name' => 'Makanan Ringan',
            'order' => 1,
            'description' => 'Aneka snack',
            'icon' => 'fa-cookie',
        ];

        // Proses create
        $category = Category::create($categoryData);

        // Pastikan data masuk database
        $this->assertDatabaseHas('categories', [
            'name' => 'Makanan Ringan',
            'warung_id' => $warung->id
        ]);
        
        // Pastikan ada 1 data kategori di tabel
        $this->assertEquals(1, Category::count());
    }

    /**
     * Test untuk memastikan proses update data berhasil di database.
     */
    public function test_can_update_category_in_database(): void
    {
        $warung = Warung::create([
            'name' => 'Warung Dummy Update'
        ]);

        $category = Category::create([
            'warung_id' => $warung->id,
            'name' => 'Makanan Ringan',
            'order' => 1,
            'description' => 'Aneka snack',
            'icon' => 'fa-cookie',
        ]);

        $category->update([
            'name' => 'Makanan Berat',
            'order' => 2,
            'description' => 'Makanan mengenyangkan',
        ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Makanan Berat',
            'order' => 2,
            'description' => 'Makanan mengenyangkan',
        ]);

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
            'name' => 'Makanan Ringan',
        ]);
    }

    /**
     * Test untuk memastikan proses delete data berhasil di database.
     */
    public function test_can_delete_category_in_database(): void
    {
        $warung = Warung::create([
            'name' => 'Warung Dummy Delete'
        ]);

        $category = Category::create([
            'warung_id' => $warung->id,
            'name' => 'Minuman',
            'order' => 1,
        ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
        ]);

        $category->delete();

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}
