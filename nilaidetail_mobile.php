<?php

	include"lib/conn.php";

	//mod=nilai&act=detail&nipguru=101&idkelas=47&idsemester=21
	
	//afektif : http://easytech.co.id/sia/med2.php?mod=nilai&act=detail&idkelas=47&idsemester=21&nipguru=101&idaturan=5&nip=45

	$userId= $_GET['uid'];
	$idsemester= $_GET['smstrid'];
	$nipguru= $_GET['nipguru'];
	$nip= $_GET['nip'];
	$idkelas= $_GET['klsid'];

	$idaturan = $_GET['aturanid'];
	
	
	$qisi = "SELECT a.`id`,a.`idpelajaran`,b.nama as pelajaran,c.`id` as iddasarpenilaian, c.`keterangan` as dasarpenilaian, a.`idjenisujian`,d.`jenisujian`
	FROM `aturannhb` AS a
	JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
	JOIN `dasarpenilaian` AS c ON a.`dasarpenilaian` = c.`id`
	JOIN `jenisujian` as d ON d.`id` = a.`idjenisujian`
	WHERE c.`id` = '$idaturan'
	";
	$sqlisi = mysqli_query($conn,$qisi);
	$isi = mysqli_fetch_assoc($sqlisi);
	$qrt = "SELECT SUM(a.bobot) as bobotPK, COUNT(a.id) 
		  FROM aturannhb a, kelas k
		 WHERE a.nipguru = '$nip' AND k.id = '$idkelas' 
		   AND a.idpelajaran = '$isi[idpelajaran]' AND a.dasarpenilaian = '$isi[iddasarpenilaian]'
	";
	$sqlrt = mysqli_query($conn,$qrt);
	$rt = mysqli_fetch_assoc($sqlrt);

	$qkls = mysqli_query($conn,"SELECT * FROM `kelas` WHERE `id` = '$idkelas' ");
	$kls = mysqli_fetch_assoc($qkls);
	
	/*
	<th class="text-center">No</th>
	<th class="text-center">NIS</th>
	<th class="text-center">Nama</th>
	*/
	
	echo 'No';
	echo 'Nis';
	echo 'Nama';
	
	$qu = mysqli_query($conn,"SELECT DISTINCT a.`bobot`, b.`kode`, b.`jenisujian`, a.id 
							FROM `aturannhb` as a
							JOIN `jenisujian` as b
							WHERE a.`idpelajaran` = '$isi[idpelajaran]' AND a.`nipguru` = '$nip' AND a.`dasarpenilaian` = 
							'$isi[iddasarpenilaian]' AND b.id = a.idjenisujian ORDER BY b.jenisujian");
	//$i=1;
	
	$querys = mysqli_query($conn,"SELECT * FROM siswa WHERE nis = '$userId'");
	
	while($k = mysqli_fetch_assoc($querys)){
		//$k = mysqli_fetch_assoc($querys);
		/*
		$myJSON1 = json_encode($k);
		echo $myJSON1;
		*/
		while($u = mysqli_fetch_assoc($qu)){
		
			//echo $u['bobot'] ; 
			echo $u['jenisujian'];
			
			$qn = mysqli_query($conn,"SELECT h.`nis`, sum(h.`nilaiujian`) as nilai
				FROM `ujian` as a
				JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
				JOIN `kelas` as c ON a.`idkelas` = c.`id`
				JOIN `semester` as d ON a.`idsemester` = d.`id`
				JOIN `jenisujian` as e ON a.`idjenis` = e.`id`
				JOIN `aturannhb` as f ON a.`idaturan` = f.`id`
				JOIN `dasarpenilaian` AS dp ON f.`dasarpenilaian` = dp.`id`
				JOIN `rpp` as g ON a.`idrpp` = g.`id`
				JOIN `nilaiujian` AS h ON h.`idujian` = a.`id`
				WHERE a.`idpelajaran` = '$isi[idpelajaran]' AND a.`idkelas` = '$idkelas' AND a.`idsemester` = '$idsemester' AND a.`idjenis` = '$u[id]' AND h.`nis` = '$k[nis]' AND dp.`id` = '$idaturan'
				GROUP BY h.`nis`");
				$n = mysqli_fetch_assoc($qn);
				$qjml = mysqli_query($conn,"SELECT * FROM `ujian` WHERE `idpelajaran` = '$isi[idpelajaran]' AND `idkelas` = '$idkelas' AND `idsemester` = '$idsemester' AND `idjenis` = '$u[id]'");
				$jml = mysqli_num_rows($qjml);

				$sqltrans = mysqli_query($conn,"SELECT q.`id`, q.`judul`, q.`idkelas`, k.`kelas`, q.`idjenis`, j.`jenisujian`, q.`idsemester`, s.`semester`, q.`iddasarpenilaian`,dp.`keterangan` as dasarpenilaian, q.`idrpp`, r.`rpp`, q.`tgl_buat`, q.`waktu_pengerjaan`, q.`info`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
				FROM `topik_quiz` as q
				JOIN `pegawai` as b on b.nip = q.pembuat
				JOIN `pelajaran` as c on q.`idpelajaran` = c.`id`
				JOIN `guru` as a on a.`nip` = b.`nip`
				JOIN `kelas` as k on q.`idkelas` = k.`id`
				JOIN `jenisujian` as j on j.`id` = q.`idjenis`
				JOIN `semester` as s on s.`id` = q.`idsemester`
				JOIN `dasarpenilaian` as dp on q.`iddasarpenilaian` = dp.`id`
				JOIN `rpp` as r on q.`idrpp` = r.`id`
				JOIN `statusguru` as d on d.`id` = a.`statusguru` 
				WHERE a.`nip` = 'userId' AND q.`idkelas` = '$idkelas' AND q.`idsemester` = '$idsemester' AND q.`idjenis` = '$u[id]' AND dp.`id` = '$idaturan'") or die(mysqli_error());
				$cekq = mysqli_num_rows($sqltrans);
				if ($cekq !== 0) {
					//$i=1;
					$sumq=0;
					while($qz = mysqli_fetch_assoc($sqltrans)){
						$siswa_yangmengerjakan2 = mysqli_query($conn,"SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq = '$qz[id]' AND id_siswa='$k[nis]'");
						$t=mysqli_fetch_array($siswa_yangmengerjakan2);	
						$soal_pilganda = mysqli_query($conn,"SELECT * FROM quiz_pilganda WHERE idquiz='$qz[id]'");
						$pilganda = mysqli_num_rows($soal_pilganda);
						$soal_esay = mysqli_query($conn,"SELECT * FROM quiz_esay WHERE idquiz='$qz[id]'");
						$esay = mysqli_num_rows($soal_esay);										
						$nilai = mysqli_query($conn,"SELECT * FROM nilai_soal_esay WHERE id_tq='$qz[id]' AND id_siswa ='$k[nis]'");
						$n1 = mysqli_fetch_array($nilai);
						$nilai2 = mysqli_query($conn,"SELECT * FROM nilai WHERE id_tq='$qz[id]' AND id_siswa = '$k[nis]'");
						$n2 = mysqli_fetch_array($nilai2);
						if (!empty($pilganda) AND !empty($esay)){
							if ($t['dikoreksi']=='B'){
							  $hslq =  $n2['persentase']/2;
						  }else{									                          
							  $hslq =  ($n1['nilai']+$n2['persentase'])/2; 
						  }
						}elseif (empty($pilganda) AND !empty($esay)){
							if ($t['dikoreksi']=='B'){	                         
									$hslq = "0"; 
							  }else{									                      						                                                        
									$hslq =  $n1['nilai']; 
							  }
						}elseif (!empty($pilganda) AND empty($esay)){
							$hslq =  $n2['persentase'];
						}

					$sumq+=$hslq;
					//$i++;

					}

				$tjml = $jml+$cekq;
				$tsum = $n['nilai']+$sumq;
				$rata=($tsum!=0)?($tsum/$tjml):0;
				echo round($rata);							      		
				$nap = $rata * $u['bobot'];								      	
				$sumn +=$nap;
				}else{
				$hsl = ($n['nilai']!=0)?($n['nilai']/$jml):0;
				echo round($hsl);
				$nap = $hsl * $u['bobot'];								      	
				$sumn +=$nap;
				}

			$nilakhirpk = round($sumn / $rt['bobotPK']);
			echo $nilakhirpk;
		}
	}
	

	//$myJSON = json_encode($m);
	//echo $myJSON;
?>