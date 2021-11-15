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

	if($mod == "modul" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO modul(`id_menu`, `nama_modul`, `link_menu`, `posisi`, `icon_menu`, `akses_sekolah`)
									VALUES ('$_POST[id_menu]', '$_POST[nama_modul]', '$_POST[link_menu]', '$_POST[posisi]', '$_POST[icon_menu]','')") or die(mysqli_error());
		flash('example_message', '<p>Berhasil menambah data modul.</p>' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "modul" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE modul SET id_menu= '$_POST[id_menu]', nama_modul= '$_POST[nama_modul]', link_menu= '$_POST[link_menu]', posisi= '$_POST[posisi]', icon_menu= '$_POST[icon_menu]' WHERE id_modul = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', '<p>Berhasil mengubah data modul.</p>');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "modul" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM modul WHERE id_modul = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', '<p>Berhasil menghapus data modul kuliah.</p>' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>