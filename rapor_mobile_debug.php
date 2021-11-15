<html>

<?php

include"lib/conn.php";

$userId= $_GET['uid'];

$Keterangan = "";
$NPel = "";
$KlsKategori = "";
$KodeSub= "";
$NilaiSub="";

$querys = mysqli_query($conn,"SELECT * FROM dasarpenilaian order by posisi");
$is=1;
while($k = mysqli_fetch_assoc($querys)){									      		
	$Keteragan .= $k['keterangan'];
	
	
	$queryp = mysqli_query($conn,"SELECT * FROM pelajaran where sifat='$k[id]'");
	$ip=1;
	
	
	
	while($p = mysqli_fetch_assoc($queryp)){

		//echo 'ip = ' . $ip . PHP_EOL; 
		//echo 'p[nama] = ' . $p['nama'] . PHP_EOL; 
		
		$NPel .= $p['nama'];

		$queryk = mysqli_query($conn,"SELECT * FROM `rpp` WHERE `idpelajaran` = '$p[id]' AND idsemester = '$_GET[id]'");
		$queryk1 = mysqli_query($conn,"SELECT * FROM `rpp` WHERE `idpelajaran` = '$p[id]' AND idsemester = '$_GET[id]'");

		$temukan = mysqli_num_rows($queryk);
		$hs=$temukan+1;
		$jmkodep = 0;
		$jmkodek = 0;
		while ($c = mysqli_fetch_assoc($queryk1)) {
			
			$qtp = mysqli_query($conn,"SELECT  max(`uhke`) as totp FROM `raport_katagori` WHERE `idpelajaran` = '$p[id]' and `idrpp` ='$c[id]' and `jenisujian` ='Pengetahuan' ");
			$tp = mysqli_fetch_assoc($qtp);
			$qtk = mysqli_query($conn,"SELECT  max(`uhke`) as totk FROM `raport_katagori` WHERE `idpelajaran` = '$p[id]' and `idrpp` ='$c[id]' and `jenisujian` ='Keterampilan' ");
			$tk = mysqli_fetch_assoc($qtk);
			
			$jmkodep += $tp['totp'];
			$jmkodek += $tk['totk'];
		}	
		$qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$userId' and `idpelajaran` = '$p[id]'");
		$tps = mysqli_fetch_assoc($qtps);
		$jrt = $tps['totp'];
		$kodeb = $jmkodep + $jmkodek;
		if ($kodeb <= 0) $kodeb = 1;
		$trt = ($jrt!=0)?($jrt/$kodeb):0;

		if ($trt >= 95) {
			$kelas = "A";
		}elseif ($trt >= 90) {
			$kelas = "B";
		}elseif ($trt >= 85) {
			$kelas = "C";
		}elseif ($trt >= 80) {
			$kelas = "D";
		}elseif ($trt <= 80) {
			$kelas = "E";
		}
		
		//echo 'hs = ' . $hs . "\n"; echo 'kelas = ' . $kelas . "\n" ;
		
		$KlsKategori .= $kelas . "#MAY#";
		
		$ik=1;
		while($kd = mysqli_fetch_assoc($queryk)){

			//echo 'ik = ' . $ik . "\n";  echo 'kd[rpp] = ' . $kd['rpp'] . "\n" ;
			$KodeSub .= $kd['rpp'] . "#MAY#";
			$no=1;
			for ($x=0; $x < 3; $x++) { 
				$q = mysqli_query($conn,"SELECT * FROM `raport_katagori` WHERE `nis`='$userId' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]' and `jenisujian` ='Pengetahuan' and `uhke` ='$no'");
				$te = mysqli_num_rows($q);
				if($te > 0)
				{
					$t = mysqli_fetch_assoc($q);
					$nilai = $t['nilai'];
					$jnp[] = $t['nilai']; 
				}else{
					$nilai = '-';
				}

				$NilaiSub .= $nilai ."#uh#";
				//echo 'nilai pengetahuan= ' . $nilai . "\n";
				$no++;
			}

			$no=1;
			for ($x=0; $x < 3; $x++) { 
				$q = mysqli_query($conn,"SELECT * FROM `raport_katagori` WHERE `nis`='$userId' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]' and `jenisujian` ='Keterampilan' and `uhke` ='$no'");
				$te = mysqli_num_rows($q);
				if($te > 0)
				{
					$t = mysqli_fetch_assoc($q);
					$nilai = $t['nilai'];
					$jnp[] = $t['nilai']; 
				}else{
					$nilai = '-';
				}
				
				$NilaiSub .= $nilai ."#uh#";
				//echo 'nilai keterampilan= ' . $nilai . "\n";
				$no++;
			}

			$qtp = mysqli_query($conn,"SELECT  max(`uhke`) as totp FROM `raport_katagori` WHERE `nis`='$userId' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]' and `jenisujian` ='Pengetahuan' ");
			$tp = mysqli_fetch_assoc($qtp);
			$qtk = mysqli_query($conn,"SELECT  max(`uhke`) as totk FROM `raport_katagori`  WHERE `nis`='$userId' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]' and `jenisujian` ='Keterampilan' ");
			$tk = mysqli_fetch_assoc($qtk);

			$qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$userId' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]'");
			$tps = mysqli_fetch_assoc($qtps);
			$jrt = $tps['totp'];
			$kodeb = $tp['totp'] + $tk['totk'];
			if ($kodeb <= 0) $kodeb = 1;
			$trt = ($jrt!=0)?($jrt/$kodeb):0;

			///echo 'round (trt,1) = ' . round($trt,1) . "\n";

			$ik++;
			$NilaiSub .= "#mp#";
		}
		
		$NPel .= '=' . ($ik - 1) . "#M#";
		
		$ip++;
	}
	$NPel .= "#MAY#";
	$Keteragan .= "=" . ($ip -1) . "#MAY#";
	$is++;
}

$querys = mysqli_query($conn,"SELECT * FROM dasarpenilaian WHERE keterangan LIKE '%Peminatan%'");
$sqlp = mysqli_fetch_assoc($querys);
$q= mysqli_query($conn,"SELECT * FROM pelajaran WHERE sifat = '$sqlp[id]'");
$jmqmk = mysqli_num_rows($q);	
$jrtp = 0;
while($kd = mysqli_fetch_assoc($q)){
	$qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$_SESSION[login_user]' and `idpelajaran` = '$kd[id]'");
	$tps = mysqli_fetch_assoc($qtps);
	$jrtp += $tps['totp'];
}		  
$rtnp = $jrtp/$jmqmk;    
if ($rtnp >= 95) {
	$kelas = "A";
}elseif ($rtnp >= 90) {
	$kelas = "B";
}elseif ($rtnp >= 85) {
	$kelas = "C";
}elseif ($rtnp >= 80) {
	$kelas = "D";
}elseif ($rtnp <= 80) {
	$kelas = "E";
}	
	
/*	
echo 'Rata Nilai Perminatan : ' . round($rtnp,1) . "\n";
echo 'Kelas Katagori : ' . $kelas . "\n";
*/

$RataNilai = round($rtnp,1);
$KlsKategoriSum = $kelas;

					
?>
<p> <?php echo $Keteragan?></p>
<p> <?php echo $NPel?></p>
<p> <?php echo $KlsKategori?></p>
<p> <?php echo $KodeSub?></p>
<p> <?php echo $NilaiSub?></p>
<p> <?php echo $RataNilai?></p>
<p> <?php echo $KlsKategoriSum?></p>

</html>