<?php
	
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['nilaib']) AND $_SESSION['nilaib'] <> 'TRUE')
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
		$linkaksi = 'med.php?mod=nilaib';
	}else{		
		$linkaksi = 'med2.php?mod=nilaib';
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

	$aksi = 'mod/nilai/act_nilaib.php';

	?>
	<?php
	switch ($act) {
		case 'edit':
			$js = $_GET['idsemester'];
			$q = $_GET['idkelas'];
			$queryx = "SELECT a.*, c.`kelas`, d.`semester`, c.`tingkat`
			            FROM `data_ujian` as a
			            JOIN `kelas` as c ON a.`idkelas` = c.`id`
			            JOIN `semester` as d ON a.`idsemester` = d.`id`
			            WHERE a.`idsemester`='$js' AND a.`idkelas` = '$q'
			            GROUP BY a.`idkelas`";
			$sqlx = mysqli_query($conn,$queryx);	
			$qkls = mysqli_fetch_assoc($sqlx);

			?>

		        <!-- page start-->

		        <div class="row">

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">		                        
        						Data Nilai Kelas <?php echo $qkls['kelas'] ?> <b><?php echo $qkls['semester'] ?></b>
		                        <span class="tools pull-right">
		                            <a href="javascript:;" class="fa fa-chevron-down"></a>
		                            <a href="javascript:;" class="fa fa-cog"></a>
		                            <a href="javascript:;" class="fa fa-times"></a>
		                         </span>
		                    </header>
							
							
				            <form class="form-horizontal" role="form" method='POST' action='<?php echo $aksi ?>?mod=nilai&act=edit'>

		                           <input type="hidden" name="idkelas" value="<?php echo $q ?>">
		                           <input type="hidden" name="id_semester" value="<?php echo $js ?>">
		                    <div class="panel-body">
							
		                        <div class="adv-table editable-table table-responsive">
		                            <div class="clearfix">
		                                <div class="btn-group">
		                                </div>
		                                <div class="btn-group pull-right">
		                                   
		                                </div>
		                            </div>
		                            <div class="space12"></div>
		                            <table class="table table-striped table-hover table-bordered">
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>
						                    <th class="text-center">NIS</th>
											<th class="text-center">Nama Santri</th>
						                    <?php
						                    $qk = "SELECT * FROM pelajaran WHERE tingkat = '$qkls[tingkat]' order by id asc";
						                    $sqlk = mysqli_query($conn,$qk);
						                    while ($kh = mysqli_fetch_assoc($sqlk)) {
						                    ?>
						                    <th class="text-center"><?php echo $kh['nama']?></th>
						                    <?php
						                    }
						                    ?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT * 
														FROM `siswa` as a
														JOIN `kelas` as b ON a.`idkelas` = b.`id` 
														WHERE `idkelas` = '$q'";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											$x=0;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id[]" value="<?php echo $m['id'] ?>">
                    						<input type="hidden" name="nis[]" value="<?php echo $m['nis'] ?>">
		                                    <td align="center"><?php echo $m['nis']?></td>
		                                    <td><?php echo $m['nama']?></td>
											<?php
						                    $qk = "SELECT * FROM pelajaran WHERE tingkat = '$qkls[tingkat]' order by id asc";
						                    $sqlk = mysqli_query($conn,$qk);
						                    while ($kh = mysqli_fetch_assoc($sqlk)) {
						                    	$querys = mysqli_query($conn,"SELECT * FROM `data_ujian` WHERE `nis`='$m[nis]' AND `idpelajaran`='$kh[id]' AND `idkelas` = '$q' AND `idsemester` = '$js' ");
										      	$is=1;
										      	$k = mysqli_fetch_assoc($querys);
						                    ?>
						                    <td align="center">
						                        <input type="hidden" name="pel<?php echo $x ?>[]" value="<?php echo $kh['id'] ?>">
						                        <input type="hidden" name="idn<?php echo $x ?>[]" value="<?php echo $k['id'] ?>">
						                        <input type="text" name="nilai<?php echo $x ?>[]" value="<?php echo $k['nilai'] ?>" class="form-control">
						                    </td>
						                    <?php
						                    }
						                    ?>
		                                </tr>
										
		                                <?php
		 									 $x++;
		 									 $i++;
		 								 }
		 								?>
		                                </tbody>
		                            </table>
		                        </div>


						        <div class="form-group">
						            <div align="center" class="col-lg-12">
						                <button type="submit" name="submit" value="simpan" class="btn btn-warning"><i class='fa fa-save'></i> Simpan</button>
						            </div>
						        </div>
		                    </div>
		                	</form>
		                </section>
		            </div>
		        </div>

		            <!-- page end-->
		<?php
		break;
		case 'add':
			$act = "$aksi?mod=nilai&act=simpan";

			?>
			        <!-- page start-->
				        <div class="row">
				            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
					            <div class="col-lg-12">
					                <section class="panel">
					                    <header class="panel-heading">
					                        Input Nilai
					                    </header>
					                    <div class="panel-body">
					                        <div class="position-center">
					                            <input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
					                            <div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Semester</label>
			                                      <div class="col-lg-10">
			                                          <select name="id_semester" class="form-control" id="js">
			                                          		<option value="">Pilih Semester</option>
			                                              <?php
			                                                        $sql_kelas = mysqli_query($conn,"SELECT * FROM `semester` where aktif = 'Aktif'");
			                                                while($k = mysqli_fetch_assoc($sql_kelas))
			                                                {
			                                                 
			                                                    echo"<option value='$k[id]'>$k[semester]</option>";  
			                                                  
			                                                }
			                                                        ?>
			                                          </select>
			                                      	</div>
			                                  	</div>
					                            
					                            <div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
			                                      <div class="col-lg-10">
			                                          <select name="idkelas" class="select2" onchange="showUser(this.value)" style="width: 100%">
			                                          		<option>Kelas</option>
			                                              <?php
			                                              	$sql_kelas = mysqli_query($conn,"SELECT a.* 
															FROM `kelas` as a 
															JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
															WHERE b.`aktif` = 'Aktif'");
			                                                        
			                                                while($k = mysqli_fetch_assoc($sql_kelas))
			                                                {
			                                                 
			                                                    echo"<option value='$k[id]'>$k[kelas]</option>";  
			                                                  
			                                                }
			                                                        ?>
			                                          </select>
			                                      	</div>
			                                  	</div>
			                                  	
					                        </div>
					                    </div>
					                </section>

                    				<div id="txtHint" align="center"><b>Info will be listed here...</b></div>

					                
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
				$act = "$aksi?mod=act_nilaib&act=edit";
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
				$act = "$aksi?mod=nilaib&act=simpan";
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
								include "isinilaib.php";									
									
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
		                        	<a href="med.php?mod=nilaib&act=add">
									<button class="btn btn-primary">
										Tambah Nilai <i class="fa fa-plus"></i>
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
											<th class="text-center">Semester</th>
											<th class="text-center">Aksi</th>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
		                                	if($_SESSION['level']=='admin' ){
											$query = "SELECT a.*, c.`kelas`, d.`semester`
												FROM `data_ujian` as a
												JOIN `kelas` as c ON a.`idkelas` = c.`id`
												JOIN `semester` as d ON a.`idsemester` = d.`id`
												GROUP BY a.`idkelas`";
												$sql_kul = mysqli_query($conn,$query);	
											}
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <td align="center"><?php echo $m['kelas']?></td>
		                                    <td align="center"><?php echo $m['semester']?></td>
		                                   
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> 
		                                   		<a href="<?php echo $linkaksi ?>&act=detail&idkelas=<?php echo $m['idkelas'] ?>&idsemester=<?php echo $m['idsemester']?>" ><button class="btn btn-info btn-sm"><i class="fa fa-search"></i></button> </a>
		                                        <a href="<?php echo $linkaksi ?>&act=edit&idkelas=<?php echo $m['idkelas'] ?>&idsemester=<?php echo $m['idsemester']?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>

												
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
			$q = $_GET['idkelas'];
			$js = $_GET['idsemester'];
			$queryx = "SELECT a.*, c.`kelas`, d.`semester`, c.`tingkat`
			            FROM `data_ujian` as a
			            JOIN `kelas` as c ON a.`idkelas` = c.`id`
			            JOIN `semester` as d ON a.`idsemester` = d.`id`
			            WHERE a.`idsemester`='$js' AND a.`idkelas` = '$q'
			            GROUP BY a.`idkelas`";
			$sqlx = mysqli_query($conn,$queryx);	
			$qkls = mysqli_fetch_assoc($sqlx);
			?>
		        <!-- page start-->

		        <div class="row">

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">
		                        Data Nilai Kelas <?php echo $qkls['kelas'] ?> <b><?php echo $qkls['semester'] ?></b>
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
						                    <th class="text-center">NIS</th>
											<th class="text-center">Nama Santri</th>
						                    <?php
						                    $qk = "SELECT * FROM pelajaran WHERE tingkat = '$qkls[tingkat]' order by id asc";
						                    $sqlk = mysqli_query($conn,$qk);
											$jmlp = mysqli_num_rows($sqlk);	
						                    while ($kh = mysqli_fetch_assoc($sqlk)) {
						                    ?>
						                    <th class="text-center"><?php echo $kh['nama']?></th>
						                    <?php
						                    }
						                    ?>
						                    <th class="text-center">Jumlah</th>
						                    <th class="text-center">Rata</th>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT * 
														FROM `siswa` as a
														JOIN `kelas` as b ON a.`idkelas` = b.`id` 
														WHERE `idkelas` = '$q'";
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
						                    $qk = "SELECT * FROM pelajaran WHERE tingkat = '$qkls[tingkat]' order by id asc";
						                    $sqlk = mysqli_query($conn,$qk);
						                    $jmlr = 0;
						                    while ($kh = mysqli_fetch_assoc($sqlk)) {
						                    	$querys = mysqli_query($conn,"SELECT * FROM `data_ujian` WHERE `nis`='$m[nis]' AND `idpelajaran`='$kh[id]' AND `idkelas` = '$q' AND `idsemester` = '$js' ");										      	
										      	$k = mysqli_fetch_assoc($querys);
										      	$jmlr = $jmlr + floatval($k['nilai']);
						                    ?>
						                    <td align="center">
						                        <?php echo $k['nilai']?>
						                    </td>
						                    <?php
						                    }
						                    $rt = $jmlr/$jmlp;
						                    $jrt = round($rt,1);
						                    ?>
						                    <td align="center"><?php echo $jmlr ?></td>
						                    <td align="center"><?php echo $jrt ?></td>
		                                </tr>
										
		                                <?php
		                                	$jmlx = $jmlx + floatval($jmlr);
		                                	$jmlrt = $jmlrt + floatval($jrt);
		 									 $x++;
		 									 $i++;
		 								 }
		 								?>
		                                </tbody>
		                                <tfoot>
		                                	<tr>
		                                		<th class="text-center" colspan="3">Jumlah</th>	
		                                		<?php
							                    $qk = "SELECT * FROM pelajaran WHERE tingkat = '$qkls[tingkat]' order by id asc";
							                    $sqlk = mysqli_query($conn,$qk);
							                    while ($kh = mysqli_fetch_assoc($sqlk)) {
							                    	$querys = mysqli_query($conn,"SELECT SUM(`nilai`) as Jumlah  FROM `data_ujian` WHERE `idpelajaran`='$kh[id]' AND `idkelas` = '$q' AND `idsemester` = '$js' ");										      	
										      		$k = mysqli_fetch_assoc($querys);
							                    ?>
							                    <th class="text-center"><?php echo $k['Jumlah']?></th>
							                    <?php
							                    }
							                    ?>      
							                    <th class="text-center"><?php echo $jmlx  ?></th>                         		
							                    <th class="text-center"><?php echo $jmlrt  ?></th>                         		
		                                	</tr>		                                	
		                                	<tr>

		                                		<th class="text-center" colspan="3">Rata -Rata</th>	
		                                		<?php
							                    $qk = "SELECT * FROM pelajaran WHERE tingkat = '$qkls[tingkat]' order by id asc";
							                    $sqlk = mysqli_query($conn,$qk);
							                    while ($kh = mysqli_fetch_assoc($sqlk)) {
							                    	$querys = mysqli_query($conn,"SELECT SUM(`nilai`) as Jumlah  FROM `data_ujian` WHERE `idpelajaran`='$kh[id]' AND `idkelas` = '$q' AND `idsemester` = '$js' ");										      	
										      		$k = mysqli_fetch_assoc($querys);
										      		$rt2 = $k['Jumlah']/$jmls;
							                    ?>
							                    <th class="text-center"><?php echo round($rt2,1)?></th>
							                    <?php
							                    }
							                    ?>   
							                    <th class="text-center"><?php echo round(($jmlx/$jmls),1)  ?></th>            	                                		
							                    <th class="text-center"><?php echo round(($jmlrt/$jmls),1)   ?></th>            	                                		
		                                	</tr>
		                                </tfoot>
		                            </table>
		                        </div>
		                    </div>
		                </section>
		            </div>
		        </div>

				       
		<?php
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
function showUser(str) {
  var xhttp;    
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("txtHint").innerHTML = this.responseText;
    }
  };
  var district = document.getElementById('js');
    var js = district.value;
  xhttp.open("GET", "mod/nilai/getnilai.php?q="+str+"&js="+js, true);
  xhttp.send();
}
</script>
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