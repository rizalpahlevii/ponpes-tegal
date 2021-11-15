<?php
	
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['pembagiannama']) AND $_SESSION['pembagiannama'] <> 'TRUE')
	{
		?>
		  <div class="alert alert-danger alert-dismissible" id="succsess-alert">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	        Dilarang mengakses file ini.
	      </div>
		<?php
	}
	else{

	//link buat paging
	if ($_SESSION['level']=="admin") {
		$linkaksi = 'med.php?mod=pembagiannama';
	}else{		
		$linkaksi = 'med2.php?mod=pembagiannama';
	}

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/nilai/act_pembagiannama.php';

	?>
	<?php
	switch ($act) {
		case 'addguru':
		?>
		 			<div class="row">
		 				<?php

		 				if (isset($_GET['aks'])) {
		 				?>
				       	<form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=detail' enctype="multipart/form-data">
		 				<?php
		 				}else{
		 				?>
				       	<form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=form' enctype="multipart/form-data">
		 				<?php
		 				}
		 				?>
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Perhitungan Nilai Raport
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            	<input type="hidden" name="nipguru" value="<?php echo $_GET['id'] ?>">

				                            
			                                <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Semester</label>
		                                      	<div class="col-lg-6">
		                                          	<select  name="idsemester" class="form-control round-input" >
		                                              <?php
		                                                        $sql_semester = mysqli_query($conn,"SELECT * FROM `semester` where aktif = 'Aktif'");
		                                                while($k = mysqli_fetch_assoc($sql_semester))
		                                                {
		                                                  if(isset($c['id']) && $k['id'] == $c['id'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[semester]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[semester]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
			                                    </div>
			                                </div>
			                                <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
		                                      	<div class="col-lg-6">
		                                          	<select  name="idkelas" class="form-control round-input" >
		                                              <?php
		                                                        $sql_penilaian = mysqli_query($conn,"SELECT a.* 
																	FROM `kelas` as a 
																	JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
																	WHERE b.`aktif` = 'Aktif'");
		                                                while($k = mysqli_fetch_assoc($sql_penilaian))
		                                                {
		                                                  if(isset($c['id']) && $k['id'] == $c['id'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[kelas]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[kelas]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
			                                    </div>
			                                </div>
				                            
				                                                     
				                            <div class="form-group">
				                                <div class="col-lg-offset-2 col-lg-10">
									                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Next</button>
									                <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
				                                </div>
				                            </div>
				                        </div>

					                    
				                    </div>

				                    
				                </section>

				            </div>

				        </form>    
				        </div>
		<?php
		break;
		case 'add':
		?>
		 			<div class="row">

				       <form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=form' enctype="multipart/form-data">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Perhitungan Nilai Raport
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">

				                            <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Guru</label>
		                                      	<div class="col-lg-6">
		                                          	<select  name="nipguru" class="form-control round-input" >
		                                              <?php
		                                                        $sql_guru = mysqli_query($conn,"SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
																	FROM `guru` as a
																	JOIN `pegawai` as b on a.nip = b.nip
																	JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
																	JOIN `statusguru` as d on d.`id` = a.`statusguru`");
		                                                while($k = mysqli_fetch_assoc($sql_guru))
		                                                {
		                                                  if(isset($c['id']) && $k['id'] == $c['id'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[nip] - $k[guru]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[nip] - $k[guru]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
			                                    </div>
			                                </div>
			                                <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Semester</label>
		                                      	<div class="col-lg-6">
		                                          	<select  name="idsemester" class="form-control round-input" >
		                                              <?php
		                                                        $sql_semester = mysqli_query($conn,"SELECT * FROM `semester` where aktif = 'Aktif'");
		                                                while($k = mysqli_fetch_assoc($sql_semester))
		                                                {
		                                                  if(isset($c['id']) && $k['id'] == $c['id'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[semester]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[semester]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
			                                    </div>
			                                </div>
			                                <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
		                                      	<div class="col-lg-6">
		                                          	<select  name="idkelas" class="form-control round-input" >
		                                              <?php
		                                                        $sql_penilaian = mysqli_query($conn,"SELECT * FROM `kelas`");
		                                                while($k = mysqli_fetch_assoc($sql_penilaian))
		                                                {
		                                                  if(isset($c['id']) && $k['id'] == $c['id'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[kelas]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[kelas]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
			                                    </div>
			                                </div>
				                            
				                                                     
				                            <div class="form-group">
				                                <div class="col-lg-offset-2 col-lg-10">
									                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Next</button>
									                <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
				                                </div>
				                            </div>
				                        </div>

					                    
				                    </div>

				                    
				                </section>

				            </div>

				        </form>    
				        </div>
		<?php	
		break;
		case 'form':
			
					if (isset($_POST['idkelas'])=='1') {
			        	$idkelas=$_POST['idkelas'];
			        	$idtahunajaran=$_POST['idtahunajaran'];
			        	$idsemester=$_POST['idsemester'];
			        }else{

			        	$idkelas=$_GET['idkelas'];
			        	$idtahunajaran=$_GET['idtahunajaran'];
			        	$idsemester=$_GET['idsemester'];
			        }
				
			flash('example_message');	
			


			$qkls = mysqli_query($conn,"SELECT a.`id`as idkelas, a.`kelas`, b.`id` as nipguru,a.`nipwali`
										FROM `kelas` as a
										JOIN `guru` as b ON a.`nipwali` = b.`nip` WHERE a.`id` = '$idkelas' AND a.`idtahunajaran` = '$idtahunajaran'");
			$kls = mysqli_fetch_assoc($qkls);

			$nipguru = $kls['nipguru'];

			$sql = "SELECT DISTINCT b.id,a.dasarpenilaian, b.keterangan
					FROM `aturannhb` as a 
					JOIN `dasarpenilaian` as b ON a.`dasarpenilaian` = b.`id`";
		    $res = mysqli_query($conn,$sql);
		    $i = 0;
		    while($row = mysqli_fetch_assoc($res)){
		    	$sp[$i] = array($row['dasarpenilaian'],$row['keterangan']);

 			$i++;
 			}
			$naspek = count($sp);

			$querysis = mysqli_query($conn,"SELECT * FROM siswa WHERE idkelas = '$idkelas'");
	      	$s=0;
	      	while($sis = mysqli_fetch_assoc($querysis)){
	      	$nis = $sis['nis'];
	      	$nama = $sis['nama'];
			$qisi1 = "SELECT nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas
					FROM siswa as s 
                    left join kelas k on s.idkelas = k.id
                    left join tahunajaran t on t.id = k.idtahunajaran
                    where s.`nis` = '$nis'
			";
			$sqlisi1 = mysqli_query($conn,$qisi1);
			$isi1 = mysqli_fetch_assoc($sqlisi1);

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
	      	$i++;
	      	}
	      	$nilakhirpk = round($sumn / $rt['bobotPK']); 
	      	$jrata += $nilakhirpk;
			}							        		
	        
	        $aspekarr[$s] = array($nis, $nama, $nilakhirpk);

	        if ($naspek>1) {

	      	$nila = $jrata / $naspek; 	
	        $nilxa[$s] = array($nila); 
	        }
	      	$is++;
	      	}

	      	$s++;
	      	}

			$jsiswa = count($aspekarr);


	 		$sqlnl = mysqli_query($conn,"SELECT * FROM `standartnilai` WHERE `id` ='1'");
            $nl = mysqli_fetch_assoc($sqlnl);
            $ratenilai = $nl['nilai'];
		      	
		?>
		
		<div class="row">
            <div class="col-lg-12">
                <section class="panel panel-info">
                    <header class="panel-heading">
                        Data Pembagian Nama Naik Kelas
                    </header>
				    <div class="panel-body">
				        <section id="flip-scroll">
				        	<div class="table-responsive">
				        		<table class="table table-striped table-hover table-bordered" id="example">
				        			<thead>
				        				<tr>
					        	 			<th rowspan="2" class="text-center">NIS</th>
					        	 			<th rowspan="2" class="text-center">Nama</th>
					        	 			<?php
						        				for($l = 0; $l < $naspek; $l++){
							        		?>
							        		<th colspan="2" class="text-center"><?php echo $sp[$l][1] ?></th>
							        		<?php
								        		}
								        	?>
								        	<?php
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
					        	 			<th class="text-center">Nilai</th>	
					        	 			<?php
					        	 			}
					        	 			?>	
					        	 		</tr>    
				        			</thead>
				        			<tbody>				        				
							        	<?php
							        	for($l = 0; $l < $jsiswa; $l++){
							        		if ($aspekarr[$l][2] > $ratenilai) {
							        		?>		
							        		<tr>				        	 			
										        <td align="center"><?php echo $aspekarr[$l][0] ?></td>	
										        <td align="center"><?php echo $aspekarr[$l][1] ?></td>	
										        <td align="center"><?php echo $aspekarr[$l][2] ?></td>	
										        <?php
										        if ($naspek>1) { 	
										        ?>
										        <td align="center"><?php echo $nilxa[$l][0] ?></td>	
										        <?php
										        }
										        ?>
						        	 		</tr>
							        		<?php
							        		}
							        	}
						        	?>	
				        			</tbody>
					        	</table>
				        	</div>
				        </section>
				    </div>
				</section>
				<section class="panel panel-warning">
				    <header class="panel-heading">
                        Data Pembagian Nama Santri Yang Tidak Naik Kelas atau di ta'leg/ Nilai rata - rata dibawah <?php echo $ratenilai ?>
                    </header>
				    <div class="panel-body">
				        <section id="flip-scroll">
				        	<div class="table-responsive">
				        		<table class="table table-striped table-hover table-bordered" id="example1">
				        			<thead>
				        				<tr>
					        	 			<th rowspan="2" class="text-center">NIS</th>
					        	 			<th rowspan="2" class="text-center">Nama</th>
					        	 			<?php
						        				for($l = 0; $l < $naspek; $l++){
							        		?>
							        		<th class="text-center"><?php echo $sp[$l][1] ?></th>
							        		<?php
								        		}
								        	?>
								        	<?php
								        	if ($naspek>1) {
		    								?>
					        	 			<th rowspan="2" class="text-center">Rata - Rata</th>
					        	 			<?php
		    								}
					        	 			?>

					        	 			<th rowspan="2" class="text-center">Sebab/Alasan</th>
					        	 		</tr>
					        	 		<tr>
					        	 			<?php
					        	 			for($i = 0; $i < count($sp); $i++){
					        	 			?>			        	 			
					        	 			<th class="text-center">Nilai</th>	
					        	 			<?php
					        	 			}
					        	 			?>	
					        	 		</tr>    
				        			</thead>
				        			<tbody>				        				
							        	<?php
							        	for($l = 0; $l < $jsiswa; $l++){
							        		if ($aspekarr[$l][2] < $ratenilai) {
							        		?>		
							        		<tr>				        	 			
										        <td align="center"><?php echo $aspekarr[$l][0] ?></td>	
										        <td align="center"><?php echo $aspekarr[$l][1] ?></td>	
										        <td align="center"><?php echo $aspekarr[$l][2] ?></td>	
										        <?php
										        if ($naspek>1) { 	
										        ?>
										        <td align="center"><?php echo $nilxa[$l][0] ?></td>	
										        <?php
										        }
										        ?>
										        <td align="center">Nilai</td>
						        	 		</tr>
							        		<?php
							        		}
							        	}
						        	?>	
				        			</tbody>
					        	</table>
				        	</div>
				        </section>
				    </div>
				</section>
			</div>
		</div> 

			<?php

		break;

		default :
		flash('example_message');
			?>
		        <!-- page start-->

		        <div class="row">

				       <form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=form' enctype="multipart/form-data">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Pembagian Nama
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">

				                            <div class="form-group">
			                                  <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
			                                  	<div class="col-lg-6">
			                                      	<select  name="idkelas" class="form-control round-input" >
			                                          <?php
			                                                    $sql_guru = mysqli_query($conn,"SELECT * FROM `kelas` ");
			                                            while($k = mysqli_fetch_assoc($sql_guru))
			                                            {
			                                              if(isset($c['id']) && $k['id'] == $c['id'])
			                                              {
			                                                echo"<option value='$k[id]' selected>$k[kelas]</option>";  
			                                              }
			                                              else
			                                              {
			                                                echo"<option value='$k[id]'>$k[kelas]</option>";
			                                              }
			                                              
			                                            }
			                                                    ?>
			                                      	</select>
			                                    </div>
			                                </div>
			                                <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Semester</label>
		                                      	<div class="col-lg-6">
		                                          	<select  name="idsemester" class="form-control round-input" >
		                                              <?php
		                                                        $sql_semester = mysqli_query($conn,"SELECT * FROM `semester` where aktif = 'Aktif'");
		                                                while($k = mysqli_fetch_assoc($sql_semester))
		                                                {
		                                                  if(isset($c['id']) && $k['id'] == $c['id'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[semester]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[semester]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
			                                    </div>
			                                </div>
			                                <div class="form-group">
			                                  <label class="col-lg-2 col-sm-2 control-label">Tahun Ajaran</label>
			                                  	<div class="col-lg-6">
			                                      	<select  name="idtahunajaran" class="form-control round-input" >
			                                          <?php
			                                                    $sql_penilaian = mysqli_query($conn,"SELECT * FROM `tahunajaran` WHERE `aktif` = 'Aktif'");
			                                            while($k = mysqli_fetch_assoc($sql_penilaian))
			                                            {
			                                              if(isset($c['id']) && $k['id'] == $c['id'])
			                                              {
			                                                echo"<option value='$k[id]' selected>$k[tahunajaran]</option>";  
			                                              }
			                                              else
			                                              {
			                                                echo"<option value='$k[id]'>$k[tahunajaran]</option>";
			                                              }
			                                              
			                                            }
			                                                    ?>
			                                      	</select>
			                                    </div>
			                                </div>
				                            
				                                                     
				                            <div class="form-group">
				                                <div class="col-lg-offset-2 col-lg-10">
									                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Next</button>
									                <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
				                                </div>
				                            </div>
				                        </div>

					                    
				                    </div>

				                    
				                </section>

				            </div>

				        </form>    
				        </div>

		            <!-- page end-->
			<?php
		break;
		case 'detail':
			if(!empty($_GET['idkelas']) or !empty($_POST['idkelas']))
				if(!empty($_GET['idkelas'])){
					$nipguru=$_GET['nipguru'];
					$idsemester = $_GET['idsemester'];
					$idkelas = $_GET['idkelas'];
				}else{
					$nipguru=$_POST['nipguru'];					
					$idsemester = $_POST['idsemester'];
					$idkelas = $_POST['idkelas'];
				}
			{
		flash('example_message');
		?>
		 
	        <div class="row">
	            <div class="col-sm-3">
	                <section class="panel">
	                    <div class="panel-body">
	                    	<label class="btn btn-compose">
	                    		<?php 
	                    		$sqlguru = "SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
								FROM `guru` as a
								JOIN `pegawai` as b on a.nip = b.nip
								JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
								JOIN `statusguru` as d on d.`id` = a.`statusguru` WHERE a.`nip` = '$nipguru'";
								$kguru = mysqli_query($conn, $sqlguru);
								$guru = mysqli_fetch_assoc($kguru);
								echo $guru['pelajaran'];
	                    		?>
	                    		
	                    	</label>					                       
	                       		
	                        
	                        <ul class="nav nav-pills nav-stacked mail-nav">
	                        	<?php
	                        	$queryb = "SELECT DISTINCT a.`nipguru`,b.`dasarpenilaian`, b.`keterangan`, b.id 
											FROM `aturannhb` as a 
											LEFT JOIN `dasarpenilaian` as b ON a.`dasarpenilaian` = b.`id`
											WHERE a.`idpelajaran` = '$guru[idpelajaran]' AND a.`nipguru` = '$guru[id]'";
								$sqlb = mysqli_query($conn,$queryb);
								while ($x = mysqli_fetch_assoc($sqlb)) {
								?>											

	                            <li><a style="cursor:pointer" href="<?php echo $linkaksi ?>&idkelas=<?php echo $idkelas ?>&idsemester=<?php echo $idsemester ?>&nipguru=<?php echo $nipguru ?>&idaturan=<?php echo $x['id'] ?>&nip=<?php echo $guru['id'] ?>"> <i class="fa fa-caret-square-o-right"></i> <?php echo $x['keterangan'] ?></a></li>
								<?php
								}
	                        	?>
	                        </ul>
	                    	
	                    </div>
	                </section>
	                
	            </div>
	            <?php 
				if(isset($_GET['idaturan'])){						 							
				include "isipembagiannama.php";									
					
				}
			 
				 ?>

	    		<input type="hidden" name="nipguru" class="form-control " value="<?php echo $nipguru ?>" >
	    		<input type="hidden" name="idkelas" class="form-control " value="<?php echo $idkelas ?>" >
	    		<input type="hidden" name="idsemester" class="form-control " value="<?php echo $idsemester ?>" >
	        </div>
				       
		<?php
			}
		break;
		case 'raportsiswa':

      	$querys = mysqli_query($conn,"SELECT * FROM siswa WHERE nis = '$_SESSION[id_user]'");
      	$s = mysqli_fetch_assoc($querys);
      	$kelas=$s['idkelas'];
      	$semester=$_GET['id'];
      	$sql = mysqli_query($conn,"SELECT DISTINCT a.dasarpenilaian, b.keterangan
      			FROM `aturannhb` as a 
				LEFT JOIN `dasarpenilaian` as b ON a.`dasarpenilaian` = b.`id`");
      	$row = mysqli_fetch_assoc($sql);
      	$i=0;
      	while($row = mysqli_fetch_row($sql))
		{
			$aspekarr[$i++] = array($row[0], $row[1]);
		}
		?>
									
						<div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data Raport
				                    </header>
				                    <div class="panel-body">
				                        <form action="" method="">
				                        	<div class="table-responsive">
					                          <table class="table table-hover table-bordered">			  
											    <thead>
											      <tr>
											        <th width="40" style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center">Mata Pelajaran</th>
											        <?php
											        for($i = 0; $i < count($aspekarr); $i++){
											        ?>											        
											        <th colspan="3" class="text-center"><?php echo $aspekarr[$i][1] ?></th>
											        <?php
											        }
											        ?>
											        <th style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center">Predikat</th>
											      </tr>
											      <tr>
											      	<?php
											      		for($i = 0; $i < count($aspekarr); $i++){
											      			?>
											        		<th class="text-center">Angka</th>
											        		<th class="text-center">Huruf</th>
											        		<th class="text-center">Terbilang</th>
											      			<?php
											      		}
											      	?>
											      	
											      </tr>
											    </thead>
											    <tbody>
											        <?php
											        $queryp = mysqli_query($conn,"SELECT DISTINCT pel.id, pel.nama
															 FROM ujian uji, nilaiujian niluji, siswa sis, pelajaran pel 
															WHERE uji.id = niluji.idujian 
															  AND niluji.nis = sis.nis 
															  AND uji.idpelajaran = pel.id 
															  AND uji.idsemester = '$semester'
															  AND uji.idkelas = '$kelas'
															  AND sis.nis = '$_SESSION[id_user]' 
														GROUP BY pel.nama");
											      	$ip=1;
											      	while($rowpel = mysqli_fetch_assoc($queryp)){
											      		$idpel = $rowpel['id'];
														$nmpel = $rowpel['nama'];
											        ?>
											        <tr>
											        	<td><?php echo $nmpel ?></td>
												       
											      	</tr>
											      	<?php
											      	$ip++;
											      	}
											      	?>

											    </tbody>
											  </table>												
											</div>
				                        </form>
				                    </div>

				                </section>
				                
				            </div>
				        </div>

		<?php
		break;
	}
	
	}
?>
<script>
													
function myFunction() {
  var msg;
	msg= "Apakah Anda Yakin Akan Menghapus Data ? " ;
	var agree=confirm(msg);
	if (agree)
	return true ;
	else
	return false ;
}

</script>

<script type="text/javascript">
$(function() {
    $('#loading').ajaxStart(function(){
        $(this).fadeIn();
    }).ajaxStop(function(){
        $(this).fadeOut();
    });

    $('#menu a').click(function() {
        var url = $(this).attr('href');
        $('#container').load(url);
        return false;
    });
});
</script>