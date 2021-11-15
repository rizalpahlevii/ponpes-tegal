<?php
	// Include file koneksi
	include"lib/conn.php";
	include"lib/zip.php";
	
	session_start();// Memulai Session
	// Menyimpan Session
	$level_check = $_SESSION['level'];
	$user_check = $_SESSION['login_user'];
	if ($level_check=='siswa') {
			$ses_sql=mysqli_query($conn,"select panggilan from siswa where nis = '$user_check'");
		$row = mysqli_fetch_assoc($ses_sql);
		$login_session = $row['panggilan'];

		if(!isset($login_session)){
			mysqli_close($conn); // Menutup koneksi
			header('location: login.php'); // Mengarahkan ke Home Page
		}
	}elseif ($level_check=='ortu') {
			$ses_sql=mysqli_query($conn,"select wali from siswa where nis = '$user_check'");
		$row = mysqli_fetch_assoc($ses_sql);
		$login_session = $row['wali'];

		if(!isset($login_session)){
			mysqli_close($conn); // Menutup koneksi
			header('location: login.php'); // Mengarahkan ke Home Page
		}
	}elseif ($level_check=='guru') {
			$ses_sql=mysqli_query($conn,"select panggilan from pegawai where nip = '$user_check'");
		$row = mysqli_fetch_assoc($ses_sql);
		$login_session = $row['panggilan'];

		if(!isset($login_session)){
			mysqli_close($conn); // Menutup koneksi
			header('location: login.php'); // Mengarahkan ke Home Page
		}
	}elseif ($level_check=='keuangan') {
			$ses_sql=mysqli_query($conn,"select panggilan from pegawai where nip = '$_SESSION[id_user]'");
		$row = mysqli_fetch_assoc($ses_sql);
		$login_session = $row['panggilan'];

		if(!isset($login_session)){
			mysqli_close($conn); // Menutup koneksi
			header('location: login.php'); // Mengarahkan ke Home Page
		}
	}else{
		$ses_sql=mysqli_query($conn,"select *from user where username = '$user_check'");
		$row = mysqli_fetch_assoc($ses_sql);
		$login_session = $row['username'];

		if(!isset($login_session)){
			mysqli_close($conn); // Menutup koneksi
			header('location: login.php'); // Mengarahkan ke Home Page
		}
	}
	// Ambil nama karyawan berdasarkan username karyawan dengan mysql_fetch_assoc
?>