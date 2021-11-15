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

	if($mod == "pendidikan" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO tingkatpendidikan (`pendidikan`, `urutan`)
									VALUES ('$_POST[pendidikan]', '$_POST[urutan]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data pendidikan.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "pendidikan" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE tingkatpendidikan SET `pendidikan`='$_POST[pendidikan]',`urutan`='$_POST[urutan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data pendidikan.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "pendidikan" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM tingkatpendidikan WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data pendidikan.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>