<?php
	session_start();
	include"../../lib/conn.php";

	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	$linkaksi = 'med.php?mod=jenisabsensi';
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

	if($mod == "jenisabsensi" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO jenisabsensi (`nama`, `id_absensi`, `urutan`)
									VALUES ('$_POST[nama]','$_POST[id_absensi]', '$_POST[urutan]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data jenisabsensi.' );

		header("location:../../".$linkaksi);
	}

	elseif ($mod == "jenisabsensi" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE jenisabsensi SET `nama`='$_POST[nama]', `id_absensi` = '$_POST[id_absensi]',`urutan`='$_POST[urutan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data jenisabsensi.');

		header("location:../../".$linkaksi);
	}

	elseif ($mod == "jenisabsensi" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM jenisabsensi WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data jenisabsensi.' );
		header("location:../../".$linkaksi);
	}

?>