 <?php
date_default_timezone_set("Asia/Jakarta");
	$idkelas=$_GET['idkelas'];
 $idpel = $_GET['idpel'];
    $idsemester = $_GET['idsemester'];
    $qsms = mysqli_query($conn,"SELECT * FROM semester WHERE id = '$idsemester'");
    $sms = mysqli_fetch_assoc($qsms);
    $qdtl = "SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` and d.alumni='0' ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
    	FROM `kelas` as a
    	JOIN `pegawai` as b on a.nipwali = b.nip
    	JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
    	WHERE a.id = '$idkelas'
    ";
    $sqldtl = mysqli_query($conn,$qdtl);	
    $dtl = mysqli_fetch_assoc($sqldtl);
    $qisi = "SELECT a.`id`, a.`kode`, a.`nama`, a.`kkm`, a.`tingkat`, a.`sifat`, b.`kode` as kelompok, b.`keterangan` 
    		FROM `pelajaran` as a
    		JOIN `aspekkelompok` as b ON a.`sifat` = b.`id`
    		WHERE a.`id` = '$idpel'
    ";
    $sqlisi = mysqli_query($conn,$qisi);
    $isi = mysqli_fetch_assoc($sqlisi);
    
				
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
								<td width="17%" style="vertical-align: top; font-weight:bold;">Pelajaran</td>
								<td style="vertical-align: top;">:&nbsp;<?php echo $isi['nama'] ?></td>
        					</tr>
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
        									
        	</table>
        	<!--
        	<div style="padding-top:-5;">
        		<hr style="margin-top: -1; color: #000000; margin-bottom: 1;" />
        	</div>
        	-->
        	<br>
        	<table width="100%" border="1">
        		<tr>
             		<th class="text-center" style="font-weight:bold; border:1px solid black;">No</th>
             		<th class="text-center" style="font-weight:bold; border:1px solid black;">NIS</th>
             		<th class="text-center" style="font-weight:bold; border:1px solid black;">Nama</th>
             		
             		<?php
                 		$qsms = "SELECT * FROM semester WHERE id = '$idsemester'";
                			$asms = mysqli_query($conn,$qsms);	
                			while ($ss = mysqli_fetch_assoc($asms)) {
                		      	$i=1;
                		      	
                              	$qu = mysqli_query($conn,"SELECT a.`id`, a.`idpelajaran`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`, a.`deskripsi`, a.`tanggal` 
                            	FROM `ujian` as a
                            	JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
                            	JOIN `kelas` as c ON a.`idkelas` = c.`id`
                            	JOIN `semester` as d ON a.`idsemester` = d.`id`
                            	WHERE a.`idpelajaran` = '$isi[id]' AND a.`idkelas` = '$idkelas' AND a.`idsemester` = '$ss[id]'");
                            	$jml = mysqli_num_rows($qu);
                		      	while($u = mysqli_fetch_assoc($qu)){
                      	?>
                      	<th class="text-center" style="font-weight:bold; border:1px solid black;"><?php echo getBulanHijriah($u['deskripsi']) ?></th>
                      	<?php
                	      	$i++;
                	      	}
                	     ?>					
                 			<th class="text-center" style="font-weight:bold; border:1px solid black;">Jumlah</th>		
                 			<th class="text-center" style="font-weight:bold; border:1px solid black;">Rata - Rata</th>
                	     <?php
                	      }
                	    ?>
             		
             	</tr>  	
                <?php
	      	$querys = mysqli_query($conn,"SELECT * FROM siswa WHERE idkelas = '$idkelas'");
	      	$is=1;
	      	while($k = mysqli_fetch_assoc($querys)){
        	    ?>
        	    <tr>
        	      	<th class="text-center" style="font-weight:bold; border:1px solid black;"><?php echo $is ?></th>
        	        <td align="center" style="font-weight:bold; border:1px solid black;"><?php echo $k['nis'] ?></td>
        	        <td style="font-weight:bold; border:1px solid black;"><?php echo $k['nama'] ?></td>		
        	        <?php
        	        $qsms = "SELECT * FROM semester WHERE id = '$idsemester'";
        				$asms = mysqli_query($conn,$qsms);	
        				while ($ss = mysqli_fetch_assoc($asms)) {
        			      	$qu = mysqli_query($conn,"SELECT a.`id`, a.`idpelajaran`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`, a.`deskripsi`, a.`tanggal` 
        					FROM `ujian` as a
        					JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
        					JOIN `kelas` as c ON a.`idkelas` = c.`id`
        					JOIN `semester` as d ON a.`idsemester` = d.`id`
        					WHERE a.`idpelajaran` = '$isi[id]' AND a.`idkelas` = '$idkelas' AND a.`idsemester` = '$ss[id]'");
        			      	$jml = mysqli_num_rows($qu);
        			      	$i=1;
        			      	$sumn=0;
        			      	while($u = mysqli_fetch_assoc($qu)){
        	      	?>
        	        <td align="center" style="font-weight:bold; border:1px solid black;">
        	        	<?php
        		        	$qn = mysqli_query($conn,"SELECT * FROM `nilaiujian` WHERE `idujian` = '$u[id]' AND `nis` = '$k[nis]'");
        			      	$n = mysqli_fetch_assoc($qn);
        		        	?>
        		        	<?php echo $n['nilaiujian'] ?>
        	        	
        	        	
        	        </td>	
        	        <?php
        	      	$sumn+=$n['nilaiujian'];
        	      	$i++;
        	      	}							     	
              		$rata=($sumn!=0)?($sumn/$jml):0; 
           			?>	
                	<td align="center" style="font-weight:bold; border:1px solid black;"><?php echo $sumn ?></td>							      	
                	<td align="center" style="font-weight:bold; border:1px solid black;"><?php echo round($rata,1) ?></td>							      	
        			<?php
        		      }
        		    ?>	
        
         		</tr>
              	<?php
        	      	$is++;
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
		font-size:10px;
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
	  	size: A4 portrait;
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
