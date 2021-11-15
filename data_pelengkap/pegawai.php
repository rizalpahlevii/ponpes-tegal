<?php

	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['pegawai']) AND $_SESSION['pegawai'] <> 'TRUE')
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
	$linkaksi = 'med.php?mod=pegawai';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/data_pelengkap/act_pegawai.php';

	?>
	<?php
	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=pegawai&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM pegawai WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=pegawai");
				}

			}
			else
			{
				$act = "$aksi?mod=pegawai&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">

				       <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>' enctype="multipart/form-data">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data Pribadi Pegawai
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            	<input type="hidden" name="img" value="<?php echo isset($c['foto']) ? $c['foto'] : '' ;?>">
				                            	<input type="hidden" name="pin" value="<?php echo isset($c['pinpegawai']) ? $c['pinpegawai'] : '' ;?>">
				                            <div class="form-group">
				                                <label class="col-lg-2 col-sm-2 control-label">Bagian</label>
				                                <div class="col-lg-6">
				                                    <select class="form-control round-input" name="bagian" style="width: 100%" id="source">
				                                    	<option value="<?php echo isset($c['bagian']) ? $c['bagian'] : 'Pilih Bagian' ;?>"><?php echo isset($c['bagian']) ? $c['bagian'] : 'Pilih Bagian' ;?></option>
			                                            <option value="Akademik">Akademik</option>
			                                            <option value="Non-Akademik">Non-Akademik</option>
				                                    </select>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">NIP</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="nip" class="form-control round-input" value="<?php echo isset($c['nip']) ? $c['nip'] : '' ;?>" required>
				                                </div>
				                            </div>			                            
				                            
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Nama</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="nama" class="form-control round-input" value="<?php echo isset($c['nama']) ? $c['nama'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Panggilan</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="panggilan" class="form-control round-input" value="<?php echo isset($c['panggilan']) ? $c['panggilan'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Gelar</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="gelarawal" class="form-control round-input" value="<?php echo isset($c['gelarawal']) ? $c['gelarawal'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <input type="hidden" name="gelarakhir" class="form-control round-input" value="<?php echo isset($c['gelarakhir']) ? $c['gelarakhir'] : '' ;?>" >
				                            

				                            <div class="form-group">
				                                <label class="col-lg-2 col-sm-2 control-label">Jenis Kelamin</label>
				                                <div class="col-lg-6">
				                                    <select class="form-control round-input" name="kelamin" style="width: 100%" id="source">
				                                    	<option value="<?php echo isset($c['kelamin']) ? $c['kelamin'] : 'Pilih Jenis Kelamin' ;?>"><?php echo isset($c['kelamin']) ? $c['kelamin'] : 'Pilih Jenis Kelamin' ;?></option>
			                                            <option value="Laki - Laki">Laki - Laki</option>
			                                            <option value="Perempuan">Perempuan</option>
				                                    </select>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Tempat Lahir</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="tmplahir" class="form-control round-input" value="<?php echo isset($c['tmplahir']) ? $c['tmplahir'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label class="control-label col-lg-2 col-sm-2">Tanggal Lahir</label>
				                                <div class="col-lg-10">
				                                    <input name="tgllahir" class="form-control form-control-inline input-medium default-date-picker  round-input"  size="16" type="text" value="<?php echo isset($c['tgllahir']) ? $c['tgllahir'] : '' ;?>" />
				                                </div>
				                            </div>
				                            <!--<div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Agama</label>
		                                      	<div class="col-lg-6">
		                                          	<select  name="agama" class="form-control round-input" style="width: 550px">
		                                              <?php
		                                                        $sql_agama = mysqli_query($conn,"SELECT * FROM agama order by urutan");
		                                                while($k = mysqli_fetch_assoc($sql_agama))
		                                                {
		                                                  if(isset($c['id']) && $k['id'] == $c['id'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[agama]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[agama]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
			                                    </div>
			                                </div>-->
			                                <input type="hidden" name="agama" class="form-control round-input" value="30" >
			                                <div class="form-group">
				                                <label class="col-lg-2 col-sm-2 control-label">Menikah</label>
				                                <div class="col-lg-6">
				                                    <select class="form-control round-input" name="nikah" style="width: 100%" id="source">
				                                    	<option value="<?php echo isset($c['nikah']) ? $c['nikah'] : 'Pilih Status' ;?>"><?php echo isset($c['nikah']) ? $c['nikah'] : 'Pilih Status' ;?></option>
			                                            <option value="Sudah Menikah">Sudah Menikah</option>
			                                            <option value="Belum Menikah">Belum Menikah</option>
			                                            <option value="Tidak Ada Data">Tidak Ada Data</option>
				                                    </select>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">No. Identitas</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="noid" class="form-control round-input" value="<?php echo isset($c['noid']) ? $c['noid'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label class="control-label col-md-2">Alamat</label>
				                                <div class="col-md-10">
				                                    <textarea class="form-control" name="alamat" rows="5"><?php echo isset($c['alamat']) ? $c['alamat'] : '' ;?></textarea>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Handphone</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="handphone" class="form-control round-input" value="<?php echo isset($c['handphone']) ? $c['handphone'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email</label>
				                                <div class="col-lg-10">
				                                    <input type="email" name="email" class="form-control round-input" value="<?php echo isset($c['email']) ? $c['email'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group last">
				                                <label class="control-label col-md-2">Foto</label>
				                                <div class="col-md-10">
				                                    <div class="fileupload fileupload-new" data-provides="fileupload">
				                                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
				                                            <img src="<?php echo isset($c['foto']) ? 'images/pegawai/'.$c['foto'] : 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image' ;?>" alt="" />
				                                        </div>
				                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
				                                        <div>
				                                                   <span class="btn btn-white btn-file">
				                                                   <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
				                                                   <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
				                                                   <input type="file" name="foto" class="default" />
				                                                   </span>
				                                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
				                                        </div>
				                                    </div>
				                                    <span class="label label-danger">NOTE!</span>
				                                             <span>
				                                             Attached image thumbnail is
				                                             supported in Latest Firefox, Chrome, Opera,
				                                             Safari and Internet Explorer 10 only
				                                             </span>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label class="control-label col-md-2">Keterangan</label>
				                                <div class="col-md-10">
				                                    <textarea class="form-control" name="keterangan" rows="5"><?php echo isset($c['keterangan']) ? $c['keterangan'] : '' ;?></textarea>
				                                </div>
				                            </div>		
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Pin</label>
				                                <div class="col-lg-10">
				                                    <input type="password" maxlength="5" name="pinpegawai" class="form-control round-input" value="<?php echo isset($c['pinpegawai']) ? $c['pinpegawai'] : '' ;?>" >
				                                </div>
				                            </div>	                            
				                            <div class="form-group">
				                                <div class="col-lg-offset-2 col-lg-10">
									                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
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
		                        	<a href="med.php?mod=pegawai&act=form">
									<button class="btn btn-primary">
										Tambah <i class="fa fa-plus"></i>
									</button>
									</a>
								<?php }?>

								<?php if($_SESSION['level']=='admin'){?>
		                        	<a href="med.php?mod=pegawai&act=formimport">
									<button class="btn btn-primary">
										Tambah Import <i class="fa fa-plus"></i>
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
											<th class="text-center">NIP</th>
											<th class="text-center">Nama</th>
		                                    <th class="text-center">Tempat, Tanggal Lahir</th>
		                                    <th class="text-center">Bagian</th>
											<?php if($_SESSION['level']=='admin' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT `id`, `nip`, `nrp`, `nuptk`, `nama`, `panggilan`, `gelarawal`, `gelarakhir`, `tmplahir`,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn, `agama`, `noid`, `alamat`, `handphone`, `email`, `foto`, `bagian`, `nikah`, `keterangan`, `kelamin`, `pinpegawai`, `mulaikerja`, `status`, `ketnonaktif`, `pensiun`, `doaudit` FROM `pegawai` ";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['nip']?></td>
		                                    <td align="center"><?php echo $m['nama']?></td>
		                                    <td ><?php echo $m['tmplahir']?>, <?php echo $m['tgl']?> <?php echo NamaBulan($m['bln']) ?> <?php echo $m['thn']?></td>
		                                    <td align="center"><?php echo $m['bagian']?></td>

											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> <?php if($_SESSION['level']=='admin' ){?>
		                                   		<a href="med.php?mod=pegawai&act=detail&id=<?php echo $m['id'] ?>" ><button class="btn btn-info btn-sm"><i class="fa fa-search"></i></button> </a>
		                                        <a href="med.php?mod=pegawai&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												<a href="<?php echo $aksi ?>?mod=pegawai&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

												
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
			if(isset($_GET['id']))
			{
				$sqltrans = mysqli_query($conn,"SELECT a.`id`, a.`nip`, a.`nrp`, a.`nuptk`, a.`nama`, a.`panggilan`, a.`gelarawal`, a.`gelarakhir`, a.`tmplahir`,tgllahir,DAY(a.tgllahir) as tgl,MONTH(a.tgllahir) as bln,YEAR(a.tgllahir) as thn, b.`agama`, a.`noid`, `alamat`, `handphone`, `email`, `foto`, `bagian`, `nikah`, `keterangan`, `kelamin`, `pinpegawai`, `mulaikerja`, a.`status`, a.`ketnonaktif`, a.`pensiun`, a.`doaudit` 
					FROM `pegawai` as a
					JOIN `agama` as b ON b.`id` = a.`agama`
					WHERE a.`id` ='$_GET[id]'") or die(mysqli_error());
				$tra = mysqli_fetch_assoc($sqltrans);

		?>
		<div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body profile-information">
                       <div class="col-md-3">
                           <div class="profile-pic text-center">
                               <img src="images/pegawai/<?php echo $tra['foto'] ?>" alt=""/>
                           </div>
                       </div>
                       <div class="col-md-9">
                           <div class="profile-desk">
                               <h1>DATA PEGAWAI <?php echo $tra['nama'] ?></h1>
                               <br>
                               	<table class="table table-striped">                               		
	                               	<tr>
	                                    <td>NIP</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['nip'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Bagian</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['bagian'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Gelar Awal</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['gelarawal'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Gelar Akhir</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['gelarakhir'] ?></td>
	                                </tr>
                               	</table>
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
                                    DATA PRIBADI PEGAWAI
                                </a>
                            </li>
                        </ul>
                    </header>
                    <div class="panel-body">
                        <div class="tab-content tasi-tab">
                            <div id="datasiswa" class="tab-pane active">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-striped">                               		
			                               	<tr>
			                                    <td >1.</td>
			                                    <td colspan="3">Nama Pegawai</td>
			                                </tr>
			                                <tr>
			                                	<td></td>
			                                    <td>a. Lengkap</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['nama'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td></td>
			                                    <td>a. Panggilan</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['panggilan'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>2.</td>
			                                    <td>Jenis Kelamin</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['kelamin'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>3.</td>
			                                    <td>Tempat Lahir</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['tmplahir'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>4.</td>
			                                    <td>Tanggal Lahir</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['tgl']?> <?php echo NamaBulan($tra['bln']) ?> <?php echo $tra['thn']?></td>
			                                </tr>
			                                <tr>
			                                	<td>5.</td>
			                                    <td>Agama</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['agama'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>6.</td>
			                                    <td>No. Identitas</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['noid'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>7.</td>
			                                    <td>Status Menikah</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['nikah'] ?></td>
			                                </tr>                                
			                                

		                               	</table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-striped">                               		
			                               	
			                                <tr>
			                                	<td>8.</td>
			                                    <td>Alamat</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['alamat'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>9.</td>
			                                    <td>Handphone</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['handphone'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>10.</td>
			                                    <td>Email</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['email'] ?></td>
			                                </tr>			                                		                                
			                                <tr>
			                                	<td>11.</td>
			                                    <td>Keterangan</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['keterangan'] ?></td>
			                                </tr>

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
		case 'formimport':
		?>
		<style>
        #loading{
			background: whitesmoke;
			position: absolute;
			top: 140px;
			left: 82px;
			padding: 5px 10px;
			border: 1px solid #ccc;
		}
		</style>
		<script>
		$(document).ready(function(){
			// Sembunyikan alert validasi kosong
			$("#kosong").hide();
		});
		</script>
		<div class="row">
			<div style="padding: 0 15px;">
				<!-- Buat sebuah tombol Cancel untuk kemabli ke halaman awal / view data -->
				<div class="col-lg-12">
	                <section class="panel">
	                    <header class="panel-heading">
	                        Form Import Data Pribadi Pegawai
	                    </header>
	                    <div class="panel-body">
	                    	<!-- Buat sebuah tag form dan arahkan action nya ke file ini lagi -->
							<form method="post" action="" enctype="multipart/form-data">
								<a href="import/Format.xlsx" class="btn btn-primary">
									<span class="glyphicon glyphicon-download"></span>
									Download Format
								</a><br><br>

								<!--
								-- Buat sebuah input type file
								-- class pull-left berfungsi agar file input berada di sebelah kiri
								-->
								<input type="file" name="file" class="pull-left">

								<button type="submit" name="preview" class="btn btn-success btn-sm">
									<span class="glyphicon glyphicon-eye-open"></span> Preview
								</button>
							</form>

							<hr>	
							<!-- Buat Preview Data -->
							<?php
							// Jika user telah mengklik tombol Preview
							if(isset($_POST['preview'])){
								//$ip = ; // Ambil IP Address dari User
								$nama_file_baru = 'data.xlsx';

								// Cek apakah terdapat file data.xlsx pada folder tmp
								if(is_file('import/tmp/'.$nama_file_baru)) // Jika file tersebut ada
									unlink('import/tmp/'.$nama_file_baru); // Hapus file tersebut

								$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
								$tmp_file = $_FILES['file']['tmp_name'];

								// Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
								if($ext == "xlsx"){
									// Upload file yang dipilih ke folder tmp
									// dan rename file tersebut menjadi data{ip_address}.xlsx
									// {ip_address} diganti jadi ip address user yang ada di variabel $ip
									// Contoh nama file setelah di rename : data127.0.0.1.xlsx
									move_uploaded_file($tmp_file, 'import/tmp/'.$nama_file_baru);

									// Load librari PHPExcel nya
									require_once 'PHPExcel/PHPExcel.php';

									$excelreader = new PHPExcel_Reader_Excel2007();
									$loadexcel = $excelreader->load('import/tmp/'.$nama_file_baru); // Load file yang tadi diupload ke folder tmp
									$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

									// Buat sebuah tag form untuk proses import data ke database
									echo "<form method='post' action='$aksi?mod=pegawai&act=import'>";

									// Buat sebuah div untuk alert validasi kosong
									echo "<div class='alert alert-danger' id='kosong'>
									Ada <span id='jumlah_kosong'></span> data yang belum diisi.
									</div>";
									echo "<div class='table-responsive'>";
									echo "<table id='dtHorizontalVerticalExample' class='table table-striped table-bordered table-sm'>
									<thead>
									<tr>
										<th colspan='16' class='text-center'>Preview Data</th>
									</tr>
									<tr>
										<th>NIP</th>
										<th>Nama</th>
										<th>Panggilan</th>
										<th>Gelar</th>
										<th>Jabatan</th>
										<th>Jenis Kelamin</th>
										<th>Tempat Lahir</th>
										<th>Tanggal Lahir</th>
										<th>Menikah</th>
										<th>No. Identitas</th>
										<th>Alamat</th>
										<th>Handphone</th>
										<th>Email</th>
										<th>Keterangan</th>
									</tr>
									</thead>";

									$numrow = 1;
									$kosong = 0;
									foreach($sheet as $row){ // Lakukan perulangan dari data yang ada di excel
										// Ambil data pada excel sesuai Kolom
										$nip = $row['A']; // Ambil data NIS
										$nama = $row['B']; // Ambil data nama
										$panggilan = $row['C'];
										$gelar = $row['D'];
										$bagian = $row['E'];
										$jeniskelamin = $row['F']; // Ambil data jenis kelamin
										$tmplahir = $row['G'];
										$tgllahir = $row['H'];
										$nikah = $row['I'];
										$noid = $row['J'];
										$hp = $row['L']; // Ambil data telepon
										$alamat = $row['K']; // Ambil data alamat
										$email = $row['M'];
										$ket = $row['N']; // Ambil data alamat


										// Cek jika semua data tidak diisi
										if($nip == "" && $nama == "" && $panggilan == "" && $gelar == "" && $bagian == "" && $jeniskelamin == "" && $tmplahir == "" && $tgllahir == "" && $nikah == "" && $noid == "" && $hp == "" && $alamat == "" && $email == "" && $ket == "")
											continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

										// Cek $numrow apakah lebih dari 1
										// Artinya karena baris pertama adalah nama-nama kolom
										// Jadi dilewat saja, tidak usah diimport
										if($numrow > 1){
											// Validasi apakah semua data telah diisi
											$nip_td = ( ! empty($nip))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
											$nama_td = ( ! empty($nama))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
											$jk_td = ( ! empty($jeniskelamin))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
											$panggilan_td = ( ! empty($panggilan))? "" : " style='background: #E07171;'";
											$gelar_td = ( ! empty($gelar))? "" : " style='background: #E07171;'";
											$bagian_td = ( ! empty($bagian))? "" : " style='background: #E07171;'";
											$jabatan_td = ( ! empty($jabatan))? "" : " style='background: #E07171;'";
											$statuspegawai_td = ( ! empty($statuspegawai))? "" : " style='background: #E07171;'";
											$tmplahir_td = ( ! empty($tmplahir))? "" : " style='background: #E07171;'";
											$tgllahir_td = ( ! empty($tgllahir))? "" : " style='background: #E07171;'";
											$nikah_td = ( ! empty($nikah))? "" : " style='background: #E07171;'";
											$noid_td = ( ! empty($noid))? "" : " style='background: #E07171;'";
											$email_td = ( ! empty($email))? "" : " style='background: #E07171;'";
											$ket_td = ( ! empty($ket))? "" : " style='background: #E07171;'";
											$hp_td = ( ! empty($hp))? "" : " style='background: #E07171;'"; // Jika Telepon kosong, beri warna merah
											$alamat_td = ( ! empty($alamat))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah

											// Jika salah satu data ada yang kosong
											if($nip == "" or $nama == "" or $panggilan == "" or $gelar == "" or $bagian == "" or $jeniskelamin == "" or $tmplahir == "" or $tgllahir == "" or $nikah == "" or $noid == "" or $hp == "" or $alamat == "" or $email == "" or $ket == ""){
												$kosong++; // Tambah 1 variabel $kosong
											}
											echo "<tbody>";
											echo "<tr>";
											echo "<td".$nip_td.">".$nip."</td>";
											echo "<td".$nama_td.">".$nama."</td>";
											echo "<td".$panggilan_td.">".$panggilan."</td>";
											echo "<td".$gelar_td.">".$gelar."</td>";
											echo "<td".$bagian_td.">".$bagian."</td>";
											echo "<td".$jk_td.">".$jeniskelamin."</td>";
											echo "<td".$tmplahir_td.">".$tmplahir."</td>";
											echo "<td".$tgllahir_td.">".$tgllahir."</td>";
											echo "<td".$nikah_td.">".$nikah."</td>";
											echo "<td".$noid_td.">".$noid."</td>";
											echo "<td".$alamat_td.">".$alamat."</td>";
											echo "<td".$hp_td.">".$hp."</td>";
											echo "<td".$email_td.">".$email."</td>";
											echo "<td".$ket_td.">".$ket."</td>";
											echo "</tr>";
											echo "</tbody>";
										}

										$numrow++; // Tambah 1 setiap kali looping
									}

									echo "</table>";
									echo "</div>";
									// Cek apakah variabel kosong lebih dari 1
									// Jika lebih dari 1, berarti ada data yang masih kosong
									 // Jika semua data sudah diisi
										echo "<hr>";

										// Buat sebuah tombol untuk mengimport data ke database
										echo "<button type='submit' name='import' class='btn btn-primary'><span class='glyphicon glyphicon-upload'></span> Import</button>";
									

									echo "</form>";
								}else{ // Jika file yang diupload bukan File Excel 2007 (.xlsx)
									// Munculkan pesan validasi
									echo "<div class='alert alert-danger'>
									Hanya File Excel 2007 (.xlsx) yang diperbolehkan
									</div>";
								}
							}
							?>	
	                    </div>
	                </section>
	            </div>

				

				
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

