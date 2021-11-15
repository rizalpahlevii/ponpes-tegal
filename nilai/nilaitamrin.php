<?php
	
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['nilaitamrin']) AND $_SESSION['nilaitamrin'] <> 'TRUE')
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
		$linkaksi = 'med.php?mod=nilaitamrin';
	}else{		
		$linkaksi = 'med2.php?mod=nilaitamrin';
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

	$aksi = 'mod/nilai/act_nilai.php';

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
				                        Penilaian Tamrin Pelajaran
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            	<input type="hidden" name="nipguru" value="<?php echo $_GET['id'] ?>">

				                            
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
		                                      <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
		                                      	<div class="col-lg-10">
		                                          	<select  name="idkelas" class="select2" style="width: 100%">
		                                              <?php
		                                                      
				                                              if ($_SESSION['level']=='nilai ibt' OR $_SESSION['level']=='absensi ibt') {
				                                                  
    			                                                  $subk = substr($_SESSION['login_user'],4);
    			                                                  $subk1 = substr($_SESSION['login_user'],3,1);
    			                                                  $kls=$subk;
    			                                                  $kls1=$subk1;
			                                                    $sql_guru = mysqli_query($conn,"SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
																	FROM `kelas` as a
																	JOIN `pegawai` as b on a.nipwali = b.nip
																	JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
																	WHERE c.aktif = 'Aktif' AND a.`kelas` = '$kls1 IBT $kls'  AND a.`tingkat` BETWEEN 3 AND 6 ORDER BY `tingkat`");
				                                              }elseif ($_SESSION['level']=='nilai ts' OR $_SESSION['level']=='absensi ts') {
				                                                  $subk = substr($_SESSION['login_user'],3);
    			                                                  $subk1 = substr($_SESSION['login_user'],2,1);
    			                                                  $kls=$subk;
    			                                                  $kls1=$subk1;
			                                                   
				                                              	$sql_guru = mysqli_query($conn,"SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
																	FROM `kelas` as a
																	JOIN `pegawai` as b on a.nipwali = b.nip
																	JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
																	WHERE c.aktif = 'Aktif' AND a.`kelas` = '$kls1 TS $kls' AND a.`tingkat` BETWEEN 7 AND 9 ORDER BY `tingkat`");
				                                              }elseif ($_SESSION['level']=='nilai aly' OR $_SESSION['level']=='nilai' OR $_SESSION['level']=='absensi aly') {
				                                                  $subk = substr($_SESSION['login_user'],4);
    			                                                  $subk1 = substr($_SESSION['login_user'],3,1);
    			                                                  $kls=$subk;
    			                                                  $kls1=$subk1;
    			                                                  
				                                              	$sql_guru = mysqli_query($conn,"SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
																	FROM `kelas` as a
																	JOIN `pegawai` as b on a.nipwali = b.nip
																	JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
																	WHERE c.aktif = 'Aktif' AND a.`kelas` = '$kls1 ALY $kls' AND a.`tingkat` BETWEEN 10 AND 12 ORDER BY `tingkat`");
				                                              }elseif ($_SESSION['level']=='nilai sp' OR $_SESSION['level']=='absensi sp') {
				                                                  $subk = substr($_SESSION['login_user'],2);
    			                                                  $kls=$subk;
    			                                                  
				                                              	$sql_guru = mysqli_query($conn,"SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
																	FROM `kelas` as a
																	JOIN `pegawai` as b on a.nipwali = b.nip
																	JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
																	WHERE c.aktif = 'Aktif' AND a.`kelas` = 'SP $kls' AND a.`tingkat` = '2' ORDER BY `tingkat`");
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
				                        Penilaian Tamrin 
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">

				                            <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
		                                      	<div class="col-lg-10">
		                                          	<select  name="idkelas" class="select2" style="width: 100%" >
		                                              <?php
		                                                        $sql_penilaitamrinan = mysqli_query($conn,"SELECT a.* 
                                                															FROM `kelas` as a 
                                                															JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
                                                															WHERE b.`aktif` = 'Aktif' ORDER BY tingkat");
		                                                while($k = mysqli_fetch_assoc($sql_penilaitamrinan))
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
			if(!empty($_GET['idkelas']) or !empty($_POST['idkelas']))
			{
				if(!empty($_GET['idkelas'])){
					$idsemester = $_GET['idsemester'];
					$idkelas = $_GET['idkelas'];
				}else{		
					$idsemester = $_POST['idsemester'];
					$idkelas = $_POST['idkelas'];
				}
				$act = "$aksi?mod=act_nilaitamrin&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM ujian WHERE `idkelas` = '$idkelas' AND `idsemester` = '$idsemester' ");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				#else
				#{
				#	header("location:med.php?mod=nilaitamrin");
				#}

			}
			else
			{
				$act = "$aksi?mod=nilaitamrin&act=simpan";
			}
			flash('example_message');
			?>
			        <!-- page start-->

				       <form class="form-horizontal" role="form" method='POST' action='<?php echo $aksi ?>' enctype="multipart/form-data">
				            <div class="row">
					            <div class="col-sm-3">
					                <section class="panel">
					                    <div class="panel-body">
					                    	<label class="btn btn-compose">
					                    		<?php 
					                    		$sqlguru = "SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` and d.alumni='0' ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
												FROM `kelas` as a
												JOIN `pegawai` as b on a.nipwali = b.nip
												JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
												WHERE a.`id` = '$idkelas'";
												$kguru = mysqli_query($conn, $sqlguru);
												$guru = mysqli_fetch_assoc($kguru);
												echo $guru['kelas'];
					                    		?>
					                    		
					                    	</label>					                       
					                       		
					                        
					                        <ul class="nav nav-pills nav-stacked mail-nav">
					                        	<?php
					                        	$query = "SELECT * FROM `aspekkelompok`";
												$sql_kul = mysqli_query($conn,$query);	
												
												while ($m = mysqli_fetch_assoc($sql_kul)) {
													
												?>

												<div align="center" class="tab-pane ">                
									                <div class="prf-contacts sttng">
									                    <u><h2><?php echo $m['keterangan'] ?></h2></u>
									                </div>      
									            </div>
					                        	<?php
					                        	$queryb = "SELECT a.`id`, a.`kode`, a.`nama`, a.`kkm`, a.`tingkat`, a.`sifat`, b.`kode` as kelompok, b.`keterangan` 
															FROM `pelajaran` as a
															JOIN `aspekkelompok` as b ON a.`sifat` = b.`id`
															WHERE a.`tingkat` = '$guru[tingkat]' AND b.`id` = '$m[id]' ORDER BY a.id";
												$sqlb = mysqli_query($conn,$queryb);
												while ($x = mysqli_fetch_assoc($sqlb)) {
												?>											

					                            <li><a style="cursor:pointer" href="<?php echo $linkaksi ?>&aks=nilai&act=add&act=form&idkelas=<?php echo $idkelas ?>&idsemester=<?php echo $idsemester ?>&idpel=<?php echo $x['id'] ?>"> <i class="fa fa-caret-square-o-right"></i> <?php echo $x['nama'] ?></a></li>
												<?php
												}}
					                        	?>
					                        </ul>
					                    	
					                    </div>
					                </section>
					                
					            </div>
					            <?php 
								if(isset($_GET['idpel'])){						 							
								include "isinilai.php";									
									
								}
							 
								 ?>

				        		<input type="hidden" name="nipguru" class="form-control " value="<?php echo $nipguru ?>" >
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

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">
		                        <?php if($_SESSION['level']=='admin'){?>
		                        	<a href="med.php?mod=nilaitamrin&act=add">
									<button class="btn btn-primary">
										Tambah Nilai Tamrin <i class="fa fa-plus"></i>
									</button>
									</a>
								<?php }?>
		                        <span class="tools pull-right">
		                            <a href="javascript:;" class="fa fa-chevron-down"></a>
		                            <a href="javascript:;" class="fa fa-cog"></a>
		                            <a href="javascript:;" class="fa fa-times"></a>
		                         </span>
		                    </header>
							
							
		                    <div class="panel-body">
							
		                        <div class="adv-table editable-table table-responsive">
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
											<th class="text-center">Kelas</th>
											<th class="text-center">Tahun Ajaran</th>
											<th class="text-center">Aksi</th>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
		                                	if($_SESSION['level']=='admin' ){
											$query = "SELECT DISTINCT a.`idpelajaran`, b.`kode`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`,i.`nip`, i.`nama` as guru, t.`tahunajaran` 
												FROM `ujian` as a
												JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
												JOIN `kelas` as c ON a.`idkelas` = c.`id`
												JOIN `semester` as d ON a.`idsemester` = d.`id`	
					                            JOIN `pegawai` as i on c.`nipwali` = i.`nip`
					                            JOIN `tahunajaran` as t on c.`idtahunajaran` = t.`id`
					                            GROUP BY c.id";
												$sql_kul = mysqli_query($conn,$query);	
											}else {
												$query2 = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$_SESSION[id_user]'");
                            					$a2 = mysqli_fetch_assoc($query2);
												$query = "SELECT DISTINCT a.`idpelajaran`, b.`kode`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`,i.`nip`, i.`nama` as guru, t.`tahunajaran` 
												FROM `ujian` as a
												JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
												JOIN `kelas` as c ON a.`idkelas` = c.`id`
												JOIN `semester` as d ON a.`idsemester` = d.`id`		
					                            JOIN `pegawai` as i on c.`nipwali` = i.`nip`
					                            JOIN `tahunajaran` as t on c.`idtahunajaran` = t.`id`
					                            where a.`idkelas` = '$a2[idkelas]'";
												$sql_kul = mysqli_query($conn,$query);	
											}
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <td align="center"><?php echo $m['kelas'] ?></td>
		                                    <td align="center"><?php echo $m['tahunajaran']?></td>
		                                   
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> 
		                                   <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm" type="button"><i class="fa fa-search"></i> <span class="caret"></span></button>
                                            <ul role="menu" class="dropdown-menu">
                                                <?php
                                                 $queryp = mysqli_query($conn,"SELECT * FROM semester where aktif='Aktif'");
                                                  
                                                  while($p = mysqli_fetch_assoc($queryp)){
                                                ?>
                                                 <li><a href="<?php echo $linkaksi ?>&act=detail&nipguru=<?php echo $m['nip']?>&idkelas=<?php echo $m['idkelas']?>&idsemester=<?php echo $p['id']?>"><?php echo $p['semester'] ?></a></li>
                                                 
                                                <?php
                                                }
                                                ?>
                                            </ul>
                                        </div><!-- /btn-group -->
		                                   
		                                   		
		                                        

												
											</td>
		                                </tr>
										
		                                <?php
		 									 $i++;
		 								 }
		 								?>
		                                </tbody>
		                            </table>
		                        </div>
		                    </div>
		                </section>
		            </div>
		        </div>

		            <!-- page end-->
			<?php
		break;
		case 'detail':
			if(!empty($_GET['idkelas']) or !empty($_POST['idkelas']))
				if(!empty($_GET['idkelas'])){
					$idkelas = $_GET['idkelas'];
					$idsemester = $_GET['idsemester'];
				}else{		
					$idkelas = $_POST['idkelas'];
					$idsemester = $_POST['idsemester'];
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
	                    		$sqlguru = "SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` and d.alumni='0' ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
								FROM `kelas` as a
								JOIN `pegawai` as b on a.nipwali = b.nip
								JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
								WHERE a.`id` = '$idkelas'";
								$kguru = mysqli_query($conn, $sqlguru);
								$guru = mysqli_fetch_assoc($kguru);
								echo $guru['kelas'];
	                    		?>
	                    		
	                    	</label>					                       
	                       		
	                        
	                        <ul class="nav nav-pills nav-stacked mail-nav">
	                        	<?php
	                        	$query = "SELECT * FROM `aspekkelompok`";
								$sql_kul = mysqli_query($conn,$query);	
								
								while ($m = mysqli_fetch_assoc($sql_kul)) {
									
								?>

								<div align="center" class="tab-pane ">                
					                <div class="prf-contacts sttng">
					                    <u><h2><?php echo $m['keterangan'] ?></h2></u>
					                </div>      
					            </div>
	                        	<?php
	                        	$queryb = "SELECT a.`id`, a.`kode`, a.`nama`, a.`kkm`, a.`tingkat`, a.`sifat`, b.`kode` as kelompok, b.`keterangan` 
											FROM `pelajaran` as a
											JOIN `aspekkelompok` as b ON a.`sifat` = b.`id`
											WHERE a.`tingkat` = '$guru[tingkat]' AND b.`id` = '$m[id]' ORDER BY a.id";
								$sqlb = mysqli_query($conn,$queryb);
								while ($x = mysqli_fetch_assoc($sqlb)) {
								?>											

	                            <li><a style="cursor:pointer" href="<?php echo $linkaksi ?>&idkelas=<?php echo $idkelas ?>&idpel=<?php echo $x['id'] ?>&idsemester=<?php echo $idsemester ?>"> <i class="fa fa-caret-square-o-right"></i> <?php echo $x['nama'] ?></a></li>
								<?php
								}}
	                        	?>

	                        </ul>
	                    	
	                    </div>
	                </section>
	                
	            </div>
	            <?php 
				if(isset($_GET['idpel'])){						 							
				include "isinilai.php";									
					
				}
			 
				 ?>

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
      	$sql = mysqli_query($conn,"SELECT DISTINCT a.dasarpenilaitamrinan, b.keterangan
      			FROM `aturannhb` as a 
				LEFT JOIN `dasarpenilaitamrinan` as b ON a.`dasarpenilaitamrinan` = b.`id`");
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
															 FROM ujian uji, nilaitamrinujian niluji, siswa sis, pelajaran pel 
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
		case 'detailsiswa':
	    $qsms = mysqli_query($conn,"SELECT * FROM `siswa` WHERE `nis`= '$_SESSION[id_user]'");
		$sms = mysqli_fetch_assoc($qsms);
		$idkelas = $sms['idkelas'];
		$semester=$_GET['semester'];
		?>
		<div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body">
                    	<label class="btn btn-compose">
                    		<?php 
                    		$sqlguru = "SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` and d.alumni='0' ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
							FROM `kelas` as a
							JOIN `pegawai` as b on a.nipwali = b.nip
							JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
							WHERE a.`id` = '$idkelas'";
							$kguru = mysqli_query($conn, $sqlguru);
							$guru = mysqli_fetch_assoc($kguru);
							echo "Pilih Mata Pelajaran";
                    		?>
                    		
                    	</label>					                       
                       		
                        
                        <ul class="nav nav-pills nav-stacked mail-nav">
                        	<?php
                        	$query = "SELECT * FROM `aspekkelompok`";
							$sql_kul = mysqli_query($conn,$query);	
							
							while ($m = mysqli_fetch_assoc($sql_kul)) {
								
							?>

							<div align="center" class="tab-pane ">                
				                <div class="prf-contacts sttng">
				                    <u><h2><?php echo $m['keterangan'] ?></h2></u>
				                </div>      
				            </div>
                        	<?php
                        	$queryb = "SELECT a.`id`, a.`kode`, a.`nama`, a.`kkm`, a.`tingkat`, a.`sifat`, b.`kode` as kelompok, b.`keterangan` 
										FROM `pelajaran` as a
										JOIN `aspekkelompok` as b ON a.`sifat` = b.`id`
										WHERE a.`tingkat` = '$guru[tingkat]' AND b.`id` = '$m[id]' ORDER BY a.id";
							$sqlb = mysqli_query($conn,$queryb);
							while ($x = mysqli_fetch_assoc($sqlb)) {
							?>											

                            <li><a style="cursor:pointer" href="<?php echo $linkaksi ?>&act=detailmk&idkelas=<?php echo $idkelas ?>&idpel=<?php echo $x['id'] ?>&semester=<?php echo $semester ?>"> <i class="fa fa-caret-square-o-right"></i> <?php echo $x['nama'] ?></a></li>
							<?php
							}}
                        	?>

                        </ul>
                    	
                    </div>
                </section>
                
            </div>
        </div>
		<?php
		break;
		case 'detailmk':
		    $idpel = $_GET['idpel'];
		    $idkelas = $_GET['idkelas'];
		    $idsemester = $_GET['semester'];
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
		<div class="col-sm-12">
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
				                    <h2>NILAI TAMRIN <?php echo $dtl['tahunajaran'] ?></h2>
				                </div>      
				            </div>`
			               	<table class="table table-borderless" >
			               		<tr>
			               			<td>Pelajaran</td>
			               			<td>:</td>
			               			<td><?php echo $isi['nama']?></td>
			               		</tr>
			               		<tr>
			               			<td>Wali Kelas</td>
			               			<td>:</td>
			               			<td><?php echo $dtl['nama']?></td>
			               		</tr>
			               		<tr>
			               			<td>Semester</td>
			               			<td>:</td>
			               			<td><?php echo $sms['semester']?></td>
			               		</tr>
			               	</table>                   
			               </div>
			           </div>
			        </div>
			    </section>
			</section>
		</div>
		<div class="col-md-12">
			<section class="panel">
			    <div class="panel-body">
			        <section id="flip-scroll">
			        	<div class="table-responsive">
			        	 <table class="table table-striped table-hover table-bordered" id="example">
			        	 	<thead>
			        	 		<tr>
			        	 			<th class="text-center">No</th>
			        	 			<th class="text-center">NIS</th>
			        	 			<th class="text-center">Nama</th>
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
									      	
									      	while($u = mysqli_fetch_assoc($qu)){
							      	?>
							      	<th class="text-center" >
							      		<font class="popovers" data-original-title="<?php echo getBulanHijriah($u['deskripsi']) ?>" data-content="<?php echo getBulanHijriah($u['deskripsi']) ?>" data-placement="top" data-trigger="hover" ><?php echo getBulanHijriah($u['deskripsi']) ?></font> 
							      		
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
			        	 	</thead>	
			        	 	<tbody>
			        	 		<?php
							      	$querys = mysqli_query($conn,"SELECT * FROM siswa WHERE nis = '$_SESSION[id_user]'");
							      	$is=1;
							      	while($k = mysqli_fetch_assoc($querys)){
							    ?>
							    <tr>
							      	<td class="text-center"><?php echo $is ?></td>
							        <td align="center"><?php echo $_SESSION['id_user'] ?></td>
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