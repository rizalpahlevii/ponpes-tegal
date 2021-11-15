<?php
	session_start();
	include"../../../lib/conn.php";

	if(!isset($_SESSION['login_user'])){
		header('location: ../../../login.php'); // Mengarahkan ke Home Page
	}

	$linkaksi = 'med.php?mod=libur';
	
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

	if($mod == "libur" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO libur (`keterangan`, `mulai`, `sampai`)
									VALUES ('$_POST[keterangan]', '$_POST[mulai]', '$_POST[selesai]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data libur.' );

		header("location:../../../".$linkaksi);
	}

	elseif ($mod == "libur" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE libur SET `keterangan`='$_POST[keterangan]',`mulai`='$_POST[mulai]',`sampai`='$_POST[selesai]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data libur.');

		header("location:../../../".$linkaksi);
	}

	elseif ($mod == "libur" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM libur WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data libur.' );
		header("location:../../../".$linkaksi);
	}

?>