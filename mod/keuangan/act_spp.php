<?php
	session_start();
	include"../../lib/conn.php";
	include"../../lib/all_function.php";

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

	if($mod == "spp" AND $act == "simpan")
	{
		$jmlbayar = str_replace(",", "", anti_inject($_POST['nominal']));
		mysqli_query($conn,"INSERT INTO `spp`(`nis`, `idtahunajaran`, `bulanke`, `nominal`, `date`) VALUES ('$_POST[nis]','$_POST[idtahunajaran]','$_POST[bulan]','$jmlbayar','$_POST[tgl]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah SPP.' );

		
		header("location:../../med2.php?mod=spp&act=form&nis=$_POST[nis]&idtahunajaran=$_POST[idtahunajaran]");
	}

	elseif ($mod == "spp" AND $act == "edit") 
	{
		$jmlbayar = str_replace(",", "", anti_inject($_POST['nominal']));
		mysqli_query($conn,"UPDATE `spp` SET `nis`='$_POST[nis]',`idtahunajaran`='$_POST[idtahunajaran]',`bulanke`='$_POST[bulan]',`nominal`='$jmlbayar',`date`='$_POST[tgl]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah SPP.');
		
		header("location:../../med2.php?mod=spp&act=form&nis=$_POST[nis]&idtahunajaran=$_POST[idtahunajaran]");
	}

	elseif ($mod == "spp" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM Spp WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data SPP.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>