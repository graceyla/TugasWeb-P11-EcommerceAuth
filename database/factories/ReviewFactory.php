<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // kebanyakan review bagus, sesekali ada yang jelek biar realistis
        $rating = fake()->randomElement([5, 5, 5, 4, 4, 4, 3, 2]);

        $komentar = [
            5 => ['Barang sesuai deskripsi, pengiriman cepat. Mantap!', 'Kualitas oke banget, bakal order lagi.', 'Packing rapi, seller ramah. Recommended!', 'Original, harga bersaing. Puas banget.'],
            4 => ['Barang bagus, cuma pengirimannya agak lama.', 'Sesuai harga, overall puas.', 'Bagus, tapi warnanya sedikit beda dari foto.'],
            3 => ['Lumayan, sesuai harga lah.', 'Biasa aja, tidak terlalu spesial.'],
            2 => ['Kurang sesuai ekspektasi, kemasan agak penyok.', 'Pengiriman lama banget, barangnya sih oke.'],
        ];

        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'rating' => $rating,
            'comment' => fake()->randomElement($komentar[$rating]),
        ];
    }
}
