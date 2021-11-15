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
		$linkaksi = 'med2.php?mod=laporan';
	}elseif ($_SESSION['level']=='admin') {
		$linkaksi = 'med.php?mod=laporan';
	}else{	
		$linkaksi = 'med2.php?mod=laporan';
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

	$aksi = 'mod/keuangan/act_laporan.php';

	?>
	<?php
	switch ($act) {
		case 'aksi':
			
        	$sqltrans = mysqli_query($conn,"SELECT c.nis, c.nama, c.panggilan, c.tahunmasuk, c.idkelas, c.agama, b.status, a.kondisi, c.kelamin,
				   c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.tgllahir, c.warga,
				   c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa,
				   c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanayah ) as pendidikanayah
				   , (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanibu ) as pendidikanibu, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanayah) as pekerjaanayah, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanibu) as pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu,
				   c.alamatortu, c.hportu, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan, t.tahunajaran, t.id AS idtahunajaran,
				   k.kelas, c.nisn, 
	               c.noijasah,c.tglijasah,c.tmplahirayah,c.tmplahiribu,c.tgllahirayah,c.tgllahiribu,c.hobi
			  FROM siswa c, kelas k, tahunajaran t, kondisisiswa a, statussiswa b
			 WHERE c.nis='$_SESSION[login_user]' AND k.id = c.idkelas AND a.id = c.kondisi AND b.id = c.status AND k.idtahunajaran = t.id") or die(mysqli_error());	  
			$tra = mysqli_fetch_assoc($sqltrans);
			flash('example_message');
			?>
			        <!-- page start-->
				        <!-- page start-->
				  
						
				        <div class="row">
				            <div class="col-sm-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        DATA LAPORAN PEMBAYARAN SPP
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
											$query = "SELECT DISTINCT `bulanke` FROM `spp` WHERE `idtahunajaran` = '$tra[idtahunajaran]' order by `bulanke`";
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
		                                <tr class="">										
											<?php
														$jmg=0;
											$x=1;
											for ($b=0; $b < $jmlb ; $b++) { 
												if ($x<=9) {
													$blnk = '0'.$x;
												}else{
													$blnk = $x;
												}
											$qbln = mysqli_query($conn,"SELECT `id`, `nis`, `idtahunajaran`, `bulanke`, `nominal`, DAY(date) AS tanggal, MONTH(date) AS bulan, YEAR(date) AS tahun FROM `spp` WHERE `nis` = '$tra[nis]' AND `idtahunajaran` = '$tra[idtahunajaran]' AND `bulanke` = '$blnk' ");				
											$bln = mysqli_fetch_assoc($qbln);				
											?>

											<td align="center" style="vertical-align : middle;text-align:center;">
												<table class="table table-bordered">													
													<?php
													if (isset($bln['nominal'])) {
													?>
													<tr>
														<td class="bg-info" align="center">
														 Rp. <?php echo number_format($bln['nominal']) ?>
														 	
														</td>
													</tr>
													<tr >
														<td  align="center"><?php echo $bln['tanggal']?> <?php echo NamaBulan($bln['bulan'])?> <?php echo $bln['tahun']?></td>
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
											$x++;
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
	               c.noijasah,c.tglijasah,c.tmplahirayah,c.tmplahiribu,c.tgllahirayah,c.tgllahiribu,c.hobi
			  FROM siswa c, kelas k, tahunajaran t, kondisisiswa a, statussiswa b
			 WHERE k.id = c.idkelas AND a.id = c.kondisi AND b.id = c.status AND k.idtahunajaran = '$_POST[idtahunajaran]' $qkls ") or die(mysqli_error());	        
	        
			
			flash('example_message');
			?>
			        <!-- page start-->
				        <!-- page start-->
				  
						
				        <div class="row">
				            <div class="col-sm-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        DATA LAPORAN PEMBAYARAN SPP
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
											$query = "SELECT DISTINCT `bulanke` FROM `spp` WHERE `idtahunajaran` = '$_POST[idtahunajaran]' order by `bulanke`";
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
											for ($b=0; $b < $jmlb ; $b++) { 
												if ($x<=9) {
													$blnk = '0'.$x;
												}else{
													$blnk = $x;
												}
											$qbln = mysqli_query($conn,"SELECT `id`, `nis`, `idtahunajaran`, `bulanke`, `nominal`, DAY(date) AS tanggal, MONTH(date) AS bulan, YEAR(date) AS tahun FROM `spp` WHERE `nis` = '$n[nis]' AND `idtahunajaran` = '$n[idtahunajaran]' AND `bulanke` = '$blnk' ");				
											$bln = mysqli_fetch_assoc($qbln);				
											?>

											<td align="center" style="vertical-align : middle;text-align:center;">
												<table class="table table-bordered">													
													<?php
													if (isset($bln['nominal'])) {
													?>
													<tr>
														<td align="center">
														 Rp. <?php echo number_format($bln['nominal']) ?>
														 	
														</td>
													</tr>
													<tr>
														<td align="center"><?php echo $bln['tanggal']?> <?php echo NamaBulan($bln['bulan'])?> <?php echo $bln['tahun']?></td>
													</tr>
													<?php
													}else{
													?>
													<tr>
														<td align="center">Belum Terbayar</td>
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

	       <form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=form' enctype="multipart/form-data">
	            <div class="col-lg-12">
	                <section class="panel">
	                    <header class="panel-heading">
	                    </header>
	                    <div class="panel-body">
	                        <div class="position-center">

	                            <div class="form-group">
                                  <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
                                  	<div class="col-lg-6">
                                      	<select id="e2" class="populate " name="kelas" class="form-control round-input" style="width: 550px">
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
                                  	<div class="col-lg-6">
                                      	<select  id="e1" class="populate" name="idtahunajaran" class="form-control round-input" style="width: 550px">
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

