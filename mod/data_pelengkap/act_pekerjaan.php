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

	if($mod == "pekerjaan" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO jenispekerjaan (`pekerjaan`, `urutan`)
									VALUES ('$_POST[pekerjaan]', '$_POST[urutan]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data pekerjaan.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "pekerjaan" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE jenispekerjaan SET `pekerjaan`='$_POST[pekerjaan]',`urutan`='$_POST[urutan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data pekerjaan.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "pekerjaan" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM jenispekerjaan WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data pekerjaan.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>