<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    /**
     * Kategori + produk. Nama dan harga ditulis manual biar realistis,
     * sisanya (deskripsi, stok, slug) diisi ProductFactory.
     */
    public function run(): void
    {
        $katalog = [
            'Elektronik' => [
                ['Mouse Wireless Logitech M331 Silent', 189000],
                ['Keyboard Mechanical Rexus Daxa M71', 459000],
                ['Headset Gaming Fantech HG11', 249000],
                ['Flashdisk SanDisk Ultra 64GB USB 3.0', 99000],
                ['Powerbank Anker PowerCore 10000mAh', 329000],
                ['Earphone TWS Xiaomi Redmi Buds 4 Lite', 279000],
                ['Webcam Logitech C270 HD 720p', 315000],
                ['Kabel Data USB Type-C Baseus 1m', 45000],
                ['Smartwatch Amazfit Bip 5', 1149000],
            ],
            'Fashion Pria' => [
                ['Kemeja Flanel Kotak Lengan Panjang', 129000],
                ['Kaos Polos Cotton Combed 30s', 49000],
                ['Celana Chino Slim Fit Cream', 159000],
                ['Jaket Hoodie Zipper Basic Hitam', 175000],
                ['Sepatu Sneakers Canvas Putih', 219000],
                ['Dompet Kulit Pria Lipat', 89000],
                ['Topi Baseball Polos Navy', 39000],
                ['Celana Jeans Pria Regular Fit', 199000],
            ],
            'Fashion Wanita' => [
                ['Blouse Wanita Lengan Balon', 119000],
                ['Rok Plisket Panjang Premium', 99000],
                ['Hijab Segi Empat Voal Motif', 55000],
                ['Tas Selempang Wanita Mini', 145000],
                ['Cardigan Rajut Oversize', 135000],
                ['Sandal Jepit Wanita Teplek', 59000],
                ['Gamis Rayon Polos Busui', 185000],
                ['Celana Kulot Highwaist', 89000],
            ],
            'Kesehatan & Kecantikan' => [
                ['Sunscreen Azarine Hydrasoothe SPF 45', 65000],
                ['Facial Wash Wardah Acnederm 60ml', 28000],
                ['Serum Somethinc Niacinamide 20ml', 99000],
                ['Lip Tint Emina Cheeklit Cream', 36000],
                ['Masker Medis 3 Ply isi 50', 25000],
                ['Hand Sanitizer Antis 300ml', 32000],
                ['Shampoo Pantene Anti Lepek 340ml', 54000],
                ['Vitamin C 1000mg isi 30 Tablet', 47000],
            ],
            'Rumah Tangga' => [
                ['Rice Cooker Miyako 1.8 Liter', 289000],
                ['Set Panci Stainless 5 in 1', 349000],
                ['Dispenser Galon Bawah Sanken', 1299000],
                ['Sprei Katun Motif 160x200', 179000],
                ['Rak Sepatu Susun 5 Tingkat', 115000],
                ['Lampu LED Philips 12 Watt', 42000],
                ['Botol Minum Tupperware 1 Liter', 85000],
                ['Kipas Angin Berdiri Cosmos 16 Inch', 325000],
            ],
            'Makanan & Minuman' => [
                ['Kopi Bubuk Arabika Gayo 250gr', 75000],
                ['Teh Hijau Celup isi 25', 18000],
                ['Keripik Pisang Lampung 500gr', 35000],
                ['Madu Hutan Asli 500ml', 95000],
                ['Sambal Bawang Bu Rudy 150gr', 45000],
                ['Granola Almond Cranberry 400gr', 69000],
                ['Mie Instan Goreng 1 Dus isi 40', 118000],
                ['Susu UHT Full Cream 1 Liter isi 12', 205000],
            ],
            'Olahraga' => [
                ['Matras Yoga TPE 6mm', 129000],
                ['Dumbbell Vinyl 2kg Sepasang', 99000],
                ['Sepatu Lari Ortuseight Hyperglide', 499000],
                ['Raket Badminton Li-Ning Turbo X', 389000],
                ['Bola Futsal Specs Accelerator', 245000],
                ['Botol Shaker Protein 600ml', 49000],
                ['Resistance Band Set 5 Level', 79000],
            ],
            'Buku & Alat Tulis' => [
                ['Buku Atomic Habits Edisi Indonesia', 108000],
                ['Pulpen Gel Kenko K-1 isi 12', 36000],
                ['Buku Tulis Sidu 38 Lembar isi 10', 42000],
                ['Stabilo Boss Original Set 4 Warna', 52000],
                ['Buku Laravel untuk Pemula', 125000],
                ['Kalkulator Casio FX-991ID Plus', 279000],
                ['Binder A5 Transparan 20 Ring', 45000],
            ],
        ];

        foreach ($katalog as $namaKategori => $produk) {
            $kategori = Category::create([
                'name' => $namaKategori,
                'slug' => Str::slug($namaKategori),
                'description' => 'Semua produk kategori ' . strtolower($namaKategori),
            ]);

            foreach ($produk as [$nama, $harga]) {
                Product::factory()->for($kategori)->create([
                    'name' => $nama,
                    'slug' => Str::slug($nama),
                    'price' => $harga,
                ]);
            }
        }
    }
}
