<?php

    date_default_timezone_set('Asia/Jakarta');
    include"../../../session.php";
    include"../../../lib/fungsi_indotgl.php";
    $querys = mysqli_query($conn,"SELECT * FROM siswa WHERE id = '$_GET[id]'");
    $siswa = mysqli_fetch_assoc($querys);
    $querykl = mysqli_query($conn,"SELECT a.`id`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
												FROM `kelas` as a
												JOIN `pegawai` as b on a.nipwali = b.nip
												JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id` WHERE a.id = '$siswa[idkelas]'");
    $kls = mysqli_fetch_assoc($querykl);
    $querysm = mysqli_query($conn,"SELECT * FROM semester WHERE id = '$_GET[idsemester]'");
    $sm= mysqli_fetch_assoc($querysm);
	$date=date('Y-m-d');
	$tgl=tglindo($date);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">

    <title>RAPORT</title>

    <!--Core CSS -->
    <link href="../../../bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../css/bootstrap-reset.css" rel="stylesheet">
    <link href="../../../font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="../../../css/style.css" rel="stylesheet">
    <link href="../../../css/style-responsive.css" rel="stylesheet" />

    <link href="../../../css/invoice-print.css" rel="stylesheet" media="all">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<section id="container" class="print" >

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->

        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body invoice">
                    	<div style="border: 3px #1780dd solid; padding: 10px;background-color:#ffffff;">
							<table width="100%">
								<tr>
									<td width="25%" align="center"><img src="../../../images/logokop.png" width="40%"></td>
									<td width="75%" align="center">
										<b><font size="2">PEMERINTAH PROVINSI JAWA TIMUR</font></b>
										<br>
										<b><font size="2">DINAS PENDIDIKAN</font></b>
										<br>
										<b><font size="3">SMA NEGERI 2 SIDOARJO</font></b>
										<br>
										<font size="1">Jalan Lingkar Barat Gading Fajar 2 Sidoarjo</font>
										<br>
										<font size="1">E-mail : smanda_sda@yahoo.com, Website : www.sman2sidaorjo.sch.id</font>
									</td>
								</tr>
							</table>
								<div style="border: 1px #000 solid; padding: 1px;background-color:#ffffff;"></div>
							<table width="100%">
								<tr>
									<td align="center">
										<b><font size="2">RAPORT KATAGORI</font></b>
					                    <br>
					                    <b><font size="2"><?php echo $sm['semester'] ?></font></b>       
										<br>
										<b><font size="2">TAHUN AJARAN <?php echo $kls['tahunajaran'] ?></font></b>
									</td>
								</tr>
							</table>
							<br>
							<table width="100%">
								<tr>
									<td width="25%">Nama Peserta Didik</td>
									<td align="center" width="2%" >:</td>
									<td ><?php echo $siswa['nama'] ?></td>
								</tr>
								<tr>
									<td>Nomor Induk</td>
									<td align="center">:</td>
									<td><?php echo $siswa['nis'] ?></td>
								</tr>
								<tr>
									<td>NIPDN</td>
									<td align="center">:</td>
									<td></td>
								</tr>
								<tr>
									<td>Kelas</td>
									<td align="center">:</td>
									<td><?php echo $kls['kelas'] ?></td>
								</tr>
							</table>
							<table width="100%" border="1">		
							      <tr>
							        <th width="10" style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center"><font size="1">No</font></th>
							        <th width="40" style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center"><font size="1">Mata Pelajaran</font></th>
							        <th colspan="3" class="text-center">Pengetahuan</th></th>
							        <th colspan="3" class="text-center">Keterampilan</th></th>
							        <th style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center"><font size="1">Rata -Rata Nilai</font></th>
							      	<th style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center"><font size="1">Kelas Katagori</font></th>
							      </tr>
							      <tr>
							        <th class="text-center"><font size="1">UH1</font></th>
							        <th class="text-center"><font size="1">UH2</font></th>
							        <th class="text-center"><font size="1">UH3</font></th>
							      	
							        <th class="text-center"><font size="1">UH1</font></th>
							        <th class="text-center"><font size="1">UH2</font></th>
							        <th class="text-center"><font size="1">UH3</font></th>
							      	
							      </tr>
							    	<?php
							      	$querys = mysqli_query($conn,"SELECT * FROM dasarpenilaian order by posisi");
							      	$is=1;
							      	while($k = mysqli_fetch_assoc($querys)){									      		
							      	?>
							      <tr>
							      	
							        <th colspan="10"><?php echo $k['keterangan'] ?></th>
									 </tr>
							        <?php
							        $queryp = mysqli_query($conn,"SELECT * FROM pelajaran where sifat='$k[id]'");
							      	$ip=1;
							      	while($p = mysqli_fetch_assoc($queryp)){
							        ?>
							        <tr>
							        <th class="text-center"><font size="1"><?php echo $ip ?></font></th>
							        <td width="20%"><font size="1"><?php echo $p['nama'] ?></font></td>
							        <td colspan="7"></td>
							       	
							      		
							      		<?php
								        $queryk = mysqli_query($conn,"SELECT * FROM `rpp` WHERE `idpelajaran` = '$p[id]' and idsemester = '$_GET[idsemester]'");
								        $queryk1 = mysqli_query($conn,"SELECT * FROM `rpp` WHERE `idpelajaran` = '$p[id]' and idsemester = '$_GET[idsemester]'");
								        
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
										$qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$siswa[nis]' and `idpelajaran` = '$p[id]'");
							        	$tps = mysqli_fetch_assoc($qtps);
							        	$jrt = $tps['totp'];
							        	$kodeb = $jmkodep + $jmkodek;
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
								      	?>

							    	<td style="vertical-align : middle;text-align:center;" rowspan="<?php echo $hs ?>"><font size="1"><?php echo $kelas ?></font></td>
							    	</tr>
								      	<?php
								      	$ik=1;
								      	while($kd = mysqli_fetch_assoc($queryk)){

								        ?>
								     <tr>
								     	<td><font size="1">KD<?php echo $ik ?></font></td>
								        <td><font size="1"><?php echo $kd['rpp'] ?></font></td>
								        <?php
								        $no=1;
								        for ($x=0; $x < 3; $x++) { 
							        		$q = mysqli_query($conn,"SELECT * FROM `raport_katagori` WHERE `nis`='$siswa[nis]' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]' and `jenisujian` ='Pengetahuan' and `uhke` ='$no'");
											$te = mysqli_num_rows($q);
											if($te > 0)
											{
												$t = mysqli_fetch_assoc($q);
												$nilai = $t['nilai'];
												$jnp[] = $t['nilai']; 
											}else{
												$nilai = '-';
											}
								        ?>
								        <td align="center" ><font size="1"><?php echo $nilai ?></font></td>
								        <?php
								        $no++;
								    	}
								        ?>
								        <?php
								        $no=1;
								        for ($x=0; $x < 3; $x++) { 
							        		$q = mysqli_query($conn,"SELECT * FROM `raport_katagori` WHERE `nis`='$siswa[nis]' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]' and `jenisujian` ='Keterampilan' and `uhke` ='$no'");
											$te = mysqli_num_rows($q);
											if($te > 0)
											{
												$t = mysqli_fetch_assoc($q);
												$nilai = $t['nilai'];
												$jnp[] = $t['nilai']; 
											}else{
												$nilai = '-';
											}
								        ?>
								        <td align="center" ><font size="1"><?php echo $nilai ?></font></td>

								        <?php
								        $no++;
								    	}
								        ?>
								        <?php
								        $qtp = mysqli_query($conn,"SELECT  max(`uhke`) as totp FROM `raport_katagori` WHERE `nis`='$siswa[nis]' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]' and `jenisujian` ='Pengetahuan' ");
							        	$tp = mysqli_fetch_assoc($qtp);
							        	$qtk = mysqli_query($conn,"SELECT  max(`uhke`) as totk FROM `raport_katagori`  WHERE `nis`='$siswa[nis]' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]' and `jenisujian` ='Keterampilan' ");
							        	$tk = mysqli_fetch_assoc($qtk);
							        	
							        	$qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$siswa[nis]' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]'");
							        	$tps = mysqli_fetch_assoc($qtps);
							        	$jrt = $tps['totp'];
								        $kodeb = $tp['totp'] + $tk['totk'];
							        	if ($kodeb <= 0) $kodeb = 1;
							        	$trt = ($jrt!=0)?($jrt/$kodeb):0;
							        	
								        ?>
								        <td align="center"><font size="1"><?php echo round($trt,1) ?></font></td>
								       
							      	</tr>
							      	<?php
							      	$ik++;
							      	}
							      	$ip++;
							      	}
							      	$is++;
							      	}
							      	?>
							      </table>
						 <?php
						    $querys = mysqli_query($conn,"SELECT * FROM dasarpenilaian WHERE keterangan LIKE '%Peminatan%'");
							$sqlp = mysqli_fetch_assoc($querys);
							$q= mysqli_query($conn,"SELECT * FROM pelajaran WHERE sifat = '$sqlp[id]'");
							$jmqmk = mysqli_num_rows($q);	
							$jrtp = 0;
							while($kd = mysqli_fetch_assoc($q)){
								$qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$siswa[nis]' and `idpelajaran` = '$kd[id]'");
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
						    ?>
						    <br>
						    <table width="100%">
						    	<td width="5%"></td>
						    	<td width="40%" style="border: 1px #000 solid; padding: 10px;background-color:#ffffff;"><b>Rata - Rata Nilai Perminatan : <?php echo round($rtnp,1) ?></b></td>
						    	<td width="10%"></td>
						    	<td width="40%" style="border: 1px #000 solid; padding: 10px;background-color:#ffffff;"><b>Kelas Katagori : <?php echo $kelas ?></b></td>
						    	<td width="5%"></td>
						    	
						    </table>
						    <table width="100%">
						    	<tr>
						    		<td width="30%" align="center">Mengetahui, <br> Wali Kelas,</td>
						    		<td width="40%" align="center"><br> Orang Tua/ Wali,</td>
						    		<td width="30%" align="center">Sidoarjo, <?php echo $tgl; ?> <br> Wali Kelas,</td>
						    	</tr>
						    	<tr height="30px">
						    	</tr>
						    	<tr>
						    		<td width="30%" align="center"><u><?php echo $kls['nama'] ?></u></td>
						    		<td width="40%" align="center">________________</td>
						    		<td width="30%" align="center"><u><?php echo $kls['nama'] ?></u></td>
						    	</tr>
						    </table>
						    
						</div>
                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
        </section>
    </section>
    <!--main content end-->

</section>

<!-- Placed js at the end of the document so the pages load faster -->

<!--Core js-->
<script src="../../../js/jquery.js"></script>
<script src="../../../bs3/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../../js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../../js/jquery.scrollTo.min.js"></script>
<script src="../../../js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="../../../js/jquery.nicescroll.js"></script>
<!--Easy Pie Chart-->
<script src="../../../js/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="../../../js/sparkline/jquery.sparkline.js"></script>
<!--jQuery Flot Chart-->
<script src="../../../js/flot-chart/jquery.flot.js"></script>
<script src="../../../js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="../../../js/flot-chart/jquery.flot.resize.js"></script>
<script src="../../../js/flot-chart/jquery.flot.pie.resize.js"></script>


<!--common script init for all pages-->
<script src="../../../js/scripts.js"></script>

<script type="text/javascript">
    window.print();
</script>

</body>
</html>
