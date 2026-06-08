<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'SkyRent');
        $this->migrator->add('general.description', 'Lorem Ipsum Sit Doler Amet');
        $this->migrator->add('general.logo', '');
        $this->migrator->add('general.logo_cms', '');
        $this->migrator->add('general.favicon', '');
        $this->migrator->add('general.about_us', 'About Us');
        $this->migrator->add('general.primary_color', '#350B75');
        $this->migrator->add('general.youtube', 'https://www.youtube.com/channel/UCV6b1a5g2k8z9c4d3e5f7wA');
        $this->migrator->add('general.tiktok', 'tiktok.com/@example');
        $this->migrator->add('general.instagram', 'instagram.com/example');
        $this->migrator->add('general.facebook', 'facebook.com/example');
        $this->migrator->add('general.twitter', 'x.com/example');
        $this->migrator->add('general.whatsapp', 'https://wa.me/1234567890');
        $this->migrator->add('general.telegram', 'te.me/example');
        $this->migrator->add('general.tagline', 'Tagline');
        $this->migrator->add('general.how_to_rent', '<h1 data-start="258" data-end="294">📱 Cara Sewa iPhone di Skyrental</h1><p data-start="296" data-end="374">Menyewa iPhone di <strong data-start="314" data-end="327">Skyrental</strong> sangat mudah. Ikuti langkah-langkah berikut:</p><hr data-start="376" data-end="379"><h2 data-start="381" data-end="401">1. Pilih iPhone</h2><ul data-start="402" data-end="564">
<li data-start="402" data-end="439">
<p data-start="404" data-end="439">Buka halaman katalog iPhone kami.</p>
</li>
<li data-start="440" data-end="496">
<p data-start="442" data-end="496">Pilih tipe iPhone yang sesuai dengan kebutuhan Anda.</p>
</li>
<li data-start="497" data-end="564">
<p data-start="499" data-end="564">Lihat detail spesifikasi, durasi sewa, dan harga yang tersedia.</p>
</li>
</ul><hr data-start="566" data-end="569"><h2 data-start="571" data-end="594">2. Tentukan Durasi</h2><ul data-start="595" data-end="726">
<li data-start="595" data-end="658">
<p data-start="597" data-end="658">Pilih durasi sewa sesuai kebutuhan (per jam atau per hari).</p>
</li>
<li data-start="659" data-end="726">
<p data-start="661" data-end="726">Harga akan otomatis menyesuaikan dengan durasi yang Anda pilih.</p>
</li>
</ul><hr data-start="728" data-end="731"><h2 data-start="733" data-end="758">3. Lakukan Pemesanan</h2><ul data-start="759" data-end="978">
<li data-start="759" data-end="826">
<p data-start="761" data-end="826">Klik tombol <strong data-start="773" data-end="792">“Sewa Sekarang”</strong> pada perangkat yang Anda pilih.</p>
</li>
<li data-start="827" data-end="924">
<p data-start="829" data-end="924">Isi formulir pemesanan dengan lengkap, termasuk nama, nomor telepon, email, dan tanggal sewa.</p>
</li>
<li data-start="925" data-end="978">
<p data-start="927" data-end="978">Pastikan data yang Anda masukkan benar dan valid.</p>
</li>
</ul><hr data-start="980" data-end="983"><h2 data-start="985" data-end="1011">4. Lakukan Pembayaran</h2><ul data-start="1012" data-end="1215">
<li data-start="1012" data-end="1066">
<p data-start="1014" data-end="1066">Selesaikan pembayaran sesuai nominal yang tertera.</p>
</li>
<li data-start="1067" data-end="1167">
<p data-start="1069" data-end="1167">Metode pembayaran tersedia melalui transfer bank, e-wallet, atau metode lain yang kami sediakan.</p>
</li>
<li data-start="1168" data-end="1215">
<p data-start="1170" data-end="1215">Simpan bukti pembayaran sebagai konfirmasi.</p>
</li>
</ul><hr data-start="1217" data-end="1220"><h2 data-start="1222" data-end="1255">5. Konfirmasi &amp; Serah Terima</h2><ul data-start="1256" data-end="1464">
<li data-start="1256" data-end="1321">
<p data-start="1258" data-end="1321">Tim Skyrental akan menghubungi Anda untuk konfirmasi pesanan.</p>
</li>
<li data-start="1322" data-end="1400">
<p data-start="1324" data-end="1400">Serah terima perangkat dilakukan sesuai jadwal dan lokasi yang disepakati.</p>
</li>
<li data-start="1401" data-end="1464">
<p data-start="1403" data-end="1464">Periksa kondisi iPhone bersama tim kami sebelum penggunaan.</p>
</li>
</ul><hr data-start="1466" data-end="1469"><h2 data-start="1471" data-end="1494">6. Nikmati Layanan</h2><ul data-start="1495" data-end="1593">
<li data-start="1495" data-end="1544">
<p data-start="1497" data-end="1544">Gunakan iPhone dengan bijak selama masa sewa.</p>
</li>
<li data-start="1545" data-end="1593">
<p data-start="1547" data-end="1593">Pastikan perangkat tetap dalam kondisi baik.</p>
</li>
</ul><hr data-start="1595" data-end="1598"><h2 data-start="1600" data-end="1630">7. Pengembalian Perangkat</h2><ul data-start="1631" data-end="1849">
<li data-start="1631" data-end="1687">
<p data-start="1633" data-end="1687">Kembalikan perangkat tepat waktu sesuai jadwal sewa.</p>
</li>
<li data-start="1688" data-end="1786">
<p data-start="1690" data-end="1786">Pastikan semua data pribadi telah dihapus dan perangkat sudah <strong data-start="1752" data-end="1783">logout dari Apple ID/iCloud</strong>.</p>
</li>
<li data-start="1787" data-end="1849">
<p data-start="1789" data-end="1849">Serah terima kembali akan dilakukan bersama tim Skyrental.</p>
</li>
</ul><hr data-start="1851" data-end="1854"><h2 data-start="1856" data-end="1879">📌 Catatan Penting</h2><p class="">
























</p><ul data-start="1880" data-end="2127">
<li data-start="1880" data-end="1949">
<p data-start="1882" data-end="1949">Keterlambatan pengembalian akan dikenakan denda sesuai ketentuan.</p>
</li>
<li data-start="1950" data-end="2027">
<p data-start="1952" data-end="2027">Penyewa bertanggung jawab penuh atas kerusakan atau kehilangan perangkat.</p>
</li>
<li data-start="2028" data-end="2127">
<p data-start="2030" data-end="2127">Dengan melakukan pemesanan, Anda dianggap telah menyetujui <strong data-start="2089" data-end="2111">Syarat &amp; Ketentuan</strong> yang berlaku.</p>
</li>
</ul>');
        $this->migrator->add('general.terms_conditions', '<h1 data-start="148" data-end="188">📑 Syarat &amp; Ketentuan Penyewaan iPhone</h1>
<h2 data-start="190" data-end="218">1. Pernyataan Persetujuan</h2>
<ul data-start="219" data-end="607">
<li data-start="219" data-end="348">
<p data-start="221" data-end="348">Dengan melanjutkan transaksi atau menggunakan layanan kami, Anda secara otomatis menyetujui seluruh Syarat dan Ketentuan ini.</p>
</li>
<li data-start="349" data-end="495">
<p data-start="351" data-end="495">Syarat dan Ketentuan ini adalah perjanjian yang mengikat secara hukum antara Anda (penyewa) dan <strong data-start="447" data-end="473">Skyrental</strong> (penyedia layanan).</p>
</li>
<li data-start="496" data-end="607">
<p data-start="498" data-end="607">Sebelum melakukan pemesanan, pastikan Anda telah membaca, memahami, dan menyetujui seluruh isi dokumen ini.</p>
</li>
</ul>
<hr data-start="609" data-end="612">
<h2 data-start="614" data-end="634">2. Ketentuan Umum</h2>
<ul data-start="635" data-end="1111">
<li data-start="635" data-end="777">
<p data-start="637" data-end="777">Usia minimal penyewa adalah <strong data-start="665" data-end="677">18 tahun</strong> dan wajib menunjukkan identitas diri (KTP/SIM/Paspor) yang masih berlaku saat pengambilan barang.</p>
</li>
<li data-start="778" data-end="930">
<p data-start="780" data-end="930">Semua data dan informasi yang diberikan penyewa harus <strong data-start="834" data-end="853">benar dan valid</strong>. Kami berhak membatalkan pesanan apabila ditemukan data yang tidak sesuai.</p>
</li>
<li data-start="931" data-end="1111">
<p data-start="933" data-end="1111">iPhone yang disewa hanya boleh digunakan untuk <strong data-start="980" data-end="1001">keperluan pribadi</strong>, tidak boleh dipinjamkan, disewakan kembali, atau dijual kepada pihak ketiga tanpa izin tertulis dari kami.</p>
</li>
</ul>
<hr data-start="1113" data-end="1116">
<h2 data-start="1118" data-end="1141">3. Kondisi Perangkat</h2>
<ul data-start="1142" data-end="1654">
<li data-start="1142" data-end="1295">
<p data-start="1144" data-end="1295">Sebelum diserahkan, setiap unit iPhone telah diperiksa dan dipastikan dalam kondisi baik. Penyewa disarankan untuk memeriksa ulang saat serah terima.</p>
</li>
<li data-start="1296" data-end="1506">
<p data-start="1298" data-end="1506"><strong data-start="1298" data-end="1324">Segala kerusakan fisik</strong> (retak, pecah, penyok, terkena cairan, dll.) selama masa sewa menjadi <strong data-start="1395" data-end="1427">tanggung jawab penuh penyewa</strong>. Biaya perbaikan atau penggantian akan dibebankan sesuai kerusakan yang ada.</p>
</li>
<li data-start="1507" data-end="1654">
<p data-start="1509" data-end="1654">Penyewa dilarang keras membongkar, memodifikasi, atau melakukan perbaikan terhadap perangkat tanpa persetujuan dari <b>Skyrental</b></p>
</li>
</ul>
<hr data-start="1656" data-end="1659">
<h2 data-start="1661" data-end="1687">4. Biaya dan Pembayaran</h2>
<ul data-start="1688" data-end="2252">
<li data-start="1688" data-end="1850">
<p data-start="1690" data-end="1850">Harga sewa yang tertera sudah termasuk <strong data-start="1729" data-end="1755">[charger + kabel data]</strong> (jika disediakan) dan tidak termasuk biaya asuransi atau pengiriman kecuali disebutkan lain.</p>
</li>
<li data-start="1851" data-end="1986">
<p data-start="1853" data-end="1986"><strong data-start="1853" data-end="1889">Denda keterlambatan pengembalian</strong> sebesar <strong data-start="1898" data-end="1919">Rp [nominal]/hari</strong> akan dikenakan apabila perangkat tidak dikembalikan tepat waktu.</p>
</li>
<li data-start="1987" data-end="2117">
<p data-start="1989" data-end="2117">Keterlambatan lebih dari <strong data-start="2014" data-end="2031">[jumlah hari]</strong> tanpa konfirmasi dapat dianggap sebagai penggelapan dan akan diproses secara hukum.</p>
</li>
<li data-start="2118" data-end="2252">
<p data-start="2120" data-end="2252">Seluruh pembayaran harus dilakukan melalui metode resmi yang telah kami sediakan. Bukti pembayaran wajib dikirim sesuai instruksi.</p>
</li>
</ul>
<hr data-start="2254" data-end="2257">
<h2 data-start="2259" data-end="2292">5. Pengembalian dan Pembatalan</h2>
<ul data-start="2293" data-end="2822">
<li data-start="2293" data-end="2488">
<p data-start="2295" data-end="2488">iPhone harus dikembalikan tepat waktu dan dalam kondisi sama seperti saat diterima. Pastikan semua data pribadi telah dihapus dan perangkat <strong data-start="2435" data-end="2485">telah logout dari seluruh akun Apple ID/iCloud</strong>.</p>
</li>
<li data-start="2489" data-end="2711">
<p data-start="2491" data-end="2711">Pembatalan pemesanan yang dilakukan minimal <strong data-start="2535" data-end="2573">[jumlah hari] sebelum tanggal sewa</strong> tidak dikenakan biaya. Setelah melewati batas waktu tersebut, akan dikenakan <strong data-start="2651" data-end="2708">biaya pembatalan sebesar [persentase/jumlah tertentu]</strong>.</p>
</li>
<li data-start="2712" data-end="2822">
<p data-start="2714" data-end="2822">Kami berhak menolak pengembalian jika kondisi perangkat tidak sesuai dengan standar yang telah ditetapkan.</p>
</li>
</ul>
<hr data-start="2824" data-end="2827">
<h2 data-start="2829" data-end="2864">6. Tanggung Jawab dan Ganti Rugi</h2>
<ul data-start="2865" data-end="3313">
<li data-start="2865" data-end="2969">
<p data-start="2867" data-end="2969">Penyewa bertanggung jawab penuh atas <strong data-start="2904" data-end="2939">kehilangan atau kerusakan total</strong> perangkat selama masa sewa.</p>
</li>
<li data-start="2970" data-end="3152">
<p data-start="2972" data-end="3152">Dalam kasus tersebut, penyewa wajib mengganti unit dengan perangkat sejenis dalam kondisi baru atau membayar biaya ganti rugi sebesar <strong data-start="3106" data-end="3149">[nominal/persentase harga jual terbaru]</strong>.</p>
</li>
<li data-start="3153" data-end="3313">
<p data-start="3155" data-end="3313"><strong data-start="3155" data-end="3181">Skyrental</strong> tidak bertanggung jawab atas kehilangan data pribadi penyewa maupun penyalahgunaan perangkat untuk kegiatan yang melanggar hukum.</p>
</li>
</ul>
<hr data-start="3315" data-end="3318">
<h2 data-start="3320" data-end="3333">7. Penutup</h2>
<ul data-start="3334" data-end="3637">
<li data-start="3334" data-end="3472">
<p data-start="3336" data-end="3472">Dengan membaca dan menyetujui Syarat dan Ketentuan ini, Anda menyatakan bahwa Anda memahami seluruh hak dan kewajiban sebagai penyewa.</p>
</li>
<li data-start="3473" data-end="3637">
<p data-start="3475" data-end="3637">Untuk pertanyaan lebih lanjut, silakan hubungi layanan pelanggan kami melalui:<br data-start="3553" data-end="3556">
📧 Email: <b>skyrental@gmail.com</b><br data-start="3590" data-end="3593">
📞 WhatsApp/Telp: <strong data-start="3613" data-end="3635">083146838432</strong></p></li></ul>');
        $this->migrator->add('general.privacy_policy', '<h1 data-start="147" data-end="181">📑 Kebijakan Privasi Skyrental</h1>
<h2 data-start="183" data-end="202">1. Pendahuluan</h2>
<p data-start="203" data-end="480">Kami di <strong data-start="211" data-end="224">Skyrental</strong> berkomitmen untuk melindungi dan menjaga kerahasiaan data pribadi pelanggan. Dokumen Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi pribadi yang Anda berikan saat menggunakan layanan kami.</p>
<p data-start="482" data-end="605">Dengan menggunakan website dan layanan kami, Anda dianggap telah membaca, memahami, dan menyetujui Kebijakan Privasi ini.</p>
<hr data-start="607" data-end="610">
<h2 data-start="612" data-end="649">2. Informasi yang Kami Kumpulkan</h2>
<p data-start="650" data-end="732">Kami dapat mengumpulkan data pribadi berikut saat Anda menggunakan layanan kami:</p>
<ul data-start="733" data-end="1047">
<li data-start="733" data-end="749">
<p data-start="735" data-end="749">Nama lengkap</p>
</li>
<li data-start="750" data-end="784">
<p data-start="752" data-end="784">Nomor telepon dan alamat email</p>
</li>
<li data-start="785" data-end="824">
<p data-start="787" data-end="824">Alamat tempat tinggal atau domisili</p>
</li>
<li data-start="825" data-end="889">
<p data-start="827" data-end="889">Data identitas resmi (KTP/SIM/Paspor) saat proses verifikasi</p>
</li>
<li data-start="890" data-end="968">
<p data-start="892" data-end="968">Informasi pembayaran (misalnya bukti transfer atau metode pembayaran lain)</p>
</li>
<li data-start="969" data-end="1047">
<p data-start="971" data-end="1047">Data teknis seperti alamat IP, browser, dan aktivitas Anda di website kami</p>
</li>
</ul>
<hr data-start="1049" data-end="1052">
<h2 data-start="1054" data-end="1082">3. Penggunaan Informasi</h2>
<p data-start="1083" data-end="1134">Data pribadi yang kami kumpulkan digunakan untuk:</p>
<ul data-start="1135" data-end="1410">
<li data-start="1135" data-end="1179">
<p data-start="1137" data-end="1179">Memproses pemesanan dan penyewaan iPhone</p>
</li>
<li data-start="1180" data-end="1254">
<p data-start="1182" data-end="1254">Menghubungi Anda terkait konfirmasi, pengingat, atau kendala pemesanan</p>
</li>
<li data-start="1255" data-end="1305">
<p data-start="1257" data-end="1305">Mengelola pembayaran dan administrasi keuangan</p>
</li>
<li data-start="1306" data-end="1355">
<p data-start="1308" data-end="1355">Menyediakan layanan pelanggan yang lebih baik</p>
</li>
<li data-start="1356" data-end="1410">
<p data-start="1358" data-end="1410">Memenuhi kewajiban hukum dan regulasi yang berlaku</p>
</li>
</ul>
<p data-start="1412" data-end="1501">Kami tidak akan menggunakan data pribadi Anda untuk tujuan lain tanpa persetujuan Anda.</p>
<hr data-start="1503" data-end="1506">
<h2 data-start="1508" data-end="1533">4. Perlindungan Data</h2>
<ul data-start="1534" data-end="1965">
<li data-start="1534" data-end="1701">
<p data-start="1536" data-end="1701">Skyrental menggunakan langkah-langkah keamanan teknis dan administratif untuk menjaga data pribadi Anda agar tidak disalahgunakan, diakses tanpa izin, atau hilang.</p>
</li>
<li data-start="1702" data-end="1827">
<p data-start="1704" data-end="1827">Akses terhadap data pribadi pelanggan hanya diberikan kepada pihak internal yang membutuhkan untuk keperluan operasional.</p>
</li>
<li data-start="1828" data-end="1965">
<p data-start="1830" data-end="1965">Kami tidak menjual, menyewakan, atau membagikan data pribadi pelanggan kepada pihak ketiga tanpa izin, kecuali diwajibkan oleh hukum.</p>
</li>
</ul>
<hr data-start="1967" data-end="1970">
<h2 data-start="1972" data-end="1996">5. Penyimpanan Data</h2>
<ul data-start="1997" data-end="2202">
<li data-start="1997" data-end="2091">
<p data-start="1999" data-end="2091">Data pribadi Anda akan disimpan selama diperlukan untuk tujuan penyewaan dan administrasi.</p>
</li>
<li data-start="2092" data-end="2202">
<p data-start="2094" data-end="2202">Setelah tidak lagi diperlukan, data Anda akan dihapus secara aman sesuai dengan standar perlindungan data.</p>
</li>
</ul>
<hr data-start="2204" data-end="2207">
<h2 data-start="2209" data-end="2230">6. Hak Pelanggan</h2>
<p data-start="2231" data-end="2257">Anda memiliki hak untuk:</p>
<ul data-start="2258" data-end="2434">
<li data-start="2258" data-end="2308">
<p data-start="2260" data-end="2308">Meminta salinan data pribadi yang kami simpan.</p>
</li>
<li data-start="2309" data-end="2360">
<p data-start="2311" data-end="2360">Memperbarui atau memperbaiki data pribadi Anda.</p>
</li>
<li data-start="2361" data-end="2434">
<p data-start="2363" data-end="2434">Meminta penghapusan data pribadi sesuai ketentuan hukum yang berlaku.</p>
</li>
</ul>
<p data-start="2436" data-end="2526">Untuk mengajukan permintaan, silakan hubungi kami melalui kontak yang tersedia di bawah.</p>
<hr data-start="2528" data-end="2531">
<h2 data-start="2533" data-end="2568">7. Perubahan Kebijakan Privasi</h2>
<p data-start="2569" data-end="2766">Skyrental dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu untuk menyesuaikan dengan perkembangan hukum, regulasi, atau layanan kami. Versi terbaru akan selalu tersedia di halaman ini.</p>
<hr data-start="2768" data-end="2771">
<h2 data-start="2773" data-end="2787">8. Kontak</h2>
<p data-start="2788" data-end="2974">Jika Anda memiliki pertanyaan atau permintaan terkait Kebijakan Privasi ini, silakan hubungi kami melalui:<br data-start="2894" data-end="2897">
📧 Email: <strong data-start="2907" data-end="2929">Skyrental</strong><br data-start="2929" data-end="2932">
📞 WhatsApp/Telp: <strong data-start="2950" data-end="2972">083146838432</strong></p>');
    }
};
