<?php
	session_start();
	include"../../../lib/conn.php";
	include"../../../lib/all_function.php";

	if(!isset($_SESSION['login_user'])){
		header('location: ../../../login.php'); // Mengarahkan ke Home Page
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

	if($mod == "kelas" AND $act == "simpan")
	{
		$idtahunajaran = anti_inject($_POST['idtahunajaran']);
		$nip = anti_inject($_POST['nip']);
		$kelas = anti_inject($_POST['kelas']);
		$kapasitas = anti_inject($_POST['kapasitas']);
		$keterangan = anti_inject($_POST['keterangan']);
		$tingkat = anti_inject($_POST['tingkat']);

		mysqli_query($conn,"INSERT INTO `kelas`(`kelas`, `idtahunajaran`, `kapasitas`, `nipwali`, `tingkat`, `keterangan`) VALUES ('$kelas','$idtahunajaran','$kapasitas','$nip','$tingkat','$keterangan')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data kelas.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "kelas" AND $act == "edit") 
	{
		$idtahunajaran = anti_inject($_POST['idtahunajaran']);
		$nip = anti_inject($_POST['nip']);
		$kelas = anti_inject($_POST['kelas']);
		$kapasitas = anti_inject($_POST['kapasitas']);
		$keterangan = anti_inject($_POST['keterangan']);
		$tingkat = anti_inject($_POST['tingkat']);
		mysqli_query($conn,"UPDATE `kelas` SET `kelas`='$kelas',`idtahunajaran`='$idtahunajaran',`kapasitas`='$kapasitas',`nipwali`='$nip', `tingkat`='$tingkat',`keterangan`='$keterangan' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data kelas.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "kelas" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM kelas WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data kelas.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>