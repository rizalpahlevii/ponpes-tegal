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

	if($mod == "rak_buku" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO rak (`rak`)
									VALUES ('$_POST[rak]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data Rak Buku.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "rak_buku" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE rak SET `rak`='$_POST[rak]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data Rak Buku.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "rak_buku" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM rak WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data Rak Buku.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>