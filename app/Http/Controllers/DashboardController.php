<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Isi dashboard beda-beda tergantung role yang login.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $statistik = match ($user->role) {
            User::ROLE_ADMIN => [
                'Total User' => User::count(),
                'Produk Aktif' => Product::active()->count(),
                'Total Pesanan' => Order::count(),
                'Artikel' => Post::count(),
            ],
            User::ROLE_EDITOR => [
                'Artikel Saya' => $user->posts()->count(),
                'Sudah Publish' => $user->posts()->published()->count(),
                'Draft' => $user->posts()->where('is_published', false)->count(),
            ],
            default => [
                'Pesanan Saya' => $user->orders()->count(),
                'Pesanan Selesai' => $user->orders()->status('completed')->count(),
                'Alamat Tersimpan' => $user->addresses()->count(),
            ],
        };

        return view('dashboard', compact('statistik'));
    }
}
