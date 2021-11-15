<?php
include"lib/conn.php";
include"lib/all_function.php";
session_start(); // Memulai Session
$error=''; // Variabel untuk menyimpan pesan error
if (isset($_POST['submit'])) {
	
		// Variabel username dan password
		$nama=anti_inject($_POST['nama']);
		$alamat=anti_inject($_POST['alamat']);
		$email=anti_inject($_POST['email']);
		$kota=anti_inject($_POST['kota']);
		$kode=trim($_POST['kode']);
		$catatan=anti_inject($_POST['catatan']);
		
		
		mysqli_query($conn,"INSERT INTO `sekolah`( `nama`, `alamat`, `email`, `kota`, `kode`, `keterangan`, `aktif`, `date`, `last_login`) VALUES ('$nama','$alamat','$email','$kota','$kode','$catatan','pending', NOW(), NOW())");
		
		echo"<script>alert('Berhasil menambahkan data sekolah');history.go(-2);</script>";
}
mysqli_close($conn); // Menutup koneksi
?>