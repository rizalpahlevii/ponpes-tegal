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

	if($mod == "agama" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO agama (`agama`, `urutan`)
									VALUES ('$_POST[agama]', '$_POST[urutan]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data agama.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "agama" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE agama SET `agama`='$_POST[agama]',`urutan`='$_POST[urutan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data agama.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "agama" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM agama WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data agama.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>