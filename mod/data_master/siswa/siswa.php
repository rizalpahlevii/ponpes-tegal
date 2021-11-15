<?php

	if(!isset($_SESSION['login_user'])){
		header('location: ../../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['siswa']) AND $_SESSION['siswa'] <> 'TRUE')
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
	$linkaksi = 'med.php?mod=siswa';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/data_master/siswa/act_siswa.php';

	?>
	<?php
	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=siswa&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM siswa WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=siswa");
				}

			}
			else
			{
				$act = "$aksi?mod=siswa&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">

				       <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>' enctype="multipart/form-data">
				            <div class="col-lg-12">
				                <section class="panel panel-danger">
				                    <header class="panel-heading ">
				                        Data Pribadi Santri
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            	<input type="hidden" name="img" value="<?php echo isset($c['foto']) ? $c['foto'] : '' ;?>">
				                            	<input type="hidden" name="pins" value="<?php echo isset($c['pinsiswa']) ? $c['pinsiswa'] : '' ;?>">
				                            	<input type="hidden" name="pino" value="<?php echo isset($c['pinortu']) ? $c['pinortu'] : '' ;?>">
				                            	<div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
			                                      <div class="col-lg-6">
			                                          <select name="idkelas" class="form-control round-input" style="width: 550px">
			                                              <?php
			                                                        $sql_kelas = mysqli_query($conn,"SELECT * FROM kelas");
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
			                                      <label class="col-lg-2 col-sm-2 control-label">Angkatan</label>
			                                      <div class="col-lg-6">
			                                          <select name="idangkatan" class="form-control round-input" style="width: 550px">
			                                              <?php
			                                                        $sql_angkatan = mysqli_query($conn,"SELECT * FROM tahunajaran");
			                                                while($k = mysqli_fetch_assoc($sql_angkatan))
			                                                {
			                                                  if(isset($c['idangkatan']) && $k['id'] == $c['idangkatan'])
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
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Tahun Masuk</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="tahunmasuk" class="form-control round-input" value="<?php echo isset($c['tahunmasuk']) ? $c['tahunmasuk'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">NIS</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="nis" class="form-control round-input" value="<?php echo isset($c['nis']) ? $c['nis'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">NISN</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="nisn" class="form-control round-input" value="<?php echo isset($c['nisn']) ? $c['nisn'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Nama</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="nama" class="form-control round-input" value="<?php echo isset($c['nama']) ? $c['nama'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Panggilan</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="panggilan" class="form-control round-input" value="<?php echo isset($c['panggilan']) ? $c['panggilan'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label class="col-lg-2 col-sm-2 control-label">Jenis Kelamin</label>
				                                <div class="col-lg-6">
				                                    <select class="form-control round-input" name="kelamin" style="width: 540px" id="source">
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
		                                                  if(isset($c['agama']) && $k['id'] == $c['agama'])
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
		                                      <label class="col-lg-2 col-sm-2 control-label">Status</label>
		                                      	<div class="col-lg-6">
		                                          	<select  name="status" class="form-control round-input" style="width: 550px">
		                                              <?php
		                                                        $sql_status = mysqli_query($conn,"SELECT * FROM statussiswa order by urutan");
		                                                while($k = mysqli_fetch_assoc($sql_status))
		                                                {
		                                                  if(isset($c['status']) && $k['id'] == $c['status'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[status]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[status]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
			                                    </div>
			                                </div>
			                                <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Kondisi</label>
		                                      	<div class="col-lg-6">
		                                          	<select  name="kondisi" class="form-control round-input" style="width: 550px">
		                                              <?php
		                                                        $sql_kondisi = mysqli_query($conn,"SELECT * FROM kondisisiswa");
		                                                while($k = mysqli_fetch_assoc($sql_kondisi))
		                                                {
		                                                  if(isset($c['kondisi']) && $k['id'] == $c['kondisi'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[kondisi]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[kondisi]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
			                                    </div>
			                                </div>
			                                <div class="form-group">
				                                <label class="col-lg-2 col-sm-2 control-label">Warga</label>
				                                <div class="col-lg-6">
				                                    <select class="form-control round-input" name="warga" style="width: 540px" id="source">
				                                    	<option value="<?php echo isset($c['warga']) ? $c['warga'] : 'Pilih Kewarganegaraan' ;?>"><?php echo isset($c['warga']) ? $c['warga'] : 'Pilih Kewarganegaraan' ;?></option>
			                                            <option value="WNI">WNI</option>
			                                            <option value="WNA">WNA</option>
				                                    </select>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label class="control-label col-lg-2 col-sm-2">Anak Ke - </label>
				                                <div class="col-lg-8">
				                                    <div class="input-group input-large" >
				                                        <input type="number" class="form-control round-input" value="<?php echo isset($c['anakke']) ? $c['anakke'] : '' ;?>" name="anakke">
				                                        <span class="input-group-addon">Dari</span>
				                                        <input type="number" class="form-control round-input" value="<?php echo isset($c['jsaudara']) ? $c['jsaudara'] : '' ;?>" name="jsaudara">
				                                    </div>
				                                </div>
				                                <div class="col-lg-2">
				                                	<label class="control-label col-lg-2 col-sm-2">Bersodara</label>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Bahasa</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="bahasa" class="form-control round-input" value="<?php echo isset($c['bahasa']) ? $c['bahasa'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group last">
				                                <label class="control-label col-md-2">Foto</label>
				                                <div class="col-md-10">
				                                    <div class="fileupload fileupload-new" data-provides="fileupload">
				                                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
				                                            <img src="<?php echo isset($c['foto']) ? 'images/siswa/'.$c['foto'] : 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image' ;?>" alt="" />
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
				                                <label class="control-label col-md-2">Alamat</label>
				                                <div class="col-md-10">
				                                    <textarea class="form-control" name="alamatsiswa" rows="5"><?php echo isset($c['alamatsiswa']) ? $c['alamatsiswa'] : '' ;?></textarea>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Kode Pos</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="kodepossiswa" class="form-control round-input" value="<?php echo isset($c['kodepossiswa']) ? $c['kodepossiswa'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Handphone</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="hpsiswa" class="form-control round-input" value="<?php echo isset($c['hpsiswa']) ? $c['hpsiswa'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email</label>
				                                <div class="col-lg-10">
				                                    <input type="email" name="emailsiswa" class="form-control round-input" value="<?php echo isset($c['emailsiswa']) ? $c['emailsiswa'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Asal Sekolah</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="asalsekolah" class="form-control round-input" value="<?php echo isset($c['asalsekolah']) ? $c['asalsekolah'] : '' ;?>" >
				                                </div>
				                            </div>
				                            
				                        </div>
				                    </div>
				                    <header class="panel-heading">
				                        Riwayat Kesehatan
				                    </header>
				                    <div class="panel-body">
				                    	<div class="position-center">
				                    		<div class="form-group">
				                                <label class="col-lg-2 col-sm-2 control-label">Gol. Darah</label>
				                                <div class="col-lg-6">
				                                    <select class="form-control round-input" name="darah" style="width: 540px" id="source">
				                                    	<option value="<?php echo isset($c['darah']) ? $c['darah'] : 'Pilih Jenis Gol. Darah' ;?>"><?php echo isset($c['darah']) ? $c['darah'] : 'Pilih Jenis Gol. Darah' ;?></option>
			                                            <option value="A">A</option>
			                                            <option value="AB">AB</option>
			                                            <option value="B">B</option>
			                                            <option value="O">O</option>
			                                            <option value="Tidak Tahu">Tidak Tahu</option>
				                                    </select>
				                                </div>
				                            </div>

						                    <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Berat</label>
				                                <div class="col-lg-8">
				                                    <input type="number" name="berat" class="form-control round-input" value="<?php echo isset($c['berat']) ? $c['berat'] : '' ;?>" >
				                                </div>
				                                <div class="col-lg-2">
				                                	<label class="control-label">Kg</label>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Tinggi</label>
				                                <div class="col-lg-8">
				                                    <input type="number" name="tinggi" class="form-control round-input" value="<?php echo isset($c['tinggi']) ? $c['tinggi'] : '' ;?>" >
				                                </div>
				                                <div class="col-lg-2">
				                                	<label class="control-label">Cm</label>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label class="control-label col-md-2">Riwayat Kesehatan</label>
				                                <div class="col-md-10">
				                                    <textarea class="form-control" name="kesehatan" rows="5"><?php echo isset($c['kesehatan']) ? $c['kesehatan'] : '' ;?></textarea>
				                                </div>
				                            </div>
				                        </div>
				                    </div>

				                    <header class="panel-heading">
				                        Data Orang Tua
				                    </header>
				                    <div class="panel-body">
				                    	<div class="position-center">
				                    		<div class="form-group">
				                    			<label class="col-lg-2"></label>
				                    			<label class="col-lg-5 text-center">AYAH</label>
				                    			<label class="col-lg-5 text-center">IBU</label>
				                    		</div>
				                    		<div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Nama</label>
				                                <div class="col-lg-5">
				                                    <input type="text" name="namaayah" class="form-control round-input" value="<?php echo isset($c['namaayah']) ? $c['namaayah'] : '' ;?>" >
				                                </div>
				                                <div class="col-lg-5">
				                                    <input type="text" name="namaibu" class="form-control round-input" value="<?php echo isset($c['namaibu']) ? $c['namaibu'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Pendidikan</label>
		                                      	<div class="col-lg-5">
		                                          	<select  name="pendidikanayah" class="form-control round-input" style="width: 250px">
		                                              <?php
		                                                        $sql_kondisi = mysqli_query($conn,"SELECT * FROM tingkatpendidikan order by urutan");
		                                                while($k = mysqli_fetch_assoc($sql_kondisi))
		                                                {
		                                                  if(isset($c['pendidikanayah']) && $k['id'] == $c['pendidikanayah'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[pendidikan]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[pendidikan]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
			                                    </div>
			                                    <div class="col-lg-5">
		                                          	<select  name="pendidikanibu" class="form-control round-input" style="width: 250px">
		                                              <?php
		                                                        $sql_kondisi = mysqli_query($conn,"SELECT * FROM tingkatpendidikan order by urutan");
		                                                while($k = mysqli_fetch_assoc($sql_kondisi))
		                                                {
		                                                  if(isset($c['penghasilanibu']) && $k['id'] == $c['penghasilanibu'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[pendidikan]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[pendidikan]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
			                                    </div>
			                                </div>
			                                <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Pekerjaan</label>
		                                      	<div class="col-lg-5">
		                                          	<select  name="pekerjaanayah" class="form-control round-input" style="width: 250px">
		                                              <?php
		                                                        $sql_kondisi = mysqli_query($conn,"SELECT * FROM jenispekerjaan order by urutan");
		                                                while($k = mysqli_fetch_assoc($sql_kondisi))
		                                                {
		                                                  if(isset($c['pekerjaanayah']) && $k['id'] == $c['pekerjaanayah'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[pekerjaan]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[pekerjaan]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
			                                    </div>
			                                    <div class="col-lg-5">
		                                          	<select  name="pekerjaanibu" class="form-control round-input" style="width: 250px">
		                                              <?php
		                                                        $sql_kondisi = mysqli_query($conn,"SELECT * FROM jenispekerjaan order by urutan");
		                                                while($k = mysqli_fetch_assoc($sql_kondisi))
		                                                {
		                                                  if(isset($c['pekerjaanibu']) && $k['id'] == $c['pekerjaanibu'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[pekerjaan]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[pekerjaan]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
			                                    </div>
			                                </div>
			                                <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Penghasilan</label>
				                                <div class="col-lg-5">
				                                    <input type="text"  name="penghasilanayah" class="form-control round-input" value="<?php echo isset($c['penghasilanayah']) ? $c['penghasilanayah'] : '' ;?>" >
				                                </div>
				                                <div class="col-lg-5">
				                                    <input type="text"  name="penghasilanibu" class="form-control round-input" value="<?php echo isset($c['penghasilanibu']) ? $c['penghasilanibu'] : '' ;?>" >
				                                </div>
				                            </div>
			                                <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email Orang Tua</label>
				                                <div class="col-lg-5">
				                                    <input type="email" name="emailayah" class="form-control round-input" value="<?php echo isset($c['emailayah']) ? $c['emailayah'] : '' ;?>" >
				                                </div>
				                                <div class="col-lg-5">
				                                    <input type="email" name="emailibu" class="form-control round-input" value="<?php echo isset($c['emailibu']) ? $c['emailibu'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Nama Wali</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="wali" class="form-control round-input" value="<?php echo isset($c['wali']) ? $c['wali'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label class="control-label col-md-2">Alamat Orang Tua</label>
				                                <div class="col-md-10">
				                                    <textarea class="form-control" name="alamatortu" rows="5"><?php echo isset($c['alamatortu']) ? $c['alamatortu'] : '' ;?></textarea>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Hp Orang Tua</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="hportu" class="form-control round-input" value="<?php echo isset($c['hportu']) ? $c['hportu'] : '' ;?>" >
				                                </div>
				                            </div>
				                    	</div>
				                    </div>
				                    <header class="panel-heading">
				                        Data Lainnya
				                    </header>
				                    <div class="panel-body">
				                    	<div class="position-center">
				                    		<div class="form-group">
				                                <label class="control-label col-md-2">Alamat Surat</label>
				                                <div class="col-md-10">
				                                    <textarea class="form-control" name="alamatsurat" rows="5"><?php echo isset($c['alamatsurat']) ? $c['alamatsurat'] : '' ;?></textarea>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label class="control-label col-md-2">Keterangan</label>
				                                <div class="col-md-10">
				                                    <textarea class="form-control" name="keterangan" rows="5"><?php echo isset($c['keterangan']) ? $c['keterangan'] : '' ;?></textarea>
				                                </div>
				                            </div>
				                            <?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='ortu'){?>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Pin Ortu</label>
				                                <div class="col-lg-10">
				                                    <input type="password" maxlength="8" name="pinortu" class="form-control round-input" value="<?php echo isset($c['pinortu']) ? $c['pinortu'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <?php }?>
				                            <?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='siswa'){?>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Pin Siswa</label>
				                                <div class="col-lg-10">
				                                    <input type="password" maxlength="8" name="pinsiswa" class="form-control round-input" value="<?php echo isset($c['pinsiswa']) ? $c['pinsiswa'] : '' ;?>" >
				                                </div>
				                            </div>
				                            <?php }?>
				                    	</div>
				                    </div>
				                    <?php
				                    if(empty($_GET['id']))
									{
									?>
									<?php
									}
				                    ?>
				                    <div class="form-group">
		                                <div class="col-lg-offset-2 col-lg-10">
							                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
							                <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
		                                </div>
		                            </div>
				                    <div class="panel-body">
				                    	<div class="position-center">
				                    		
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
		                        	<a href="med.php?mod=siswa&act=form">
									<button class="btn btn-primary">
										Tambah <i class="fa fa-plus"></i>
									</button>
									</a>
								<?php }?>
								
								<?php if($_SESSION['level']=='admin'){?>
		                        	<a href="med.php?mod=siswa&act=formimport">
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
							
		                        <div class="adv-table editable-table ">
		                            <div class="clearfix">
		                                <div class="btn-group">
		                                </div>
		                                <div class="btn-group pull-right">
		                                   
		                                </div>
		                            </div>
		                            <div class="space12"></div>
		                            <div class="table-responsive">
		                            <table class="table table-striped table-hover table-bordered" id="example">
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>
											<th class="text-center">Nis</th>
											<th class="text-center">Nisn</th>
		                                    <th class="text-center">Nama Santri</th>
											<th class="text-center">Kelas</th>
											<th class="text-center">Tempat, Tanggal Lahir</th>
											<?php if($_SESSION['level']=='admin' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas
														FROM siswa as s 
                                                        left join kelas k on s.idkelas = k.id
                                                        left join tahunajaran t on t.id = k.idtahunajaran
                                                        where s.alumni=0";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['nis']?></td>
		                                    <td align="center"><?php echo $m['nisn']?></td>
		                                    <td align="center"><?php echo $m['nama']?></td>
		                                    <td ><?php echo $m['kelas']?></td>
		                                    <td ><?php echo $m['tmplahir']?>, <?php echo $m['tgl']?> <?php echo NamaBulan($m['bln']) ?> <?php echo $m['thn']?></td>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> <?php if($_SESSION['level']=='admin' ){?>
		                                   		<a href="med.php?mod=siswa&act=detail&id=<?php echo $m['id'] ?>" ><button class="btn btn-info btn-sm"><i class="fa fa-search"></i></button> </a>
		                                        <a href="med.php?mod=siswa&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												<a href="<?php echo $aksi ?>?mod=siswa&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>


												
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
			if(isset($_GET['id']))
			{
				$sqltrans = mysqli_query($conn,"SELECT c.nis, c.nama, c.panggilan, c.tahunmasuk, c.idkelas, c.agama, b.status, a.kondisi, c.kelamin,
				   c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.tgllahir, c.warga,
				   c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa,
				   c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanayah ) as pendidikanayah
				   , (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanibu ) as pendidikanibu, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanayah) as pekerjaanayah, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanibu) as pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu,
				   c.alamatortu, c.hportu, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan, t.tahunajaran,
				   k.kelas, c.nisn, 
	               c.noijasah,c.tglijasah,c.tmplahirayah,c.tmplahiribu,c.tgllahirayah,c.tgllahiribu,c.hobi
			  FROM siswa c, kelas k, tahunajaran t, kondisisiswa a, statussiswa b
			 WHERE c.id='$_GET[id]' AND k.id = c.idkelas AND a.id = c.kondisi AND b.id = c.status AND k.idtahunajaran = t.id ") or die(mysqli_error());
				$tra = mysqli_fetch_assoc($sqltrans);

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
                       <div class="col-md-9">
                           <div class="profile-desk">
                               <h1>DATA SISWA <?php echo $tra['nama'] ?></h1>
                               <br>
                               <div class="table-responsive">
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
	                                <tr>
	                                    <td>NISN</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['nisn'] ?></td>
	                                </tr>
                               	</table>
                               </div>
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
                                    DATA PRIBADI SANTRI
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#dataorangtua">
                                   DATA ORANG TUA
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#lain" class="contact-map">
                                    KETERANGAN LAIN
                                </a>
                            </li>
                        </ul>
                    </header>
                    <div class="panel-body">
                        <div class="tab-content tasi-tab">
                            <div id="datasiswa" class="tab-pane active">
                                <div class="row">
                                    <div class="col-md-6 table-responsive">
                                        <table class="table table-striped">                               		
			                               	<tr>
			                                    <td >1.</td>
			                                    <td colspan="3">Nama Peserta Didik</td>
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
			                                    <td><?php echo $tra['tanggal']?> <?php echo NamaBulan($tra['bulan']) ?> <?php echo $tra['tahun']?></td>
			                                </tr>
			                                <tr>
			                                	<td>5.</td>
			                                    <td>Agama</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['agama'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>6.</td>
			                                    <td>Kewarganegaraan</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['warga'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>7.</td>
			                                    <td>Anak ke berapa</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['anakke'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>8.</td>
			                                    <td>Jumlah Saudara</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['jsaudara'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>9.</td>
			                                    <td>Kondisi Siswa</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['kondisi'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>10.</td>
			                                    <td>Status Siswa</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['status'] ?></td>
			                                </tr>
			                                

		                               	</table>
                                    </div>
                                    <div class="col-md-6 table-responsive">
                                        <table class="table table-striped">                               		
			                               	
			                                <tr>
			                                	<td>11.</td>
			                                    <td>Alamat</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['alamatsiswa'] ?>, Kodepos : <?php echo $tra['kodepossiswa'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>12.</td>
			                                    <td>Handphone</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['hpsiswa'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>13.</td>
			                                    <td>Email</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['emailsiswa'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>14.</td>
			                                    <td>Berat Badan</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['berat'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>15.</td>
			                                    <td>Tinggi Badan</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['tinggi'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>16.</td>
			                                    <td>Golongan Darah</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['darah'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>17.</td>
			                                    <td>Riwayat Penyakit</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['kesehatan'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>18.</td>
			                                    <td>Asal Sekolah</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['asalsekolah'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>19.</td>
			                                    <td>Keterangan</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['ketsekolah'] ?></td>
			                                </tr>

		                               	</table>
                                    </div>
                                </div>
                            </div>
                            <div id="dataorangtua" class="tab-pane ">
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped">  
                                        	<thead>
                                        		<th colspan="3">Orang Tua</th>
                                        		<th>Ayah</th>
                                        		<th>Ibu</th>
                                        	</thead> 
                                        	<tbody>
                                        		<tr>
				                                    <td width="20">1.</td>
				                                    <td>Nama </td>
				                                    <td width="10">:</td>
				                                    <td><?php echo $tra['namaayah'] ?></td>
				                                    <td><?php echo $tra['namaibu'] ?></td>
				                                </tr>
				                                <tr>
				                                    <td width="20">2.</td>
				                                    <td>Pendidikan </td>
				                                    <td width="10">:</td>
				                                    <td><?php echo $tra['pendidikanayah'] ?></td>
				                                    <td><?php echo $tra['pendidikanibu'] ?></td>
				                                </tr>
				                                <tr>
				                                    <td width="20">3.</td>
				                                    <td>Pekerjaan </td>
				                                    <td width="10">:</td>
				                                    <td><?php echo $tra['pekerjaanayah'] ?></td>
				                                    <td><?php echo $tra['pekerjaanibu'] ?></td>
				                                </tr>
				                                <tr>
				                                    <td width="20">4.</td>
				                                    <td>Penghasilan </td>
				                                    <td width="10">:</td>
				                                    <td>Rp. <?php echo number_format($tra['penghasilanayah']) ?></td>
				                                    <td>Rp. <?php echo number_format($tra['penghasilanibu']) ?></td>
				                                </tr>
				                                <tr>
				                                    <td width="20">5.</td>
				                                    <td>Email</td>
				                                    <td width="10">:</td>
				                                    <td><?php echo $tra['emailayah'] ?></td>
				                                    <td><?php echo $tra['emailibu'] ?></td>
				                                </tr>
				                                <tr>
				                                    <td width="20">6.</td>
				                                    <td>Nama Wali </td>
				                                    <td width="10">:</td>
				                                    <td colspan="2"><?php echo $tra['wali'] ?></td>
				                                </tr>
				                                <tr>
				                                    <td width="20">7.</td>
				                                    <td>Alamat </td>
				                                    <td width="10">:</td>
				                                    <td colspan="2"><?php echo $tra['alamatortu'] ?></td>
				                                </tr>
				                                <tr>
				                                    <td width="20">8.</td>
				                                    <td>Handphone</td>
				                                    <td width="10">:</td>
				                                    <td colspan="2"><?php echo $tra['hportu'] ?></td>
				                                </tr>
                                        	</tbody>                            		
			                               	
		                               	</table>
                                    </div>
                                </div>
                            </div>
                            <div id="lain" class="tab-pane ">
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped">     
			                                <tr>
			                                	<td>1.</td>
			                                    <td>Alamat Surat</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['alamatsurat'] ?></td>
			                                </tr>
			                                <tr>
			                                	<td>2.</td>
			                                    <td>Keterangan</td>
			                                    <td>:</td>
			                                    <td><?php echo $tra['keterangan'] ?></td>
			                                </tr>

			                            </table>
			                            <?php
		                                $qkls = mysqli_query($conn,"SELECT s.nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn,k.tingkat, k.kelas,k.idtahunajaran, t.tahunajaran 
														FROM siswa as s         
                                                        RIGHT JOIN `history` as h ON s.nis = h.nis
                                                        left join kelas k on h.idkelas = k.id
                                                        left join tahunajaran t on t.id = k.idtahunajaran 
                                                        WHERE h.`nis`='$tra[nis]'");
		                                if(mysqli_num_rows($qkls) > 0)
											{ 
			                                ?>
			                                <section class="panel panel-danger">
				                                <header class="panel-heading">
	                                				History Kelas
					                            </header>
					                            <div class="panel-body">
								                    <table class="table table-striped">  
						                                <?php
		                              					  $i=1;
						                                	while ($m = mysqli_fetch_assoc($qkls)) {
						                                		?>						                                		 
									                                <tr>
									                                    <td>Kelas <?php echo $m['tingkat'] ?></td>
									                                    <td>:</td>
									                                    <td><?php echo $m['kelas'] ?></td>
									                                </tr>
						                                		<?php
						 									 $i++;
						 								 }
						 								 ?>  
						                               
						                            </table>
						                        </div>
					                        </section>
					                        <?php

		 								 }
			 								 ?>
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
	                        Form Import Data Siswa
	                    </header>
	                    <div class="panel-body">
	                    	<!-- Buat sebuah tag form dan arahkan action nya ke file ini lagi -->
							<form method="post" action="" enctype="multipart/form-data">
								<a href="import/Formatsiswa.xlsx" class="btn btn-primary">
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
								$nama_file_baru = 'datasiswa.xlsx';

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
									echo "<form method='post' action='$aksi?mod=siswa&act=import'>";

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
										<th>NIS</th>
										<th>Nama</th>
										<th>Panggilan</th>
										<th>Tahun Masuk</th>
										<th>Jenis Kelamin</th>
										<th>Tempat Lahir</th>
										<th>Tanggal Lahir</th>
										<th>Alamat</th>
										<th>Handphone</th>
										<th>Email</th>
										<th>Asal Sekolah</th>
									</tr>
									</thead>";

									$numrow = 1;
									$kosong = 0;
									foreach($sheet as $row){ // Lakukan perulangan dari data yang ada di excel
										// Ambil data pada excel sesuai Kolom
										$nis = $row['A']; // Ambil data NIS
										$nama = $row['B']; // Ambil data nama
										$panggilan = $row['C'];
										$tahunajaran = $row['D'];
										$jeniskelamin = $row['E']; // Ambil data jenis kelamin
										$tmplahir = $row['F'];
										$tgllahir = $row['G'];
										$alamat = $row['H']; // Ambil data alamat
										$hp = $row['I']; // Ambil data telepon
										$email = $row['J'];
										$asal = $row['K']; // Ambil data alamat


										// Cek jika semua data tidak diisi
										if($nis == "" && $nama == "" && $panggilan == "" && $tahunajaran == "" && $jeniskelamin == "" && $tmplahir == "" && $tgllahir == "" && $hp == "" && $alamat == "" && $email == "" && $asal == "")
											continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

										// Cek $numrow apakah lebih dari 1
										// Artinya karena baris pertama adalah nama-nama kolom
										// Jadi dilewat saja, tidak usah diimport
										if($numrow > 1){
											// Validasi apakah semua data telah diisi
											$nis_td = ( ! empty($nis))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
											$nama_td = ( ! empty($nama))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
											$jk_td = ( ! empty($jeniskelamin))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
											$panggilan_td = ( ! empty($panggilan))? "" : " style='background: #E07171;'";
											$tahunajaran_td = ( ! empty($tahunajaran))? "" : " style='background: #E07171;'";
											$tmplahir_td = ( ! empty($tmplahir))? "" : " style='background: #E07171;'";
											$tgllahir_td = ( ! empty($tgllahir))? "" : " style='background: #E07171;'";
											$email_td = ( ! empty($email))? "" : " style='background: #E07171;'";
											$asal_td = ( ! empty($asal))? "" : " style='background: #E07171;'";
											$hp_td = ( ! empty($hp))? "" : " style='background: #E07171;'"; // Jika Telepon kosong, beri warna merah
											$alamat_td = ( ! empty($alamat))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah

											// Jika salah satu data ada yang kosong
											if($nis == "" or $nama == "" or $panggilan == "" or $tahunajaran == "" or $jeniskelamin == "" or $tmplahir == "" or $tgllahir == "" or $hp == "" or $alamat == "" or $email == "" or $asal == ""){
												$kosong++; // Tambah 1 variabel $kosong
											}
											echo "<tbody>";
											echo "<tr>";
											echo "<td".$nis_td.">".$nis."</td>";
											echo "<td".$nama_td.">".$nama."</td>";
											echo "<td".$panggilan_td.">".$panggilan."</td>";
											echo "<td".$tahunajaran_td.">".$tahunajaran."</td>";
											echo "<td".$jk_td.">".$jeniskelamin."</td>";
											echo "<td".$tmplahir_td.">".$tmplahir."</td>";
											echo "<td".$tgllahir_td.">".$tgllahir."</td>";
											echo "<td".$alamat_td.">".$alamat."</td>";
											echo "<td".$hp_td.">".$hp."</td>";
											echo "<td".$email_td.">".$email."</td>";
											echo "<td".$asal_td.">".$asal."</td>";
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

