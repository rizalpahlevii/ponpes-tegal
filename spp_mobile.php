<?php
	include"lib/conn.php";
	
	if (empty($_POST['username']) || empty($_POST['password'])) {
		$error = "Username or Password is invalid";
		$myObj -> info = $error;
	}
	else
	{
	
		// Variabel username dan password
		$username=$_POST['username'];
		$password=$_POST['password'];
	
		
		//echo $_GET[id];
		
		
		$sqltrans = mysqli_query($conn,"SELECT c.nis, c.nama, c.panggilan, c.tahunmasuk, c.idkelas, c.agama, b.status, a.kondisi, c.kelamin,
			   c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.tgllahir, c.warga,
			   c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa,
			   c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanayah ) as pendidikanayah
			   , (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanibu ) as pendidikanibu, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanayah) as pekerjaanayah, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanibu) as pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu,
			   c.alamatortu, c.hportu, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan, t.tahunajaran, t.id AS idtahunajaran,
			   k.kelas, c.nisn, 
			   c.noijasah,c.tglijasah,c.tmplahirayah,c.tmplahiribu,c.tgllahirayah,c.tgllahiribu,c.hobi
		  FROM siswa c, kelas k, tahunajaran t, kondisisiswa a, statussiswa b
		 WHERE c.nis='$username' AND k.id = c.idkelas AND a.id = c.kondisi AND b.id = c.status AND k.idtahunajaran = t.id") or die(mysqli_error());	  
		$tra = mysqli_fetch_assoc($sqltrans);
		
		//$cekJson= json_encode($tra);
		//echo $cekJson;
		
		
		$query = "SELECT DISTINCT `bulanke` FROM `spp` WHERE `idtahunajaran` = '$tra[idtahunajaran]' order by `bulanke`";
		$sql_kul = mysqli_query($conn,$query);	
		$jmlb = mysqli_num_rows($sql_kul);
		
		//$m = mysqli_fetch_assoc($sql_kul);
		
		//$cekJson= json_encode($m);
		//echo $cekJson;

		//******************************sampai sini lancar no error *******************************//
		
		$jmg=0;
		$x=1;
		
		class cls_data_spp{
			public $nominal;
			public $tgl;
			public $bln;
			public $thn;
		}
		$arr_spp= array();
		
		for ($b=0; $b < $jmlb ; $b++) { 
			if ($x<=9) {
				$blnk = '0'.$x;
			}else{
				$blnk = $x;
			}
			$qbln = mysqli_query($conn,"SELECT `id`, `nis`, `idtahunajaran`, `bulanke`, `nominal`, DAY(date) AS tanggal, MONTH(date) AS bulan, YEAR(date) AS tahun FROM `spp` WHERE `nis` = '$tra[nis]' AND `idtahunajaran` = '$tra[idtahunajaran]' AND `bulanke` = '$blnk'");				
			$bln = mysqli_fetch_assoc($qbln);
			
			
			//$cekJson= json_encode($bln);
			//echo "\n".$cekJson;
			
			
			if (isset($bln['nominal'])) {
			
				$data_spp= new cls_data_spp();
			
				$data_spp-> nominal= $bln['nominal'];
				$data_spp-> tgl= $bln['tanggal'];
				$data_spp-> bln= $bln['bulan'];
				$data_spp-> thn= $bln['tahun'];
				
				$arr_spp[]= $data_spp;
				
				//$cekJson= json_encode($data_spp);
				//echo "\n".$cekJson;
			}
			
			
			$x++;
		}
		
		$myObj -> arr_spp = $arr_spp;
		$myObj -> info = "Pengambilan data berhasil";
		
		
		
	}
	
	$myJSON = json_encode($myObj);
	echo $myJSON;
	
?>
