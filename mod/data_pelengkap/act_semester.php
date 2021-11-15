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

	if($mod == "semester" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO semester (`semester`, `aktif`, `keterangan`)
									VALUES ('$_POST[semester]', '$_POST[aktif]', '$_POST[keterangan]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data semester.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "semester" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE semester SET `semester`='$_POST[semester]',`aktif`='$_POST[aktif]',`keterangan`='$_POST[keterangan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data semester.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "semester" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM semester WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data semester.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>