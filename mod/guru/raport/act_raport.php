<?php
	session_start();
	include"../../../lib/conn.php";

	if(!isset($_SESSION['login_user'])){
		header('location: ../../../login.php'); // Mengarahkan ke Home Page
	}
		$siswap = $_POST['siswap'];
		$kodep = $_POST['kodep'];
		$nilaip = $_POST['nilaip'];
		$uhp = $_POST['uhp'];

		$siswak = $_POST['siswak'];
		$kodek = $_POST['kodek'];
		$nilaik = $_POST['nilaik'];
		$uhk = $_POST['uhk'];
		$idp = $_POST['idp'];
		$jumlah_dipilih = count($siswap);
		$kodej = count($kodep);
		for ($i=0; $i < $kodej ; $i++) { 
			$siswapx = $siswap[$i];
			$kodepx = $kodep[$i];
			$nilaipx = $nilaip[$i];
			$uhpx = $uhp[$i];
			$queryx = mysqli_query($conn,"SELECT * FROM `raport_katagori` WHERE `nis`='$siswapx' and `idpelajaran` = '$idp' and `idrpp` ='$kodepx' and `jenisujian` ='Pengetahuan' and `uhke` ='$uhpx'");
			$c = mysqli_fetch_assoc($queryx);
			$idkodep=$c['id'];
			$temukan = mysqli_num_rows($queryx);
			if ($temukan==0) {
				if ($nilaipx !=="") {					
					$query = "INSERT INTO `raport_katagori`(`nis`, `idpelajaran`, `idrpp`, `jenisujian`, `uhke`, `nilai`) VALUES ('$siswapx','$idp','$kodepx','Pengetahuan','$uhpx','$nilaipx')";
					$conn->query($query);
				}
			}else{
				mysqli_query($conn,"UPDATE `raport_katagori` SET `nilai`='$nilaipx' WHERE `id`='$idkodep'");
			}
			
		}
		for ($i=0; $i < $kodej ; $i++) { 
			$siswakx = $siswak[$i];
			$kodekx = $kodek[$i];
			$nilaikx = $nilaik[$i];
			$uhkx = $uhk[$i];

			$queryk = mysqli_query($conn,"SELECT * FROM `raport_katagori` WHERE `nis`='$siswakx' and `idpelajaran` = '$idp' and `idrpp` ='$kodekx' and `jenisujian` ='Keterampilan' and `uhke` ='$uhkx'");
			$k = mysqli_fetch_assoc($queryk);
			$idkodek=$k['id'];
			$temukan = mysqli_num_rows($queryk);
			if ($temukan==0) {
				if ($nilaikx !=="") {		
				$query = "INSERT INTO `raport_katagori`(`nis`, `idpelajaran`, `idrpp`, `jenisujian`, `uhke`, `nilai`) VALUES ('$siswakx','$idp','$kodekx','Keterampilan','$uhkx','$nilaikx')";
				$conn->query($query);
				}
			}else{
				mysqli_query($conn,"UPDATE `raport_katagori` SET `nilai`='$nilaikx' WHERE `id`='$idkodek'");
			}

			
		}
		
		
			// $query = "INSERT INTO `raport_katagori`(`nis`, `idpelajaran`, `idrpp`, `jenisujian`, `uhke`, `nilai`) VALUES ('$psiswaUH1x','$idp','$kodex','Pengetahuan','$uhx','$pnilaiUH1x')";
			// $conn->query($query);
		$kelas = $_POST['idkelas'];
		$th = $_POST['idtahunajaran'];
		$sm = $_POST['idsemester'];
			
		flash('example_message', 'Berhasil menambah data nilai.' );
		
		header("location:../../../med2.php?mod=raport&act=form&idkelas=$kelas&idtahunajaran=$th&idsemester=$sm");
	

?>