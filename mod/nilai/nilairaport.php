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
	if ($_SESSION['level']=="admin") {
		$linkaksi = 'med.php?mod=nilairaport';
	}else{		
		$linkaksi = 'med2.php?mod=nilairaport';
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

	$aksi = 'mod/nilai/act_nilairaport.php';

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
				                                  	<div class="col-lg-6">
				                                      	<select  name="idkelas" class="form-control round-input" >
				                                          <?php
				                                                    $sql_guru = mysqli_query($conn,"SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
																		FROM `kelas` as a
																		JOIN `pegawai` as b on a.nipwali = b.nip
																		JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
																		WHERE c.aktif = 'Aktif'");
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
					                        	$queryb = "SELECT * FROM `siswa` WHERE `idkelas` = '$idkelas'";
												$sqlb = mysqli_query($conn,$queryb);
												while ($x = mysqli_fetch_assoc($sqlb)) {
												?>											

					                            <li><a style="cursor:pointer" href="<?php echo $linkaksi ?>&idkelas=<?php echo $idkelas ?>&idtahunajaran=<?php echo $idtahunajaran ?>&idsemester=<?php echo $idsemester ?>&nis=<?php echo $x['nis'] ?>"><?php echo $x['nama'] ?> - <?php echo $x['nis'] ?></a></li>
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
									
								}
							 
								 ?>

					    		<input type="hidden" name="idsemester" class="form-control " value="<?php echo $idsemester ?>" >
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
			                                  	<div class="col-lg-6">
			                                      	<select  name="idkelas" class="form-control round-input" >
			                                          <?php
			                                                    $sql_guru = mysqli_query($conn,"SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
																		FROM `kelas` as a
																		JOIN `pegawai` as b on a.nipwali = b.nip
																		JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
																		WHERE c.aktif = 'Aktif'");
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