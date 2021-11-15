<?php

	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['perhitungan_nilai']) AND $_SESSION['perhitungan_nilai'] <> 'TRUE')
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
	$linkaksi = 'med.php?mod=perhitungan_nilai';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/nilai/act_perhitungan_nilai.php';

	?>
	<?php
	switch ($act) {
		case 'add':
		?>
		 			<div class="row">

				       <form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=form' enctype="multipart/form-data">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Aturan Perhitungan Nilai Rapor
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">

				                            <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Guru</label>
		                                      	<div class="col-lg-6">
		                                          	<select  name="nipguru" class="form-control round-input">
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
		                                      <label class="col-lg-2 col-sm-2 control-label">Mata Pelajaran</label>
		                                      	<div class="col-lg-6">
		                                          	<select  name="idpelajaran" class="form-control round-input" >
		                                              <?php
		                                                        $sql_pelajaran = mysqli_query($conn,"SELECT * FROM `pelajaran`");
		                                                while($k = mysqli_fetch_assoc($sql_pelajaran))
		                                                {
		                                                  if(isset($c['id']) && $k['id'] == $c['id'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[kode] - $k[nama]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[kode] - $k[nama]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
			                                    </div>
			                                </div>
			                                <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Dasar Penilaian</label>
		                                      	<div class="col-lg-6">
		                                          	<select  name="dasarpenilaian" class="form-control round-input" >
		                                              <?php
		                                                        $sql_penilaian = mysqli_query($conn,"SELECT * FROM `dasarpenilaian`");
		                                                while($k = mysqli_fetch_assoc($sql_penilaian))
		                                                {
		                                                  if(isset($c['id']) && $k['id'] == $c['id'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[dasarpenilaian] - $k[keterangan]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[dasarpenilaian] - $k[keterangan]</option>";
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
			if(!empty($_GET['idpelajaran']) or !empty($_POST['idpelajaran']))
			{
				if(!empty($_GET['idpelajaran'])){
					$idpelajaran=$_GET['idpelajaran'];
					$nipguru = $_GET['nipguru'];
					$dasarpenilaian = $_GET['dasarpenilaian'];
				}else{
					$idpelajaran=$_POST['idpelajaran'];					
					$nipguru = $_POST['nipguru'];
					$dasarpenilaian = $_POST['dasarpenilaian'];
				}
				$act = "$aksi?mod=perhitungan_nilai&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM aturannhb WHERE `idpelajaran` = '$idpelajaran' AND `nipguru` = '$nipguru' AND `dasarpenilaian` = '$dasarpenilaian'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=perhitungan_nilai");
				}

			}
			else
			{
				$act = "$aksi?mod=perhitungan_nilai&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">

				       <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>' enctype="multipart/form-data">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Aturan Perhitungan Nilai Rapor
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            	
				                            	<input type="hidden" name="nipguru" value="<?php echo isset($c['nipguru']) ? $c['nipguru'] : $_POST['nipguru'] ;?>">
				                            	<input type="hidden" name="idpelajaran" value="<?php echo isset($c['idpelajaran']) ? $c['idpelajaran'] : $_POST['idpelajaran'] ;?>">
				                            	<input type="hidden" name="dasarpenilaian" value="<?php echo isset($c['dasarpenilaian']) ? $c['dasarpenilaian'] : $_POST['dasarpenilaian'] ;?>">

				                            	<?php
				                            	if (isset($c['nipguru']) AND isset($c['idpelajaran']) AND isset($c['dasarpenilaian'])) {
				                            		$nipguru = $c['nipguru'];
				                            		$idpelajaran = $c['idpelajaran'];
				                            		$dasarpenilaian = $c['dasarpenilaian'];
				                            	}else{
				                            		$nipguru = $_POST['nipguru'];
				                            		$idpelajaran = $_POST['idpelajaran'];
				                            		$dasarpenilaian = $_POST['dasarpenilaian'];
				                            	}
				                            	$query1 = "SELECT  j.nama as pelajaran, p.nip, p.nama,j.kode
														  FROM guru g, pegawai p, pelajaran j
														 WHERE g.nip=p.nip AND g.idpelajaran = j.id
														    AND j.id = '$idpelajaran' AND g.id = '$nipguru'";
												$sql1 = mysqli_query($conn,$query1);
												$d = mysqli_fetch_assoc($sql1);	
												$query11 = "SELECT *FROM dasarpenilaian WHERE id = '$dasarpenilaian'";
												$sql11 = mysqli_query($conn,$query11);
												$s = mysqli_fetch_assoc($sql11);	
				                            	?>
				                            <div class="col-md-12">
							                <section class="panel">
							                    <div class="panel-body">						                       
							                       <div class="col-md-12 table-responsive">
							                           <div class="profile-desk">
							                               <h1>Aturan Perhitungan Nilai Rapor</h1>
							                               <br>
							                               	<table class="table table-striped">                               		
								                               	<tr>
								                                    <td>Pelajaran</td>
								                                    <td>:</td>
								                                    <td><?php echo $d['kode'] ?> <?php echo $d['pelajaran'] ?></td>
								                                </tr>
								                                <tr>
								                                    <td>Guru</td>
								                                    <td>:</td>
								                                    <td><?php echo $d['nip'] ?> - <?php echo $d['nama'] ?></td>
								                                </tr>
								                                <tr>
								                                    <td>Dasar Penilaian</td>
								                                    <td>:</td>
								                                    <td><?php echo $s['dasarpenilaian'] ?> - <?php echo $s['keterangan'] ?></td>
								                                </tr>
							                               	</table>
							                           </div>
							                       </div>
							                    </div>
							                </section>
							            </div>
				                        <div class="panel-body">
							
					                        <div class="row table-responsive">
					                            <?php
					                            $query = "SELECT *FROM jenisujian WHERE idpelajaran = '$idpelajaran'";
												$sql_kul = mysqli_query($conn,$query);	
												$num = $sql_kul->num_rows;
												
												?>
												<table class="table table-striped table-hover table-bordered">
					                                <thead>
					                                <tr>
														<th class="text-center">No</th>
														<th class="text-center">Pengujian</th>
														<th class="text-center">Bobot</th>
													</tr>
					                                </thead>
					                                <tbody>
					                                <?php
					                                	$i=1;
														while ($m = mysqli_fetch_assoc($sql_kul)) {
														$query1 = "SELECT a.bobot, j.jenisujian, a.id 
																  FROM aturannhb a, jenisujian j 
																 WHERE a.idpelajaran = '$idpelajaran' AND a.nipguru = '$nipguru' 
																   AND a.dasarpenilaian = '$dasarpenilaian' AND a.idjenisujian = '$m[id]' AND a.idjenisujian = j.id";
														$sql1 = mysqli_query($conn,$query1);
														$d = mysqli_fetch_assoc($sql1);	
													?>
					                                <tr class="">
					                                    <td align="center"><?php echo $i ?></td>
					                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
					                                    <td><?php echo $m['kode']?> - <?php echo $m['jenisujian']?></td>
					                                    <td align="center"><input type="text" name="bobot[]" class="form-control round-input" value="<?php echo isset($d['bobot']) ? $d['bobot'] : '' ;?>" required></td>
					                                    <input type="hidden" name="idb[]" value="<?php echo isset($d['id']) ? $d['id'] : '' ;?>">
					                                    <input type="hidden" name="idjenisujian[]" value="<?php echo isset($m['id']) ? $m['id'] : '' ;?>">
														 
					                                </tr>
													
					                                <?php
					 									 $i++;
					 								 }
					 								?>
					                                </tbody>
					                            </table>
												
					                            
					                        </div>
					                        <div class="form-group">
				                                <div class="col-lg-offset-2 col-lg-10">
									                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
									                <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
				                                </div>
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
		                        	<a href="med.php?mod=perhitungan_nilai&act=add">
									<button class="btn btn-primary">
										Tambah <i class="fa fa-plus"></i>
									</button>
									</a>
								<?php }?>
		                        <span class="tools pull-right">
		                            <a href="javascript:;" class="fa fa-chevron-down"></a>
		                            <a href="javascript:;" class="fa fa-cog"></a>
		                            <a href="javascript:;" class="fa fa-times"></a>
		                         </span>
		                    </header>
							
							
		                    <div class="panel-body table-responsive">
							
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
											<th class="text-center">Guru</th>
											<th class="text-center">Pelajaran</th>
											<?php if($_SESSION['level']=='admin' ){?>
											<th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT DISTINCT b.`id` as nipguru,b.`nip`, c.`nama` as guru, d.`id` as idpelajaran, d.`kode`, d.`nama` as pelajaran 
														FROM `aturannhb` as a
														LEFT JOIN `guru` as b on a.`nipguru` = b.`id`
														LEFT JOIN `pelajaran` as d on d.`id`= a.`idpelajaran`
														JOIN `pegawai` as c on b.`nip` = c.`nip`
";
											$sql_kul = mysqli_query($conn,$query);	

											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <td align="center"><?php echo $m['nip']?> - <?php echo $m['guru']?></td>
		                                    <td align="center"><?php echo $m['kode']?> - <?php echo $m['pelajaran']?></td>
		                                   
		                                    <?php if($_SESSION['level']=='admin' ){?>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> 
		                                   		<a href="med.php?mod=perhitungan_nilai&act=detail&nipguru=<?php echo $m['nipguru']?>&idpelajaran=<?php echo $m['idpelajaran']?>"><button class="btn btn-primary btn-sm"> <i class="fa fa-search"></i></button></a>
		                                        

												
											</td>
											 <?php }?>
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
			if(isset($_GET['nipguru']) AND isset($_GET['idpelajaran']))
			{
				$sqltrans = mysqli_query($conn,"SELECT  j.nama as pelajaran, p.nip, p.nama,j.kode, g.id as nipguru,j.id as idpelajaran
														  FROM guru g, pegawai p, pelajaran j
														 WHERE g.nip=p.nip AND g.idpelajaran = j.id
														    AND j.id = '$_GET[idpelajaran]' AND g.id = '$_GET[nipguru]'") or die(mysqli_error());
				$tra = mysqli_fetch_assoc($sqltrans);
		flash('example_message');
		?>
		<div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body">	
                    <div class="position-center">					                       
                       <div class="col-md-12 table-responsive">
                           <div class="profile-desk">
                               <h1>Aturan Perhitungan Nilai Rapor</h1>
                               <br>
                               	<table class="table table-striped">                               		
	                               	<tr>
	                                    <td>Pelajaran</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['kode'] ?> <?php echo $tra['pelajaran'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Guru</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['nip'] ?> - <?php echo $tra['nama'] ?></td>
	                                </tr>
	                                
                               	</table>
                           </div>
                       </div>
                    </div>
                    </div>
                </section>
            </div>
            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading tab-bg-dark-navy-blue">
                        <ul class="nav nav-tabs nav-justified ">
                            <li class="active">
                                <a data-toggle="tab" href="#datasiswa">
                                    Bobot Penilaian
                                </a>
                            </li>
                        </ul>
                    </header>
                    <div class="panel-body">
                        <div class="tab-content tasi-tab">
                            <div id="datasiswa" class="tab-pane active">
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <?php
					                            $query = "SELECT a.`nipguru`,b.`dasarpenilaian`, b.`keterangan`, b.id 
															FROM `aturannhb` as a 
															LEFT JOIN `dasarpenilaian` as b ON a.`dasarpenilaian` = b.`id`
															WHERE a.`idpelajaran` = '$tra[idpelajaran]' AND a.`nipguru` = '$tra[nipguru]'";
												$sql_kul = mysqli_query($conn,$query);	
												$num = $sql_kul->num_rows;
												$querym = "SELECT distinct a.`nipguru`,b.`dasarpenilaian`, b.`keterangan`, b.id 
															FROM `aturannhb` as a 
															LEFT JOIN `dasarpenilaian` as b ON a.`dasarpenilaian` = b.`id`
															WHERE a.`idpelajaran` = '$tra[idpelajaran]' AND a.`nipguru` = '$tra[nipguru]'";
												$sql_kulm = mysqli_query($conn,$querym);	
												?>
												<table class="table table-striped " id="example">
					                                <thead>
					                                <tr>
														<th class="text-center">No</th>
														<th class="text-center">Aspek Penilaian</th>
														<th class="text-center">Bobot Penilaian</th>
														<?php if($_SESSION['level']=='admin' ){?>
														<th class="text-center">Aksi</th>
														<?php }?>
													</tr>
					                                </thead>
					                                <tbody>
					                                <?php
					                                	$i=1;
														while ($m = mysqli_fetch_assoc($sql_kulm)) {														
													?>
					                                <tr class="">
					                                    <td align="center"><?php echo $i ?></td>
					                                    <td align="center" ><?php echo $m['dasarpenilaian'] ?> - <?php echo $m['keterangan'] ?></td>
					                                    <td>
					                                    	<?php
					                                    	$queryb = "SELECT DISTINCT a.`bobot`, b.`kode`, b.`jenisujian` 
																		FROM `aturannhb` as a
																		JOIN `jenisujian` as b
																		WHERE a.`idpelajaran` = '$tra[idpelajaran]' AND a.`nipguru` = '$tra[nipguru]' AND a.`dasarpenilaian` = '$m[id]' AND b.id = a.idjenisujian ORDER BY b.jenisujian";
															$sqlb = mysqli_query($conn,$queryb);
															while ($x = mysqli_fetch_assoc($sqlb)) {
															?>

															<?php
															echo $x['jenisujian']." = ".$x['bobot']."<br>";
															}	
					                                    	?>

					                                    </td>
					                                   	<td>
					                                   		<?php
					                                   			if ($_SESSION['level']=="admin") {
					                                   			?>
						                                   		<a href="med.php?mod=perhitungan_nilai&act=form&nipguru=<?php echo $tra['nipguru']?>&idpelajaran=<?php echo $tra['idpelajaran']?>&dasarpenilaian=<?php echo $m['id']?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
																<a href="<?php echo $aksi ?>?mod=perhitungan_nilai&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>
					                                   			<?php	
					                                   			}elseif ($_SESSION['level']=="guru") {
					                                   			?>
					                                   			<a href="med2.php?mod=perhitungan_nilai&act=form&nipguru=<?php echo $tra['nipguru']?>&idpelajaran=<?php echo $tra['idpelajaran']?>&dasarpenilaian=<?php echo $m['id']?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
																<a href="<?php echo $aksi ?>?mod=perhitungan_nilai&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>
					                                   			<?php
					                                   			}
					                                   		?>
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
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
		<?php
			}
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

