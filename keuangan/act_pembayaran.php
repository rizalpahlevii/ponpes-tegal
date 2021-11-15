<?php
	session_start();
	include"../../lib/conn.php";
	include"../../lib/all_function.php";

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

	if($mod == "pembayaran" AND $act == "simpan")
	{
		$jmlbayar = str_replace(",", "", anti_inject($_POST['nominal']));
		mysqli_query($conn,"INSERT INTO pembayaran (`idjenispembayaran`, `nama`, `harga`)
									VALUES ('$_POST[id]','$_POST[nama]', '$jmlbayar')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data jenis pembayaran.' );

		echo"<script>
			window.history.go(-1);
		</script>";
	}

	elseif ($mod == "pembayaran" AND $act == "edit") 
	{
		$jmlbayar = str_replace(",", "", anti_inject($_POST['nominal']));
		mysqli_query($conn,"UPDATE pembayaran SET `nama`='$_POST[nama]',`harga`='$jmlbayar' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data jenis pembayaran.');

		echo"<script>
			window.history.go(-1);
		</script>";
	}

	elseif ($mod == "pembayaran" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM pembayaran WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data jenis pembayaran.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>