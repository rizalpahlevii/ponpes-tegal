<?php
include"lib/conn.php";
include"lib/all_function.php";
session_start(); // Memulai Session
$error=''; // Variabel untuk menyimpan pesan error
if (isset($_POST['submit'])) {
	if (empty($_POST['username']) || empty($_POST['password'])) {
			$error = "Username or Password is invalid";
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
			$_SESSION['login_user']=$username; // Membuat Sesi/session
			$_SESSION['login_id'] = $a['id'];
			$_SESSION['id_user'] = $a['id_user'];
			$_SESSION['level'] = $a['level'];
			$sqla = "SELECT * FROM `user_nonaktif` WHERE `id_user` = '$a[id_user]'";
			$qakt = mysqli_query($conn, $sqla);
			if(mysqli_num_rows($qakt) > 0){
				header("location: nonaktif.php");
			}else{
				$akt = mysqli_fetch_assoc($qakt);
				if ($_SESSION['level']=='superadmin' OR $_SESSION['level']=='perpustakaan') {
					$_SESSION['link'] = 'location: med.php?mod=home';
					header("location: med.php?mod=home");
				}elseif ($_SESSION['level']=='admin') {
					$_SESSION['link'] = 'location: med.php?mod=home';
					header("location: med.php?mod=home");
				}else{
					$_SESSION['link'] = 'location: index2.php';
					header("location: index2.php");
				}	
				mysqli_query($conn,"UPDATE user SET last_login = NOW() WHERE id = '$a[id]'");
				if($_SESSION['level']!=='superadmin'){
				    $info = "IP :". get_client_ip()."<br> Browser : ".get_client_browser()."<br> Sistem Operasi : ".$_SERVER['HTTP_USER_AGENT'];
        		    mysqli_query($conn,"INSERT INTO `tb_log`(`kode`, `table`, `deskripsi`, `aksi`, `petugas`,`info`) VALUES ('','users','Pengguna melakukan login','Login','$a[id_user]','$info')") or die(mysqli_error());
				}
        		
			}		
		
			
		}elseif ($rows1 == 1) {
			$_SESSION['login_user']=$username; // Membuat Sesi/session
			$_SESSION['login_id'] = $a1['id'];
			$_SESSION['id_user'] = $a1['nis'];
			$_SESSION['level'] = 'siswa';
			$sqls = "SELECT * FROM `siswa_nonaktif` WHERE `nis` = '$a1[nis]'";
			$qskt = mysqli_query($conn, $sqls);
			if(mysqli_num_rows($qskt) > 0){
				header("location: nonaktif.php");
			    
			}else{
			$_SESSION['link'] = 'location: siswa.php?nis='.$a1['id'];
			header("location: index2.php");
			    
			}
		}elseif ($rows2 == 1) {
			$_SESSION['login_user']=$username; // Membuat Sesi/session
			$_SESSION['login_id'] = $a2['id'];
			$_SESSION['id_user'] = $a2['nip'];
			$_SESSION['level'] = 'guru';
			$_SESSION['link'] = 'location: guru.php';
			header("location: index2.php");
		}elseif ($rows3 == 1) {
			$_SESSION['login_user']=$username; // Membuat Sesi/session
			$_SESSION['login_id'] = $a3['id'];
			$_SESSION['id_user'] = $a3['nis'];
			$_SESSION['level'] = 'ortu';
			$_SESSION['link'] = 'location: siswa.php?nis='.$a3['id'];
			header("location: index2.php");
		}else{
			$error = "Username atau Password salah.";
		}


		mysqli_close($conn); // Menutup koneksi

		
	}
}


?>