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

	if($mod == "statusiswa" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO statussiswa (`status`, `urutan`)
									VALUES ('$_POST[status]', '$_POST[urutan]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data status siswa.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "statusiswa" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE statussiswa SET `status`='$_POST[status]',`urutan`='$_POST[urutan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data status siswa.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "statusiswa" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM statussiswa WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data status siswa.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>