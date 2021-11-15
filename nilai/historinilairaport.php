<?php
	
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['nilairaport']) AND $_SESSION['nilairaport'] <> 'TRUE')
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
	if ($_SESSION['level']=="admin" OR $_SESSION['level']=="superadmin") {
		$linkaksi = 'med.php?mod=historinilairaport';
	}else{		
		$linkaksi = 'med2.php?mod=historinilairaport';
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

	$aksi = 'mod/nilai/act_historinilairaport.php';

	?>
	<?php
	switch ($act) {
		case 'addguru':
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
				                                  <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
				                                  	<div class="col-lg-10">
				                                      	<select  name="idkelas" class="select2" style="width: 100%">
				                                          <?php

				                                          	if ($_SESSION['level']=='nilai ibt') {				                                              	
			                                                    $sql_guru = mysqli_query($conn,"SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
																	FROM `kelas` as a
																	JOIN `pegawai` as b on a.nipwali = b.nip
																	JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
																	WHERE c.aktif = 'Aktif' AND a.`tingkat` BETWEEN 3 AND 6 ORDER BY `tingkat`");
				                                              }elseif ($_SESSION['level']=='nilai ts') {
				                                              	$sql_guru = mysqli_query($conn,"SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
																	FROM `kelas` as a
																	JOIN `pegawai` as b on a.nipwali = b.nip
																	JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
																	WHERE c.aktif = 'Aktif' AND a.`tingkat` BETWEEN 7 AND 9 ORDER BY `tingkat`");
				                                              }elseif ($_SESSION['level']=='nilai aly' OR $_SESSION['level']=='nilai') {
				                                              	$sql_guru = mysqli_query($conn,"SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
																	FROM `kelas` as a
																	JOIN `pegawai` as b on a.nipwali = b.nip
																	JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
																	WHERE c.aktif = 'Aktif' AND a.`tingkat` BETWEEN 10 AND 12 ORDER BY `tingkat`");
				                                              }else{
				                                              	$sql_guru = mysqli_query($conn,"SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
																	FROM `kelas` as a
																	JOIN `pegawai` as b on a.nipwali = b.nip
																	JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
																	WHERE c.aktif = 'Aktif'");
				                                              }
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
			                                      	<div class="col-lg-10">
			                                          	<select  name="idsemester" class="form-control" style="width: 100%">
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
			        	$idsemester=$_POST['idsemester'];
			        }else{

			        	$idkelas=$_GET['idkelas'];
			        	$idsemester=$_GET['idsemester'];
			        }
					
			flash('example_message');
			?>
			        <!-- page start-->

				       <form class="form-horizontal" role="form" method='POST' action='<?php echo $aksi ?>' enctype="multipart/form-data">
				            <div class="row">
				            	<?php
				            	if ($_SESSION['level']=='admin' or $_SESSION['level']=='guru') {
				            	?>
					            <div class="col-sm-3">
					                <section class="panel">
					                    <div class="panel-body">
					                    	<label class="btn btn-compose">
					                    		SISWA
					                    	</label>					                       
					                       		
					                        
					                        <ul class="nav nav-pills nav-stacked mail-nav">
					                        	<?php
					                        	$queryb = "SELECT s.nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn,k.tingkat, k.kelas,k.idtahunajaran, t.tahunajaran 
														FROM siswa as s         
                                                        RIGHT JOIN `history` as h ON s.nis = h.nis
                                                        left join kelas k on h.idkelas = k.id
                                                        left join tahunajaran t on t.id = k.idtahunajaran 
                                                        WHERE h.`idkelas` = '$idkelas'";
												$sqlb = mysqli_query($conn,$queryb);
												while ($x = mysqli_fetch_assoc($sqlb)) {
												?>											

					                            <li><a style="cursor:pointer" href="<?php echo $linkaksi ?>&idkelas=<?php echo $idkelas ?>&idsemester=<?php echo $idsemester ?>&nis=<?php echo $x['nis'] ?>"><?php echo $x['nis'] ?> - <?php echo $x['nama'] ?></a></li>
												<?php
												}
					                        	?>
					                        </ul>
					                    	
					                    </div>
					                </section>
					                
					            </div>
					            <?php 
					        	}
								if(isset($_GET['nis'])){						 							
								include "isinilairaport.php";									
									
								}else{

									$qsms = mysqli_query($conn,"SELECT * FROM semester WHERE id = '$idsemester'");
									$sms = mysqli_fetch_assoc($qsms);
									$qdtl = "SELECT s.nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn,k.tingkat, k.kelas,k.idtahunajaran, t.tahunajaran 
									FROM siswa as s         
                                    RIGHT JOIN `history` as h ON s.nis = h.nis
                                    left join kelas k on h.idkelas = k.id
                                    left join tahunajaran t on t.id = k.idtahunajaran 
									WHERE a.id = '$idkelas'";
								$sqldtl = mysqli_query($conn,$qdtl);	
								$dtl = mysqli_fetch_assoc($sqldtl);
								?>
								<?php if ($_SESSION['level']=='siswa' or $_SESSION['level']=='ortu') {
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
			    						<div class="panel-body profile-information">

								           <div class="col-md-3">
								           		<br>
									           	<div align="center" >
									           		<b><h2><?php echo $dtl['kelas']?></h2></b>
									           		<img src="images/ect/nilai.png" width="80%" alt=""/>
									            </div>
								           </div>
								           <div class="col-md-9 table-responsive">
								               <div class="profile-desk">
								               	<div class="tab-pane ">                
									                <div class="prf-contacts sttng">
									                    <h2>REKAP NILAI MURNI RAPORT HASIL TEST</h2>
									                </div>      
									            </div>
								               	<table class="table table-borderless" >
								               		<tr>
								               			<td>Kelas</td>
								               			<td>:</td>
								               			<td><?php echo $dtl['kelas']?></td>
								               		</tr>								               		
								               		<tr>               			
								               			<td>Wali Kelas</td>
								               			<td>:</td>
								               			<td><?php echo $dtl['nama']?></td>
								               		</tr>
								               		<tr>               			
								               			<td>Semester</td>
								               			<td>:</td>
								               			<td><?php echo $sms['semester']?> </td>
								               		</tr>
								               		<tr>               			
								               			<td>Tahun Ajaran</td>
								               			<td>:</td>
								               			<td><?php echo $dtl['tahunajaran'] ?></td>
								               		</tr>
								               	</table>              
								               </div>
								           </div>
								        </div>
			    					</section>
								</div>
								<div class="col-sm-3">
								</div>
						    	<div class="col-sm-9">
									<section class="panel">
										<div class="panel-body">
									        <section id="flip-scroll">
									        	<div class="table-responsive">
							                        <div class="adv-table editable-table">
							                            <div class="clearfix">
							                                <div class="btn-group">
							                                </div>
							                                <div class="btn-group pull-right">
							                                   
							                                </div>
							                            </div>
							                            <div class="space12"></div>
							                            <table class="table table-striped table-hover table-bordered nowrap" id="exampleres">
							                                <thead>
							                                <tr>
																<th rowspan="2" class="text-center">No</th>
											                    <th rowspan="2" class="text-center">NIS</th>
																<th rowspan="2" class="text-center">Nama Santri</th>
											                    <?php
											                    $qkw = "SELECT * FROM pelajaran WHERE tingkat = '$dtl[tingkat]' AND sifat = '5' order by id asc";
											                    $sqlkw = mysqli_query($conn,$qkw);
																$jmlw = mysqli_num_rows($sqlkw);	
																?>
																<th colspan="<?php echo $jmlw?>" class="text-center">Mata Pelajaran</th>
																<?php
											                    $qkt = "SELECT * FROM pelajaran WHERE tingkat = '$dtl[tingkat]' AND sifat = '7' order by id asc";
											                    $sqlkt = mysqli_query($conn,$qkt);
																$jmlt = mysqli_num_rows($sqlkt);	
																?>
																<th colspan="<?php echo $jmlt?>" class="text-center">Tes Kitab</th>
																<?php
											                    $qk8 = "SELECT * FROM pelajaran WHERE tingkat = '$dtl[tingkat]' AND sifat = '8' order by id asc";
											                    $sqlk8 = mysqli_query($conn,$qk8);
																$jml8 = mysqli_num_rows($sqlk8);	
																?>
																<th colspan="<?php echo $jml8?>" class="text-center">Tamrin</th>
																<?php
											                    $qk9 = "SELECT * FROM pelajaran WHERE tingkat = '$dtl[tingkat]' AND sifat = '9' order by id asc";
											                    $sqlk9 = mysqli_query($conn,$qk9);
																$jml9 = mysqli_num_rows($sqlk9);	
																?>
																<th colspan="<?php echo $jml9?>" class="text-center">Muhafadoh</th>
																<?php
											                    $qk10 = "SELECT * FROM pelajaran WHERE tingkat = '$dtl[tingkat]' AND sifat = '10' order by id asc";
											                    $sqlk10 = mysqli_query($conn,$qk10);
																$jml10 = mysqli_num_rows($sqlk10);	
																while ($kh10 = mysqli_fetch_assoc($sqlk10)) {
											                    ?>
											                    <th rowspan="2" class="text-center"><?php echo $kh10['nama']?></th>
											                    <?php
											                    }
											                    ?>
											                    <th rowspan="2" class="text-center">Jumlah</th>
											                    <th rowspan="2" class="text-center">Rata</th>
															</tr>
															<tr>
																<?php											                    
										                    	if ($jmlw==0) {
										                    		?>
										                    		<th></th>
										                    		<?php
										                    	}else{
										                    		while ($khw = mysqli_fetch_assoc($sqlkw)) {
											                    	?>
										                    		<th class="text-center"><?php echo $khw['nama']?></th>
											                    	<?php
											                    	}}
											                    ?>
											                    <?php											                    
										                    	if ($jmlt==0) {
										                    		?>
										                    		<th></th>
										                    		<?php
										                    	}else{
										                    		while ($kht = mysqli_fetch_assoc($sqlkt)) {
											                    	?>
										                    		<th class="text-center"><?php echo $kht['nama']?></th>
											                    	<?php
											                    	}}
											                    ?>
											                    <?php											                    
										                    	if ($jml8==0) {
										                    		?>
										                    		<th></th>
										                    		<?php
										                    	}else{
										                    		while ($kh8 = mysqli_fetch_assoc($sqlk8)) {
											                    	?>
										                    		<th class="text-center"><?php echo $kh8['nama']?></th>
											                    	<?php
											                    	}}
											                    ?>
											                    <?php											                    
										                    	if ($jml9==0) {
										                    		?>
										                    		<th></th>
										                    		<?php
										                    	}else{
										                    		while ($kh9 = mysqli_fetch_assoc($sqlk9)) {
											                    	?>
										                    		<th class="text-center"><?php echo $kh9['nama']?></th>
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
										                    		<th class="text-center"><?php echo $kh10['nama']?></th>
											                    	<?php
											                    	}}
											                    ?>
															</tr>
							                                </thead>
							                                <tbody>
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
							                                    <td align="center"><?php echo $i ?></td>
							                                    <input type="hidden" name="id[]" value="<?php echo $m['id'] ?>">
					                    						<input type="hidden" name="nis[]" value="<?php echo $m['nis'] ?>">
							                                    <td align="center"><?php echo $m['nis']?></td>
							                                    <td><?php echo $m['nama']?></td>
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
													      			<td align="center"><?php echo $jrata ?></td>	
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
																	<td align="center">0</td>
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
													      			<td align="center"><?php echo $jrata7 ?></td>	
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
																	<td align="center">0</td>
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
													      			<td align="center"><?php echo $jrata8 ?></td>	
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
																	<td align="center">0</td>
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
													      			<td align="center"><?php echo $jrata9 ?></td>	
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
													      			<td align="center"><?php echo $jrata10 ?></td>	
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
							                                    <td><?php echo $total ?></td>
							                                    <td><?php echo round($ratatotal,1) ?></td>
							                                </tr>
															
							                                <?php
							 									 $x++;
							 									 $i++;
							 								 }
							 								?>
							                                </tbody>
							                                
							                            </table>
							                        </div>
							                    </div>
							                </section>
							            </div>
									</section>
						    	</div>
								<?php
								}
							 
								 ?>

					    		<input type="hidden" name="idkelas" class="form-control " value="<?php echo $idkelas ?>" >
					    		<input type="hidden" name="idsemester" class="form-control " value="<?php echo $idsemester ?>" >
					        </div>
				       </form>  

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
				                        Perhitungan Nilai Raport
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">

				                            <div class="form-group">
			                                  <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
			                                  	<div class="col-lg-10">
			                                      	<select  name="idkelas" class="select2" style="width: 100%" >
			                                          <?php
			                                                    $sql_guru = mysqli_query($conn,"SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
																		FROM `kelas` as a
																		JOIN `pegawai` as b on a.nipwali = b.nip
																		JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
																		ORDER BY c.id, a.id");
			                                            while($k = mysqli_fetch_assoc($sql_guru))
			                                            {
			                                              if(isset($c['id']) && $k['id'] == $c['id'])
			                                              {
			                                                echo"<option value='$k[id]' selected>$k[kelas] - $k[tahunajaran]</option>";  
			                                              }
			                                              else
			                                              {
			                                                echo"<option value='$k[id]'>$k[kelas] - $k[tahunajaran]</option>";
			                                              }
			                                              
			                                            }
			                                                    ?>
			                                      	</select>
			                                    </div>
			                                </div>
			                                <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Semester</label>
		                                      	<div class="col-lg-10">
		                                          	<select  name="idsemester" class="form-control" style="width: 100%" >
		                                              <?php
		                                                        $sql_semester = mysqli_query($conn,"SELECT * FROM `semester`");
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
				include "isinilairaport.php";									
					
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