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

	if($mod == "kejadian_sekolah" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO daftar_kejadian (`nama`, `poin`)
									VALUES ('$_POST[nama]', '$_POST[poin]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data Kejadian Sekolah.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "kejadian_sekolah" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE daftar_kejadian SET `nama`='$_POST[nama]',`poin`='$_POST[poin]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data Kejadian Sekolah.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "kejadian_sekolah" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM daftar_kejadian WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data Kejadian Sekolah.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>