<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'quantity' => fake()->numberBetween(1, 3),
            'price' => 0,
            'subtotal' => 0,
        ];
    }

    public function configure(): static
    {
        // harga & subtotal ngikutin harga produknya
        return $this->afterMaking(function (OrderItem $item) {
            if (! $item->price) {
                $item->price = Product::find($item->product_id)->price;
            }
            $item->subtotal = $item->price * $item->quantity;
        });
    }
}
