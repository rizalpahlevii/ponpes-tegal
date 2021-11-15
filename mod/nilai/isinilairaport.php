<?php
if(isset($_GET['aks']))
	{
		$aks = $_GET['aks'];
	}
	else
	{
		$aks = '';
	}
switch ($aks) {
	case 'nilai':
		?>
		<?php
			$nis = $_GET['nis'];
			$qisi = "SELECT nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas
					FROM siswa as s 
                    left join kelas k on s.idkelas = k.id
                    left join tahunajaran t on t.id = k.idtahunajaran
                    where s.`nis` = '$nis' and k.id='idkelas' and t.id='idtahunajaran'
			";
			$sqlisi = mysqli_query($conn,$qisi);
			$isi = mysqli_fetch_assoc($sqlisi);
			?>
			<?php
        	if ($_SESSION['level']=='siswa' or $_SESSION['level']=='ortu') {
        	?>
			<div class="col-lg-12">
			<?php
        	}else{
        	?>
        	<div class="col-sm-9">
        	<?php	
        	}
        	?>
			<section class="panel">
			    <section class="panel">
			        <div class="panel-body profile-information">

			           <div class="col-md-3">
			           		<br>
			           		<br>
				           	<div align="center" >
				           		<img src="images/ect/nilai.png" width="80%" alt=""/>
				            </div>
			           </div>
			           <div class="col-md-9 table-responsive">
			               <div class="profile-desk">
			               	<div class="tab-pane ">                
				                <div class="prf-contacts sttng">
				                    <h2>DATA NILAI</h2>
				                </div>      
				            </div>
			               	<table class="table table-borderless" >
			               		<tr>
			               			<td>Nama</td>
			               			<td>:</td>
			               			<td><?php echo $isi['nama']?></td>
			               		</tr>
			               		<tr>
			               			<td>NIS</td>
			               			<td>:</td>
			               			<td><?php echo $isi['nis']?></td>
			               		</tr>
			               		<tr>               			
			               			<td>Kelas</td>
			               			<td>:</td>
			               			<td><?php echo $isi['kelas']?></td>
			               		</tr>
			               	</table>                   
			               </div>
			           </div>
			        </div>
			    </section>
			</section>
			</div>
			<div class="col-sm-3">
			</div>
			<div class="col-sm-9">
				<div class="panel-body" align="right">
					<a onclick="window.location.reload();" class="btn btn-warning">
			            <i class="fa fa-refresh"></i> Refresh
			        </a>
					
			        <a onClick="tambah();" class="btn btn-success">
			            Tambah Penilaian
			        </a>
			    </div>
			</div>
			<div class="col-sm-3">
			</div>
			<div class="col-md-9">
			<section class="panel">
			    <div class="panel-body">
			        <div class="table-responsive">
			        	 <table class="table table-striped table-hover table-bordered">
			        	 	<thead>
			        	 		<tr>
			        	 			<th class="text-center">No</th>
			        	 			<th class="text-center">NIS</th>
			        	 			<th class="text-center">Nama</th>
			        	 			<?php
							      	$qu = mysqli_query($conn,"SELECT a.`id`, a.`idpelajaran`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`, a.`idjenis`, e.`jenisujian`, a.`deskripsi`, a.`tanggal`, a.`idaturan`, a.`idrpp`, g.`rpp` 
										FROM `ujian` as a
										JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
										JOIN `kelas` as c ON a.`idkelas` = c.`id`
										JOIN `semester` as d ON a.`idsemester` = d.`id`
										JOIN `jenisujian` as e ON a.`idjenis` = e.`id`
										JOIN `aturannhb` as f ON a.`idaturan` = f.`id`
										JOIN `rpp` as g ON a.`idrpp` = g.`id`
										WHERE a.`idpelajaran` = '$isi[idpelajaran]' AND a.`idkelas` = '$idkelas' AND a.`idsemester` = '$idsemester' AND a.`idjenis` = '$isi[idjenisujian]' AND a.`idaturan` = '$idaturan'");
							      	$i=1;
							      	while($u = mysqli_fetch_assoc($qu)){
							      	?>
							      	<th class="text-center" >
							      		<font class="popovers" data-original-title="<?php echo $u['rpp'] ?>" data-content="Materi : <?php echo $u['deskripsi'] ?>, <?php echo tglindo($u['tanggal']) ?>" data-placement="top" data-trigger="hover" ><?php echo $u['jenisujian'] ?> - <?php echo $i ?></font> 
							      		<a onclick="window.open('modal.php?act=tambahpenilaian&idaturan=<?php echo $idaturan ?>&idsemester=<?php echo $idsemester?>&idkelas=<?php echo $idkelas?>&id=<?php echo $u['id'] ?>','TambahNilai','680','600','resizable=1,scrollbars=1,status=0,toolbar=0');" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>
										<a href="act_modal.php?act=hapus&id=<?php echo $u['id'] ?>" onclick="return myFunction();" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> </a>
							      	</th>
							      	<?php
									$i++;
							      	}
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
													WHERE a.`nip` = '$_SESSION[id_user]' AND q.`idkelas` = '$idkelas' AND q.`idsemester` = '$idsemester' AND q.`idjenis` = '$isi[idjenisujian]'") or die(mysqli_error());
									$cekq = mysqli_num_rows($sqltrans);
									if ($cekq !== 0) {
										$x=0;
										while($qz = mysqli_fetch_assoc($sqltrans)){
											?>
									      	<th class="text-center" >
									      		<font class="popovers" data-original-title="<?php echo $qz['rpp'] ?>" data-content="Judul : <?php echo $qz['judul'] ?>, <?php echo tglindo($qz['tgl_buat']) ?>" data-placement="top" data-trigger="hover" ><?php echo $qz['jenisujian'] ?> - <?php echo $i+$x ?></font> 
									      	</th>

									      	<?php
									      	$x++;
										}
									}
							    	?>				    	
			        	 			<th class="text-center">Rata - Rata Nilai </th>		
			        	 		</tr>        	 	
			        	 	</thead>	
			        	 	<tbody>
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
							      	$qu = mysqli_query($conn,"SELECT a.`id`, a.`idpelajaran`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`, a.`idjenis`, e.`jenisujian`, a.`deskripsi`, a.`tanggal`, a.`idaturan`, a.`idrpp`, g.`rpp` 
										FROM `ujian` as a
										JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
										JOIN `kelas` as c ON a.`idkelas` = c.`id`
										JOIN `semester` as d ON a.`idsemester` = d.`id`
										JOIN `jenisujian` as e ON a.`idjenis` = e.`id`
										JOIN `aturannhb` as f ON a.`idaturan` = f.`id`
										JOIN `rpp` as g ON a.`idrpp` = g.`id`
										WHERE a.`idpelajaran` = '$isi[idpelajaran]' AND a.`idkelas` = '$idkelas' AND a.`idsemester` = '$idsemester' AND a.`idjenis` = '$isi[idjenisujian]' AND a.`idaturan` = '$idaturan'");
							      	$jml = mysqli_num_rows($qu);
							      	$i=1;
							      	$sumn=0;
							      	while($u = mysqli_fetch_assoc($qu)){
							      	?>
							        <td align="center">
							        	<?php
							        	$qn = mysqli_query($conn,"SELECT * FROM `nilaiujian` WHERE `idujian` = '$u[id]' AND `nis` = '$nis'");
								      	$n = mysqli_fetch_assoc($qn);
							        	?>
							        	<input type="hidden" name="idujian[]" class="form-control " value="<?php echo $u['id'] ?>" >
							        	<input type="hidden" name="nis[]" class="form-control " value="<?php echo $k['nis'] ?>" >
										<input type="text" name="nilai[]" class="form-control " value="<?php echo $n['nilaiujian'] ?>" >
							        	<input type="hidden" name="idaturan" class="form-control " value="<?php echo $idaturan ?>" >
							        	
							        </td>	
							        <?php
							        $sumn+=$n['nilaiujian'];
							      	$i++;
							      	}
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
										WHERE a.`nip` = '$_SESSION[id_user]' AND q.`idkelas` = '$idkelas' AND q.`idsemester` = '$idsemester' AND q.`idjenis` = '$isi[idjenisujian]'") or die(mysqli_error());
										$cekq = mysqli_num_rows($sqltrans);
										if ($cekq !== 0) {
											$i=1;
											$sumq=0;
											while($qz = mysqli_fetch_assoc($sqltrans)){
												$siswa_yangmengerjakan2 = mysqli_query($conn,"SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq = '$qz[id]' AND id_siswa='$k[nis]'");
												$t=mysqli_fetch_array($siswa_yangmengerjakan2);	
												$soal_pilganda = mysqli_query($conn,"SELECT * FROM quiz_pilganda WHERE idquiz='$qz[id]'");
										        $pilganda = mysqli_num_rows($soal_pilganda);
										        $soal_esay = mysqli_query($conn,"SELECT * FROM quiz_esay WHERE idquiz='$qz[id]'");
										        $esay = mysqli_num_rows($soal_esay);										
									            $nilai = mysqli_query($conn,"SELECT * FROM nilai_soal_esay WHERE id_tq='$qz[id]' AND id_siswa ='$k[nis]'");
									            $n = mysqli_fetch_array($nilai);
									            $nilai2 = mysqli_query($conn,"SELECT * FROM nilai WHERE id_tq='$qz[id]' AND id_siswa = '$k[nis]'");
									            $n2 = mysqli_fetch_array($nilai2);
									            if (!empty($pilganda) AND !empty($esay)){
			                                    	if ($t['dikoreksi']=='B'){
							                          ?>	 
												      	<td align="center">
												      		<font class="popovers" data-original-title="Jawaban soal essay <b>belum di koreksi</b>" data-content="Nilai Tugas/Quiz Pilihan Ganda : <?php echo $n2['persentase'] ?>" data-placement="top" data-trigger="hover" ><?php echo $n2['persentase']/2; ?></font> 
												      	</td> 
							                          <?php
							                          $hslq =  $n2['persentase']/2;
							                      }else{
							                          ?>	
							                          	<td align="center">
												      		<font class="popovers" data-original-title="Score" data-content="Nilai Tugas/Quiz Essay: <?php echo $n['nilai']?>, Nilai Tugas/Quiz Pilihan Ganda : <?php echo $n2['persentase'] ?>" data-placement="top" data-trigger="hover" ><?php echo ($n['nilai']+$n2['persentase'])/2; ?></font> 
												      	</td>		
							                          <?php										                          
							                          $hslq =  ($n['nilai']+$n2['persentase'])/2; 
							                      }
			                                    }elseif (empty($pilganda) AND !empty($esay)){
			                                    	if ($t['dikoreksi']=='B'){
								                          ?>		
								                          <td align="center">
													      		<font class="popovers" data-original-title="Score" data-content="Jawaban soal essay <b>belum di koreksi</b>" data-placement="top" data-trigger="hover" >0</font> 
													      	</td> 		
								                          <?php											                                                
							                          		$hslq = "0"; 
								                      }else{
									                      ?>				    
									                      	<td align="center">
													      		<font class="popovers" data-original-title="Score" data-content="Nilai Tugas/Quiz Essay: <?php echo $n['nilai']?>" data-placement="top" data-trigger="hover" ><?php echo $n['nilai']?></font> 
													      	</td>     
						                                  <?php									                                                        
							                          		$hslq =  $n['nilai']; 
								                      }
			                                    }elseif (!empty($pilganda) AND empty($esay)){
			                                    	?>
			                                    	<td align="center">
											      		<font class="popovers" data-original-title="Score" data-content="Nilai Tugas/Quiz Pilihan Ganda : <?php echo $n2['persentase'] ?>" data-placement="top" data-trigger="hover" ><?php echo $n2['persentase'] ?></font> 
											      	</td>     
			                                    	<?php	
			                                    	$hslq =  $n2['persentase'];
			                                    }

							        		$sumq+=$hslq;
									      	$i++;

											}

							   			$tjml = $jml+$cekq;
							   			$tsum = $sumn+$sumq;
							      		$rata=($tsum!=0)?($tsum/$tjml):0;
							   			?>
							        	<td align="center"><?php echo round($rata) ?></td>	
							      		<?php
										}else{
							      		$rata=($sumn!=0)?($sumn/$jml):0;	
							      		?>
							        	<td align="center"><?php echo round($rata) ?></td>	
							      		<?php	
										}

							    	?>
				    
			        	 		</tr>
						      	<?php
							      	$is++;
							      	}
						      	?>
			        	 	</tbody>
			        	 			
			        	 </table>
			        </div>
			    </div>
			</section>
			<div class="form-group">
			    <div class="col-lg-12" align="center">
			        <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
			        <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
			    </div>
			</div>
			</div>
			<script type="text/javascript">
				function tambah()
				{
					window.open('modal.php?act=tambahpenilaian&idaturan=<?php echo $idaturan ?>&idsemester=<?php echo $idsemester?>&idkelas=<?php echo $idkelas?>','TambahNilai','680','600','resizable=1,scrollbars=1,status=0,toolbar=0');
				}
			</script>
		<?php
		break;
	
	default:
			$nis = $_GET['nis'];
			$qisi1 = "SELECT nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas
					FROM siswa as s 
                    left join kelas k on s.idkelas = k.id
                    left join tahunajaran t on t.id = k.idtahunajaran
                    where s.`nis` = '$nis'
			";
			$sqlisi1 = mysqli_query($conn,$qisi1);
			$isi1 = mysqli_fetch_assoc($sqlisi1);


			$qkls = mysqli_query($conn,"SELECT a.`id`as idkelas, a.`kelas`, b.`id` as nipguru,a.`nipwali`
										FROM `kelas` as a
										JOIN `guru` as b ON a.`nipwali` = b.`nip` WHERE a.`id` = '$idkelas' AND a.`idtahunajaran` = '$idtahunajaran'");
			$kls = mysqli_fetch_assoc($qkls);

			$nipguru = $kls['nipguru'];
		?>
			<?php
	    	if ($_SESSION['level']=='siswa' or $_SESSION['level']=='ortu') {
	    	?>
			<div class="col-lg-12">
			<?php
	    	}else{
	    	?>
	    	<div class="col-sm-9">
	    	<?php	
	    	}
	    	?>
			<section class="panel">
			    <section class="panel">
			        <div class="panel-body profile-information">

			           <div class="col-md-3">
			           		<br>
			           		<br>
				           	<div align="center" >
				           		<img src="images/ect/nilai.png" width="80%" alt=""/>
				            </div>
			           </div>
			           <div class="col-md-9 table-responsive">
			               <div class="profile-desk">
			               	<div class="tab-pane ">                
				                <div class="prf-contacts sttng">
				                    <h2>DATA NILAI RAPORT</h2>
				                </div>      
				            </div>
			               	<table class="table table-borderless" >
			               		<tr>
			               			<td>Nama</td>
			               			<td>:</td>
			               			<td><?php echo $isi1['nama']?></td>
			               		</tr>
			               		<tr>
			               			<td>NIS</td>
			               			<td>:</td>
			               			<td><?php echo $isi1['nis']?></td>
			               		</tr>
			               		<tr>               			
			               			<td>Kelas</td>
			               			<td>:</td>
			               			<td><?php echo $isi1['kelas']?></td>
			               		</tr>
			               	</table>              
			               </div>
			           </div>
			        </div>
			    </section>
			</section>
			</div>
		<?php
	    	if ($_SESSION['level']=='siswa' or $_SESSION['level']=='ortu') {
	    	?>
			<div class="col-lg-12">
			<?php
	    	}else{
	    	?>
			<div class="col-sm-3">
			</div>
	    	<div class="col-sm-9">
	    	<?php	
	    	}
	    	?>
			<section class="panel">
			    <div class="panel-body">
			        <section id="flip-scroll">
			        	<div class="table-responsive">
			        	 <table class="table table-striped table-hover table-bordered" id="example">
			        	 	<thead>
			        	 		<tr>
			        	 			<th rowspan="2" class="text-center">No</th>
			        	 			<th rowspan="2" class="text-center">Pelajaran</th>
			        	 			<th rowspan="2" class="text-center">KKM</th>
			        	 			<?php
			        	 			$sql = "SELECT DISTINCT b.id,a.dasarpenilaian, b.keterangan
											FROM `aturannhb` as a 
											JOIN `dasarpenilaian` as b ON a.`dasarpenilaian` = b.`id`";
								    $res = mysqli_query($conn,$sql);
								    $i = 0;
								    while($row = mysqli_fetch_assoc($res)){
								    	$sp[$i] = array($row['dasarpenilaian']);
			        	 			?>
			        	 			<th colspan="2" class="text-center"><?php echo  $row['keterangan'] ?></th>
			        	 			<?php
			        	 			$i++;
			        	 			}
    								$naspek = count($sp);
    								if ($naspek>1) {
    								?>
			        	 			<th rowspan="2" class="text-center">Rata - Rata</th>
			        	 			<?php
    								}
			        	 			?>

			        	 		</tr>
			        	 		<tr>
			        	 			<?php
			        	 			for($i = 0; $i < count($sp); $i++){
			        	 			?>			        	 			
			        	 			<th class="text-center">Angka</th>		
			        	 			<th class="text-center">Huruf</th>	
			        	 			<?php
			        	 			}
			        	 			?>	
			        	 		</tr>      	 	
			        	 	</thead>	
			        	 	<tbody>
			        	 		<?php
							      	$querys = mysqli_query($conn,"SELECT pel.id, pel.nama, pel.sifat, kpel.keterangan, pel.kkm
												                  FROM ujian uji, nilaiujian niluji, siswa sis, pelajaran pel, aspekkelompok kpel 
												                 WHERE uji.id = niluji.idujian 
												                   AND niluji.nis = sis.nis 
												                   AND uji.idpelajaran = pel.id 
												                   AND pel.sifat = kpel.id
												                   AND uji.idsemester = '$idsemester'
												                   AND uji.idkelas = '$idkelas'
												                   AND sis.nis = '$nis' 
												                 GROUP BY kpel.posisi, pel.nama");
							      	$is=1;
							      	while($k = mysqli_fetch_assoc($querys)){
							      	$idpelajaran=$k['id'];
							    ?>
							    <tr>
							    	<td align="center"><?php echo $is ?></td>
							        <td align="center"><?php echo $k['nama'] ?></td>	
							        <td align="center"><?php echo $k['kkm'] ?></td>	
							        <?php

							      	$jrata=0;
						        	for($a = 0; $a < count($sp); $a++){
						        		$idaturan=$sp[$a][0];
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
										 WHERE a.nipguru = '$nipguru' AND k.id = '$idkelas' 
										   AND a.idpelajaran = '$isi[idpelajaran]' AND a.dasarpenilaian = '$isi[iddasarpenilaian]'
									";
									$sqlrt = mysqli_query($conn,$qrt);
									$rt = mysqli_fetch_assoc($sqlrt);
									?>
									<?php
							      	$qu = mysqli_query($conn,"SELECT DISTINCT a.`bobot`, b.`kode`, b.`jenisujian`, b.id
															FROM `aturannhb` as a
															JOIN `jenisujian` as b
															WHERE a.`idpelajaran` = '$isi[idpelajaran]' AND a.`nipguru` = '$nipguru' AND a.`dasarpenilaian` = '$isi[iddasarpenilaian]' AND b.id = a.idjenisujian ORDER BY b.jenisujian");
							      	
							      	$i=1;
							      	$sumn=0;							      	while($u = mysqli_fetch_assoc($qu)){
							      	
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
                                        WHERE a.`idpelajaran` = '$isi[idpelajaran]' AND a.`idkelas` = '$idkelas' AND a.`idsemester` = '$idsemester' AND a.`idjenis` = '$u[id]' AND h.`nis` = '$nis' AND dp.`id` = '$idaturan'
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
										WHERE a.`nip` = '$nipguru' AND q.`idkelas` = '$idkelas' AND q.`idsemester` = '$idsemester' AND q.`idjenis` = '$u[id]' AND dp.`id` = '$idaturan'") or die(mysqli_error());
										$cekq = mysqli_num_rows($sqltrans);
										if ($cekq !== 0) {
											$i=1;
											$sumq=0;
											while($qz = mysqli_fetch_assoc($sqltrans)){
												$siswa_yangmengerjakan2 = mysqli_query($conn,"SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq = '$qz[id]' AND id_siswa='$nis'");
												$t=mysqli_fetch_array($siswa_yangmengerjakan2);	
												$soal_pilganda = mysqli_query($conn,"SELECT * FROM quiz_pilganda WHERE idquiz='$qz[id]'");
										        $pilganda = mysqli_num_rows($soal_pilganda);
										        $soal_esay = mysqli_query($conn,"SELECT * FROM quiz_esay WHERE idquiz='$qz[id]'");
										        $esay = mysqli_num_rows($soal_esay);										
									            $nilai = mysqli_query($conn,"SELECT * FROM nilai_soal_esay WHERE id_tq='$qz[id]' AND id_siswa ='$nis'");
									            $n1 = mysqli_fetch_array($nilai);
									            $nilai2 = mysqli_query($conn,"SELECT * FROM nilai WHERE id_tq='$qz[id]' AND id_siswa = '$nis'");
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
			                                    	?>  
			                                    	<?php	
			                                    	$hslq =  $n2['persentase'];
			                                    }

							        		$sumq+=$hslq;
									      	$i++;

											}

							   			$tjml = $jml+$cekq;
							   			$tsum = $n['nilai']+$sumq;
							      		$rata=($tsum!=0)?($tsum/$tjml):0;
							      		//echo round($rata);							      		
								      	$nap = $rata * $u['bobot'];								      	
							        	$sumn +=$nap;
										}else{
								      	$hsl = ($n['nilai']!=0)?($n['nilai']/$jml):0;
								      	//echo round($hsl);
								      	$nap = $hsl * $u['bobot'];								      	
							        	$sumn +=$nap;
										}
							        	?>	
							        <?php
							      	$i++;
							      	}
							      	$nilakhirpk = round($sumn / $rt['bobotPK']); 
							      	$jrata += $nilakhirpk;
							    	?>							    	
							        <td align="center"><?php echo $nilakhirpk ?></td>	
							        <td align="center"><?php echo ucwords(terbilang2($nilakhirpk)); ?></td>	
									<?php
									}							        		
							        ?>
							        <?php
							        if ($naspek>1) {

							      	$nila = $jrata / $naspek; 	
							        ?>
							        <td align="center"><?php echo $nila ?></td>	
							        <?php
							        }
							        ?>
							    </tr>
						      	<?php
							      	$is++;
							      	}
						      	?>
			        	 	</tbody>
			        	 			
			        	 </table>
			        	</div>
			        </section>
			    </div>
			</section>
		</div>
		
		
		<?php
		break;
}
?>

