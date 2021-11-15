<?php

	include"lib/conn.php";

	$userId= $_GET['uid'];
	$semesterId= $_GET['smstrid'];

	class data_aturan{
		public $idaturan;
		public $namaaturan;
	}

	class pelajaran{
		public $idpelajaran;
		public $kodepelajaran;
		public $namapelajaran;
		public $idkelas;
		public $namakelas;
		public $idsemester;
		public $namasemester;
		public $nipguru;
		public $namaguru;
		public $idguru;
		public $arr_idaturan= array();
	}
	
	$arr_pelajaran= array();

	$query2 = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$userId'");
	$a2 = mysqli_fetch_assoc($query2);
	//echo $a2;
	$query = "SELECT DISTINCT a.`idpelajaran`, b.`kode`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`,h.`nip`, i.`nama` as guru 
		FROM `ujian` as a
		JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
		JOIN `kelas` as c ON a.`idkelas` = c.`id`
		JOIN `semester` as d ON a.`idsemester` = d.`id`
		JOIN `jenisujian` as e ON a.`idjenis` = e.`id`
		JOIN `aturannhb` as f ON a.`idaturan` = f.`id`
		JOIN `rpp` as g ON a.`idrpp` = g.`id`
		JOIN `guru` as h on f.`nipguru` = h.`id`
		JOIN `pegawai` as i on h.`nip` = i.`nip`
		where a.`idkelas` = '$a2[idkelas]' AND  a.`idsemester`= '$semesterId'";
	$sql_kul = mysqli_query($conn,$query);

	/*
	$m = mysqli_fetch_assoc($sql_kul);
	$myJSON = json_encode($m);
	echo $myJSON;
	*/
	while ($m = mysqli_fetch_assoc($sql_kul)){
		$nipguru= $m['nip'];
		
		$tmpPelajaran= new pelajaran();
		
		$tmpPelajaran-> idpelajaran= $m['idpelajaran'];
		$tmpPelajaran-> kodepelajaran= $m['kode'];
		$tmpPelajaran-> namapelajaran= $m['pelajaran'];
		$tmpPelajaran-> idkelas= $m['idkelas'];
		$tmpPelajaran-> namakelas= $m['kelas'];
		$tmpPelajaran-> idsemester= $m['idsemester'];
		$tmpPelajaran-> namasemester= $m['semester'];
		$tmpPelajaran-> nipguru= $m['nip'];
		$tmpPelajaran-> namaguru= $m['guru'];
		
	
		$sqlguru = "SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
		FROM `guru` as a
		JOIN `pegawai` as b on a.nip = b.nip
		JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
		JOIN `statusguru` as d on d.`id` = a.`statusguru` WHERE a.`nip` = '$nipguru'";
		$kguru = mysqli_query($conn, $sqlguru);
		$guru = mysqli_fetch_assoc($kguru);
		/*
		echo $guru['pelajaran'];
		
		$myJSON1 = json_encode($guru);
		echo $myJSON1;
		*/
		$tmpPelajaran-> idguru= $guru[id];
		
		$queryb = "SELECT DISTINCT a.`nipguru`,b.`dasarpenilaian`, b.`keterangan`, b.id 
					FROM `aturannhb` as a 
					LEFT JOIN `dasarpenilaian` as b ON a.`dasarpenilaian` = b.`id`
					WHERE a.`idpelajaran` = '$guru[idpelajaran]' AND a.`nipguru` = '$guru[id]'";
		$sqlb = mysqli_query($conn,$queryb);
		
		/*
		$x = mysqli_fetch_assoc($sqlb);
		
		$myJSONaturanId = json_encode($x);
		echo $myJSONaturanId;
		*/
		
		while ($x = mysqli_fetch_assoc($sqlb)) {										
			
			$tmpaturan= new data_aturan();
			$tmpaturan-> idaturan= $x[id];
			$tmpaturan-> namaaturan= $x[keterangan];
			
			$tmpPelajaran-> arr_idaturan[]= $tmpaturan;
		
		}
		
		$arr_pelajaran[]= $tmpPelajaran;
	}
	
	$myJSONObj= json_encode($arr_pelajaran);
	echo $myJSONObj;
		
?>
