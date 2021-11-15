<?php
	session_start();
	include"../../lib/conn.php";
	include"../../lib/all_function.php";

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
		$idmateri = '';
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
		$query = "SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
				FROM `guru` as a
				JOIN `pegawai` as b on a.nip = b.nip
				JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
				JOIN `statusguru` as d on d.`id` = a.`statusguru` 
				WHERE a.id = '$idguru'";
		$sql_kul = mysqli_query($conn,$query);	
		$m = mysqli_fetch_assoc($sql_kul);
        log_insert('',"absensi_guru","Menambahakan Data Absensi Guru ".$m['guru'],$_SESSION['id_user'] );
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
	    $qrby = "SELECT * FROM `absensi_guru` WHERE id = '$_GET[id]'";
		$sqqrby = mysqli_query($conn,$qrby);	
		$by = mysqli_fetch_assoc($sqqrby);
	    $query = "SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
				FROM `guru` as a
				JOIN `pegawai` as b on a.nip = b.nip
				JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
				JOIN `statusguru` as d on d.`id` = a.`statusguru` 
				WHERE a.id = '$by[idguru]'";
		$sql_kul = mysqli_query($conn,$query);	
		$m = mysqli_fetch_assoc($sql_kul);
		
		log_delete('',"absensi_guru","Menghapus Data Absensi Guru ".$m['guru'],$_SESSION['id_user'] );
		mysqli_query($conn,"DELETE FROM absensi_guru WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data absensi.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>