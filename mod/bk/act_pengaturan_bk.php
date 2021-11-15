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

	if($mod == "pengaturan_bk" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO pengaturan_bk (`poinawal`, `reward`, `sistempelanggaran`, `text1`, `text2`, `text3`, `text4`)
									VALUES ('$_POST[poinawal]', '$_POST[reward]', '$_POST[sistempelanggaran]', '', '', '', '')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data Pengaturan Bimbingan Konseling.' );

		echo"<script>
			window.history.go(-1);
		</script>";
	}

	elseif ($mod == "pengaturan_bk" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE pengaturan_bk SET `poinawal`='$_POST[poinawal]',`reward`='$_POST[reward]',`sistempelanggaran`='$_POST[sistempelanggaran]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data Pengaturan Bimbingan Konseling.');

		echo"<script>
			window.history.go(-1);
		</script>";
	}

	elseif ($mod == "pengaturan_bk" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM pengaturan_bk WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data Kejadian Siswa.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>