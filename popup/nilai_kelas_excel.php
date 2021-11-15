<?php
include"../lib/conn.php";
include"../lib/all_function.php";
include"../lib/fungsi_indotgl.php";
include"../lib/fungsi_terbilang.php";
$tgl=date('dmY');
header("Content-type: application/vnd-ms-excel");
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
    
	
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=".$dtl['kelas']."_".$isi['nama'].".xls");

?>
<style> .str{ mso-number-format:\@; } </style>
<table>
    <tr>
        <th align="left" colspan="2">Pelajaran</th>
        <th align="left" colspan="3">: <?php echo $isi['nama'] ?></th>
    </tr>
    <tr>
        <th align="left" colspan="2">Kelas</th>
        <th align="left" colspan="3">: <?php echo $dtl['kelas'] ?></th>
    </tr>
    <tr>
        <th align="left" colspan="2">Wali Kelas</th>
        <th align="left" colspan="<?php echo $coll ?>">: <?php echo $dtl['nama']?></th>
    </tr>
    <tr>
        <th align="left" colspan="2">Semester</th>
        <th align="left" colspan="3">: <?php echo $sms['semester']?></th>
    </tr>
</table>
<table border="1">
    <tr>
 		<th class="text-center">No</th>
 		<th class="text-center">NIS</th>
 		<th class="text-center">Nama</th>
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
      	<th class="text-center" >
      		<?php echo getBulanHijriah($u['deskripsi']) ?>
      	</th>
      	<?php
	      	$i++;
	      	}
	     ?>									     
 			<th class="text-center">Jumlah</th>		
 			<th class="text-center">Rata - Rata</th>
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
	      	<th class="text-center"><?php echo $is ?></th>
	        <td align="center"><?php echo $k['nis'] ?></td>
	        <td><?php echo $k['nama'] ?></td>		
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
	        <td align="center">
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
        	<td align="center"><?php echo $sumn ?></td>							      	
        	<td align="center"><?php echo round($rata,1) ?></td>							      	
			<?php
		      }
		    ?>	

 		</tr>
      	<?php
	      	$is++;
	      	}
      	?>
</table>