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

	if($mod == "kondisisiswa" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO kondisisiswa (`kondisi`, `urutan`)
									VALUES ('$_POST[kondisi]', '$_POST[urutan]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data kondisi siswa.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "kondisisiswa" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE kondisisiswa SET `kondisi`='$_POST[kondisi]',`urutan`='$_POST[urutan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data kondisi siswa.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "kondisisiswa" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM kondisisiswa WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data kondisi siswa.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>