<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

/**
 * Bonus: demo perbedaan lazy loading (N+1) vs eager loading.
 * Data yang ditampilkan sama, yang beda jumlah query ke database.
 */
class EagerLoadingController extends Controller
{
    public function __invoke()
    {
        // 1. TANPA eager loading
        DB::flushQueryLog();
        DB::enableQueryLog();
        $mulai = microtime(true);

        $orders = Order::latest()->take(10)->get();
        foreach ($orders as $order) {
            $order->user->name;               // 1 query per order
            foreach ($order->items as $item) { // 1 query per order
                $item->product->name;          // 1 query per item
            }
        }

        $tanpa = [
            'jumlah' => count(DB::getQueryLog()),
            'waktu' => round((microtime(true) - $mulai) * 1000, 2),
            'query' => array_column(DB::getQueryLog(), 'query'),
        ];

        // 2. DENGAN eager loading
        DB::flushQueryLog();
        $mulai = microtime(true);

        $orders = Order::with(['user', 'items.product'])->latest()->take(10)->get();
        foreach ($orders as $order) {
            $order->user->name;
            foreach ($order->items as $item) {
                $item->product->name;
            }
        }

        $dengan = [
            'jumlah' => count(DB::getQueryLog()),
            'waktu' => round((microtime(true) - $mulai) * 1000, 2),
            'query' => array_column(DB::getQueryLog(), 'query'),
        ];

        DB::disableQueryLog();

        return view('eager-loading', compact('tanpa', 'dengan', 'orders'));
    }
}
