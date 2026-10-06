<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Order + item + review dari pembeli.
     */
    public function run(): void
    {
        $produk = Product::active()->get();

        User::where('role', User::ROLE_USER)->with('addresses')->each(function (User $user) use ($produk) {
            $jumlahOrder = fake()->numberBetween(1, 4);

            for ($i = 0; $i < $jumlahOrder; $i++) {
                $order = Order::factory()->for($user)->create([
                    'address_id' => $user->addresses->firstWhere('is_default', true)?->id,
                ]);

                // 1-4 produk berbeda per order
                foreach ($produk->random(fake()->numberBetween(1, 4)) as $p) {
                    OrderItem::factory()->for($order)->create([
                        'product_id' => $p->id,
                        'price' => $p->price,
                    ]);
                }

                $order->update(['total' => $order->items()->sum('subtotal')]);

                // pembeli kasih review kalau pesanannya sudah selesai
                if ($order->status === 'completed') {
                    foreach ($order->items as $item) {
                        $kunci = ['user_id' => $user->id, 'product_id' => $item->product_id];

                        Review::firstOrCreate($kunci, Review::factory()->make($kunci)->only(['rating', 'comment']));
                    }
                }
            }
        });
    }
}
