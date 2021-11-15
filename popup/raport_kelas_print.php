 <?php
date_default_timezone_set("Asia/Jakarta");
	$idkelas=$_GET['idkelas'];
	$idsemester=$_GET['idsemester'];
    $qsms = mysqli_query($conn,"SELECT * FROM semester WHERE id = '$idsemester'");
		$sms = mysqli_fetch_assoc($qsms);
		$qdtl = "SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` and d.alumni='0' ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
		FROM `kelas` as a
		JOIN `pegawai` as b on a.nipwali = b.nip
		JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
		WHERE a.id = '$idkelas'";
	$sqldtl = mysqli_query($conn,$qdtl);	
	$dtl = mysqli_fetch_assoc($sqldtl);
    
				
?>
<body>
	<div class="page">
		<div class="subpage" style="margin-left: 10mm; margin-right: 10mm; ">
			<br>
<br>
    <table width="100%">
		<tr>
			<td>
			    <table>
			        <thead>
			            <tr align="left">
				            <td>
				                <th>
				                    <img class="user-image" src="../assets/print/logo.png" alt="" style="width:auto; height:auto; max-width:90px; max-height:90px; display:block;">				                    	
			                    </th>
				                <th>                
				                <table>
				                    <thead>
				                        <tr>
				                            <th align="center"><h4 class="w3-text-blue" style="padding-bottom:0;margin-bottom:0;"><b>Pondok Pesantren Attauhidiyyah Syaikh Sa'id Bin Armia</b></h4></th>
				                        </tr>
				                    </thead>
				                    <tbody>
				                        <tr>
				                            <td align="center">Giren - Talang - Tegal </td>
				                        </tr>				        
				                        
				                    </tbody>
				                </table>
				                </th>
				            </td>
			            </tr>
			        </thead>
			    </table>
			
		</tr>
	</table>
	<div style="padding-top:-5;">
		<hr style="margin-top: -1; color: #000000; margin-bottom: 1;" />
	</div>
        <div style="width: 100%; ">
            
        	<table width="100%" border="0">
							<tr>
								<td width="17%" style="vertical-align: top; font-weight:bold; ">Kelas</td>
        						<td style="vertical-align: top;">:&nbsp;<?php echo $dtl['kelas']?></td>
							</tr>
							<tr>
								<td width="17%" style="vertical-align: top; font-weight:bold; ">Wali Kelas</td>
        						<td style="vertical-align: top;">:&nbsp;<?php echo $dtl['nama']?></td>
							</tr>
        					<tr>
        						<td width="17%" style="vertical-align: top; font-weight:bold; ">Semester</td>
								<td style="vertical-align: top;">:&nbsp;<?php echo $sms['semester'] ?></td>
							</tr>
        					<tr>
								<td width="17%" style="vertical-align: top; font-weight:bold;">Tahun Ajaran</td>
								<td style="vertical-align: top;">:&nbsp;<?php echo $dtl['tahunajaran'] ?></td>
        					</tr>
        									
        	</table>
        	<!--
        	<div style="padding-top:-5;">
        		<hr style="margin-top: -1; color: #000000; margin-bottom: 1;" />
        	</div>
        	-->
        	<br>
        	<table width="100%" border="1">
        		<tr>
            		<th rowspan="2" class="text-center" style="font-weight:bold; border:1px solid black;">No</th>
                    <th rowspan="2" class="text-center" style="font-weight:bold; border:1px solid black;">NIS</th>
            		<th rowspan="2" class="text-center" style="font-weight:bold; border:1px solid black;">Nama Santri</th>
                    <?php
                    $qkw = "SELECT * FROM pelajaran WHERE tingkat = '$dtl[tingkat]' AND sifat = '5' order by id asc";
                    $sqlkw = mysqli_query($conn,$qkw);
            		$jmlw = mysqli_num_rows($sqlkw);	
            		?>
            		<th colspan="<?php echo $jmlw?>" class="text-center" style="font-weight:bold; border:1px solid black;">Mata Pelajaran</th>
            		<?php
                    $qkt = "SELECT * FROM pelajaran WHERE tingkat = '$dtl[tingkat]' AND sifat = '7' order by id asc";
                    $sqlkt = mysqli_query($conn,$qkt);
            		$jmlt = mysqli_num_rows($sqlkt);	
            		?>
            		<th colspan="<?php echo $jmlt?>" class="text-center" style="font-weight:bold; border:1px solid black;">Tes Kitab</th>
            		<?php
                    $qk8 = "SELECT * FROM pelajaran WHERE tingkat = '$dtl[tingkat]' AND sifat = '8' order by id asc";
                    $sqlk8 = mysqli_query($conn,$qk8);
            		$jml8 = mysqli_num_rows($sqlk8);	
            		?>
            		<th colspan="<?php echo $jml8?>" class="text-center" style="font-weight:bold; border:1px solid black;">Tamrin</th>
            		<?php
                    $qk9 = "SELECT * FROM pelajaran WHERE tingkat = '$dtl[tingkat]' AND sifat = '9' order by id asc";
                    $sqlk9 = mysqli_query($conn,$qk9);
            		$jml9 = mysqli_num_rows($sqlk9);	
            		?>
            		<th colspan="<?php echo $jml9?>" class="text-center" style="font-weight:bold; border:1px solid black;">Muhafadoh</th>
            		<?php
                    $qk10 = "SELECT * FROM pelajaran WHERE tingkat = '$dtl[tingkat]' AND sifat = '10' order by id asc";
                    $sqlk10 = mysqli_query($conn,$qk10);
            		$jml10 = mysqli_num_rows($sqlk10);	
            		while ($kh10 = mysqli_fetch_assoc($sqlk10)) {
                    ?>
                    <th rowspan="2" class="text-center" style="font-weight:bold; border:1px solid black;"><?php echo $kh10['nama']?></th>
                    <?php
                    }
                    ?>
                    <th rowspan="2" class="text-center" style="font-weight:bold; border:1px solid black;">Jumlah</th>
                    <th rowspan="2" class="text-center" style="font-weight:bold; border:1px solid black;">Rata</th>
            	</tr>  	 	
                <tr>
            		<?php											                    
                	if ($jmlw==0) {
                		?>
                		<th style="font-weight:bold; border:1px solid black;"></th>
                		<?php
                	}else{
                		while ($khw = mysqli_fetch_assoc($sqlkw)) {
                    	?>
                		<th class="text-center" style="font-weight:bold; border:1px solid black;"><?php echo $khw['nama']?></th>
                    	<?php
                    	}}
                    ?>
                    <?php											                    
                	if ($jmlt==0) {
                		?>
                		<th style="font-weight:bold; border:1px solid black;"></th>
                		<?php
                	}else{
                		while ($kht = mysqli_fetch_assoc($sqlkt)) {
                    	?>
                		<th class="text-center" style="font-weight:bold; border:1px solid black;"><?php echo $kht['nama']?></th>
                    	<?php
                    	}}
                    ?>
                    <?php											                    
                	if ($jml8==0) {
                		?>
                		<th style="font-weight:bold; border:1px solid black;"></th>
                		<?php
                	}else{
                		while ($kh8 = mysqli_fetch_assoc($sqlk8)) {
                    	?>
                		<th class="text-center" style="font-weight:bold; border:1px solid black;"><?php echo $kh8['nama']?></th>
                    	<?php
                    	}}
                    ?>
                    <?php											                    
                	if ($jml9==0) {
                		?>
                		<th style="font-weight:bold; border:1px solid black;"></th>
                		<?php
                	}else{
                		while ($kh9 = mysqli_fetch_assoc($sqlk9)) {
                    	?>
                		<th class="text-center" style="font-weight:bold; border:1px solid black;"><?php echo $kh9['nama']?></th>
                    	<?php
                    	}}
                    ?>
                    <?php											                    
                	if ($jml10==0) {
                		?>
                		<?php
                	}else{
                		while ($kh10 = mysqli_fetch_assoc($sqlk10)) {
                    	?>
                		<th class="text-center" style="font-weight:bold; border:1px solid black;"><?php echo $kh10['nama']?></th>
                    	<?php
                    	}}
                    ?>
            	</tr>
            	<?php
            		$query = "SELECT * 
            					FROM `siswa` as a
            					JOIN `kelas` as b ON a.`idkelas` = b.`id` 
            					WHERE `idkelas` = '$idkelas'";
            		$sql_kul = mysqli_query($conn,$query);	
            		$jmls = mysqli_num_rows($sql_kul);	
            		$i=1;
            		$x=0;
            		$jmlx=0;
            		$jmlrt=0;
            		while ($m = mysqli_fetch_assoc($sql_kul)) {
            	?>
                <tr class="">
                    <td align="center" style="font-weight:bold; border:1px solid black;"><?php echo $i ?></td>
                    <input type="hidden" name="id[]" value="<?php echo $m['id'] ?>">
            		<input type="hidden" name="nis[]" value="<?php echo $m['nis'] ?>">
                    <td align="center" style="font-weight:bold; border:1px solid black;"><?php echo $m['nis']?></td>
                    <td style="font-weight:bold; border:1px solid black;"><?php echo $m['nama']?></td>
                    <?php
                    $qp1 = "SELECT * FROM pelajaran WHERE tingkat = '$dtl[tingkat]' AND sifat = '5' order by id asc";
                    $sqlp1 = mysqli_query($conn,$qp1);
            		$p1 = mysqli_num_rows($sqlp1);	
            		if ($p1==0) {
            			$jm1 = 0;
            			?>
            			<td align="center">0</td>
            			<?php
            		}else{
            
                        $jm1 = 0;
                        while ($p1 = mysqli_fetch_assoc($sqlp1)) {
                    		$qu = mysqli_query($conn,"SELECT a.`id`, a.`idpelajaran`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`, a.`deskripsi`, a.`tanggal` 
            				FROM `ujian` as a
            				JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
            				JOIN `kelas` as c ON a.`idkelas` = c.`id`
            				JOIN `semester` as d ON a.`idsemester` = d.`id`
            				WHERE a.`idpelajaran` = '$p1[id]' AND a.`idkelas` = '$idkelas' AND a.`idsemester` = '$idsemester'");
            				$jml = mysqli_num_rows($qu);
              				$sumn=0;
              				while($u = mysqli_fetch_assoc($qu)){
              					$qn = mysqli_query($conn,"SELECT * FROM `nilaiujian` WHERE `idujian` = '$u[id]' AND `nis` = '$m[nis]'");
              					$n = mysqli_fetch_assoc($qn);
              					$sumn+=$n['nilaiujian'];
              					}
              					$rata=($sumn!=0)?($sumn/$jml):0; 
              					$jrata = round($rata,1);
              			?>
              			<td align="center" style="font-weight:bold; border:1px solid black;"><?php echo $jrata ?></td>	
              			<?php
            				$jm1 = $jm1 + floatval($jrata);
              			}
            		}
                    ?>
                    <?php
                    $qp7 = "SELECT * FROM pelajaran WHERE tingkat = '$dtl[tingkat]' AND sifat = '7' order by id asc";
                    $sqlp7 = mysqli_query($conn,$qp7);
            		$p7 = mysqli_num_rows($sqlp7);	
            		if ($p7==0) {
            			$jm7 = 0;
            			?>
            			<td align="center" style="font-weight:bold; border:1px solid black;">0</td>
            			<?php
            		}else{
                         $jm7 = 0;
                         while ($p7 = mysqli_fetch_assoc($sqlp7)) {
                    		$qu = mysqli_query($conn,"SELECT a.`id`, a.`idpelajaran`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`, a.`deskripsi`, a.`tanggal` 
            				FROM `ujian` as a
            				JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
            				JOIN `kelas` as c ON a.`idkelas` = c.`id`
            				JOIN `semester` as d ON a.`idsemester` = d.`id`
            				WHERE a.`idpelajaran` = '$p7[id]' AND a.`idkelas` = '$idkelas' AND a.`idsemester` = '$idsemester'");
            				$jml = mysqli_num_rows($qu);
              				$sumn=0;
              				while($u = mysqli_fetch_assoc($qu)){
              					$qn = mysqli_query($conn,"SELECT * FROM `nilaiujian` WHERE `idujian` = '$u[id]' AND `nis` = '$m[nis]'");
              					$n = mysqli_fetch_assoc($qn);
              					$sumn+=$n['nilaiujian'];
              					}
              					$rata7=($sumn!=0)?($sumn/$jml):0; 
              					$jrata7 =round($rata7,1);
              			?>
              			<td align="center" style="font-weight:bold; border:1px solid black;"><?php echo $jrata7 ?></td>	
              			<?php
            
            				$jm7 = $jm7 + floatval($jrata7);
              			}
            		}											                    
                    ?>
            		<?php
                    $qp8 = "SELECT * FROM pelajaran WHERE tingkat = '$dtl[tingkat]' AND sifat = '8' order by id asc";
                    $sqlp8 = mysqli_query($conn,$qp8);
            		$p8 = mysqli_num_rows($sqlp8);	
            		if ($p8==0) {
            			$jm8 = 0;
            			?>
            			<td align="center" style="font-weight:bold; border:1px solid black;">0</td>
            			<?php
            		}else{
                         $jm8 = 0;
                         while ($p8 = mysqli_fetch_assoc($sqlp8)) {
                    		$qu = mysqli_query($conn,"SELECT a.`id`, a.`idpelajaran`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`, a.`deskripsi`, a.`tanggal` 
            				FROM `ujian` as a
            				JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
            				JOIN `kelas` as c ON a.`idkelas` = c.`id`
            				JOIN `semester` as d ON a.`idsemester` = d.`id`
            				WHERE a.`idpelajaran` = '$p8[id]' AND a.`idkelas` = '$idkelas' AND a.`idsemester` = '$idsemester'");
            				$jml = mysqli_num_rows($qu);
              				$sumn=0;
              				while($u = mysqli_fetch_assoc($qu)){
              					$qn = mysqli_query($conn,"SELECT * FROM `nilaiujian` WHERE `idujian` = '$u[id]' AND `nis` = '$m[nis]'");
              					$n = mysqli_fetch_assoc($qn);
              					$sumn+=$n['nilaiujian'];
              					}
              					$rata8=($sumn!=0)?($sumn/$jml):0; 
              					$jrata8=round($rata8,1);
              			?>
              			<td align="center" style="font-weight:bold; border:1px solid black;"><?php echo $jrata8 ?></td>	
              			<?php
              			$jm8 = $jm8 + floatval($jrata8);
              			}
            		}
                    
                    ?>
                    <?php
                    $qp9 = "SELECT * FROM pelajaran WHERE tingkat = '$dtl[tingkat]' AND sifat = '9' order by id asc";
                    $sqlp9 = mysqli_query($conn,$qp9);
                    $p9 = mysqli_num_rows($sqlp9);	
            		if ($p9==0) {
            			$jm9 = 0;
            			?>
            			<td align="center" style="font-weight:bold; border:1px solid black;">0</td>
            			<?php
            		}else{
                        $jm9=0;
                        while ($p9 = mysqli_fetch_assoc($sqlp9)) {
                    		$qu = mysqli_query($conn,"SELECT a.`id`, a.`idpelajaran`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`, a.`deskripsi`, a.`tanggal` 
            				FROM `ujian` as a
            				JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
            				JOIN `kelas` as c ON a.`idkelas` = c.`id`
            				JOIN `semester` as d ON a.`idsemester` = d.`id`
            				WHERE a.`idpelajaran` = '$p9[id]' AND a.`idkelas` = '$idkelas' AND a.`idsemester` = '$idsemester'");
            				$jml = mysqli_num_rows($qu);
              				$sumn=0;
              				while($u = mysqli_fetch_assoc($qu)){
              					$qn = mysqli_query($conn,"SELECT * FROM `nilaiujian` WHERE `idujian` = '$u[id]' AND `nis` = '$m[nis]'");
              					$n = mysqli_fetch_assoc($qn);
              					$sumn+=$n['nilaiujian'];
              					}
              					$rata9=($sumn!=0)?($sumn/$jml):0; 
              					$jrata9=round($rata9,1);
              			?>
              			<td align="center" style="font-weight:bold; border:1px solid black;"><?php echo $jrata9 ?></td>	
              			<?php
              			$jm9 = $jm9 + floatval($jrata9);
              			}
              		}
                    ?>
                    <?php
                    $qp10 = "SELECT * FROM pelajaran WHERE tingkat = '$dtl[tingkat]' AND sifat = '10' order by id asc";
                    $sqlp10 = mysqli_query($conn,$qp10);
                    $p10 = mysqli_num_rows($sqlp10);	
            		if ($p10==0) {
            			$jm10 = 0;
            			?>
            			<?php
            		}else{
                        $jm10=0;
                        while ($p10 = mysqli_fetch_assoc($sqlp10)) {
                    		$qu = mysqli_query($conn,"SELECT a.`id`, a.`idpelajaran`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`, a.`deskripsi`, a.`tanggal` 
            				FROM `ujian` as a
            				JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
            				JOIN `kelas` as c ON a.`idkelas` = c.`id`
            				JOIN `semester` as d ON a.`idsemester` = d.`id`
            				WHERE a.`idpelajaran` = '$p10[id]' AND a.`idkelas` = '$idkelas' AND a.`idsemester` = '$idsemester'");
            				$jml = mysqli_num_rows($qu);
              				$sumn=0;
              				while($u = mysqli_fetch_assoc($qu)){
              					$qn = mysqli_query($conn,"SELECT * FROM `nilaiujian` WHERE `idujian` = '$u[id]' AND `nis` = '$m[nis]'");
              					$n = mysqli_fetch_assoc($qn);
              					$sumn+=$n['nilaiujian'];
              					}
              					$rata10=($sumn!=0)?($sumn/$jml):0; 
              					$jrata10 = round($rata10,1);
              			?>
              			<td align="center" style="font-weight:bold; border:1px solid black;"><?php echo $jrata10 ?></td>	
              			<?php
              			$jm10 = $jm10 + floatval($jrata10);
              			}
              		}
              		$total = $jm1+$jm7+$jm8+$jm9+$jm10;
              		$qk = "SELECT * FROM pelajaran WHERE tingkat = '$dtl[tingkat]' order by id asc";
                    $sqlk = mysqli_query($conn,$qk);
            		$jmlp = mysqli_num_rows($sqlk);	
            		$ratatotal = $total/$jmlp;
                    ?>
                    <td style="font-weight:bold; border:1px solid black;"><?php echo $total ?></td>
                    <td style="font-weight:bold; border:1px solid black;"><?php echo round($ratatotal,1) ?></td>
                </tr>
            	
                <?php
             		 $x++;
             		 $i++;
             	 }
             	?>
        	</table>
        </div>
		</div>
	</div>
</body>
<style>
	.epage{
		margin: 0 auto;
		width: 210mm;
		height: auto;
		background-color: white !important;
		display: table;
        content: "";
        clear: both;
	}
    .pagebreak { page-break-before: always; } /* page-break-after works, as well */
    .etiket{
        padding: 1%;
        width: 31%;
        border: 1px dashed #ccc;
        float: left;
    }
    .clearf{
        margin: 0;
        padding: 0;
        display: table;
        content: "";
        clear: both;
    }
    .sm50{
        float: left;
        width: 45%;
        height: 50px;
    }
    #promo{
    	white-space: pre-line;
    }
    .lefts{
        float: left;
    }
    .rights{
        float: right;
    }
    .clearfix{
        clear: both;
        float: none;
    }
    /*--------- EHeader ------*/
    .eheader{
        width: 100%;
        font-size: ;
    }

    .identitas{
        max-width: 70%;
        height: auto;
    }
    .foto{
        width: 25%;
        height: auto;
    }
    .user-image{
        margin-right: 10px;
        max-width: 50px;
        max-height: 50px;
    }
    .kl-nama{
        margin:0;
        padding: 0;
    }
    .kl-alamat{
        margin:0;
        font-size: 8px;
    }


    /* ------ EContent ---------*/
    .econtent{
        width: 100%;
        font-size: ;
    }
    .econtent p{
        margin: 3px 5px 3px 1px;
    }
</style>
<style>
	body{
		font-family : Arial;
		font-size:8px;
		font-style: bold;
		margin: 0;
		background-color: #404040;
	}
	#invoice{
		font-family : Courier New;
		font-style: bold;		
		font-size: 200%;
		font-weight:bold;
		letter-spacing: 8px;
		padding-bottom:10px;
	}
    .page {
        width: 297mm;
        height: 210mm;*/
        min-height: 147mm;
        /*padding: 1mm;*/
        margin: 1mm auto;
        background: white;
        /*border: 1px solid red;*/
    }
    .subpage {
        /*margin-left:0cm;*/
	    /*margin-right:0cm;*/
	    /*height: 148mm;*/
	    /*margin-bottom: 0cm;*/
	    /*border: 1px solid red;*/
    }
    #promo{
    	white-space: pre-line;
    }
    
    @page {
	  	size: A4 landscape;
	 	 margin: 0;
	}

	@media print {
		/*html, body {
			width: 210mm;
			height: 148.5mm;
		}*/
		.page {
	        margin: 0;
	        border: initial;
	        border-radius: initial;
	        width: initial;
	        min-height: initial;
	        box-shadow: initial;
	        background: initial;
	        page-break-after: always;
	    }
	}
</style>
	<script type="text/javascript">
		function myFunction() {
		    window.print();
		}
		window.onload = myFunction;	
	</script>
