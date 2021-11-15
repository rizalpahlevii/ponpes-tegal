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

	if($mod == "kasmasuk" AND $act == "simpan")
	{

		$nominal = str_replace(",", "", anti_inject($_POST['nominal']));
		mysqli_query($conn,"INSERT INTO `kas`(`tanggal`, `nominal`, `keterangan`, `jenis`) VALUES ('$_POST[tanggal]','$nominal','$_POST[keterangan]','masuk')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data Kas Masuk.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}
	elseif ($mod == "kaskeluar" AND $act == "simpan") {
		$nominal = str_replace(",", "", anti_inject($_POST['nominal']));
		mysqli_query($conn,"INSERT INTO `kas`(`tanggal`, `nominal`, `keterangan`, `jenis`) VALUES ('$_POST[tanggal]','$nominal','$_POST[keterangan]','keluar')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data Kas Keluar.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}
	elseif ($mod == "kasmasuk" AND $act == "edit") 
	{
		$nominal = str_replace(",", "", anti_inject($_POST['nominal']));
		mysqli_query($conn,"UPDATE `kas` SET `tanggal`='$_POST[tanggal]',`nominal`='$nominal',`keterangan`='$_POST[keterangan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data Kas Masuk.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}
	elseif ($mod == "kaskeluar" AND $act == "edit") 
	{
		$nominal = str_replace(",", "", anti_inject($_POST['nominal']));
		mysqli_query($conn,"UPDATE `kas` SET `tanggal`='$_POST[tanggal]',`nominal`='$nominal',`keterangan`='$_POST[keterangan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data Kas Keluar.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "kas" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM kas WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data Rak Buku.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>