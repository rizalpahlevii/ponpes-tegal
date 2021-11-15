 <?php
date_default_timezone_set("Asia/Jakarta");
	$nis = $_GET['nis'];
     $idkelas=$_GET['idkelas'];
     $idsemester=$_GET['idsemester'];
    $qisi1 = "SELECT nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas
    		FROM siswa as s 
            left join kelas k on s.idkelas = k.id
            left join tahunajaran t on t.id = k.idtahunajaran
            where s.`nis` = '$nis'
    ";
    $sqlisi1 = mysqli_query($conn,$qisi1);
    $isi1 = mysqli_fetch_assoc($sqlisi1);
    
    $qsms = mysqli_query($conn,"SELECT * FROM semester WHERE id = '$idsemester'");
    						$sms = mysqli_fetch_assoc($qsms);
    $qkls = mysqli_query($conn,"SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` and d.alumni='0' ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
    						FROM `kelas` as a
    						JOIN `pegawai` as b on a.nipwali = b.nip
    						JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
    						WHERE a.id = '$idkelas'");
    $kls = mysqli_fetch_assoc($qkls);
				
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
								<td width="17%" style="vertical-align: top; font-weight:bold;">Nama Santri</td>
								<td style="vertical-align: top;">:&nbsp;<?php echo $isi1['nama'] ?></td>
        					</tr>
							<tr>
								<td width="17%" style="vertical-align: top; font-weight:bold; ">Kelas</td>
        						<td style="vertical-align: top;">:&nbsp;<?php echo $isi1['kelas'] ?></td>
							</tr>
        					<tr>
        						<td width="17%" style="vertical-align: top; font-weight:bold; ">Semster</td>
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
             		<th class="text-center" style="font-weight:bold; border:1px solid black;">Pelajaran</th>
             		<th class="text-center" style="font-weight:bold; border:1px solid black;">KKM</th>
             		<th class="text-center" style="font-weight:bold; border:1px solid black;">Angka</th>		
             		<th class="text-center" style="font-weight:bold; border:1px solid black;">Huruf</th>
             	</tr>  	
                <?php
                  	$querys = mysqli_query($conn,"SELECT * FROM `aspekkelompok`");
                  	$is=1;
                  	while($k = mysqli_fetch_assoc($querys)){
                  	$idaspek=$k['id'];
                ?>
                <tr>
                    <td colspan="5" align="center" style="font-weight:bold; border:1px solid black;"><?php echo $k['keterangan'] ?></td>
                </tr>
            
                    <?php
                    $queryb = "SELECT a.`id`, a.`kode`, a.`nama`, a.`kkm`, a.`tingkat`, a.`sifat`, b.`kode` as kelompok, b.`keterangan` 
            					FROM `pelajaran` as a
            					JOIN `aspekkelompok` as b ON a.`sifat` = b.`id`
            					WHERE a.`tingkat` = '$kls[tingkat]' AND b.`id` = '$k[id]' ORDER BY a.id";
            		$sqlb = mysqli_query($conn,$queryb);
            		$i=1;
            		while ($x = mysqli_fetch_assoc($sqlb)) {
            			$qu = mysqli_query($conn,"SELECT a.`id`, a.`idpelajaran`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`, a.`deskripsi`, a.`tanggal` 
            			FROM `ujian` as a
            			JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
            			JOIN `kelas` as c ON a.`idkelas` = c.`id`
            			JOIN `semester` as d ON a.`idsemester` = d.`id`
            			WHERE a.`idpelajaran` = '$x[id]' AND a.`idkelas` = '$idkelas' AND a.`idsemester` = '$idsemester'");
            			$jml = mysqli_num_rows($qu);
              			$sumn=0;
              			while($u = mysqli_fetch_assoc($qu)){
              				$qn = mysqli_query($conn,"SELECT * FROM `nilaiujian` WHERE `idujian` = '$u[id]' AND `nis` = '$nis'");
              				$n = mysqli_fetch_assoc($qn);
              				$sumn+=$n['nilaiujian'];
              				}
              				$rata=($sumn!=0)?($sumn/$jml):0; 
              				$jrata = round($rata,1);
            		?>		
            		<tr>
            	    	<td align="center" style="font-weight:bold; border:1px solid black;"><?php echo $i ?></td>							
            	        <td style="font-weight:bold; border:1px solid black;padding-left: 5px;"><?php echo $x['nama'] ?></td>	
            	        <td align="center" style="font-weight:bold; border:1px solid black;"><?php echo $x['kkm'] ?></td>	
            
            	        <td align="center" style="font-weight:bold; border:1px solid black;"><?php echo $jrata ?></td>
            	        <td align="center" style="font-weight:bold; border:1px solid black;"><?php echo ucwords(terbilang2($jrata)); ?></td>
                	</tr>
            		<?php
                  	$i++;
            		}
                  	?>
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
