<?php
	include"lib/conn.php";
	
	if (empty($_POST['username']) || empty($_POST['password'])) {
		$error = "Username or Password is invalid";
		$myObj -> info = $error;
	}
	else
	{
	
		// Variabel username dan password
		$username=$_POST['username'];
		$password=$_POST['password'];
		
		$siswa = mysqli_query($conn,"SELECT * FROM siswa");
		$jsiswa = mysqli_num_rows($siswa);
		$guru = mysqli_query($conn,"SELECT * FROM pegawai where bagian = 'Akademik'");
		$jguru = mysqli_num_rows($guru);
		$kelas = mysqli_query($conn,"SELECT * FROM kelas");
		$jkelas = mysqli_num_rows($kelas);
		$mk = mysqli_query($conn,"SELECT * FROM pelajaran");
		$jmk = mysqli_num_rows($mk);
					
		$myObj -> jsiswa = $jsiswa;
		$myObj -> jguru = $jguru;
		$myObj -> jkelas = $jkelas;
		$myObj -> jmk = $jmk;
		$myObj -> info = "Pengambilan data berhasil";
		
	}
	
	$myJSON = json_encode($myObj);
	echo $myJSON;
	
?>