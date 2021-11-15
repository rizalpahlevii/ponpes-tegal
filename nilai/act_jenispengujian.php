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

	if($mod == "jenispengujian" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO `jenisujian`(`kode`, `jenisujian`, `idpelajaran`, `keterangan`) VALUES ('$_POST[kode]','$_POST[jenisujian]','$_POST[idpelajaran]','$_POST[keterangan]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data aspek penilaian.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "jenispengujian" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE `jenisujian` SET `kode`='$_POST[kode]',`jenisujian`='$_POST[jenisujian]',`idpelajaran`='$_POST[idpelajaran]',`keterangan`='$_POST[keterangan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data aspek penilaian.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "jenispengujian" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM jenisujian WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data aspek penilaian.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>