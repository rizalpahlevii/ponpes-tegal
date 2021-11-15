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

	if($mod == "absensiguru" AND $act == "simpan")
	{
		$idkelas = $_POST['idkelas'];
		$idpelajaran = $_POST['idpelajaran'];
		$idmateri = $_POST['idmateri'];
		$idguru = $_POST['idguru'];
		$selesai = $_POST['selesai'];
		$mulai = $_POST['mulai'];
		$kehadiran = $_POST['kehadiran'];
		
		mysqli_query($conn,"INSERT INTO `absensi_guru`(
										`idkelas`, 
										`idpelajaran`, 
										`idrpp`, 
										`idguru`,
										`mulai`, 
										`selesai`, 
										`date`, 
										`kehadiran`) 
							VALUES ('$idkelas',
									'$idpelajaran',
									'$idmateri',
									'$idguru',
									'$mulai',
									'$selesai',
									CURDATE(),
									'$kehadiran')") or die(mysqli_error());

		flash('example_message', 'Berhasil menambah data absensi.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "absensiguru" AND $act == "edit") 
	{	
		$idx = $_POST['id'];
		$kehadiranx = $_POST['kehadiran'];
		$number = count($idx);
	       for($i=0;$i<$number;$i++){
	       	$id = $idx[$i];
	        $kehadiran = $kehadiranx[$i];			
			mysqli_query($conn,"UPDATE `absensi_siswa` SET `kehadiran`='$kehadiran' WHERE `id` = '$id'") or die(mysqli_error());
        }

		flash('example_message', 'Berhasil mengubah data absensi.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "absensiguru" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM absensi_guru WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data absensi.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>