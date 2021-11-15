<?php
include"lib/conn.php";
$error=''; // Variabel untuk menyimpan pesan error


$myObj->authenticate = "denied";
$myObj->info = "";

/*
$myObj->authenticate = $_POST['username'];
$myObj->info = $_POST['password'];
*/

if (empty($_POST['username']) || empty($_POST['password'])) {
		$error = "Username or Password is invalid";
		$myObj->info = $error;
}
else
{
	// Variabel username dan password
	$username=$_POST['username'];
	$password=$_POST['password'];

	$pass = md5($password);
	
	// Mencegah MySQL injection 
	$username = stripslashes($username);
	$password = stripslashes($password);
	
	

	$username = mysqli_real_escape_string($conn,$username);
	$password = mysqli_real_escape_string($conn,$password);
	// SQL query untuk memeriksa apakah karyawan terdapat di database?
	$query = mysqli_query($conn, "SELECT * FROM user WHERE password='$pass' AND username='$username'");
	$rows = mysqli_num_rows($query);
	$a = mysqli_fetch_assoc($query);
	$query1 = mysqli_query($conn, "SELECT * FROM siswa WHERE pinsiswa='$pass' AND nis='$username'");
	$rows1 = mysqli_num_rows($query1);
	$a1 = mysqli_fetch_assoc($query1);		
	$query3 = mysqli_query($conn, "SELECT * FROM siswa WHERE pinortu='$pass' AND nis='$username'");
	$rows3 = mysqli_num_rows($query3);
	$a3 = mysqli_fetch_assoc($query3);
	$query2 = mysqli_query($conn, "SELECT * FROM pegawai WHERE pinpegawai='$pass' AND nip='$username'");
	$rows2 = mysqli_num_rows($query2);
	$a2 = mysqli_fetch_assoc($query2);

	if ($rows == 1) {
		
		if ($_SESSION['level']=='admin') {
			$myObj->authenticate = "granted";
			$myObj->info = "admin";
		}elseif($_SESSION['level']=='keuangan'){
			$myObj->authenticate = "granted";
			$myObj->info = "guru";
		}
		
	}elseif ($rows1 == 1) {
		$myObj->authenticate = "granted";
		$myObj->info = "siswa";
	}elseif ($rows2 == 1) {
		$myObj->authenticate = "granted";
		$myObj->info = "guru";
	}elseif ($rows3 == 1) {
		$myObj->authenticate = "granted";
		$myObj->info = "ortu";
	}else{
		$myObj->info = "Error: Username atau Password salah.";
	}
	mysqli_close($conn); // Menutup koneksi

	
}

$myJSON = json_encode($myObj);
echo $myJSON;


?>