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

	if($mod == "kategori_buku" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO kategori (`kategori`)
									VALUES ('$_POST[kategori]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data Kategori Buku.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "kategori_buku" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE kategori SET `kategori`='$_POST[kategori]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data Kategori Buku.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "kategori_buku" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM kategori WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data Kategori Buku.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>