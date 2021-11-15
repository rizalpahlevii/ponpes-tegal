<?php
    
    include"lib/fungsi_indotgl.php";
    include"lib/all_function.php";
    include"lib/fungsi_terbilang.php";
    
    if(isset($_GET['mod']))
    {
        $mod = $_GET['mod']; //modul yang akan ditampilkan
        if ($mod == "home") {
            include"dashboard.php";
        }
        elseif($mod == "user")
        {
            include"mod/user/user.php";
        }
        elseif($mod == "userakun")
        {
            include"mod/user/user.php";
        }
        elseif($mod == "laporan_user")
        {
            include"mod/user/laporan_user.php";
        }
        elseif($mod == "menu")
        {
            include"mod/menu/menu.php";
        }
        elseif($mod == "modul")
        {
            include"mod/modul/modul.php";
        }
        elseif($mod == "absensi")
        {
            include"mod/data_pelengkap/absensi.php";
        }
        elseif($mod == "absensisiswa")
        {
            include"mod/absensi/absensisiswa.php";
        }
        elseif($mod == "absensiguru")
        {
            include"mod/absensi/absensiguru.php";
        }
        elseif($mod == "kehadiran")
        {
            include"mod/data_pelengkap/kehadiran.php";
        }
        elseif($mod == "jenisabsensi")
        {
            include"mod/data_pelengkap/jenisabsensi.php";
        }
        elseif($mod == "jamabsen")
        {
            include"mod/absensi/jamabsen.php";
        }
        elseif($mod == "agama")
        {
            include"mod/data_pelengkap/agama.php";
        }
        elseif($mod == "pekerjaan")
        {
            include"mod/data_pelengkap/pekerjaan.php";
        }
        elseif($mod == "pendidikan")
        {
            include"mod/data_pelengkap/pendidikan.php";
        }
        elseif($mod == "statusiswa")
        {
            include"mod/data_pelengkap/statusiswa.php";
        }
        elseif($mod == "kondisisiswa")
        {
            include"mod/data_pelengkap/kondisisiswa.php";
        }
        elseif($mod == "statusguru")
        {
            include"mod/data_pelengkap/statusguru.php";
        }
        elseif($mod == "siswa")
        {
            include"mod/data_master/siswa/siswa.php";
        }
        elseif ($mod == "tahunajaran") {
            include 'mod/data_master/tahunajaran/tahunajaran.php';
        }
        elseif($mod == "pegawai")
        {
            include"mod/data_pelengkap/pegawai.php";
        }
        elseif($mod == "guru")
        {
            include"mod/data_master/guru/guru.php";
        }
        elseif($mod == "pelajaran")
        {
            include"mod/data_master/guru/pelajaran.php";
        }
        elseif($mod == "kelas")
        {
            include"mod/data_master/kelas/kelas.php";
        }
        elseif($mod == "naikkelas")
        {
            include"mod/data_master/naikkelas/naikkelas.php";
        }
        elseif($mod == "naikkelas2")
        {
            include"mod/data_master/naikkelas/naikkelas2.php";
        }
        elseif($mod == "libur")
        {
            include"mod/data_master/libur/libur.php";
        }
        elseif($mod == "kelompok")
        {
            include"mod/nilai/kelompok.php";
        }
        elseif($mod == "aspekpenilaian")
        {
            include"mod/nilai/aspekpenilaian.php";
        }
        elseif($mod == "semester")
        {
            include"mod/data_pelengkap/semester.php";
        }
        elseif($mod == "program")
        {
            include"mod/nilai/program.php";
        }
        elseif($mod == "jenispengujian")
        {
            include"mod/nilai/jenispengujian.php";
        }
        elseif($mod == "perhitungan_nilai")
        {
            include"mod/nilai/perhitungan_nilai.php";
        }
        elseif($mod == "nilai")
        {
            include"mod/nilai/nilai.php";
        }
        elseif($mod == "nilairaport")
        {
            include"mod/nilai/nilairaport.php";
        }
        elseif($mod == "nilaib")
        {
            include"mod/nilai/nilaib.php";
        }
        elseif($mod == "nilairaportb")
        {
            include"mod/nilai/nilairaportb.php";
        }
        elseif($mod == "historinilairaport")
        {
            include"mod/nilai/historinilairaport.php";
        }
        elseif($mod == "pembagiannama")
        {
            include"mod/nilai/pembagiannama.php";
        }
        elseif($mod == "standart")
        {
            include"mod/nilai/standart.php";
        }
        elseif($mod == "raport")
        {
            include"mod/guru/raport/raport.php";
        }
        elseif($mod == "raportsiswa")
        {
            include"mod/siswa/raport/raportsiswa.php";
        }
        elseif($mod == "pengembangan_prestasi")
        {
            include"mod/nilai/pengembangan_prestasi.php";
        }
        elseif($mod == "nilaitamrin")
        {
            include"mod/nilai/nilaitamrin.php";
        }
        elseif($mod == "spp")
        {
            include"mod/keuangan/spp.php";
        }
        elseif($mod == "kemaarifan")
        {
            include"mod/keuangan/kemaarifan.php";
        }
        elseif($mod == "laporan")
        {
            include"mod/keuangan/laporan.php";
        }
        elseif($mod == "laporankemaarifan")
        {
            include"mod/keuangan/laporankemaarifan.php";
        }
        elseif($mod == "jenispembayaran")
        {
            include"mod/keuangan/jenispembayaran.php";
        }
        elseif($mod == "pembayaran")
        {
            include"mod/keuangan/pembayaran.php";
        }
        elseif($mod == "historipembayaran")
        {
            include"mod/keuangan/historipembayaran.php";
        }
        elseif($mod == "pendaftaran")
        {
            include"mod/keuangan/pendaftaran.php";
        }
        elseif($mod == "laporanpendaftaran")
        {
            include"mod/keuangan/laporanpendaftaran.php";
        }
        elseif($mod == "transaksi")
        {
            include"mod/keuangan/transaksi.php";
        }
        elseif($mod == "kejadian_sekolah")
        {
            include"mod/bk/kejadian_sekolah.php";
        }
        elseif($mod == "kejadian_siswa")
        {
            include"mod/bk/kejadian_siswa.php";
        }
        elseif($mod == "skor_siswa")
        {
            include"mod/bk/skor_siswa.php";
        }
        elseif($mod == "pengaturan_bk")
        {
            include"mod/bk/pengaturan_bk.php";
        }
        elseif($mod == "kategori_buku")
        {
            include"mod/perpustakaan/kategori_buku.php";
        }
        elseif($mod == "sumber_buku")
        {
            include"mod/perpustakaan/sumber_buku.php";
        }
        elseif($mod == "rak_buku")
        {
            include"mod/perpustakaan/rak_buku.php";
        }
        elseif($mod == "buku")
        {
            include"mod/perpustakaan/buku.php";
        }
        elseif($mod == "peminjaman")
        {
            include"mod/perpustakaan/peminjaman.php";
        }
        elseif($mod == "pengembalian")
        {
            include"mod/perpustakaan/pengembalian.php";
        }
        elseif($mod == "kas")
        {
            include"mod/perpustakaan/kas.php";
        }
        elseif($mod == "laporan_perpustakaan")
        {
            include"mod/perpustakaan/laporan_perpustakaan.php";
        }
        elseif($mod == "materi")
        {
            include"mod/elearning/materi.php";
        }
        elseif($mod == "quiz")
        {
            include"mod/elearning/quiz.php";
        }
        elseif($mod == "table")
        {
            include"mod/guru/raport/table.php";
        }
        elseif($mod == "coba")
        {
            include"coba.php";
        }
        elseif($mod == "insert")
        {
            include"insert.php";
        }

    }
    else
    {
        header("location:index.php");
    }
?>