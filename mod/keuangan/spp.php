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
		$linkaksi = 'med2.php?mod=spp';
	}elseif ($_SESSION['level']=='admin') {
		$linkaksi = 'med.php?mod=spp';
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

	$aksi = 'mod/keuangan/act_spp.php';

	?>
	<?php
	switch ($act) {
		case 'aksi':
		if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=spp&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM spp WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
					$nis = $c['nis'];
					$thn = $c['idtahunajaran'];
				}
				else
				{
					if($_SESSION['level']=='keuangan'){
						header("location:med2.php?mod=spp");
					}elseif ($_SESSION['level']=='admin') {
						header("location:med2.php?mod=spp");
					}
					
				}

			}
			else
			{

					$nis = $_GET['nis'];
					$thn = $_GET['thn'];
				$act = "$aksi?mod=spp&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data SPP Pembelajaran
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Bulan</label>
				                                <div class="col-lg-10">
			                                          <select name="bulan" class="form-control round-input" style="width: 550px">
			                                          		<option value="<?php echo isset($c['bulanke']) ? $c['bulanke'] : 'Pilih Bulan' ;?>"><?php echo isset($c['bulanke']) ? getBulanHijriah($c['bulanke']) : 'Pilih Bulan' ;?></option>
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
				                                <label class="control-label col-lg-2 col-sm-2">Tanggal Pembayaran</label>
				                                <div class="col-lg-10">
				                                    <input name="tgl" class="form-control form-control-inline input-medium default-date-picker  round-input"  size="16" type="text" value="<?php echo isset($c['date']) ? $c['date'] : '' ;?>" />
				                                </div>
				                            </div>
			                                <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Bayar (Rp.)</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="nominal" class="form-control round-input currency4" value="<?php echo isset($c['nominal']) ? $c['nominal'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <input type="hidden" name="nis" value="<?php echo $nis ?>">	                            
				                            <input type="hidden" name="idtahunajaran" value="<?php echo $thn ?>">	                            
				                            <div class="form-group">
				                                <div class="col-lg-offset-2 col-lg-10">
									                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
									                <!--<button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>-->
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
		case 'form':
	        if (isset($_POST['nis'])=='1') {
	        	$nis=$_POST['nis'];
	        	$idtahunajaran=$_POST['idtahunajaran'];
	        }else{

	        	$nis=$_GET['nis'];
	        	$idtahunajaran=$_GET['idtahunajaran'];
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
			 WHERE c.nis='$nis' AND k.id = c.idkelas AND a.id = c.kondisi AND b.id = c.status AND k.idtahunajaran = '$idtahunajaran' ") or die(mysqli_error());
				$tra = mysqli_fetch_assoc($sqltrans);	        
	        
			
			flash('example_message');
			?>
			        <!-- page start-->
				        <!-- page start-->
				  
						<div class="row">
				            <div class="col-md-12">
				                <section class="panel">
				                    <div class="panel-body profile-information">
				                       <div class="col-md-3">
				                           <div class="profile-pic text-center">
				                               <img src="images/siswa/<?php echo $tra['foto'] ?>" alt=""/>
				                           </div>
				                       </div>
				                       <div class="col-md-9 table-responsive">
				                           <div class="profile-desk">
				                               <h1>DATA SISWA <?php echo $tra['nama'] ?></h1>
				                               <br>
				                               	<table class="table table-striped">                               		
					                               	<tr>
					                                    <td>Tahun Ajaran</td>
					                                    <td>:</td>
					                                    <td><?php echo $tra['tahunajaran'] ?></td>
					                                </tr>
					                                <tr>
					                                    <td>Kelas</td>
					                                    <td>:</td>
					                                    <td><?php echo $tra['kelas'] ?></td>
					                                </tr>
					                                <tr>
					                                    <td>NIS</td>
					                                    <td>:</td>
					                                    <td><?php echo $tra['nis'] ?></td>
					                                </tr>
					                                <!--<tr>
					                                    <td>NISN</td>
					                                    <td>:</td>
					                                    <td><?php echo $tra['nisn'] ?></td>
					                                </tr>-->
				                               	</table>
				                           </div>
				                       </div>
				                    </div>
				                </section>
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-sm-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        DATA PEMBAYARAN SPP
				                        <span class="tools pull-right">
				                            <a href="<?php echo $linkaksi ?>&act=aksi&nis=<?php echo $nis ?>&thn=<?php echo $idtahunajaran ?>">
											<button class="btn btn-primary btn-xs">
												Tambah Pembayaran SPP <i class="fa fa-plus"></i>
											</button>
											</a>
				                         </span>
				                    </header>
				                    <div class="panel-body table-responsive">
				                        <table class="table table-striped table-hover table-bordered" id="example">
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>
											<th class="text-center">Bulan</th>
											<th class="text-center">Tanggal Pembayaran</th>
		                                    <th class="text-center">Nominal</th>
											<th class="text-center">Aksi</th>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT `id`, `nis`, `idtahunajaran`, `bulanke`, `nominal`, DAY(date) AS tanggal, MONTH(date) AS bulan, YEAR(date) AS tahun FROM `spp` WHERE `nis` = '$tra[nis]' AND `idtahunajaran` = '$tra[idtahunajaran]' order by `bulanke`";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo getBulanHijriah($m['bulanke'])?></td>
		                                    <td align="center"><?php echo $m['tanggal']?> <?php echo NamaBulan($m['bulan'])?> <?php echo $m['tahun']?></td>
		                                    <td align="center">Rp. <?php echo number_format($m['nominal']) ?></td>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> 
		                                        <a href="<?php echo $linkaksi ?>&act=aksi&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												<a href="<?php echo $aksi ?>?mod=spp&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>


												
											</td>
											 
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
                                  <label class="col-lg-2 col-sm-2 control-label">Siswa</label>
                                  	<div class="col-lg-6">
                                      	<select id="e2" class="populate " name="nis" class="form-control round-input" style="width: 550px">
	                                          <?php
	                                                    $sql_angkatan = mysqli_query($conn,"SELECT nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas
														FROM siswa as s 
                                                        left join kelas k on s.idkelas = k.id
                                                        left join tahunajaran t on t.id = k.idtahunajaran
                                                        where s.alumni=0");
	                                            while($k = mysqli_fetch_assoc($sql_angkatan))
	                                            {
	                                              
	                                                echo"<option value='$k[nis]'>$k[nis] - $k[nama]</option>";
	                                              
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

