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

	if($mod == "statusguru" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO statusguru (`status`, `keterangan`)
									VALUES ('$_POST[status]', '$_POST[keterangan]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data status guru.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "statusguru" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE statusguru SET `status`='$_POST[status]', `keterangan` = '$_POST[keterangan]'WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data status guru.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "statusguru" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM statusguru WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data status guru.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>