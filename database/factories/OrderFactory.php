<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * Total diisi 0 dulu, nanti dihitung ulang dari order_items di seeder.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanggal = fake()->dateTimeBetween('-3 months');

        return [
            'user_id' => User::factory(),
            'address_id' => null,
            'invoice_number' => 'INV/' . $tanggal->format('Ymd') . '/' . fake()->unique()->numerify('#####'),
            'status' => fake()->randomElement(['pending', 'paid', 'shipped', 'completed', 'completed', 'completed', 'cancelled']),
            'total' => 0,
            'created_at' => $tanggal,
            'updated_at' => $tanggal,
        ];
    }
}
