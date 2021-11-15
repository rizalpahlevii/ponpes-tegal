<?php
	session_start();
	include"../../../lib/conn.php";

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

	if($mod == "naikkelas" AND $act == "simpan")
	{
		
			$kelas1 = $_POST['kelas'];
			$kelas2 = $_POST['kelas2'];
			if ($kelas2=="Lulus") {
				

				$query = "SELECT s.nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas,k.idtahunajaran 
																FROM siswa as s 
		                                                        left join kelas k on s.idkelas = k.id
		                                                        left join tahunajaran t on t.id = k.idtahunajaran          
		                                                        LEFT JOIN `history_tmp` as h ON s.nis = h.nis
		                                                        where s.idkelas='$kelas1' AND h.nis IS NULL";
				$sql_kul = mysqli_query($conn,$query);
				while ($m = mysqli_fetch_assoc($sql_kul)) {
					mysqli_query($conn,"INSERT INTO `history`(`nis`, `idkelas`, `idtahunajaran`) VALUES ('$m[nis]','$kelas1','$m[idtahunajaran]')") or die(mysqli_error());
					mysqli_query($conn,"UPDATE `siswa` SET `alumni`='1' WHERE `nis` = '$m[nis]'") or die(mysqli_error());
				}
			}else{

				$query = "SELECT s.nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas,k.idtahunajaran 
																FROM siswa as s 
		                                                        left join kelas k on s.idkelas = k.id
		                                                        left join tahunajaran t on t.id = k.idtahunajaran          
		                                                        LEFT JOIN `history_tmp` as h ON s.nis = h.nis
		                                                        where s.idkelas='$kelas1' AND h.nis IS NULL";
				$sql_kul = mysqli_query($conn,$query);
				while ($m = mysqli_fetch_assoc($sql_kul)) {
					mysqli_query($conn,"INSERT INTO `history`(`nis`, `idkelas`, `idtahunajaran`) VALUES ('$m[nis]','$kelas1','$m[idtahunajaran]')") or die(mysqli_error());
					mysqli_query($conn,"UPDATE `siswa` SET `idkelas`='$kelas2' WHERE `nis` = '$m[nis]'") or die(mysqli_error());
				}

		

				
			}
		mysqli_query($conn,"DELETE FROM history_tmp");
		header("location:../../../med.php?mod=naikkelas");
	}
	elseif ($mod == "naikkelas" AND $act == "add") 
	{
		mysqli_query($conn,"INSERT INTO `history_tmp`(`nis`, `idkelas`, `idtahunajaran`) VALUES ('$_POST[nis]','$_POST[kelas]','$_POST[idtahunajaran]')") or die(mysqli_error());
		flash('example_message', 'Berhasil.');

		
				$kelas1 = $_POST['kelas'];
				$kelas2 = $_POST['kelas2'];
		header("location:../../../med.php?mod=naikkelas&act=form&kelas=".$kelas1."&kelas2=".$kelas2);
		
	}
	elseif ($mod == "naikkelas" AND $act == "batal") {
		mysqli_query($conn,"DELETE FROM history_tmp 
					WHERE id= '$_GET[id]'") or die(mysqli_error());

		
				$kelas1 = $_GET['kelas'];
				$kelas2 = $_GET['kelas2'];
		header("location:../../../med.php?mod=naikkelas&act=form&kelas=".$kelas1."&kelas2=".$kelas2);
	}
	elseif ($mod == "naikkelas" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE naikkelas SET `naikkelas`='$_POST[naikkelas]',`tglmulai`='$_POST[tglmulai]',`tglakhir`='$_POST[tglakhir]',`aktif`='$_POST[aktif]',`keterangan`='$_POST[keterangan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data naikkelas.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "naikkelas" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM naikkelas WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data naikkelas.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>