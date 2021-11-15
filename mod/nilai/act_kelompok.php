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

	if($mod == "kelompok" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO `aspekkelompok`(`kode`, `keterangan`, `posisi`) VALUES ('$_POST[aspekkelompok]','$_POST[keterangan]','$_POST[posisi]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data aspek kelompok.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "kelompok" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE `aspekkelompok` SET `kode`='$_POST[aspekkelompok]',`keterangan`='$_POST[keterangan]',`posisi`='$_POST[posisi]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data aspek kelompok.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "kelompok" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM aspekkelompok WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data aspek kelompok.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>