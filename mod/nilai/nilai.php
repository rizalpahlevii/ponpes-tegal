<?php
	
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['nilai']) AND $_SESSION['nilai'] <> 'TRUE')
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
		$linkaksi = 'med.php?mod=nilai';
	}else{		
		$linkaksi = 'med2.php?mod=nilai';
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
				                        Penilaian Pelajaran
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
				                        Penilaian Pelajaran
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
			if(!empty($_GET['idkelas']) or !empty($_POST['idkelas']))
			{
				if(!empty($_GET['idkelas'])){
					$nipguru=$_GET['nipguru'];
					$idsemester = $_GET['idsemester'];
					$idkelas = $_GET['idkelas'];
				}else{
					$nipguru=$_POST['nipguru'];					
					$idsemester = $_POST['idsemester'];
					$idkelas = $_POST['idkelas'];
				}
				$act = "$aksi?mod=act_nilai&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM ujian WHERE `idkelas` = '$idkelas' AND `idsemester` = '$idsemester' ");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				#else
				#{
				#	header("location:med.php?mod=nilai");
				#}

			}
			else
			{
				$act = "$aksi?mod=nilai&act=simpan";
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
					                    		$sqlguru = "SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
												FROM `guru` as a
												JOIN `pegawai` as b on a.nip = b.nip
												JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
												JOIN `statusguru` as d on d.`id` = a.`statusguru` WHERE a.`id` = '$nipguru'";
												$kguru = mysqli_query($conn, $sqlguru);
												$guru = mysqli_fetch_assoc($kguru);
												echo $guru['pelajaran'];
					                    		?>
					                    		
					                    	</label>					                       
					                       		
					                        
					                        <ul class="nav nav-pills nav-stacked mail-nav">
					                        	<?php
					                        	$query = "SELECT DISTINCT a.`nipguru`,b.`dasarpenilaian`, b.`keterangan`, b.id 
															FROM `aturannhb` as a 
															LEFT JOIN `dasarpenilaian` as b ON a.`dasarpenilaian` = b.`id`
															WHERE a.`idpelajaran` = '$guru[idpelajaran]' AND a.`nipguru` = '$guru[id]'";
												$sql_kul = mysqli_query($conn,$query);	
												
												while ($m = mysqli_fetch_assoc($sql_kul)) {
													
												?>

												<div align="center" class="tab-pane ">                
									                <div class="prf-contacts sttng">
									                    <u><h2><?php echo $m['keterangan'] ?></h2></u>
									                </div>      
									            </div>
					                        	<?php
					                        	$queryb = "SELECT DISTINCT a.`bobot`, b.`kode`, b.`jenisujian`, a.id 
															FROM `aturannhb` as a
															JOIN `jenisujian` as b
															WHERE a.`idpelajaran` = '$guru[idpelajaran]' AND a.`nipguru` = '$nipguru' AND a.`dasarpenilaian` = '$m[id]' AND b.id = a.idjenisujian ORDER BY b.jenisujian";
												$sqlb = mysqli_query($conn,$queryb);
												while ($x = mysqli_fetch_assoc($sqlb)) {
												?>											

					                            <li><a style="cursor:pointer" href="<?php echo $linkaksi ?>&aks=nilai&act=add&act=form&idkelas=<?php echo $idkelas ?>&idsemester=<?php echo $idsemester ?>&nipguru=<?php echo $nipguru ?>&idaturan=<?php echo $x['id'] ?>"> <i class="fa fa-caret-square-o-right"></i> <?php echo $x['jenisujian'] ?></a></li>
												<?php
												}}
					                        	?>
					                        </ul>
					                    	
					                    </div>
					                </section>
					                
					            </div>
					            <?php 
								if(isset($_GET['idaturan'])){						 							
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
		                        	<a href="med.php?mod=nilai&act=add">
									<button class="btn btn-primary">
										Tambah Nilai<i class="fa fa-plus"></i>
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
											<th class="text-center">Guru</th>
											<th class="text-center">Pelajaran</th>
											<th class="text-center">Semester</th>
											<th class="text-center">Aksi</th>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
		                                	if($_SESSION['level']=='admin' ){
											$query = "SELECT DISTINCT a.`idpelajaran`, b.`kode`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`,h.`nip`, i.`nama` as guru 
												FROM `ujian` as a
												JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
												JOIN `kelas` as c ON a.`idkelas` = c.`id`
												JOIN `semester` as d ON a.`idsemester` = d.`id`
												JOIN `jenisujian` as e ON a.`idjenis` = e.`id`
												JOIN `aturannhb` as f ON a.`idaturan` = f.`id`
												JOIN `rpp` as g ON a.`idrpp` = g.`id`
					                            JOIN `guru` as h on f.`nipguru` = h.`id`
					                            JOIN `pegawai` as i on h.`nip` = i.`nip`";
												$sql_kul = mysqli_query($conn,$query);	
											}else {
												$query2 = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$_SESSION[id_user]'");
                            					$a2 = mysqli_fetch_assoc($query2);
												$query = "SELECT DISTINCT a.`idpelajaran`, b.`kode`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`,h.`nip`, i.`nama` as guru 
												FROM `ujian` as a
												JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
												JOIN `kelas` as c ON a.`idkelas` = c.`id`
												JOIN `semester` as d ON a.`idsemester` = d.`id`
												JOIN `jenisujian` as e ON a.`idjenis` = e.`id`
												JOIN `aturannhb` as f ON a.`idaturan` = f.`id`
												JOIN `rpp` as g ON a.`idrpp` = g.`id`
					                            JOIN `guru` as h on f.`nipguru` = h.`id`
					                            JOIN `pegawai` as i on h.`nip` = i.`nip`
					                            where a.`idkelas` = '$a2[idkelas]' AND  a.`idsemester`= '$_GET[id]'";
												$sql_kul = mysqli_query($conn,$query);	
											}
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <td align="center"><?php echo $m['nip']?> - <?php echo $m['guru']?></td>
		                                    <td align="center"><?php echo $m['kode']?> - <?php echo $m['pelajaran']?></td>
		                                    <td align="center"><?php echo $m['semester']?></td>
		                                   
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> 
		                                   		<a href="<?php echo $linkaksi ?>&act=detail&nipguru=<?php echo $m['nip']?>&idkelas=<?php echo $m['idkelas']?>&idsemester=<?php echo $m['idsemester']?>"><button class="btn btn-primary btn-sm"> <i class="fa fa-search"></i></button></a>
		                                        

												
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
				include "isinilai.php";									
					
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