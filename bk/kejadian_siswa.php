<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['kejadian_siswa']) AND $_SESSION['kejadian_siswa'] <> 'TRUE')
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
	$linkaksi = 'med.php?mod=kejadian_siswa';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/bk/act_kejadian_siswa.php';

	?>
	<?php
	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=kejadian_siswa&act=edit";
				$query = mysqli_query($conn,"SELECT a.id,a.nis,b.nama,c.nama as kejadian,c.poin,a.tanggal from 
														kejadian_siswa a
														inner join siswa b
														on a.nis = b.nis
														inner join daftar_kejadian c
														on a.iddaftarkejadian = c.id
														WHERE a.id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=kejadian_siswa");
				}

			}
			else
			{
				$act = "$aksi?mod=kejadian_siswa&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data Kejadian Siswa
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            <div class="form-group">
			                                  <label class="col-lg-2 col-sm-2 control-label">Siswa</label>
			                                  	<div class="col-lg-6">
			                                      	<select id="e2" class="populate " name="nis" class="form-control round-input" style="width: 550px">
			                                      		<option value="<?php echo isset($c['nis']) ? $c['nis'] : '' ;?>"><?php echo isset($c['nis']) ? $c['nis'].' - '.$c['nama'] : 'Pilih Siswa' ;?></option>
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
			                                  <label class="col-lg-2 col-sm-2 control-label">Kejadian</label>
			                                  	<div class="col-lg-6">
			                                      	<select  id="e1" class="populate" name="iddaftarkejadian" class="form-control round-input" style="width: 550px">
			                                      		<option value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>"><?php echo isset($c['id']) ? $c['kejadian'] : 'Pilih Kejadian' ;?></option>
			                                          <?php
			                                                    $sql_penilaian = mysqli_query($conn,"SELECT * FROM `daftar_kejadian`");
			                                            while($k = mysqli_fetch_assoc($sql_penilaian))
			                                            {
			                                              
			                                                echo"<option value='$k[id]'>$k[nama]</option>";
			                                              
			                                            }
			                                                    ?>
			                                      	</select>
			                                    </div>
			                                </div>
			                                <div class="form-group">
				                                <label class="control-label col-lg-2 col-sm-2">Tanggal Kejadian</label>
				                                <div class="col-lg-10">
				                                    <input name="tanggal" class="form-control form-control-inline input-medium default-date-picker  round-input"  size="16" type="text" value="<?php echo isset($c['tanggal']) ? $c['tanggal'] : '' ;?>" />
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
		                <section class="panel">
		                    <header class="panel-heading">
		                        <?php if($_SESSION['level']=='admin'){?>
		                        	<a href="med.php?mod=kejadian_siswa&act=form">
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
							
							
		                    <div class="panel-body">
							
		                        <div class="adv-table editable-table ">
		                            <div class="clearfix">
		                                <div class="btn-group">
		                                </div>
		                                <div class="btn-group pull-right">
		                                   
		                                </div>
		                            </div>
		                            <div class="space12"></div>
		                            <div class="table-responsive">
		                            <table class="table table-striped table-hover table-bordered table-responsive" id="example">
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>
											<th class="text-center">Siswa</th>
											<th class="text-center">Kelas</th>
		                                    <th class="text-center">Poin Awal</th>
											<th class="text-center">Poin Pelanggaran</th>
											<th class="text-center">Total Poin</th>
											<?php if($_SESSION['level']=='admin' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
		                                	$queryp = "SELECT * FROM `pengaturan_bk` WHERE id = '$_GET[id]'";
											$sqlp = mysqli_query($conn,$queryp);
											$p = mysqli_fetch_assoc($sqlp);


											$query = "SELECT a.id,a.nis,b.nama,sum(c.poin)as poinsiswa, d.kelas from 
														kejadian_siswa a
														inner join siswa b
														on a.nis = b.nis
														inner join daftar_kejadian c
														on a.iddaftarkejadian = c.id 
														join kelas d
														on b.idkelas = d.id  
                                                        GROUP BY a.`nis`";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
											if ($p['sistempelanggaran']=='Ditambah') {
												$totalpoin = $p['poinawal']+$m['poinsiswa'];
											}elseif ($p['sistempelanggaran']=='Dikurangi') {
												$totalpoin = $p['poinawal']-$m['poinsiswa'];
											}
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td><?php echo $m['nis']?> - <?php echo $m['nama']?></td>
		                                    <td align="center"><?php echo $m['kelas']?></td>
		                                    <td align="center"><?php echo $p['poinawal']?></td>
		                                    <td align="center"><?php echo $m['poinsiswa']?></td>
		                                    <td align="center"><?php echo $totalpoin?></td>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>

		                                       <a href="med.php?mod=kejadian_siswa&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												<a href="<?php echo $aksi ?>?mod=kejadian_siswa&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>							
		                                   --> <?php if($_SESSION['level']=='admin' ){?>
		                                   		<a href="med.php?mod=kejadian_siswa&act=detail&id=<?php echo $m['nis'] ?>" ><button class="btn btn-info btn-sm"><i class="fa fa-search"></i></button> </a>

		                                        

												
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
		                </section>
		            </div>
		        </div>

		            <!-- page end-->
			<?php
		break;
		case 'detail':
			$sqltrans = mysqli_query($conn,"SELECT c.nis, c.nama, c.panggilan, c.tahunmasuk, c.idkelas, c.agama, b.status, a.kondisi, c.kelamin,
				   c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.tgllahir, c.warga,
				   c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa,
				   c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanayah ) as pendidikanayah
				   , (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanibu ) as pendidikanibu, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanayah) as pekerjaanayah, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanibu) as pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu,
				   c.alamatortu, c.hportu, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan, t.tahunajaran, t.id AS idtahunajaran,
				   k.kelas, c.nisn, 
	               c.noijasah,c.tglijasah,c.tmplahirayah,c.tmplahiribu,c.tgllahirayah,c.tgllahiribu,c.hobi
			  FROM siswa c, kelas k, tahunajaran t, kondisisiswa a, statussiswa b
			 WHERE c.nis='$_GET[id]' AND k.id = c.idkelas AND a.id = c.kondisi AND b.id = c.status ") or die(mysqli_error());
				$tra = mysqli_fetch_assoc($sqltrans);	        
	        
			
			flash('example_message');
		?>

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
				                               	<table class="table table-striped table-responsive">                               		
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
					                                <tr>
					                                    <td>NISN</td>
					                                    <td>:</td>
					                                    <td><?php echo $tra['nisn'] ?></td>
					                                </tr>
				                               	</table>
				                           </div>
				                       </div>
				                    </div>
				                </section>
				            </div>
				        </div>
				        <div class="row">

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">
		                        
		                        <span class="tools pull-right">
		                            <a href="javascript:;" class="fa fa-chevron-down"></a>
		                            <a href="javascript:;" class="fa fa-cog"></a>
		                            <a href="javascript:;" class="fa fa-times"></a>
		                         </span>
		                    </header>
							
							
		                    <div class="panel-body">
							
		                        <div class="adv-table editable-table ">
		                            <div class="clearfix">
		                                <div class="btn-group">
		                                </div>
		                                <div class="btn-group pull-right">
		                                   
		                                </div>
		                            </div>
		                            <div class="space12"></div>
		                            <div class="table-responsive">
		                            <table class="table table-striped table-hover table-bordered table-responsive" id="example">
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>
											<th class="text-center">Siswa</th>
		                                    <th class="text-center">Kejadian</th>
											<th class="text-center">Poin Kejadian</th>
											<th class="text-center">Tanggal Kejadian</th>
											<?php if($_SESSION['level']=='admin' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT a.id,a.nis,b.nama,c.nama as kejadian,c.poin,a.tanggal from 
														kejadian_siswa a
														inner join siswa b
														on a.nis = b.nis
														inner join daftar_kejadian c
														on a.iddaftarkejadian = c.id 
														WHERE b.nis='$_GET[id]' order by a.tanggal desc";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td><?php echo $m['nis']?> - <?php echo $m['nama']?></td>
		                                    <td><?php echo $m['kejadian']?></td>
		                                    <td align="center"><?php echo $m['poin']?></td>
		                                    <td align="center"><?php echo $m['tanggal']?></td>
		                                    <?php if($_SESSION['level']=='admin' ){?>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> 
		                                        <a href="med.php?mod=kejadian_siswa&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												<a href="<?php echo $aksi ?>?mod=kejadian_siswa&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

												
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

