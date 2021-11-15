<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['absensiguru']) AND $_SESSION['absensiguru'] <> 'TRUE')
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
	if($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin'){
		$linkaksi = 'med.php?mod=absensiguru';
	}else {
		$linkaksi = 'med2.php?mod=absensiguru';
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

	$aksi = 'mod/absensi/act_absensiguru.php';

	?>
	<?php
	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=absensiguru&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM absensi_guru WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=absensiguru");
				}

			}
			else
			{
				$act = "$aksi?mod=absensiguru&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data Absensi Pengajar
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            	<div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
			                                      <div class="col-lg-10">
			                                          <select name="idkelas" id="idkelas" class="select2" style="width: 100%" onchange="pilih_kelas(this.value);">
			                                              <?php
			                                                        $sql_kelas = mysqli_query($conn,"SELECT a.* 
																	FROM `kelas` as a 
																	JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
																	WHERE b.`aktif` = 'Aktif'");
			                                                while($k = mysqli_fetch_assoc($sql_kelas))
			                                                {
			                                                  if(isset($c['idkelas']) && $k['id'] == $c['idkelas'])
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
			                                      	<label class="col-lg-2 col-sm-2 control-label">Pelajaran</label>
			                                      	<div class="col-lg-10">
			                                          	<select name="idpelajaran" id="pelajaran" class="select2" style="width: 100%" onchange="pilih_pelajaran(this.value);">

			                                              <option>Pilih Pelajaran</option>
			                                              
			                                          	</select>
			                                     	 </div>
			                                  	</div>
			                                  	<!--
			                                  	<div class="form-group">
			                                      	<label class="col-lg-2 col-sm-2 control-label">Materi</label>
			                                      	<div class="col-lg-10">
			                                          	<select name="idmateri" id="materi" class="form-control round-input">
			                                              <option>Pilih Materi</option>
			                                          	</select>
			                                     	 </div>
			                                  	</div>
			                                  	-->
			                                  	<div class="form-group">
			                                      	<label class="col-lg-2 col-sm-2 control-label">Guru</label>
			                                      	<div class="col-lg-10">
			                                          	<select name="idguru" id="guru" class="select2" style="width: 100%">
			                                              <option>Pilih Guru</option>
			                                          	</select>
			                                     	 </div>
			                                  	</div>
			                                  	<div class="form-group">
					                                <label class="col-sm-2 control-label">Mulai Pelajaran</label>
					                                <div class="col-sm-10">
					                                	<input type="text" name="mulai" class="form-control time" value="<?php echo isset($c['mulai']) ? $c['mulai'] : '' ;?>" required>
					                                </div>
					                            </div>
					                            <div class="form-group">
					                                <label class="col-sm-2 control-label">Selesai Pelajaran</label>
					                                <div class="col-sm-10">
					                                	<input type="text" name="selesai" class="form-control time1" value="<?php echo isset($c['selesai']) ? $c['selesai'] : '' ;?>" required>
					                                </div>
					                            </div>
					                            <div class="form-group">
			                                      	<label class="col-lg-2 col-sm-2 control-label">Kehadiran</label>
			                                      	<div class="col-lg-10">
			                                          	<select name="kehadiran" class="select2" style="width: 100%">

			                                              <option>Pilih Absensi</option>
			                                               <?php
		                                                        $sqlk = mysqli_query($conn,"SELECT * FROM kehadiran ORDER BY urutan ASC");
				                                                while($k = mysqli_fetch_assoc($sqlk))
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
			                                     	 </div>
			                                  	</div>
				                            <div class="form-group">
				                                <div class="col-lg-offset-2 col-lg-10">
									                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
									                <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
				                                </div>
				                            </div>
				                        </form>
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

		            <div class="clearfix">
			
		            <div class="col-sm-12">

                        <?php if($_SESSION['level']=='superadmin' OR $_SESSION['level']=='absensi pengajar'){?>
                        	<a href="<?php echo $linkaksi ?>&act=form">
							<button class="btn btn-primary">
								Tambah <i class="fa fa-plus"></i>
							</button>
							</a>

							<a href="<?php echo $linkaksi ?>&act=laporan">
							<button class="btn btn-warning">
								Rekap Absensi <i class="fa fa-calendar"></i>
							</button>
							</a>
						<?php }?>
		            	<a><span class="badge label-primary pull-right r-activity" id="dates"><i class="fa fa-calendar fa-lg"></i> <marquee width="170px" scrollamount="3"><span id="the-day">Hari, 00 Bulan 0000</span></marquee> | <span style="font-weight: bold;" id="the-time">00:00:00</span></a>
						<br>
						<br>
						
		            </div>
		            <?php
						$query = "SELECT DISTINCT a.`id`, a.`kelas`
									FROM `kelas` as a
									RIGHT JOIN `absensi_guru` as b ON a.`id` = b.`idkelas`
									WHERE b.`date` = CURDATE()";
						$sql_kul = mysqli_query($conn,$query);
						$sqlj = mysqli_num_rows($sql_kul);
						if ($sqlj=="0") {
						?>
							<div class="col-md-12">
								<div class="alert alert-danger">
					                <span class="alert-icon"><i class="fa fa-bell"></i></span>
					                <div class="notification-info">
					                    <ul class="clearfix notification-meta">
					                        <li class="pull-left notification-sender"><span>Hari ini belum ada data yang terabsen </li>
					                        <li class="pull-right notification-time">Absensi Pengajar</li>
					                    </ul>
					                    <p>
					                        Very cool photo jack
					                    </p>
					                </div>
					            </div>
							</div>
						<?php
						}else{
						while ($kls = mysqli_fetch_assoc($sql_kul)) {

					?>
		            <div class="col-lg-6">
				        <div class="row">
				            <div class="col-md-12">
				                <section class="panel panel-success">
				                    <header class="panel-heading">
				                    	Kelas <?php echo $kls['kelas'] ?>
				                        <span class="tools pull-right">
				                            <a href="javascript:;" class="fa fa-chevron-down"></a>
				                            <a href="javascript:;" class="fa fa-times"></a>
				                         </span>
				                    </header>
									
									
				                    <div class="panel-body">
										<div class="table-responsive">											
					                        <table class="table table-striped table-hover table-bordered table-condensed cf">
					                        	<thead>					                        		
						                        	<tr>
														<!--<th class="text-center">No</th>-->
					                                    <th class="text-center">Pelajaran</th>
														<th class="text-center">Pengajar</th>
														<th class="text-center">Jam Pelajaran</th>
														<th class="text-center">Kehadiran</th>
														<?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='absensi pengajar'){?>
					                                    <th class="text-center">Aksi</th>
														<?php }?>
													</tr>
					                        	</thead>
												<tbody>
													<?php
														$query = "SELECT a.`id`,b.`nama` as pelajaran, e.`nama` as guru, a.`mulai`, a.`selesai`, a.`date`, f.`kehadiran`
															FROM `absensi_guru` as a
															JOIN `pelajaran` as b ON a.`idpelajaran` = b.`id`
															JOIN `guru` as d ON a.`idguru` = d.`id`
															JOIN `pegawai` as e ON e.`nip` = d.`nip`
															JOIN `kehadiran` as f ON a.`kehadiran` = f.`id`
															WHERE `idkelas` = '$kls[id]' AND a.`date` = CURDATE() 
															ORDER BY a.`mulai`";
														$sql1 = mysqli_query($conn,$query);	
														$i=1;
														while ($m = mysqli_fetch_assoc($sql1)) {
													?>
					                                <tr class="">
					                                    <!--<td align="center"><?php echo $i ?></td>-->
					                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
					                                    <td align="center"><?php echo $m['pelajaran']?></td>
					                                    <td align="center"><?php echo $m['guru']?></td>
					                                    <td align="center"><?php echo date('H:i',strtotime($m['mulai'])) ?> - <?php echo date('H:i',strtotime($m['selesai'])) ?></td>
					                                    <td align="center"><?php echo $m['kehadiran']?></td>
					                                    <?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='absensi pengajar'){?>
														<td align="center">
					                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
					                                        <a href="med.php?mod=absensiguru&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
					                                   --> 
															<a href="<?php echo $aksi ?>?mod=absensiguru&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

															
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
				    </div>

	                <?php
					 }
					}
					?>
		        </div>

		            <!-- page end-->
			<?php
		break;
		case 'laporan':
		?>
		<div class="row">

			<div class="col-lg-12">
            <!--tab nav start-->
	            <section class="panel">
	                <header class="panel-heading tab-bg-dark-navy-blue ">
	                    <ul class="nav nav-tabs nav-justified">
	                        <li class="active">
	                            <a data-toggle="tab" href="#home">Rekap Per-kelas</a>
	                        </li>
	                        <li class="">
	                            <a data-toggle="tab" href="#about">Rekap Per-pengajar</a>
	                        </li>
	                    </ul>
	                </header>
	                <div class="panel-body">
	                    <div class="tab-content">
	                        <div id="home" class="tab-pane active">                            

					            <form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=laporandetail'>
						            <div class="col-lg-12">
					                    <div class="panel-body">
					                        <div class="position-center">
					                            <input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
					                            <div class="form-group">
				                                  <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
				                                  <div class="col-lg-10">
				                                      <select name="idkls" class="select2"  style="width: 100%">
				                                      		<option value="">Kelas</option>
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
						            </div>				            
					            </form>
	                        </div>
	                        <div id="about" class="tab-pane">
		                        <form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=laporandetailguru'>
						            <div class="col-lg-12">
					                    <div class="panel-body">
					                        <div class="position-center">
					                            <input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
					                            <div class="form-group">
				                                  <label class="col-lg-2 col-sm-2 control-label">Pengajar</label>
				                                  <div class="col-lg-10">
				                                      <select name="idkls" class="populate" id="e2" style="width: 100%">
				                                      		<option value="">Pengajar</option>
				                                          <?php
				                                                    $sql_kelas = mysqli_query($conn,"SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru
																		FROM `guru` as a
																		LEFT JOIN `pegawai` as b on a.nip = b.nip");
				                                            while($k = mysqli_fetch_assoc($sql_kelas))
				                                            {
				                                             
				                                                echo"<option value='$k[id]'>$k[nip] - $k[guru] - ($k[keterangan])</option>";  
				                                              
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
						            </div>				            
					            </form>
		                    </div>
	                    </div>
	                </div>
	            </section>
	        </div>
        </div>
		<?php
		break;
		case 'laporandetail':
			$kls = $_POST['idkls'];
			$tgl1 = $_POST['tgl1'];
			$tgl2 = $_POST['tgl2'];
			$queryx = "SELECT * FROM kelas WHERE `id`='$kls'";
			$sqlx = mysqli_query($conn,$queryx);	
			$qkls = mysqli_fetch_assoc($sqlx);


		?>
		<div class="col-sm-12"> <p class="hd-title">Rekap Absensi Pengajar Kelas <?php echo $qkls['kelas'] ?> Tanggal <?php echo tglindo($tgl1) ?> - <?php echo tglindo($tgl2) ?></div>
		<?php

		$qa = "SELECT DISTINCT `date` FROM `absensi_guru` WHERE `date` BETWEEN '$tgl1' AND '$tgl2' AND `idkelas` = $kls";
		$sqla = mysqli_query($conn,$qa);
		while ($ab = mysqli_fetch_assoc($sqla)) {

		?>
		<div class="col-lg-12">
	        <div class="row">
	            <div class="col-md-12">
	                <section class="panel panel-success">
	                    <header class="panel-heading">
	                    	Tanggal <?php echo tglindo($ab['date']) ?>
	                        <span class="tools pull-right">
	                            <a href="javascript:;" class="fa fa-chevron-down"></a>
	                            <a href="javascript:;" class="fa fa-cog"></a>
	                            <a href="javascript:;" class="fa fa-times"></a>
	                         </span>
	                    </header>
						
						
	                    <div class="panel-body">
							<div class="table-responsive">											
		                        <table class="table table-striped table-hover table-bordered table-condensed cf">
		                        	<thead>					                        		
			                        	<tr>
											<th class="text-center">No</th>
		                                    <th class="text-center">Pelajaran</th>
											<th class="text-center">Pengajar</th>
											<th class="text-center">Jam Pelajaran</th>
											<th class="text-center">Kehadiran</th>
											<?php if($_SESSION['level']=='admin' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                        	</thead>
									<tbody>
										<?php
											$query = "SELECT a.`id`,b.`nama` as pelajaran, e.`nama` as guru, a.`mulai`, a.`selesai`, a.`date`, f.`kehadiran`
												FROM `absensi_guru` as a
												JOIN `pelajaran` as b ON a.`idpelajaran` = b.`id`
												JOIN `guru` as d ON a.`idguru` = d.`id`
												JOIN `pegawai` as e ON e.`nip` = d.`nip`
												JOIN `kehadiran` as f ON a.`kehadiran` = f.`id`
												WHERE `idkelas` = '$kls' AND a.`date` = '$ab[date]'";
											$sql1 = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql1)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['pelajaran']?></td>
		                                    <td align="center"><?php echo $m['guru']?></td>
		                                    <td align="center"><?php echo date('H:i',strtotime($m['mulai'])) ?> - <?php echo date('H:i',strtotime($m['selesai'])) ?></td>
		                                    <td align="center"><?php echo $m['kehadiran']?></td>
		                                    <?php if($_SESSION['level']=='admin' ){?>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                        <a href="med.php?mod=absensiguru&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
		                                   --> 
												<a href="<?php echo $aksi ?>?mod=absensiguru&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

												
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
	    </div>
	    <?php
			}
	    ?>
	    <div class="col-sm-12">
	    	<div class="text-center">
	    		<a href="<?php echo $linkaksi ?>&act=laporan">
				<button class="btn btn-danger">
					<i class="fa fa-chevron-left"></i> Kembali 
				</button>
				</a>
	    	</div>
	    </div>
		<?php
		
		break;
		case 'laporandetailguru':
			$kls = $_POST['idkls'];
			$tgl1 = $_POST['tgl1'];
			$tgl2 = $_POST['tgl2'];
			$queryx = "SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
												FROM `guru` as a
												JOIN `pegawai` as b on a.nip = b.nip
												JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
												JOIN `statusguru` as d on d.`id` = a.`statusguru` WHERE a.`id`='$kls'";
			$sqlx = mysqli_query($conn,$queryx);	
			$qkls = mysqli_fetch_assoc($sqlx);


		?>
		<div class="col-sm-12"> <p class="hd-title">Rekap Absensi Pengajar <b><u><?php echo $qkls['guru'] ?></u></b> Tanggal <?php echo tglindo($tgl1) ?> - <?php echo tglindo($tgl2) ?></div>
		<?php

		$qa = "SELECT DISTINCT `date` FROM `absensi_guru` WHERE `date` BETWEEN '$tgl1' AND '$tgl2' AND `idguru` = $kls";
		$sqla = mysqli_query($conn,$qa);
		while ($ab = mysqli_fetch_assoc($sqla)) {

		?>
		<div class="col-lg-12">
	        <div class="row">
	            <div class="col-md-12">
	                <section class="panel panel-success">
	                    <header class="panel-heading">
	                    	Tanggal <?php echo tglindo($ab['date']) ?>
	                        <span class="tools pull-right">
	                            <a href="javascript:;" class="fa fa-chevron-down"></a>
	                            <a href="javascript:;" class="fa fa-cog"></a>
	                            <a href="javascript:;" class="fa fa-times"></a>
	                         </span>
	                    </header>
						
						
	                    <div class="panel-body">
							<div class="table-responsive">											
		                        <table class="table table-striped table-hover table-bordered table-condensed cf">
		                        	<thead>					                        		
			                        	<tr>
											<th class="text-center">No</th>
		                                    <th class="text-center">Pelajaran</th>
											<th class="text-center">Kelas</th>
											<th class="text-center">Jam Pelajaran</th>
											<th class="text-center">Kehadiran</th>
											<?php if($_SESSION['level']=='admin' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                        	</thead>
									<tbody>
										<?php
											$query = "SELECT a.`id`,b.`nama` as pelajaran, e.`nama` as guru, a.`mulai`, a.`selesai`, a.`date`, f.`kehadiran`, g.`kelas`
												FROM `absensi_guru` as a
												JOIN `pelajaran` as b ON a.`idpelajaran` = b.`id`
												JOIN `guru` as d ON a.`idguru` = d.`id`
												JOIN `pegawai` as e ON e.`nip` = d.`nip`
												JOIN `kehadiran` as f ON a.`kehadiran` = f.`id`
												JOIN `kelas` as g ON a.`idkelas` = g.`id`
												WHERE `idguru` = '$kls' AND a.`date` = '$ab[date]' ORDER BY a.`mulai` ASC";
											$sql1 = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql1)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['pelajaran']?></td>
		                                    <td align="center"><?php echo $m['kelas']?></td>
		                                    <td align="center"><?php echo date('H:i',strtotime($m['mulai'])) ?> - <?php echo date('H:i',strtotime($m['selesai'])) ?></td>
		                                    <td align="center"><?php echo $m['kehadiran']?></td>
		                                    <?php if($_SESSION['level']=='admin' ){?>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                        <a href="med.php?mod=absensiguru&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
		                                   --> 
												<a href="<?php echo $aksi ?>?mod=absensiguru&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

												
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
	    </div>
	    <?php
			}
	    ?>
	    <div class="col-sm-12">
	    	<div class="text-center">
	    		<a href="<?php echo $linkaksi ?>&act=laporan">
				<button class="btn btn-danger">
					<i class="fa fa-chevron-left"></i> Kembali 
				</button>
				</a>
	    	</div>
	    </div>
		<?php
		break;
	}

	}
?>
<script type="text/javascript">
	function pilih_pelajaran(prop)
	{
		//$.ajax({
	    //    url: 'mod/absensi/materi.php',
	    //    data : 'pelajaran_id='+prop,
		//	type: "post", 
	    //    dataType: "html",
		//	timeout: 10000,
	    //    success: function(response){
		//		$('#materi').html(response);
	    //    }
	    //});
	        var jenis = "guru";
	    $.ajax({
	        url: 'mod/absensi/guru.php',
	        data : {pelajaran_id:prop,jenis:jenis},
			type: "post", 
	        dataType: "html",
			timeout: 10000,
	        success: function(response){
				$('#guru').html(response);
				
	        }
	    });
	}
	function pilih_kelas(prop){
	        var jenis = "pelajaran";
	     $.ajax({
	        url: 'mod/absensi/guru.php',
	        data : {kelas_id:prop,jenis:jenis},
			type: "post", 
	        dataType: "html",
			timeout: 10000,
	        success: function(response){
				$('#pelajaran').html(response);
			//	alert(prop+jenis);
	        }
	    });
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

