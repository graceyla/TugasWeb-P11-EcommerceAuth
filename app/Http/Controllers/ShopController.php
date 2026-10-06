<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->query('q');
        $kategoriAktif = $request->query('kategori');

        $categories = Category::withCount(['products' => fn ($q) => $q->active()])
            ->orderBy('name')
            ->get();

        $products = Product::active()
            ->with('category') // eager loading, biar ga N+1
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->search($keyword)
            ->when($kategoriAktif, fn ($q) => $q->whereRelation('category', 'slug', $kategoriAktif))
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('shop.index', compact('products', 'categories', 'keyword', 'kategoriAktif'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $product->load(['category', 'reviews' => fn ($q) => $q->with('user')->latest()]);

        $terkait = Product::active()
            ->with('category')
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'terkait'));
    }
}
