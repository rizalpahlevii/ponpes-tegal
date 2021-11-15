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

	if($mod == "kehadiran" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO kehadiran (`kehadiran`, `urutan`)
									VALUES ('$_POST[kehadiran]', '$_POST[urutan]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data kehadiran.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "kehadiran" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE kehadiran SET `kehadiran`='$_POST[kehadiran]',`urutan`='$_POST[urutan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data kehadiran.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "kehadiran" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM kehadiran WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data kehadiran.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>