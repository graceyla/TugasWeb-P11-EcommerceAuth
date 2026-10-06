<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * Nama & harga yang realistis diisi dari ProductSeeder,
     * factory ini ngisi sisanya (slug, deskripsi, stok).
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'name' => ucwords($name),
            'description' => $this->deskripsi(),
            // harga dibulatkan ke ribuan biar kelihatan kayak harga toko beneran
            'price' => fake()->numberBetween(15, 2000) * 1000,
            'stock' => fake()->randomElement([0, 3, 5, 8, 12, 20, 35, 50, 75, 100]),
            'is_active' => fake()->boolean(92),
        ];
    }

    public function configure(): static
    {
        // slug dibuat dari nama + angka acak supaya ga bentrok kalau ada nama yang sama
        return $this->afterMaking(function (Product $product) {
            $product->slug ??= Str::slug($product->name) . '-' . Str::lower(Str::random(5));
        });
    }

    private function deskripsi(): string
    {
        $pembuka = fake()->randomElement([
            'Produk original dengan kualitas terjamin.',
            'Barang baru, segel, dan bergaransi resmi.',
            'Best seller di toko kami.',
            'Stok terbatas, cocok untuk kebutuhan sehari-hari.',
            'Kualitas premium dengan harga bersahabat.',
        ]);

        $tengah = fake()->randomElement([
            'Pengiriman dilakukan setiap hari kerja sebelum jam 15.00.',
            'Dikemas aman dengan bubble wrap tambahan.',
            'Bisa COD untuk area tertentu.',
            'Pembelian di atas 3 pcs dapat bonus kecil dari kami.',
        ]);

        return $pembuka . ' ' . $tengah . ' Silakan chat admin kalau ada pertanyaan sebelum membeli.';
    }
}
