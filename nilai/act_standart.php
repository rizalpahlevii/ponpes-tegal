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

	if($mod == "standart" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO `aspekstandart`(`kode`, `keterangan`, `posisi`) VALUES ('$_POST[aspekstandart]','$_POST[keterangan]','$_POST[posisi]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data aspek standart.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "standart" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE `standartnilai` SET `nilai`='$_POST[nilai]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data nilai.');

		echo"<script>
			window.history.back();
		</script>";
	}

	elseif ($mod == "standart" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM aspekstandart WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data aspek standart.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>