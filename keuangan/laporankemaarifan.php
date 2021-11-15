<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['admin']) AND $_SESSION['keuangan'] <> 'TRUE')
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
	
	//link buat paging
	if($_SESSION['level']=='keuangan'){
		$linkaksi = 'med2.php?mod=laporankemaarifan';
	}elseif ($_SESSION['level']=='admin') {
		$linkaksi = 'med.php?mod=laporankemaarifan';
	}else{	
		$linkaksi = 'med2.php?mod=laporankemaarifan';
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

	$aksi = 'mod/keuangan/act_kemaarifan.php';

	?>
	<?php
	switch ($act) {
		case 'aksi':
			
        $sqltrans = mysqli_query($conn,"SELECT c.nis, c.nama, c.panggilan, c.tahunmasuk, c.idkelas, c.agama, b.status, a.id as idkondisi, a.kondisi, c.kelamin,
				   c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.tgllahir, c.warga,
				   c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa,
				   c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanayah ) as pendidikanayah
				   , (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanibu ) as pendidikanibu, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanayah) as pekerjaanayah, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanibu) as pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu,
				   c.alamatortu, c.hportu, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan, t.tahunajaran, t.id AS idtahunajaran,
				   k.kelas, c.nisn, 
	               c.noijasah,c.tglijasah,c.tmplahirayah,c.tmplahiribu,c.tgllahirayah,c.tgllahiribu,c.hobi, k.tingkat, t.tglmulai, t.tglakhir
			  FROM siswa as c
              JOIN kelas AS k ON k.id = c.idkelas 
              JOIN tahunajaran AS t ON t.id = k.idtahunajaran
              LEFT JOIN kondisisiswa AS a ON a.id = c.kondisi
              LEFT JOIN statussiswa AS b ON b.id = c.status
			 WHERE c.nis='$_SESSION[login_user]'") or die(mysqli_error());	  	  
			$tra = mysqli_fetch_assoc($sqltrans);
			flash('example_message');
			?>
			        <!-- page start-->
				        <!-- page start-->
				  
						
				        <div class="row">
				            <div class="col-sm-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        DATA LAPORAN PEMBAYARAN MAHAD
				                        <span class="tools pull-right">
				                            <a href="javascript:;" class="fa fa-chevron-down"></a>
				                            <a href="javascript:;" class="fa fa-cog"></a>
				                            <a href="javascript:;" class="fa fa-times"></a>
				                         </span>
				                    </header>
				                    <div class="panel-body table-responsive">
				                        <table class="table table-striped table-hover table-bordered" id="example">
		                                <thead>
	                                    <tr>
		                                	<?php
		                                	$start = $month = strtotime($tra['tglmulai']);
											$end = strtotime($tra['tglakhir']);
											while($month <= $end)
											{
												$blnx = date('m', $month);
											?>   
												<th class="text-center"><?php echo getBulanHijriah($blnx) ?></th> 
											<?php    
											$month = strtotime("+1 month", $month);

											}
		                                	?>
		                                </tr>
		                                
		                                </thead>
		                                <tbody>
		                                <tr class="">		
		                                    <?php
												$start1 = $month1 = strtotime($tra['tglmulai']);
												$end1 = strtotime($tra['tglakhir']);
												while($month1 <= $end1)											
												{
													$bln1 = date('m', $month1);	
													$thn1 = date('Y', $month1);	
												$qbln = mysqli_query($conn,"SELECT `id`, `nis`, `idtahunajaran`, `bulanke`, `nominal`, `potongan`, DAY(date) AS tanggal, MONTH(date) AS bulan, YEAR(date) AS tahun FROM `kemaarifan` WHERE `nis` = '$tra[nis]' AND `idtahunajaran` = '$tra[idtahunajaran]' AND `bulanke` = '$bln1' ");				
											    $bln = mysqli_fetch_assoc($qbln);		
													
																	
											?>

											<td align="center" style="vertical-align : middle;text-align:center;">
												<table class="table table-bordered">													
													<?php
													if (isset($bln['nominal'])) {
													    $by = $bln['nominal'] - $bln['potongan'];
													?>
													<tr>
														<td class="bg-info" align="center">
														 Rp. <?php echo number_format($by) ?>
														 	
														</td>
													</tr>
													<tr >
														<td  align="center"><?php echo $bln['tanggal']?> <?php echo NamaBulan($bln['bulan'])?> <?php echo $bln['tahun']?></td>
													</tr>
													<?php
													}elseif($bln1=='9'){
													?>
													<tr>
														<td class="bg-danger" align="center">Libur</td>
													</tr>
													<?php    
													}else{
														$g=1;
													?>
													<tr>
														<td class="bg-danger" align="center">Belum Terbayar</td>
													</tr>
													<?php
													$jmg+= $g;
													$g++;
													}
													?>

													
												</table>
											</td>
											<?php
											$month1 = strtotime("+1 month", $month1);
											}
											?>
		                                </tr>
										
		                                
		                                </tbody>
		                            </table>
				                    </div>
				                </section>
				            </div>
				        </div>

		<?php
		break;
		case 'form':
			if ($_POST['kelas']!=='semua') {
				$qkls="AND c.idkelas='$_POST[kelas]'";
			}else{
				$qkls='';
			}
        	$sqltrans = mysqli_query($conn,"SELECT c.nis, c.nama, c.panggilan, c.tahunmasuk, c.idkelas, c.agama, b.status, a.kondisi, c.kelamin,
				   c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.tgllahir, c.warga,
				   c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa,
				   c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanayah ) as pendidikanayah
				   , (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanibu ) as pendidikanibu, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanayah) as pekerjaanayah, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanibu) as pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu,
				   c.alamatortu, c.hportu, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan, t.tahunajaran, t.id AS idtahunajaran,
				   k.kelas, c.nisn, 
	               c.noijasah,c.tglijasah,c.tmplahirayah,c.tmplahiribu,c.tgllahirayah,c.tgllahiribu,c.hobi, t.tglmulai, t.tglakhir
			  FROM siswa as c
              JOIN kelas AS k ON k.id = c.idkelas 
              JOIN tahunajaran AS t ON t.id = k.idtahunajaran
              LEFT JOIN kondisisiswa AS a ON a.id = c.kondisi
              LEFT JOIN statussiswa AS b ON b.id = c.status
			 WHERE k.idtahunajaran = '$_POST[idtahunajaran]' $qkls ") or die(mysqli_error());	        
	        
			
			flash('example_message');
			?>
			        <!-- page start-->
				        <!-- page start-->
				  
						
				        <div class="row">
				            <div class="col-sm-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        DATA LAPORAN PEMBAYARAN MAHAD
				                        <span class="tools pull-right">
				                            <a href="javascript:;" class="fa fa-chevron-down"></a>
				                            <a href="javascript:;" class="fa fa-cog"></a>
				                            <a href="javascript:;" class="fa fa-times"></a>
				                         </span>
				                    </header>
				                    <div class="panel-body table-responsive">
				                        <table class="table table-striped table-hover table-bordered" id="example">
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>
											<th class="text-center">Nama</th>
											<th class="text-center">Kelas</th>
											
											<?php
											$query = "SELECT DISTINCT `bulanke` FROM `kemaarifan` WHERE `idtahunajaran` = '$_POST[idtahunajaran]' order by `date`";
											$sql_kul = mysqli_query($conn,$query);	
											$jmlb = mysqli_num_rows($sql_kul);
											while ($m = mysqli_fetch_assoc($sql_kul)) {
											?>											
		                                    <th class="text-center"><?php echo getBulanHijriah($m['bulanke']) ?></th>
											<?php
											}
											?>
										</tr>
		                                </thead>
		                                <tbody>
		                                    <?php
		                                    $i=1;
		                                    while ($n = mysqli_fetch_assoc($sqltrans)) {
											?>	
		                                <tr class="">										
											<td style="vertical-align : middle;text-align:center;" align="center"><?php echo $i ?></td>
											<td style="vertical-align : middle;text-align:center;"><?php echo $n['nama'] ?></td>
											<td style="vertical-align : middle;text-align:center;" align="center"><?php echo $n['kelas'] ?></td>
											<?php
											$x=1;
											$query = "SELECT DISTINCT `bulanke` FROM `kemaarifan` WHERE `idtahunajaran` = '$_POST[idtahunajaran]' order by `date`";
											$sql_kul = mysqli_query($conn,$query);	
											while ($m = mysqli_fetch_assoc($sql_kul)) {
											$blnk = $m['bulanke'];
											$qbln = mysqli_query($conn,"SELECT `id`, `nis`, `idtahunajaran`, `bulanke`, `nominal`,`potongan`, DAY(date) AS tanggal, MONTH(date) AS bulan, YEAR(date) AS tahun FROM `kemaarifan` WHERE `nis` = '$n[nis]' AND `idtahunajaran` = '$n[idtahunajaran]' AND `bulanke` = '$blnk' ");				
											$bln = mysqli_fetch_assoc($qbln);				
											?>

											<td align="center" style="vertical-align : middle;text-align:center;">
												<table class="table table-bordered">													
													<?php
													if (isset($bln['nominal'])) {
													    
													    $by = $bln['nominal'] - $bln['potongan'];
													?>
													<tr>
														<td align="center" class="bg-info">
														 Rp. <?php echo number_format($by) ?>
														 	
														</td>
													</tr>
													<tr>
														<td align="center"><?php echo $bln['tanggal']?> <?php echo NamaBulan($bln['bulan'])?> <?php echo $bln['tahun']?></td>
													</tr>
													<?php
													}else{
													?>
													<tr>
														<td align="center" class="bg-danger">Belum Terbayar</td>
													</tr>
													<?php
													}
													?>
													
												</table>
											</td>
											<?php
											$x++;
											}
											?>
		                                </tr>
										
											<?php
											$i++;
											}
											?>
		                                
		                                </tbody>
		                            </table>
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
	       
	                <div class="col-lg-12">
                    
        	            <section class="panel">
        	                <header class="panel-heading tab-bg-dark-navy-blue ">
        	                    <ul class="nav nav-tabs nav-justified">
        	                        <li class="active">
        	                            <a data-toggle="tab" href="#home">Rekap Per-kelas</a>
        	                        </li>
        	                        <li class="">
        	                            <a data-toggle="tab" href="#about">Rekap Per-bulan</a>
        	                        </li>
        	                        <li class="">
        	                            <a data-toggle="tab" href="#tahun">Rekap Per-tahun</a>
        	                        </li>
        	                    </ul>
        	                </header>
        	                <div class="panel-body">
        	                    <div class="tab-content">
        	                        <div id="home" class="tab-pane active">         
        					            
            				            <form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=form' enctype="multipart/form-data">
                            	            <div class="col-lg-12">
                            	                <section class="panel">
                            	                    <header class="panel-heading">
                            	                    </header>
                            	                    <div class="panel-body">
                            	                        <div class="position-center">
                            
                            	                            <div class="form-group">
                                                              <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
                                                              	<div class="col-lg-10">
                                                                  	<select id="e2" class="populate " name="kelas" class="form-control round-input" style="width: 100%">
                                                                  		   <option value="semua">Semua Kelas</option>
                            	                                          <?php
                            	                                                    $sql_angkatan = mysqli_query($conn,"SELECT a.* 
                            																	FROM `kelas` as a 
                            																	JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
                            																	WHERE b.`aktif` = 'Aktif'");
                            	                                            while($k = mysqli_fetch_assoc($sql_angkatan))
                            	                                            {
                            	                                              
                            	                                                echo"<option value='$k[id]'>$k[kelas]</option>";
                            	                                              
                            	                                            }
                            	                                                    ?>
                            	                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                              <label class="col-lg-2 col-sm-2 control-label">Tahun Ajaran</label>
                                                              	<div class="col-lg-10">
                                                                  	<select  id="e1" class="populate" name="idtahunajaran" class="form-control round-input" style="width: 100%">
                                                                      <?php
                                                                                $sql_penilaian = mysqli_query($conn,"SELECT * FROM `tahunajaran` WHERE `aktif` = 'Aktif'");
                                                                        while($k = mysqli_fetch_assoc($sql_penilaian))
                                                                        {
                                                                          
                                                                            echo"<option value='$k[id]'>$k[tahunajaran]</option>";
                                                                          
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
        	                        <div id="about" class="tab-pane">
        		                        
        				                <form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=laporanbulan' enctype="multipart/form-data">
                            	            <div class="col-lg-12">
                            	                <section class="panel">
                            	                    <header class="panel-heading">
                            	                    </header>
                            	                    <div class="panel-body">
                            	                        <div class="position-center">
                            
                            	                            <div class="form-group">
                                                              <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
                                                              	<div class="col-lg-10">
                                                                  	<select class="populate e1p" name="kelas"  style="width: 100%">
                                                                  		   <option value="semua">Semua Kelas</option>
                            	                                          <?php
                            	                                                    $sql_angkatan = mysqli_query($conn,"SELECT a.* 
                            																	FROM `kelas` as a 
                            																	JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
                            																	WHERE b.`aktif` = 'Aktif'");
                            	                                            while($k = mysqli_fetch_assoc($sql_angkatan))
                            	                                            {
                            	                                              
                            	                                                echo"<option value='$k[id]'>$k[kelas]</option>";
                            	                                              
                            	                                            }
                            	                                                    ?>
                            	                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                              <label class="col-lg-2 col-sm-2 control-label">Tahun Ajaran</label>
                                                              	<div class="col-lg-10">
                                                                  	<select  class="populate e1p" name="idtahunajaran"  style="width: 100%">
                                                                      <?php
                                                                                $sql_penilaian = mysqli_query($conn,"SELECT * FROM `tahunajaran` WHERE `aktif` = 'Aktif'");
                                                                        while($k = mysqli_fetch_assoc($sql_penilaian))
                                                                        {
                                                                          
                                                                            echo"<option value='$k[id]'>$k[tahunajaran]</option>";
                                                                          
                                                                        }
                                                                                ?>
                                                                  	</select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
            			                                      <label class="col-lg-2 col-sm-2 control-label">Bulan</label>
            			                                      <div class="col-lg-10">
            			                                          <select name="bulan" class="populate e1p"  style="width: 100%">
            			                                          		
            															<?php
            															$bln=array(1=>'Muharram','Safar','Rabi’ul Awal','Rabi’ul Akhir','Jumadil Awal','Jumadil Akhir','Rajab','Sya’ban','Ramadhan','Syawal','Dzulka’dah','Dzulhijah');
            															for($bulan=1; $bulan<=12; $bulan++){
            															if($bulan<=9) { echo "<option value='0$bulan'>$bln[$bulan]</option>"; }
            															else { echo "<option value='$bulan'>$bln[$bulan]</option>"; }
            															}
            															?>
            			                                          </select>
            			                                      	</div>
            			                                  	</div>
                            	                            <div class="form-group">
                                                              <label class="col-lg-2 col-sm-2 control-label">Tahun</label>
                                                              	<div class="col-lg-10">
                                                                  	<select  class="populate e1p" name="tahun"  style="width: 100%">
                                                                        <?php
                            	                                            $sql_angkatan = mysqli_query($conn,"SELECT DISTINCT YEAR(`date`) AS tahun FROM `kemaarifan` ORDER BY `date` DESC");
                            	                                            while($k = mysqli_fetch_assoc($sql_angkatan))
                            	                                            {
                            	                                              
                            	                                               echo"<option value='$k[tahun]'>$k[tahun]</option>";
                            	                                              
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
        		                    <div id="tahun" class="tab-pane">
        		                        
        				                <form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=laporantahun' enctype="multipart/form-data">
                            	            <div class="col-lg-12">
                            	                <section class="panel">
                            	                    <header class="panel-heading">
                            	                    </header>
                            	                    <div class="panel-body">
                            	                        <div class="position-center">
                            
                            	                            <div class="form-group">
                                                              <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
                                                              	<div class="col-lg-10">
                                                                  	<select class="populate e1p " name="kelas"  style="width: 100%">
                                                                  		   <option value="semua">Semua Kelas</option>
                            	                                          <?php
                            	                                                    $sql_angkatan = mysqli_query($conn,"SELECT a.* 
                            																	FROM `kelas` as a 
                            																	JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
                            																	WHERE b.`aktif` = 'Aktif'");
                            	                                            while($k = mysqli_fetch_assoc($sql_angkatan))
                            	                                            {
                            	                                              
                            	                                                echo"<option value='$k[id]'>$k[kelas]</option>";
                            	                                              
                            	                                            }
                            	                                                    ?>
                            	                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                              <label class="col-lg-2 col-sm-2 control-label">Tahun Ajaran</label>
                                                              	<div class="col-lg-10">
                                                                  	<select  class="populate e1p" name="idtahunajaran"  style="width: 100%">
                                                                      <?php
                                                                                $sql_penilaian = mysqli_query($conn,"SELECT * FROM `tahunajaran` WHERE `aktif` = 'Aktif'");
                                                                        while($k = mysqli_fetch_assoc($sql_penilaian))
                                                                        {
                                                                          
                                                                            echo"<option value='$k[id]'>$k[tahunajaran]</option>";
                                                                          
                                                                        }
                                                                                ?>
                                                                  	</select>
                                                                </div>
                                                            </div>
                            	                            <div class="form-group">
                                                              <label class="col-lg-2 col-sm-2 control-label">Tahun</label>
                                                              	<div class="col-lg-10">
                                                                  	<select  class="populate e1p" name="tahun"  style="width: 100%">
                                                                        <?php
                            	                                            $sql_angkatan = mysqli_query($conn,"SELECT DISTINCT YEAR(`date`) AS tahun FROM `kemaarifan` ORDER BY `date` DESC");
                            	                                            while($k = mysqli_fetch_assoc($sql_angkatan))
                            	                                            {
                            	                                              
                            	                                               echo"<option value='$k[tahun]'>$k[tahun]</option>";
                            	                                              
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
        	                    </div>
        	                </div>
        	            </section>
        	        </div>
	            </div>

		            <!-- page end-->
			<?php
		
		
		break;
        case 'laporanbulan':

			$tahunajaran = $_POST['idtahunajaran'];
			$bln = $_POST['bulan'];
			$thn =  $_POST['tahun'];
			if ($_POST['kelas']!=='semua') {
				$qkls="AND b.idkelas='$_POST[kelas]'";
			}else{
				$qkls='';
			}
			?>
		        <!-- page start-->

		        <div class="row">

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">
		                        Data Laporan Mahad Bulan <?php echo getBulanHijriah($bln) ?> 
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
		                                    <th class="text-center">Nama</th>
		                                    <th class="text-center">Kelas</th>
		                                    <th class="text-center">Tanggal</th>
		                                    <th class="text-center">Nominal Bayar</th>
		                                    <th class="text-center">Potongan</th>
		                                    <th class="text-center">Total</th>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT a.*, b.*,c.`kelas`
                                                        FROM `kemaarifan` as a
                                                        JOIN `siswa` as b ON a.`nis` = b.`nis`
                                                        JOIN `kelas` as c ON b.`idkelas` = c.`id`
                                                        WHERE a.`bulanke` = '$bln' AND YEAR(a.`date`) = '$thn' AND c.idtahunajaran = '$_POST[idtahunajaran]' $qkls
														ORDER BY a.`date` ";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
											    $bayar = $m['nominal']- $m['potongan'];
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <td align="center"><?php echo $m['nama']?></td>
		                                    <td align="center"><?php echo $m['kelas']?></td>
		                                    <td align="center"><?php echo tglindo($m['date'])?></td>
		                                    <td align="center"><?php echo number_format($m['nominal'])?></td>
		                                    <td align="center"><?php echo number_format($m['potongan'])?></td>
		                                    <td align="center"><?php echo number_format($bayar)?></td>
		                                     
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
		case 'laporantahun':

			$tahunajaran = $_POST['idtahunajaran'];
			$tahun = $_POST['tahun'];
			if ($_POST['kelas']!=='semua') {
				$qkls="AND b.idkelas='$_POST[kelas]'";
			}else{
				$qkls='';
			}
			?>
		        <!-- page start-->

		        <div class="row">

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">
		                        Data Laporan Mahad Tahun <?php echo $tahun ?> 
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
		                                    <th class="text-center">Nama</th>
		                                    <th class="text-center">Kelas</th>
		                                    <th class="text-center">Bulan</th>
		                                    <th class="text-center">Tanggal</th>
		                                    <th class="text-center">Nominal Bayar</th>
		                                    <th class="text-center">Potongan</th>
		                                    <th class="text-center">Total</th>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT a.*, b.*,c.`kelas`
                                                        FROM `kemaarifan` as a
                                                        JOIN `siswa` as b ON a.`nis` = b.`nis`
                                                        JOIN `kelas` as c ON b.`idkelas` = c.`id`
                                                        WHERE YEAR(a.`date`) = '$tahun' AND c.idtahunajaran = '$_POST[idtahunajaran]' $qkls
														ORDER BY a.`date` ";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
											    $bayar = $m['nominal']- $m['potongan'];
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <td align="center"><?php echo $m['nama']?></td>
		                                    <td align="center"><?php echo $m['kelas']?></td>
		                                    <td align="center"><?php echo getBulanHijriah($m['bulanke'])?></td>
		                                    <td align="center"><?php echo tglindo($m['date'])?></td>
		                                    <td align="center"><?php echo number_format($m['nominal'])?></td>
		                                    <td align="center"><?php echo number_format($m['potongan'])?></td>
		                                    <td align="center"><?php echo number_format($bayar)?></td>
		                                     
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
	$(function(){
		$("#harga").number(true);

		$('#harga').keyup(function(){
			var bayar = $('#harga').val();
			$('#harga2').val(bayar);
			console.log(bayar);
		});
	})
</script>

