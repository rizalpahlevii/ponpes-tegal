<?php
	session_start();
	include"lib/conn.php";

	if(!isset($_SESSION['login_user'])){
		header('location:login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
	}
	else
	{
		$act = "";
	}

	if($act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO `ujian`(`idpelajaran`, `idkelas`, `idsemester`, `deskripsi`, `tanggal`) VALUES ('$_POST[idpel]','$_POST[idkelas]','$_POST[idsemester]','$_POST[bulan]','$_POST[tanggal]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data penilaian.' );

		echo"<script>
			window.close();
		</script>";
	}

	elseif ($act == "edit") 
	{
		mysqli_query($conn,"UPDATE `ujian` SET `idpelajaran`='$_POST[idpel]',`idkelas`='$_POST[idkelas]',`idsemester`='$_POST[idsemester]',`deskripsi`='$_POST[bulan]',`tanggal`='$_POST[tanggal]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data penilaian.');

		echo"<script>
			window.close();
		</script>";
	}

	elseif ($act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM `nilaiujian` WHERE `idujian` = '$_GET[id]'") or die(mysqli_error());
		mysqli_query($conn,"DELETE FROM ujian WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data penilaian.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>