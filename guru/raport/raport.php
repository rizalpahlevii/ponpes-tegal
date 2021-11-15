<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['raport']) AND $_SESSION['raport'] <> 'TRUE')
	{
		?>
		  <div class="alert alert-danger alert-dismissible" id="succsess-alert">
	        <button type="button" class="close" data-dismiss="alert" aria-text="true">&times;</button>
	        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	        Dilarang mengakses file ini.
	      </div>
		<?php
	}
	else{
	$queryg = "SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
		FROM `guru` as a
		JOIN `pegawai` as b on a.nip = b.nip
		JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
		JOIN `statusguru` as d on d.`id` = a.`statusguru` 
		WHERE a.`nip` = '$_SESSION[login_user]'";
	$sql_g = mysqli_query($conn,$queryg);	
	$g = mysqli_fetch_assoc($sql_g);
	//link buat paging
	$linkaksi = 'med.php?mod=raport';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/guru/raport/act_raport.php';

	?>
	<?php
	switch ($act) {
		case 'form':

			?>
			        <!-- page start-->
				        <!-- page start-->
				  
				        <?php
				        if (isset($_POST['idkelas'])=='1') {
				        	$idkelas=$_POST['idkelas'];
				        	$idtahunajaran=$_POST['idtahunajaran'];
				        	$idsemester=$_POST['idsemester'];
				        }else{

				        	$idkelas=$_GET['idkelas'];
				        	$idtahunajaran=$_GET['idtahunajaran'];
				        	$idsemester=$_GET['idsemester'];
				        }
				        $queryg = "SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
							FROM `guru` as a
							JOIN `pegawai` as b on a.nip = b.nip
							JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
							JOIN `statusguru` as d on d.`id` = a.`statusguru` 
							WHERE a.`nip` = '$_SESSION[login_user]'";

						$sql_g = mysqli_query($conn,$queryg);	
						$g = mysqli_fetch_assoc($sql_g);
						$querykls = "SELECT * FROM `kelas` WHERE `id` = '$idkelas' AND `idtahunajaran` = '$idtahunajaran'";
							
						$sql_kls = mysqli_query($conn,$querykls);	
						$kls = mysqli_fetch_assoc($sql_kls);
						flash('example_message');
						
						?>
						<div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data raport katagori
				                    </header>
				                    <div class="panel-body">
				                        <form class="form-horizontal" role="form" method='POST' action='<?php echo $aksi ?>' enctype="multipart/form-data">
				                        	<div class="table-responsive">
					                          <table class="table table-striped table-hover table-bordered">			  
											    <thead>
											      <tr>
											        <th width="10" style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center">No</th>
											        <th width="40" style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center">NIS</th>
											        <th style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center" width="150">Nama</th>
											        <th colspan="3" class="text-center">Pengetahuan</th>
											        <th colspan="3" class="text-center">Keterampilan</th>

											      	<th style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center">Rata -Rata Nilai</th>
											      	<th style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center">Kelas Katagori</th>
											      </tr>
											      	
											      <tr>
											      	<?php
											      	for ($i=0; $i < 2; $i++) { 
											      	?>

											        <th class="text-center">UH1</th>
											        <th class="text-center">UH2</th>
											        <th class="text-center">UH3</th>
											      	
											      	<?php
											      	}
											      	?>
											      </tr>
											    </thead>
											    <tbody>
											    	<?php
											      	$querys = mysqli_query($conn,"SELECT * FROM siswa WHERE idkelas = '$kls[id]'");
											      	$is=1;
											      	while($k = mysqli_fetch_assoc($querys)){
											      	?>
											      <tr>
											      	
											      	<th class="text-center"><?php echo $is ?></th>
											        <td align="center"><?php echo $k['nis'] ?></td>
											        <td><?php echo $k['nama'] ?></td>
											        <td colspan="7"></td>
 	

											        
											       
											        <?php
												        $queryk = mysqli_query($conn,"SELECT * FROM `rpp` WHERE `idpelajaran` = '$g[idpelajaran]' and `idsemester` = '$idsemester'");
												        $queryk1 = mysqli_query($conn,"SELECT * FROM `rpp` WHERE `idpelajaran` = '$g[idpelajaran]' and `idsemester` = '$idsemester'");
												        
												      	$temukan = mysqli_num_rows($queryk);
												      	$hs=$temukan+1;
													    $jmkodep = 0;
												        $jmkodek = 0;
												      	while ($c = mysqli_fetch_assoc($queryk1)) {
															
												        	$qtp = mysqli_query($conn,"SELECT  max(`uhke`) as totp FROM `raport_katagori` WHERE `idpelajaran` = '$g[idpelajaran]' and `idrpp` ='$c[id]' and `jenisujian` ='Pengetahuan' ");
												        	$tp = mysqli_fetch_assoc($qtp);
												        	$qtk = mysqli_query($conn,"SELECT  max(`uhke`) as totk FROM `raport_katagori` WHERE `idpelajaran` = '$g[idpelajaran]' and `idrpp` ='$c[id]' and `jenisujian` ='Keterampilan' ");
												        	$tk = mysqli_fetch_assoc($qtk);
												        	
												        $jmkodep += $tp['totp'];
												        $jmkodek += $tk['totk'];
														}	
														$qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$k[nis]' and `idpelajaran` = '$g[idpelajaran]'");
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

										        	<td style="vertical-align : middle;text-align:center;" rowspan="<?php echo $hs ?>"><?php echo $kelas ?></td>
										        	</tr>
											      	<?php
												      	$ik=1;
												      	while($kd = mysqli_fetch_assoc($queryk)){

												        ?>
												     <tr>
												     	<td></td>
												     	<td>KD-<?php echo $ik ?></td>
												        <td><?php echo $kd['rpp'] ?></td>
												        <?php
												        $no=1;
												        for ($x=0; $x < 3; $x++) { 
											        		$q = mysqli_query($conn,"SELECT * FROM `raport_katagori` WHERE `nis`='$k[nis]' and `idpelajaran` = '$g[idpelajaran]' and `idrpp` ='$kd[id]' and `jenisujian` ='Pengetahuan' and `uhke` ='$no'");
															$te = mysqli_num_rows($q);
															if($te > 0)
															{
																$t = mysqli_fetch_assoc($q);
																$nilai = $t['nilai'];
																$jnp[] = $t['nilai']; 
															}else{
																$nilai = '';
															}
												        ?>
												        <td width="150" align="center">
											        			<input type="hidden" name="uhp[]" class="form-control round-input" value="<?php echo $no ?>" >
													        	<input type="text" name="nilaip[]" class="form-control round-input" value="<?php echo $nilai ?>" >
													        	<input type="hidden" name="siswap[]" class="form-control round-input" value="<?php echo $k['nis'] ?>" >
													        	<input type="hidden" name="kodep[]" class="form-control round-input" value="<?php echo $kd['id'] ?>" >
													        </td>
												        <?php
												        $no++;
												    	}
												        ?>
												        <?php
												        $no=1;
												        for ($x=0; $x < 3; $x++) { 
											        		$q = mysqli_query($conn,"SELECT * FROM `raport_katagori` WHERE `nis`='$k[nis]' and `idpelajaran` = '$g[idpelajaran]' and `idrpp` ='$kd[id]' and `jenisujian` ='Keterampilan' and `uhke` ='$no'");
															$te = mysqli_num_rows($q);
															if($te > 0)
															{
																$t = mysqli_fetch_assoc($q);
																$nilai = $t['nilai'];
																$jnp[] = $t['nilai']; 
															}else{
																$nilai = '';
															}
												        ?>
												        <td width="150" align="center">
											        			<input type="hidden" name="uhk[]" class="form-control round-input" value="<?php echo $no ?>" >
													        	<input type="text" name="nilaik[]<?php echo $x?>" class="form-control round-input" value="<?php echo $nilai ;?>" >
													        	<input type="hidden" name="siswak[]" class="form-control round-input" value="<?php echo $k['nis'] ?>" >
													        	<input type="hidden" name="kodek[]" class="form-control round-input" value="<?php echo $kd['id'] ?>" >
													        </td>

												        <?php
												        $no++;
												    	}
												        ?>
												        <?php
												        $qtp = mysqli_query($conn,"SELECT  max(`uhke`) as totp FROM `raport_katagori` WHERE `nis`='$k[nis]' and `idpelajaran` = '$g[idpelajaran]' and `idrpp` ='$kd[id]' and `jenisujian` ='Pengetahuan' ");
											        	$tp = mysqli_fetch_assoc($qtp);
											        	$qtk = mysqli_query($conn,"SELECT  max(`uhke`) as totk FROM `raport_katagori`  WHERE `nis`='$k[nis]' and `idpelajaran` = '$g[idpelajaran]' and `idrpp` ='$kd[id]' and `jenisujian` ='Keterampilan' ");
											        	$tk = mysqli_fetch_assoc($qtk);
											        	
											        	$qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$k[nis]' and `idpelajaran` = '$g[idpelajaran]' and `idrpp` ='$kd[id]'");
											        	$tps = mysqli_fetch_assoc($qtps);
											        	$jrt = $tps['totp'];
												        $kodeb = $tp['totp'] + $tk['totk'];
											        	if ($kodeb <= 0) $kodeb = 1;
											        	$trt = ($jrt!=0)?($jrt/$kodeb):0;
											        	
												        ?>
												        <td align="center"><?php echo round($trt,1) ?></td>
												       
											      	</tr>
											      	<?php
											      	$ik++;
											      	}
											      	$is++;
											      	}
											      	?>
											    </tbody>
											  </table>												
											</div>
											<input type="hidden" name="idp" value="<?php echo $g['idpelajaran'] ?>">
											<input type="hidden" name="idkelas" value="<?php echo $_POST['idkelas'] ?>">
											<input type="hidden" name="idtahunajaran" value="<?php echo $_POST['idtahunajaran'] ?>">
											<input type="hidden" name="idsemester" value="<?php echo $_POST['idsemester'] ?>">
											<div class="form-group">
				                                <div class="col-lg-12" align="center">
									                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
									                <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
				                                </div>
				                            </div>
				                        </form>
				                    </div>
				                </section>

				            </div>
				        </div>
			<?php
		break;
		case 'detail'
		?>
					 <div class="row">
                  <div class="col-sm-12">

                      <section class="panel">
                          <header class="panel-heading">
                          	<?php
                          	$query = mysqli_query($conn,"SELECT * FROM kelas WHERE tingkat = '$_POST[tingkat]'");
                          	
                          	?>
                          	RAPORT KATEGORI KELAS <?php echo $_POST['tingkat'] ?>
                          		                         	
                              
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                          </header>
                          <div class="panel-body">
                          		<a href="mod/siswa/raport/blast.php?idsemester=<?php echo $_POST['idsemester'] ?>">
								<button class="btn btn-primary">
									Blast Email  <i class="fa fa-location-arrow"></i>
								</button>
								</a>
                              	<div class="table-responsive">
	                              	<div class="adv-table editable-table ">
			                            <div class="clearfix">
			                                <div class="btn-group">
			                                </div>
			                                <div class="btn-group pull-right">
			                                   
			                                </div>
			                            </div>
			                            <div class="space12"></div>
			                            <table class="table table-striped table-hover table-bordered" id="example">
			                                <thead>
			                                <tr>

												<th class="text-center">No</th>
												<th class="text-center">NIS</th>
												<th class="text-center">Nama</th>
			                                    <th class="text-center">Rata -Rata Nilai</th>
												<th class="text-center">Kelas Katagori</th>
			                                    <th class="text-center">Aksi</th>
												
											</tr>
			                                </thead>
			                                <tbody>
			                               	<?php

									      	$i=1;
			                               	while($c = mysqli_fetch_assoc($query)){

			                               	$querys = mysqli_query($conn,"SELECT a.id, a.`nis`, a.`nama`, sum(b.`nilai`)/(SELECT COUNT(*) AS jml FROM `pelajaran` as p JOIN `aspekkelompok` as dp ON p.`sifat` = dp.`id` WHERE dp.keterangan LIKE '%Peminatan%') as rpp,
												CASE
												WHEN sum(b.`nilai`)/(SELECT COUNT(*) AS jml FROM `pelajaran` as p JOIN `aspekkelompok` as dp ON p.`sifat` = dp.`id` WHERE dp.keterangan LIKE '%Peminatan%') >=95 THEN 'A'
												WHEN sum(b.`nilai`)/(SELECT COUNT(*) AS jml FROM `pelajaran` as p JOIN `aspekkelompok` as dp ON p.`sifat` = dp.`id` WHERE dp.keterangan LIKE '%Peminatan%') >=90 THEN 'B'
												WHEN sum(b.`nilai`)/(SELECT COUNT(*) AS jml FROM `pelajaran` as p JOIN `aspekkelompok` as dp ON p.`sifat` = dp.`id` WHERE dp.keterangan LIKE '%Peminatan%') >=85 THEN 'C'
												WHEN sum(b.`nilai`)/(SELECT COUNT(*) AS jml FROM `pelajaran` as p JOIN `aspekkelompok` as dp ON p.`sifat` = dp.`id` WHERE dp.keterangan LIKE '%Peminatan%') >=80 THEN 'D'
												WHEN sum(b.`nilai`)/(SELECT COUNT(*) AS jml FROM `pelajaran` as p JOIN `aspekkelompok` as dp ON p.`sifat` = dp.`id` WHERE dp.keterangan LIKE '%Peminatan%') <=80 THEN 'E'
												END AS grade
												FROM `siswa` as a
												JOIN `raport_katagori`as b ON a.nis = b.nis
												JOIN `rpp` as c ON b.idrpp = c.id
												JOIN `pelajaran` as p on b.idpelajaran = p.id
												JOIN `aspekkelompok` as dp ON p.`sifat` = dp.`id` WHERE dp.keterangan LIKE '%Peminatan%'
												AND a.idkelas = '$c[id]' AND c.idsemester = '$_POST[idsemester]'
												GROUP BY a.nis 
												ORDER BY grade");
														
									      	while($k = mysqli_fetch_assoc($querys)){
			                               
			                               	?>
			                                <tr class="">
			                                    <td align="center"><?php echo $i ?></td>
			                                    <td align="center"><?php echo $k['nis'] ?></td>
											    <td><?php echo $k['nama'] ?></td>
											    <td align="center"><?php echo round($k['rpp'],1) ?></td>
											    <td align="center"><?php echo $k['grade'] ?></td>
												<td align="center">
													<a target="_blank" href="mod/guru/raport/print.php?id=<?php echo $k['id'] ?>&idsemester=<?php echo $_POST['idsemester'] ?>" ><button class="btn btn-primary btn-sm"><i class="fa fa-print"></i></button> </a>
												</td>
			                                </tr>
											
			                                <?php
			 									 $i++;
			 								 }}
			 								?>
			                                </tbody>
			                            </table>
			                        </div>
                              </div>
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

	       <form class="form-horizontal" role="form" method='POST' action='med.php?mod=raport&act=detail' enctype="multipart/form-data">
	            <div class="col-lg-12">
	                <section class="panel">
	                    <header class="panel-heading">
	                    </header>
	                    <div class="panel-body">
	                        <div class="position-center">

	                            <div class="form-group">
                                  <label class="col-lg-2 col-sm-2 control-label">Tingkat</label>
                                  	<div class="col-lg-6">
                                      	<select  name="tingkat" class="form-control round-input" >
	                                          <option value="1">1</option>
	                                          <option value="2">2</option>
	                                          <option value="3">3</option>
	                                          <option value="4">4</option>
	                                          <option value="5">5</option>
	                                          <option value="6">6</option>
	                                          <option value="7">7</option>
	                                          <option value="8">8</option>
	                                          <option value="9">9</option>
	                                          <option value="10">10</option>
	                                          <option value="11">11</option>
	                                          <option value="12">12</option>
                                      	</select>
                                    </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-lg-2 col-sm-2 control-label">Semester</label>
                                  	<div class="col-lg-6">
                                      	<select  name="idsemester" class="form-control round-input" >
                                          <?php
                                                    $sql_pelajaran = mysqli_query($conn,"SELECT * FROM `semester` WHERE `aktif` = 'Aktif'");
                                            while($k = mysqli_fetch_assoc($sql_pelajaran))
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
		case 'guru':
		?>
		<div class="row">

	       <form class="form-horizontal" role="form" method='POST' action='med2.php?mod=raport&act=form' enctype="multipart/form-data">
	            <div class="col-lg-12">
	                <section class="panel">
	                    <header class="panel-heading">
	                        Input Raport Katagori
	                    </header>
	                    <div class="panel-body">
	                        <div class="position-center">

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
                                                    $sql_pelajaran = mysqli_query($conn,"SELECT * FROM `semester` WHERE `aktif` = 'Aktif'");
                                            while($k = mysqli_fetch_assoc($sql_pelajaran))
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

