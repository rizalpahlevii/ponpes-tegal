<?php
	session_start();
	include"../../lib/conn.php";

	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}
		$idujianx = $_POST['idujian'];
		$nisx = $_POST['nis'];
		$nilaix = $_POST['nilai'];
		$jumlah_dipilih = count($nisx);
		for ($i=0; $i < $jumlah_dipilih ; $i++) { 
			$idujian = $idujianx[$i];
			$nis = $nisx[$i];
			$nilai = $nilaix[$i];
			$queryx = mysqli_query($conn,"SELECT * FROM `nilaiujian` WHERE `idujian` = '$idujian' AND `nis` = '$nis' ");
			$c = mysqli_fetch_assoc($queryx);
			$id=$c['id'];
			$temukan = mysqli_num_rows($queryx);
			if ($temukan==0) {
				if ($nilai !=="") {					
					$query = "INSERT INTO `nilaiujian`(`idujian`, `nis`, `nilaiujian`) VALUES ('$idujian','$nis','$nilai')";
					$conn->query($query);
				}
			}else{
				mysqli_query($conn,"UPDATE `nilaiujian` SET `nilaiujian`='$nilai' WHERE `id`='$id'");
			}
			
		}
		
		
			// $query = "INSERT INTO `raport_katagori`(`nis`, `idpelajaran`, `idrpp`, `jenisujian`, `uhke`, `nilai`) VALUES ('$psiswaUH1x','$idp','$kodex','Pengetahuan','$uhx','$pnilaiUH1x')";
			// $conn->query($query);
		$kelas = $_POST['idkelas'];
		$sm = $_POST['idsemester'];
		$idpel = $_POST['idpel'];
			
		flash('example_message', 'Berhasil menambah data nilai.' );
		
		header("location:../../med2.php?mod=nilaitamrin&aks=nilai&act=form&act=add&act=form&idkelas=$kelas&idpel=$idpel&idsemester=$sm");
	

?>