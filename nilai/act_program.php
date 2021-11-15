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

	if($mod == "program" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO `rpp`(`idsemester`, `idpelajaran`, `koderpp`,`periode`, `rpp`, `deskripsi`, `aktif`) VALUES ('$_POST[idsemester]','$_POST[idpelajaran]','$_POST[koderpp]','$_POST[periode]','$_POST[rpp]','$_POST[deskripsi]','$_POST[aktif]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data aspek penilaian.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "program" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE `rpp` SET `idsemester`='$_POST[idsemester]',`idpelajaran`='$_POST[idpelajaran]',`koderpp`='$_POST[koderpp]',`periode`='$_POST[periode]',`rpp`='$_POST[rpp]',`deskripsi`='$_POST[deskripsi]',`aktif`='$_POST[aktif]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data aspek penilaian.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "program" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM rpp WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data aspek penilaian.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>