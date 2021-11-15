<?php
	include"lib/conn.php";
	
	
	if (empty($_POST['username']) || empty($_POST['password'])) {
		$error = "Username or Password is invalid";
		$myObj->info = $error;
	}
	else
	{
		// Variabel username dan password
		$username=$_POST['username'];
		$password=$_POST['password'];
		
		$sqltrans = mysqli_query($conn,"SELECT c.nis, c.nama, c.panggilan, c.tahunmasuk, c.idkelas, c.agama, b.status, a.kondisi, c.kelamin,
					   c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.tgllahir, c.warga,
					   c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa,
					   c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanayah ) as pendidikanayah
					   , (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanibu ) as pendidikanibu, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanayah) as pekerjaanayah, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanibu) as pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu,
					   c.alamatortu, c.hportu, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan, t.tahunajaran, t.id AS idtahunajaran,
					   k.kelas, c.nisn, 
					   c.noijasah,c.tglijasah,c.tmplahirayah,c.tmplahiribu,c.tgllahirayah,c.tgllahiribu,c.hobi
				  FROM siswa c, kelas k, tahunajaran t, kondisisiswa a, statussiswa b
				 WHERE c.nis='$username' AND k.id = c.idkelas AND a.id = c.kondisi AND b.id = c.status ") or die(mysqli_error());
		$tra = mysqli_fetch_assoc($sqltrans);	        
		
		$myObj -> foto = $tra['foto'];
		$myObj -> nama = $tra['nama'];
		$myObj -> tahunajaran = $tra['tahunajaran'];
		$myObj -> kelas = $tra['kelas'];
		$myObj -> nis = $tra['nis'];
		$myObj -> nisn = $tra['nisn'];
				
				
		$query = "SELECT a.id,a.nis,b.nama,c.nama as kejadian,c.poin,a.tanggal from 
					kejadian_siswa a
					inner join siswa b
					on a.nis = b.nis
					inner join daftar_kejadian c
					on a.iddaftarkejadian = c.id 
					WHERE b.nis='$username' order by a.tanggal desc";
		$sql_kul = mysqli_query($conn,$query);
		
		$i=1;
		$arr_kejadian = array();
		
		class data_kejadian{
			public $nis;
			public $nama;
			public $kejadian;
			public $poin;
			public $tanggal;
		}
		
		while ($m = mysqli_fetch_assoc($sql_kul)) {
			
			$tmpDataKejadian= new data_kejadian();
			
			$tmpDataKejadian-> nis= $m['nis'];
			$tmpDataKejadian-> nama= $m['nama'];
			$tmpDataKejadian-> kejadian= $m['kejadian'];
			$tmpDataKejadian-> poin= $m['poin'];
			$tmpDataKejadian-> tanggal= $m['tanggal'];
			
			//$cekJson= json_encode($tmpDataKejadian);
			//echo "\n\n" .$cekJson . "\n\n";
			
			$arr_kejadian[]= $tmpDataKejadian;
			
		}
		$myObj-> arr_kejadian = $arr_kejadian;
		$myObj-> info = "Pengambilan data berhasil";
		
	}
	$myJSON = json_encode($myObj);
	echo $myJSON;
?>

	