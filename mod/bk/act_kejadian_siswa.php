<?php
	session_start();
	include"../../lib/conn.php";

	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_GET['mod']) && isset($_GET['act']))
	{
		$mod = $_GET['mod'];
		$act = $_GET['act'];
	}
	else
	{
		$mod = "";
		$act = "";
	}

	if($mod == "kejadian_siswa" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO kejadian_siswa (`nis`, `iddaftarkejadian`, `tanggal`)
									VALUES ('$_POST[nis]', '$_POST[iddaftarkejadian]', '$_POST[tanggal]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data Kejadian Siswa.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "kejadian_siswa" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE kejadian_siswa SET `nis`='$_POST[nis]',`iddaftarkejadian`='$_POST[iddaftarkejadian]',`tanggal`='$_POST[tanggal]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data Kejadian Siswa.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "kejadian_siswa" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM kejadian_siswa WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data Kejadian Siswa.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>