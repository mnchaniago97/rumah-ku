<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Tips Membeli Rumah Pertama untuk Milenial',
                'slug' => 'tips-membeli-rumah-pertama-untuk-milenial',
                'category' => 'Tips',
                'excerpt' => 'Panduan lengkap membeli rumah pertama bagi milenial dengan budget terbatas.',
                'content' => '<p>Membeli rumah pertama adalah impian banyak milenial. Namun, dengan budget yang terbatas, seringkali terasa sulit untuk mewujudkannya. Berikut tips yang bisa membantu Anda:</p><h3>1. Tentukan Budget dengan realistis</h3><p>Sebelum mulai mencari rumah, tentukan terlebih dahulu berapa budget yang Anda miliki. Jangan lupa menghitung biaya tambahan seperti DP, pajak, dan biaya notaris.</p><h3>2. Pilih Lokasi Strategis</h3><p>Lokasi adalah faktor penting dalam investasi properti. Pilih lokasi yang dekat dengan transportasi umum, sekolah, atau tempat kerja.</p><h3>3. Pertimbangkan Rumah Secondary</h3><p>Rumah secondary atau rumah bekas yang sudah direnovasi bisa menjadi pilihan karena biasanya harganya lebih terjangkau.</p><h3>4. Manfaatkan Program KPR</h3><p>Banyak bank yang menawarkan program KPR dengan bunga rendah untuk rumah pertama. Bandingkan berbagai pilihan sebelum memutuskan.</p>',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Panduan Investasi Properti untuk Pemula',
                'slug' => 'panduan-investasi-properti-untuk-pemula',
                'category' => 'Panduan',
                'excerpt' => 'Pelajari dasar-dasar investasi properti yang menguntungkan bagi pemula.',
                'content' => '<p>Investasi properti adalah salah satu jenis investasi yang cukup populer di Indonesia. Berikut panduannya untuk pemula:</p><h3>Mengapa Investasi Properti?</h3><p>Properti cenderung memiliki nilai yang meningkat seiring waktu. Selain itu, properti juga bisa menghasilkan passive income dari sewa.</p><h3>Tipe Properti untuk Investasi</h3><ul><li>Rumah - Cocok untuk jangka panjang</li><li>Apartemen - Cocok untuk daerah perkotaan</li><li>Ruko - Cocok untuk usaha komersial</li><li>Tanah - Cocok untuk pengembangan masa depan</li></ul><h3>Tips Memilih Lokasi</h3><p>Pilih lokasi yang memiliki potensi perkembangan baik. Perhatikan infrastruktur yang akan dibangun di sekitar lokasi tersebut.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Cara Menyiapkan Property agar Cepat Terjual',
                'slug' => 'cara-menyiapkan-property-agar-cepat-terjual',
                'category' => 'Tips',
                'excerpt' => 'Persiapan yang tepat kunci utama property cepat terjual dengan harga bagus.',
                'content' => '<p>Menjual properti bukan hal yang mudah. Dibutuhkan strategi yang tepat agar properti Anda cepat terjual dengan harga yang diinginkan.</p><h3>1. Bersihkan dan Rapikan Properti</h3><p>Pastikan properti Anda bersih dan rapi. Bersihkan setiap sudut rumah, rapikan taman, dan pastikan tidak ada barang-barang yang tidak terpakai.</p><h3>2. Lakukan Renovasi Kecil</h3><p>Renovasi kecil seperti mengecat ulang, memperbaiki keran yang bocor, atau mengganti lampu bisa meningkatkan daya tarik properti Anda.</p><h3>3. Foto Profesional</h3><p>Foto adalah kesan pertama pembeli. Gunakan fotografer profesional untuk mengambil foto properti Anda.</p><h3>4. Pasang Harga yang Wajar</h3><p>Riset harga properti di sekitar Anda dan pasang harga yang kompetitif.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => '10 Hal yang Harus Diperiksa Sebelum Membeli Rumah',
                'slug' => '10-hal-yang-harus-diperiksa-sebelum-membeli-rumah',
                'category' => 'Panduan',
                'excerpt' => 'Jangan sampai tertipu! Periksa hal-hal penting ini sebelum memutuskan membeli rumah.',
                'content' => '<p>Membeli rumah adalah keputusan besar. Pastikan Anda tidak terburu-buru dan memeriksa hal-hal berikut:</p><h3>1. Legalitas Tanah dan Bangunan</h3><p>Pastikan sertifikat tanah asli, tidak dalam sengketa, dan sesuai dengan kondisi sebenarnya.</p><h3>2. Kondisi Struktural</h3><p>Periksa fondasi, dinding, atap, dan struktur bangunan lainnya.</p><h3>3. Sistem Kelistrikan</h3><p>Cek kapasitas listrik dan kondisi instalasi listrik.</p><h3>4. Sistem Plumbing</h3><p>Pastikan air mengalir lancar dan tidak ada kebocoran.</p><h3>5. Sumber Air</h3><p>Cek apakah air PDAM atau sumur, dan apakah mencukupi kebutuhan.</p><h3>6. Lingkungan Sekitar</h3><p>Perhatikan keamanan, kenyamanan, dan fasilitas di sekitar.</p><h3>7. Akses Jalan</h3><p>Pastikan jalan menuju rumah cukup lebar dan dapat diakses kendaraan.</p><h3>8. Banjir</h3><p>Cek riwayat banjir di lokasi tersebut.</p><h3>9. Tagihan utilities</h3><p>Tanyakan tagihan listrik, air, dan pajak sebelumnya.</p><h3>10. Developer/Rekomendasi</h3><p>Cek reputasi developer atau pemilik sebelumnya.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Tren Properti 2024: Apa yang Perlu Anda Ketahui',
                'slug' => 'tren-properti-2024',
                'category' => 'Berita',
                'excerpt' => 'Mengupas tren properti yang akan dominan di tahun 2024.',
                'content' => '<p>Tahun 2024 membawa perubahan signifikan dalam industri properti. Berikut tren yang perlu Anda ketahui:</p><h3>1. Properti Sustainable</h3><p>Semakin banyak developer yang membangun rumah ramah lingkungan dengan panel surya dan sistem pengumpulan air hujan.</p><h3>2. Smart Home</h3><p>Teknologi smart home menjadi standar baru dalam properti modern.</p><h3>3. Work From Home Space</h3><p>Rumah dengan ruang kerja yang nyaman menjadi daya tarik tersendiri.</p><h3>4. Cluster dengan Fasilitas Lengkap</h3><p>Pengembangan klaster dengan fasilitas lengkap seperti kolam, gym, dan taman semakin populer.</p><h3>5. Properti di Luar Kota</h3><p>Dengan kebijakan hybrid work, properti di luar kota semakin dilirik.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Cara Mendapat KPR dengan Bunga Rendah',
                'slug' => 'cara-mendapat-kpr-dengan-bunga-rendah',
                'category' => 'Tips',
                'excerpt' => 'Trik dan strategi untuk mendapatkan persetujuan KPR dengan bunga kompetitif.',
                'content' => '<p>KPR adalah solusi bagi kebanyakan orang untuk memiliki rumah. Berikut cara mendapatkannya dengan bunga rendah:</p><h3>1. Tingkatkan Skor Kredit</h3><p>Skor kredit yang baik akan membantu Anda mendapatkan bunga lebih rendah. Bayar tagihan tepat waktu.</p><h3>2. Stabilitas Penghasilan</h3><p>Bank lebih cenderung memberikan KPR dengan bunga rendah kepada peminjam dengan penghasilan stabil.</p><h3>3. DP Besar</h3><p>Semakin besar DP yang Anda berikan, semakin kecil risiko bank, sehingga bunga bisa lebih rendah.</p><h3>4. Bandingkan Offers</h3><p>Jangan langsung menerima tawaran pertama. Bandingkan bunga dari berbagai bank.</p><h3>5. Manfaatkan Promo</h3><p>Perhatikan promo KPR dari bank tertentu yang sering menawarkan bunga fix lebih rendah.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
