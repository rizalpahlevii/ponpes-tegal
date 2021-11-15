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

	if($mod == "aspekpenilaian" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO `dasarpenilaian`(`dasarpenilaian`, `keterangan`, `posisi`) VALUES ('$_POST[dasarpenilaian]','$_POST[keterangan]','$_POST[posisi]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data aspek penilaian.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "aspekpenilaian" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE `dasarpenilaian` SET `dasarpenilaian`='$_POST[dasarpenilaian]',`keterangan`='$_POST[keterangan]',`posisi`='$_POST[posisi]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data aspek penilaian.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "aspekpenilaian" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM dasarpenilaian WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data aspek penilaian.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>