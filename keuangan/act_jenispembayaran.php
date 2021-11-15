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

	if($mod == "jenispembayaran" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO jenispembayaran (`pembayaran`,`jenis`, `urutan`)
									VALUES ('$_POST[pembayaran]','$_POST[jenis]', '$_POST[urutan]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data jenis pembayaran.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "jenispembayaran" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE jenispembayaran SET `pembayaran`='$_POST[pembayaran]',`jenis`='$_POST[jenis]',`urutan`='$_POST[urutan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data jenis pembayaran.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "jenispembayaran" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM jenispembayaran WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data jenis pembayaran.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>