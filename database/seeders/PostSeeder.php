<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Artikel / info toko, ditulis admin dan editor.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@tokokita.test')->first();
        $editor1 = User::where('email', 'editor@tokokita.test')->first();
        $editor2 = User::where('email', 'editor2@tokokita.test')->first();

        $artikel = [
            [$admin, 'Selamat Datang di TokoKita!', "TokoKita adalah toko online yang menjual berbagai kebutuhan sehari-hari, mulai dari elektronik, fashion, sampai makanan.\n\nSemua produk yang kami jual dijamin original. Selamat berbelanja!"],
            [$admin, 'Jadwal Pengiriman Selama Libur Nasional', "Selama libur nasional, pesanan yang masuk tetap kami proses tapi pengiriman baru dilakukan di hari kerja berikutnya.\n\nMohon maaf atas ketidaknyamanannya."],
            [$editor1, 'Tips Memilih Mouse Wireless untuk Kuliah', "Kalau sering ngetik tugas di kampus, pilih mouse wireless yang silent supaya tidak mengganggu orang lain.\n\nPerhatikan juga daya tahan baterainya, minimal bisa dipakai beberapa bulan."],
            [$editor1, 'Promo Akhir Bulan: Diskon Kategori Fashion', "Akhir bulan ini ada potongan harga untuk produk kategori Fashion Pria dan Fashion Wanita.\n\nPromo berlaku selama stok masih ada."],
            [$editor2, 'Cara Merawat Sepatu Canvas Supaya Awet', "Jangan langsung masukkan sepatu canvas ke mesin cuci. Sikat bagian yang kotor dengan sabun lembut lalu jemur di tempat teduh.\n\nHindari menjemur langsung di bawah matahari terik supaya warnanya tidak pudar."],
            [$editor2, 'Draft: Review Produk Elektronik Terlaris', "Artikel ini masih draft dan belum dipublikasikan.", false],
        ];

        foreach ($artikel as $data) {
            [$penulis, $judul, $isi] = $data;

            $post = new Post([
                'title' => $judul,
                'slug' => Str::slug($judul),
                'body' => $isi,
                'is_published' => $data[3] ?? true,
            ]);
            $post->user()->associate($penulis);
            $post->save();
        }
    }
}
