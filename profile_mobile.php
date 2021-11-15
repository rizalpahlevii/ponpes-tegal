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
		
		
		//$loginId = $_GET[id];
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
		
		$myObj -> panggilan = $tra['panggilan'];
		$myObj -> kelamin = $tra['kelamin'];
		$myObj -> tmplahir = $tra['tmplahir'];
		$myObj -> tanggal = $tra['tanggal'];
		$myObj -> bulan = $tra['bulan'];
		$myObj -> tahun = $tra['tahun'];
		
		$myObj -> agama = $tra['agama'];
		$myObj -> warga = $tra['warga'];
		$myObj -> anakke = $tra['anakke'];
		$myObj -> jsaudara = $tra['jsaudara'];
		$myObj -> kondisi = $tra['kondisi'];
		$myObj -> status = $tra['status'];
		
		$myObj -> alamatsiswa = $tra['alamatsiswa'];
		$myObj -> hpsiswa = $tra['hpsiswa'];
		$myObj -> emailsiswa = $tra['emailsiswa'];
		$myObj -> berat = $tra['berat'];
		$myObj -> tinggi = $tra['tinggi'];
		$myObj -> darah = $tra['darah'];
		$myObj -> kesehatan = $tra['kesehatan'];
		$myObj -> asalsekolah = $tra['asalsekolah'];
		$myObj -> ketsekolah = $tra['ketsekolah'];
		
		//orang tua
		$myObj -> namaayah = $tra['namaayah'];
		$myObj -> namaibu = $tra['namaibu'];
		
		$myObj -> pendidikanayah = $tra['pendidikanayah'];
		$myObj -> pendidikanibu = $tra['pendidikanibu'];
		
		$myObj -> pekerjaanayah = $tra['pekerjaanayah'];
		$myObj -> pekerjaanibu = $tra['pekerjaanibu'];
		
		$myObj -> penghasilanayah = $tra['penghasilanayah'];
		$myObj -> penghasilanibu = $tra['penghasilanibu'];
		
		$myObj -> emailayah = $tra['emailayah'];
		$myObj -> emailibu = $tra['emailibu'];
		
		$myObj -> wali = $tra['wali'];
		$myObj -> alamatortu = $tra['alamatortu'];
		$myObj -> hportu = $tra['hportu'];
		
		//lain
		$myObj -> alamatsurat = $tra['alamatsurat'];
		$myObj -> keterangan = $tra['keterangan'];
		
		$myObj -> info = "Pengambilan data berhasil";
	}
	$myJSON = json_encode($myObj);
	echo $myJSON;
?>

	