<?php
include"../lib/conn.php";
include"../lib/all_function.php";
include"../lib/fungsi_indotgl.php";
include"../lib/fungsi_terbilang.php";
$tgl=date('dmY');
header("Content-type: application/vnd-ms-excel");
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
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=".$isi1['nama'].".xls");

?>
<style> .str{ mso-number-format:\@; } </style>
<table border="1">
    <tr>
 		<th class="text-center">No</th>
 		<th class="text-center">Pelajaran</th>
 		<th class="text-center">KKM</th>
 		<th class="text-center">Angka</th>		
 		<th class="text-center">Huruf</th>
 	</tr>  	
    <?php
      	$querys = mysqli_query($conn,"SELECT * FROM `aspekkelompok`");
      	$is=1;
      	while($k = mysqli_fetch_assoc($querys)){
      	$idaspek=$k['id'];
    ?>
    <tr>
        <td colspan="5" align="center"><?php echo $k['keterangan'] ?></td>
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
	    	<td align="center"><?php echo $i ?></td>							
	        <td><?php echo $x['nama'] ?></td>	
	        <td align="center"><?php echo $x['kkm'] ?></td>	

	        <td align="center"><?php echo $jrata ?></td>
	        <td align="center"><?php echo ucwords(terbilang2($jrata)); ?></td>
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