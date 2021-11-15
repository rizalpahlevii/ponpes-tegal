<?php
	session_start();
	include"../../../lib/conn.php";

	if(!isset($_SESSION['login_user'])){
		header('location: ../../../login.php'); // Mengarahkan ke Home Page
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

	if($mod == "tahunajaran" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO tahunajaran (`tahunajaran`, `tglmulai`, `tglakhir`, `aktif`, `keterangan`)
									VALUES ('$_POST[tahunajaran]', '$_POST[tglmulai]', '$_POST[tglakhir]','$_POST[aktif]', '$_POST[keterangan]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data tahunajaran.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "tahunajaran" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE tahunajaran SET `tahunajaran`='$_POST[tahunajaran]',`tglmulai`='$_POST[tglmulai]',`tglakhir`='$_POST[tglakhir]',`aktif`='$_POST[aktif]',`keterangan`='$_POST[keterangan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data tahunajaran.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "tahunajaran" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM tahunajaran WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data tahunajaran.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>