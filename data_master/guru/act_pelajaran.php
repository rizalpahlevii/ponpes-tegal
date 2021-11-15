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

	if($mod == "pelajaran" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO `pelajaran`(`kode`, `nama`, `sifat`, `kkm`, `tingkat`) VALUES ('$_POST[kode]','$_POST[nama]','$_POST[sifat]','$_POST[kkm]','$_POST[tingkat]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data pelajaran.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "pelajaran" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE `pelajaran` SET `kode`='$_POST[kode]',`nama`='$_POST[nama]',`sifat`='$_POST[sifat]',`kkm`='$_POST[kkm]',`tingkat`='$_POST[tingkat]'  WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data pelajaran.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "pelajaran" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM pelajaran WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data pelajaran.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>