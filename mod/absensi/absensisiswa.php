<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['absensisiswa']) AND $_SESSION['absensisiswa'] <> 'TRUE')
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
	$linkaksi = 'med.php?mod=absensisiswa';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/absensi/act_absensisiswa.php';

	?>
	<?php
	switch ($act) {
		case 'form':
				$act = "$aksi?mod=absensi&act=simpan";

			?>
			        <!-- page start-->
				        <div class="row">
				            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
					            <div class="col-lg-12">
					                <section class="panel">
					                    <header class="panel-heading">
					                        Data Absensi
					                    </header>
					                    <div class="panel-body">
					                        <div class="position-center">
					                            <input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
					                            <div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Jenis Absensi</label>
			                                      <div class="col-lg-10">
			                                          <select name="id_jenisabsensi" class="form-control" id="js">
			                                          		<option value="">Absensi</option>
			                                              <?php
			                                                        $sql_kelas = mysqli_query($conn,"SELECT * FROM jenisabsensi ORDER BY urutan ASC");
			                                                while($k = mysqli_fetch_assoc($sql_kelas))
			                                                {
			                                                 
			                                                    echo"<option value='$k[id]'>$k[nama]</option>";  
			                                                  
			                                                }
			                                                        ?>
			                                          </select>
			                                      	</div>
			                                  	</div>
					                            
					                            <div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
			                                      <div class="col-lg-10">
			                                          <select name="idkelas" class="form-control" onchange="showUser(this.value)">
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

		default :
		flash('example_message');
			?>
		        <!-- page start-->

		        <div class="row">

		            <div class="clearfix">
					
					<div class="col-sm-12">
			            <!--tab nav start-->

                        <?php if($_SESSION['level']=='admin'){?>
                        	<a href="med.php?mod=absensisiswa&act=form">
							<button class="btn btn-primary">
								Tambah <i class="fa fa-plus"></i>
							</button>
							</a>
							<a href="med.php?mod=absensisiswa&act=laporan">
							<button class="btn btn-warning">
								Rekap Absensi <i class="fa fa-calendar"></i>
							</button>
							</a>
						<?php }?>
						<a><span class="badge label-primary pull-right r-activity" id="dates"><i class="fa fa-calendar fa-lg"></i> <marquee width="170px" scrollamount="3"><span id="the-day">Hari, 00 Bulan 0000</span></marquee> | <span style="font-weight: bold;" id="the-time">00:00:00</span></a>
						<br>
						<br>
			            <section class="panel">
			                <header class="panel-heading tab-bg-dark-navy-blue ">
			                    <ul class="nav nav-tabs nav-justified">
			                    	<?php
				                        $sql_kelas = mysqli_query($conn,"SELECT * FROM jenisabsensi ORDER BY urutan ASC");
	                                    while($k = mysqli_fetch_assoc($sql_kelas))
	                                    {
	                                     
	                                       ?>	                                       
					                        <li <?php if ($k['urutan']=='1'){ ?>
						                        class="active"
						                        <?php } ?> >
					                            <a data-toggle="tab" href="#<?php echo $k['nama'] ?>"><?php echo $k['nama'] ?></a>
					                        </li>
	                                       <?php
	                                      
	                                    }
                                    ?>
			                    </ul>
			                </header>
			                <div class="panel-body">
			                    <div class="tab-content">
			                    	<?php
			                    		$a=1;
				                        $sql_kelas = mysqli_query($conn,"SELECT * FROM jenisabsensi ORDER BY urutan ASC");
	                                    while($k = mysqli_fetch_assoc($sql_kelas))
	                                    {
	                                     
	                                       ?>	
						                        <div id="<?php echo $k['nama'] ?>" class="tab-pane <?php if ($k['urutan']=='1'){ ?>
						                        active
						                        <?php } ?>" >											
															
								                    <div class="panel-body">
													
								                        <div class="adv-table editable-table table-responsive">
								                            <div class="clearfix">
								                                <div class="btn-group">
								                                </div>
								                                <div class="btn-group pull-right">
								                                   
								                                </div>
								                            </div>
								                            <div class="space12"></div>
								                            <table class="table table-striped table-hover table-bordered" id="example<?php echo $a?>">
								                                <thead>
								                                <tr>
																	<th class="text-center">No</th>
								                                    <th class="text-center">Kelas</th>
								                                    <?php
								                                    $qk = "SELECT * FROM kehadiran order by urutan asc";
																	$sqlk = mysqli_query($conn,$qk);
																	while ($kh = mysqli_fetch_assoc($sqlk)) {
																	?>
																	<th class="text-center"><?php echo $kh['kehadiran']?></th>
																	<?php
																	}
								                                    ?>
																	<?php if($_SESSION['level']=='admin' ){?>
								                                    <th class="text-center">Aksi</th>
																	<?php }?>
																</tr>
								                                </thead>
								                                <tbody>
								                                <?php
																	$query = "SELECT c.`id`, c.`kelas`, a.`id_jenisabsensi`, a.`date` 
																				FROM `absensi_siswa` as a
																				JOIN `siswa` as b ON a.`nis` = b.`nis`
																				JOIN `kelas` as c ON b.`idkelas` = c.`id`
																				WHERE a.`date`= CURDATE() AND a.`id_jenisabsensi`='$k[id]'
																				GROUP BY c.`id`";
																	$sql_kul = mysqli_query($conn,$query);	
																	$i=1;
																	while ($m = mysqli_fetch_assoc($sql_kul)) {
																?>
								                                <tr class="">
								                                    <td align="center"><?php echo $i ?></td>
								                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
								                                    <td align="center"><?php echo $m['kelas']?></td>
								                                     <?php
								                                     $x=1;
								                                    $qk = "SELECT * FROM kehadiran order by urutan asc";
																	$sqlk = mysqli_query($conn,$qk);
																	while ($kh = mysqli_fetch_assoc($sqlk)) {
																		$sql[$x] = "SELECT COUNT(a.`kehadiran`) as kehadiran
																				FROM `absensi_siswa` as a
																				JOIN `siswa` as b ON a.`nis` = b.`nis`
																				JOIN `kelas` as c ON b.`idkelas` = c.`id` 
																				WHERE `kehadiran` =  '$kh[id]' AND a.`date`= CURDATE() AND c.`id` = '$m[id]'";
																		$hasil[$x]= mysqli_query($conn,$sql[$x]);	
																		$absen[$x] = mysqli_fetch_assoc($hasil[$x]);
																	?>
																	<td align="center"><?php echo $absen[$x]['kehadiran']?></td>
																	<?php
																	$x++; }
								                                    ?>
																	<td align="center">
								                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>	
								                                       <a href="<?php echo $aksi ?>?mod=absensisiswa&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>						
								                                   --> <?php if($_SESSION['level']=='admin' ){?>
								                                   		<a href="med.php?mod=absensisiswa&act=detail&id=<?php echo $m['id'] ?>&tgl=<?php echo $m['date']?>&idjs=<?php echo $m['id_jenisabsensi'] ?>" ><button class="btn btn-info btn-sm"><i class="fa fa-search"></i></button> </a>
								                                        <a href="med.php?mod=absensisiswa&act=edit&id=<?php echo $m['id'] ?>&tgl=<?php echo $m['date']?>&idjs=<?php echo $m['id_jenisabsensi'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
																		

																		
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

						                        </div>
	                                       <?php
	                                     $a++; 
	                                    }
                                    ?>
			                    </div>
			                </div>
			            </section>
			            <!--tab nav start-->
			        </div>
		        </div>

		            <!-- page end-->
			<?php
		break;
		case 'edit':
			$q = $_GET['id'];
			$js = $_GET['idjs'];
			$tgl = $_GET['tgl'];
			$queryx = "SELECT c.`id`, c.`kelas`, a.`id_jenisabsensi` , d.`nama` 
						FROM `absensi_siswa` as a
						JOIN `siswa` as b ON a.`nis` = b.`nis`
						JOIN `kelas` as c ON b.`idkelas` = c.`id`
						JOIN `jenisabsensi` as d ON a.`id_jenisabsensi` = d.`id`
						WHERE a.`date`= '$tgl' AND a.`id_jenisabsensi`='$js' AND b.`idkelas` = '$q'
						GROUP BY c.`id`";
			$sqlx = mysqli_query($conn,$queryx);	
			$qkls = mysqli_fetch_assoc($sqlx);

			?>

		        <!-- page start-->

		        <div class="row">

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">		                        
        						Data Absensi Santri <?php echo $qkls['nama'] ?> Kelas <?php echo $qkls['kelas'] ?> Tanggal <b><?php echo tglindo($tgl) ?></b>
		                        <span class="tools pull-right">
		                            <a href="javascript:;" class="fa fa-chevron-down"></a>
		                            <a href="javascript:;" class="fa fa-cog"></a>
		                            <a href="javascript:;" class="fa fa-times"></a>
		                         </span>
		                    </header>
							
							
				            <form class="form-horizontal" role="form" method='POST' action='<?php echo $aksi ?>?mod=absensi&act=edit'>
		                    <div class="panel-body">
							
		                        <div class="adv-table editable-table table-responsive">
		                            <div class="clearfix">
		                                <div class="btn-group">
		                                </div>
		                                <div class="btn-group pull-right">
		                                   
		                                </div>
		                            </div>
		                            <div class="space12"></div>
		                            <table class="table table-striped table-hover table-bordered" id="examplea">
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>
						                    <th class="text-center">NIS</th>
											<th class="text-center">Nama Santri</th>
											<th class="text-center">Absen</th>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT a.`id`, b.`nis`, b.`nama`, a.`id_jenisabsensi`, a.`kehadiran`
													FROM `absensi_siswa` as a
													JOIN `siswa` as b ON a.`nis` = b.`nis`
													JOIN `kelas` as c ON b.`idkelas` = c.`id` 
                                                    WHERE a.`date`='$tgl' AND a.`id_jenisabsensi` = '$js' AND c.`id` = '$q'";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id[]" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['nis']?></td>
		                                    <td><?php echo $m['nama']?></td>
											<td align="center">
												<select name="kehadiran[]" class="form-control">
		                                              <?php
		                                                        $sql_kelas = mysqli_query($conn,"SELECT * FROM kehadiran ORDER BY urutan ASC");
		                                                while($k = mysqli_fetch_assoc($sql_kelas))
		                                                {
		                                                  if(isset($m['kehadiran']) && $k['id'] == $m['kehadiran'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[kehadiran]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[kehadiran]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          </select>
											</td>
		                                </tr>
										
		                                <?php
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
		case 'detail':
			$q = $_GET['id'];
			$js = $_GET['idjs'];
			$tgl = $_GET['tgl'];
			$queryx = "SELECT c.`id`, c.`kelas`, a.`id_jenisabsensi` , d.`nama` 
						FROM `absensi_siswa` as a
						JOIN `siswa` as b ON a.`nis` = b.`nis`
						JOIN `kelas` as c ON b.`idkelas` = c.`id`
						JOIN `jenisabsensi` as d ON a.`id_jenisabsensi` = d.`id`
						WHERE a.`date`= '$tgl' AND a.`id_jenisabsensi`='$js' AND b.`idkelas` = '$q'
						GROUP BY c.`id`";
			$sqlx = mysqli_query($conn,$queryx);	
			$qkls = mysqli_fetch_assoc($sqlx);
			?>
		        <!-- page start-->

		        <div class="row">

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">
		                        Data Absensi Santri <?php echo $qkls['nama'] ?> Kelas <?php echo $qkls['kelas'] ?> Tanggal <b><?php echo tglindo($tgl) ?></b>
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
											<th class="text-center">Absen</th>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT a.`id`, b.`nis`, b.`nama`, a.`id_jenisabsensi`, d.`kehadiran`
													FROM `absensi_siswa` as a
													JOIN `siswa` as b ON a.`nis` = b.`nis`
													JOIN `kelas` as c ON b.`idkelas` = c.`id` 												
													JOIN `kehadiran` as d ON a.`kehadiran` = d.`id`
                                                    WHERE a.`date`='$tgl' AND a.`id_jenisabsensi` = '$js' AND c.`id` = '$q'";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['nis']?></td>
		                                    <td><?php echo $m['nama']?></td>
											<td align="center"><?php echo $m['kehadiran']?></td>
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
		case 'laporan':
		?>

				        <div class="row">
				            <form class="form-horizontal" role="form" method='POST' action='med.php?mod=absensisiswa&act=laporandetail'>
					            <div class="col-lg-12">
					                <section class="panel">
					                    <header class="panel-heading">
					                        Data Absensi
					                    </header>
					                    <div class="panel-body">
					                        <div class="position-center">
					                            <input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
					                            <div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Jenis Absensi</label>
			                                      <div class="col-lg-10">
			                                          <select name="idjs" class="form-control">
			                                          		<option value="">Absensi</option>
			                                              <?php
			                                                        $sql_kelas = mysqli_query($conn,"SELECT * FROM jenisabsensi ORDER BY urutan ASC");
			                                                while($k = mysqli_fetch_assoc($sql_kelas))
			                                                {
			                                                 
			                                                    echo"<option value='$k[id]'>$k[nama]</option>";  
			                                                  
			                                                }
			                                                        ?>
			                                          </select>
			                                      	</div>
			                                  	</div>
					                            
					                            <div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Dari Tanggal</label>
			                                      <div class="col-lg-10">
			                                          <input name="tgl1" class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" />
			                                      	</div>
			                                  	</div>
			                                  	<div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Sampai</label>
			                                      <div class="col-lg-10">
			                                          <input name="tgl2" class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" />
			                                      	</div>
			                                  	</div>
			                                  	<div class="form-group">
				                                <div class="col-lg-offset-2 col-lg-10">
									                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Submit</button>
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
		case 'laporandetail':

			$js = $_POST['idjs'];
			$tgl1 = $_POST['tgl1'];
			$tgl2 = $_POST['tgl2'];
			$queryx = "SELECT * FROM jenisabsensi WHERE `id`='$js'";
			$sqlx = mysqli_query($conn,$queryx);	
			$qkls = mysqli_fetch_assoc($sqlx);
			?>
		        <!-- page start-->

		        <div class="row">

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">
		                        Data Absensi Santri <?php echo $qkls['nama'] ?> Tanggal <?php echo tglindo($tgl1) ?> - <?php echo tglindo($tgl2) ?>
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
		                                    <th class="text-center">Tanggal</th>
		                                    <?php
		                                    $qk = "SELECT * FROM kehadiran order by urutan asc";
											$sqlk = mysqli_query($conn,$qk);
											while ($kh = mysqli_fetch_assoc($sqlk)) {
											?>
											<th class="text-center"><?php echo $kh['kehadiran']?></th>
											<?php
											}
		                                    ?>
											<?php if($_SESSION['level']=='admin' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT c.`id`, c.`kelas`, a.`id_jenisabsensi`, a.`date` 
														FROM `absensi_siswa` as a
														JOIN `siswa` as b ON a.`nis` = b.`nis`
														JOIN `kelas` as c ON b.`idkelas` = c.`id`
														WHERE a.`date` BETWEEN '$tgl1' AND '$tgl2' AND a.`id_jenisabsensi`='$js'
														GROUP BY c.`id`, a.`date`
														ORDER BY a.`date` ";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['kelas']?></td>
		                                    <td align="center"><?php echo tglindo($m['date'])?></td>
		                                     <?php
		                                     $x=1;
		                                    $qk = "SELECT * FROM kehadiran order by urutan asc";
											$sqlk = mysqli_query($conn,$qk);
											while ($kh = mysqli_fetch_assoc($sqlk)) {
												$sql[$x] = "SELECT COUNT(a.`kehadiran`) as kehadiran
														FROM `absensi_siswa` as a
														JOIN `siswa` as b ON a.`nis` = b.`nis`
														JOIN `kelas` as c ON b.`idkelas` = c.`id` 
														WHERE `kehadiran` =  '$kh[id]' AND a.`date`= '$m[date]' AND c.`id` = '$m[id]'";
												$hasil[$x]= mysqli_query($conn,$sql[$x]);	
												$absen[$x] = mysqli_fetch_assoc($hasil[$x]);
											?>
											<td align="center"><?php echo $absen[$x]['kehadiran']?></td>
											<?php
											$x++; }
		                                    ?>
		                                    <?php if($_SESSION['level']=='admin' ){?>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>	
		                                       <a href="<?php echo $aksi ?>?mod=absensisiswa&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>						
		                                   --> 
		                                   		<a href="med.php?mod=absensisiswa&act=detail&id=<?php echo $m['id'] ?>&tgl=<?php echo $m['date']?>&idjs=<?php echo $m['id_jenisabsensi'] ?>" ><button class="btn btn-info btn-sm"><i class="fa fa-search"></i></button> </a>
		                                        <a href="med.php?mod=absensisiswa&act=edit&id=<?php echo $m['id'] ?>&tgl=<?php echo $m['date']?>&idjs=<?php echo $m['id_jenisabsensi'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												

												
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
  xhttp.open("GET", "mod/absensi/getkelas.php?q="+str+"&js="+js, true);
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

