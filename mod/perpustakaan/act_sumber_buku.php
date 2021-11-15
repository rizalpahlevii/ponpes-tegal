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

	if($mod == "sumber_buku" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO sumber (`sumber`)
									VALUES ('$_POST[sumber]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data Sumber Buku.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "sumber_buku" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE sumber SET `sumber`='$_POST[sumber]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data Sumber Buku.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "sumber_buku" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM sumber WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data Sumber Buku.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>