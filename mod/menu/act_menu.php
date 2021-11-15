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

	if($mod == "menu" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO menu(nama_menu, posisi, `icon_menu`)
									VALUES ('$_POST[nama]', '$_POST[posisi]', '$_POST[icon]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data menu.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "menu" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE menu SET nama_menu= '$_POST[nama]', posisi= '$_POST[posisi]',`icon_menu`= '$_POST[icon]' WHERE id_menu = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data menu.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "menu" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM menu WHERE id_menu = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data menu.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>