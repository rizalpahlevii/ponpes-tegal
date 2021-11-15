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

	if($mod == "absensi" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO absensi (`nama`, `urutan`)
									VALUES ('$_POST[nama]', '$_POST[urutan]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data absensi.' );

		header("location:../../".$linkaksi);
	}

	elseif ($mod == "absensi" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE absensi SET `nama`='$_POST[nama]',`urutan`='$_POST[urutan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data absensi.');

		header("location:../../".$linkaksi);
	}

	elseif ($mod == "absensi" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM absensi WHERE id = '$_GET[id]'") or die(mysqli_error());
		mysqli_query($conn,"DELETE FROM jenisabsensi WHERE id_absensi = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data absensi.' );
		header("location:../../".$linkaksi);
	}

?>