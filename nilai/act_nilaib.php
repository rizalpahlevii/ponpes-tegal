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

	if($mod == "nilai" AND $act == "simpan")
	{
		$idsemester= $_POST['id_semester'];
		$idkelas= $_POST['idkelas'];
		$nisx = $_POST['nis'];
		$number = count($nisx);
	       for($i=0;$i<$number;$i++){
	        $nis = $nisx[$i];
			$pelx = $_POST['pel'.$i];
			$nilaix = $_POST['nilai'.$i];

			$number1 = count($pelx);
			 for ($x=0; $x < $number1 ; $x++) { 
			 	$pel = $pelx[$x];
			 	$nilai = $nilaix[$x];

				mysqli_query($conn,"INSERT INTO `data_ujian`(`nis`, `idpelajaran`, `idkelas`, `idsemester`, `nilai`) VALUES ('$nis','$pel','$idkelas','$idsemester','$nilai')") or die(mysqli_error());
			 }

				//echo '<pre>';
				//echo $i;
				//print_r ($pelx);
				//echo "</pre>";


				//echo '<pre>';
				//print_r ($nilaix);

				//echo "</pre>";
        }

		flash('example_message', 'Berhasil menambah data nilai.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "nilai" AND $act == "edit") 
	{	
		$idsemester= $_POST['id_semester'];
		$idkelas= $_POST['idkelas'];
		$nisx = $_POST['nis'];
		$number = count($nisx);
	       for($i=0;$i<$number;$i++){
	        $nis = $nisx[$i];
			$pelx = $_POST['pel'.$i];
			$nilaix = $_POST['nilai'.$i];
			$idnx = $_POST['idn'.$i];

			$number1 = count($pelx);
			 for ($x=0; $x < $number1 ; $x++) { 
			 	$pel = $pelx[$x];
			 	$nilai = $nilaix[$x];
			 	$idn = $idnx[$x];

				mysqli_query($conn,"UPDATE `data_ujian` SET `nis`='$nis',`idpelajaran`='$pel',`idkelas`='$idkelas',`idsemester`='$idsemester',`nilai`='$nilai'WHERE `id` = '$idn'") or die(mysqli_error());
			 }

				//echo '<pre>';
				//echo $i;
				//print_r ($pelx);
				//echo "</pre>";


				//echo '<pre>';
				//print_r ($nilaix);

				//echo "</pre>";
        }


		flash('example_message', 'Berhasil mengubah data nilai.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "nilai" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM nilai WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data nilai.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>