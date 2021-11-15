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

	if($mod == "guru" AND $act == "simpan")
	{
		$idpelajaran = anti_inject($_POST['idpelajaran']);
		$nip = anti_inject($_POST['nip']);
		$status = anti_inject($_POST['status']);
		$keterangan = anti_inject($_POST['keterangan']);

		mysqli_query($conn,"INSERT INTO `guru`(`nip`, `idpelajaran`, `statusguru`, `keterangan`) VALUES ('$nip','$idpelajaran','$status','$keterangan')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data guru.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "guru" AND $act == "edit") 
	{
		$idpelajaran = anti_inject($_POST['idpelajaran']);
		$nip = anti_inject($_POST['nip']);
		$status = anti_inject($_POST['status']);
		$keterangan = anti_inject($_POST['keterangan']);
		mysqli_query($conn,"UPDATE `guru` SET `nip`='$nip',`idpelajaran`='$idpelajaran',`statusguru`='$status',`keterangan`='$keterangan'  WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data guru.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "guru" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM guru WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data guru.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>