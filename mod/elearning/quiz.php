<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['quiz']) AND $_SESSION['quiz'] <> 'TRUE')
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
	if ($_SESSION['level']=='admin') {
		$linkaksi = 'med.php?mod=quiz';		
	}else{
		$queryg = "SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
		FROM `guru` as a
		JOIN `pegawai` as b on a.nip = b.nip
		JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
		JOIN `statusguru` as d on d.`id` = a.`statusguru` 
		WHERE a.`nip` = '$_SESSION[login_user]'";
		$sql_g = mysqli_query($conn,$queryg);	
		$g = mysqli_fetch_assoc($sql_g);		
		$linkaksi = 'med2.php?mod=quiz';
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

	$aksi = 'mod/elearning/act_quiz.php';

	?>
	<?php
	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=quiz&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM topik_quiz WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med2.php?mod=quiz");
				}

			}
			else
			{
				$act = "$aksi?mod=quiz&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data topik quiz
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            	<input type="hidden" name="nip" value="<?php echo $_SESSION['id_user'] ?>">
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Judul</label>
				                                <div class="col-lg-8">
				                                    <input type="text" name="judul" class="form-control" value="<?php echo isset($c['judul']) ? $c['judul'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
		                                      <div class="col-lg-6">
		                                      	  <select multiple name="idkelas[]" id="e9" class="populatet" style="width: 210px">
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
		                                      <label class="col-lg-2 col-sm-2 control-label">Jenis Ujian</label>
		                                      <div class="col-lg-6">
		                                          <select name="idjenis" class="form-control">
		                                              <?php
		                                                        $sql_kelas = mysqli_query($conn,"SELECT * FROM jenisujian where idpelajaran='$g[idpelajaran]'");
		                                                while($k = mysqli_fetch_assoc($sql_kelas))
		                                                {
		                                                  if(isset($c['idjenis']) && $k['id'] == $c['idjenis'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[kode] - $k[jenisujian]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[kode] - $k[jenisujian]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          </select>
		                                      	</div>
		                                  	</div>
		                                  	<div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Semester</label>
		                                      <div class="col-lg-6">
		                                          <select name="idsemester" class="form-control">
		                                              <?php
		                                                        $sql_kelas = mysqli_query($conn,"SELECT * FROM semester ");
		                                                while($k = mysqli_fetch_assoc($sql_kelas))
		                                                {
		                                                  if(isset($c['idsemester']) && $k['id'] == $c['idsemester'])
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
		                                      <label class="col-lg-2 col-sm-2 control-label">Aspek Penilaian</label>
		                                      <div class="col-lg-6">
		                                          <select name="iddasarpenilaian" class="form-control" >
		                                              <?php
		                                                        $sql_kelas = mysqli_query($conn,"SELECT * FROM dasarpenilaian ");
		                                                while($k = mysqli_fetch_assoc($sql_kelas))
		                                                {
		                                                  if(isset($c['iddasarpenilaian']) && $k['id'] == $c['iddasarpenilaian'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[keterangan]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[keterangan]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          </select>
		                                      	</div>
		                                  	</div>
		                                  	<div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">quiz Pembelajaran</label>
		                                      <div class="col-lg-6">
		                                          <select name="idrpp" class="form-control">
		                                              <?php
		                                                        $sql_kelas = mysqli_query($conn,"SELECT * FROM rpp WHERE idpelajaran='$g[idpelajaran]' AND aktif='Aktif' ");
		                                                while($k = mysqli_fetch_assoc($sql_kelas))
		                                                {
		                                                  if(isset($c['idrpp']) && $k['id'] == $c['idrpp'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[rpp]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[rpp]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          </select>
		                                      	</div>
		                                  	</div>
		                                  	<div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Pelajaran</label>
			                                      <div class="col-lg-6">
			                                          <select name="idpelajaran" class="form-control">
			                                          	<?php if($_SESSION['level']=='guru'){
			                                          		$sql_pelajaran = mysqli_query($conn,"SELECT * FROM pelajaran where id='$g[idpelajaran]'");
			                                                while($k = mysqli_fetch_assoc($sql_pelajaran))
			                                                {
			                                                  if(isset($c['id']) && $k['id'] == $c['id'])
			                                                  {
			                                                    echo"<option value='$k[id]' selected>$k[kode] - $k[nama]</option>";  
			                                                  }
			                                                  else
			                                                  {
			                                                    echo"<option value='$k[id]'>$k[kode] - $k[nama]</option>";
			                                                  }
			                                                  
			                                                }
			                                          	}else{
			                                          		$sql_pelajaran = mysqli_query($conn,"SELECT * FROM pelajaran");
			                                                while($k = mysqli_fetch_assoc($sql_pelajaran))
			                                                {
			                                                  if(isset($c['id']) && $k['id'] == $c['id'])
			                                                  {
			                                                    echo"<option value='$k[id]' selected>$k[kode] - $k[nama]</option>";  
			                                                  }
			                                                  else
			                                                  {
			                                                    echo"<option value='$k[id]'>$k[kode] - $k[nama]</option>";
			                                                  }
			                                                  
			                                                }
			                                          	}
			                                          	?>

			                                              <?php
			                                                        
			                                                        ?>
			                                          </select>
			                                      </div>
			                                </div>
			                                <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Waktu Pengerjaan</label>
				                                <div class="col-lg-8">
				                                    <input type="number" name="pengerjaan" class="form-control" value="<?php echo isset($c['waktu_pengerjaan']) ? round($c['waktu_pengerjaan']/60) : '' ;?>" required>
				                                </div>
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Dalam Menit</label>
				                            </div>
				                            <div class="panel-body">
					                            <div class="form-group">
					                                <label class="control-label col-md-2">Info Quiz</label>
					                                <div class="col-md-10">
					                                    <textarea name="info" class="ckeditor form-control" rows="9"><?php echo isset($c['info']) ? $c['info'] : '' ;?></textarea>
					                                </div>
					                            </div>
						                    </div>
						                    <div class="form-group">
				                                <label class="col-lg-2 col-sm-2 control-label">Terbit</label>
				                                <div class="col-lg-6">
				                                    <select class="form-control" name="terbit" id="source">
				                                    	<option value="<?php echo isset($c['terbit']) ? $c['terbit'] : 'Pilih Status' ;?>"><?php echo isset($c['terbit']) ? $c['terbit'] : 'Pilih Status' ;?></option>
			                                            <option value="Y">Y</option>
			                                            <option value="N">N</option>
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
		                <section class="panel">
		                    <header class="panel-heading">
		                        <?php if($_SESSION['level']=='guru'){?>
		                        	<a href="med2.php?mod=quiz&act=form">
									<button class="btn btn-primary">
										Tambah <i class="fa fa-plus"></i>
									</button>
									</a>
								<?php } else{
								?>
								Data Quiz
								<?php
								}?>
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
		                                    <th class="text-center">Judul</th>
		                                    <th class="text-center">Kelas</th>
		                                    <th class="text-center">Pelajaran</th>
		                                    <th class="text-center">Lama Pengerjaan</th>
		                                    <th class="text-center">Info</th>
		                                    <th class="text-center">Tanggal Buat</th>
		                                    <th class="text-center">Pengapload</th>

											<?php if($_SESSION['level']=='siswa' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
											<?php if($_SESSION['level']=='guru' ){?>
		                                    <th class="text-center">Terbit</th>
		                                    <th class="text-center">Menu</th>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
		                                	if ($_SESSION['level']=='guru') {		                                		
												$query = "SELECT a.`id`, a.`judul`, a.`idkelas`, b.`kelas`, a.`idpelajaran`,c.`kode`, c.`nama` as pelajaran,a.`tgl_buat`, a.`pembuat`, d.`nama`, a.`waktu_pengerjaan`, a.`info`, a.`terbit`
													FROM `topik_quiz` as a
													JOIN `kelas` AS b ON a.`idkelas` = b.`id`
													JOIN `pelajaran` AS c on a.`idpelajaran` = c.`id`
													JOIN `pegawai` AS d on a.`pembuat` = d.`nip`
													WHERE d.`nip` = '$_SESSION[id_user]'
";
												$sql_kul = mysqli_query($conn,$query);
		                                	}elseif($_SESSION['level']=='siswa'){
		                                		$s="SELECT * FROM `siswa` WHERE `nis` = '$_SESSION[id_user]'";
												$sql_s = mysqli_query($conn,$s);
												$siswa = mysqli_fetch_assoc($sql_s);
		                                		$query = "SELECT a.`id`, a.`judul`, a.`idkelas`, b.`kelas`, a.`idpelajaran`,c.`kode`, c.`nama` as pelajaran, a.`tgl_buat`, a.`pembuat`, d.`nama`, a.`waktu_pengerjaan`, a.`info`, a.`terbit`
													FROM `topik_quiz`  as a
													JOIN `kelas` AS b ON a.`idkelas` = b.`id`
													JOIN `pelajaran` AS c on a.`idpelajaran` = c.`id`
													JOIN `pegawai` AS d on a.`pembuat` = d.`nip`
													WHERE b.`id` = '$siswa[idkelas]'
";
												$sql_kul = mysqli_query($conn,$query);

		                                	}else{
		                                		$query = "SELECT a.`id`, a.`judul`, a.`idkelas`, b.`kelas`, a.`idpelajaran`,c.`kode`, c.`nama` as pelajaran, a.`tgl_buat`, a.`pembuat`, d.`nama`, a.`waktu_pengerjaan`, a.`info`, a.`terbit`
													FROM `topik_quiz`  as a
													JOIN `kelas` AS b ON a.`idkelas` = b.`id`
													JOIN `pelajaran` AS c on a.`idpelajaran` = c.`id`
													JOIN `pegawai` AS d on a.`pembuat` = d.`nip`
";
												$sql_kul = mysqli_query($conn,$query);
		                                	}	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['judul']?></td>
		                                    <td align="center"><?php echo $m['kelas']?></td>
		                                    <td align="center"><?php echo $m['pelajaran']?></td>
		                                    <td align="center"><?php echo round($m['waktu_pengerjaan']/60) ?> Menit</td>
		                                    <td align="center"><?php echo $m['info']?></td>
		                                    <td align="center"><?php echo $m['tgl_buat']?></td>
		                                    <td align="center"><?php echo $m['nama']?></td>

		                                    <?php if($_SESSION['level']=='siswa' ){

												$soal = mysqli_query($conn,"SELECT * FROM quiz_pilganda where idquiz='$m[id]'");
												$pilganda = mysqli_num_rows($soal);
												$soal_esay = mysqli_query($conn,"SELECT * FROM quiz_esay WHERE idquiz='$m[id]'");
												$esay = mysqli_num_rows($soal_esay);
												if (empty($pilganda) AND empty($esay)){
													?>
													<td align="center"><button class="btn btn-default btn-sm">Belum Ada Soal</button></td>
													<?php
												}else{
													$cek = mysqli_query($conn,"SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq='$m[id]' AND id_siswa = '$_SESSION[id_user]'");
	        										$data = mysqli_fetch_array($cek);
			                                    	if ($data['hits']<=0) {
			                                    	?>
			                                    	<td align="center"><a href="soal.php?id=<?php echo $m['id'] ?>" ><button class="btn btn-primary btn-sm">Kerjakan Soal</button> </a></td>
			                                    	<?php
			                                    	}else{
			                                    	?>
			                                    	<td align="center"><a href="<?php echo $linkaksi ?>&act=show&id=<?php echo $m['id'] ?>" ><button class="btn btn-info btn-sm">Lihat Nilai</button> </a></td>
			                                    	<?php
			                                    	}
												}
												
		                                    ?>
		                                    <?php }?>
		                                    <?php if($_SESSION['level']=='guru' ){?>

		                                    <td align="center"><?php echo $m['terbit']?></td>
		                                    <td align="center">
		                                    	<a href="<?php echo $linkaksi ?>&act=data&id=<?php echo $m['id'] ?>" ><button class="btn btn-primary btn-sm">Daftar Soal</button> </a><br>
		                                    	<a href="<?php echo $linkaksi ?>&act=koreksi&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm">Peserta & Koreksi</button> </a>
		                                    	
		                                    </td>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>

		                                       <a href="<?php echo $linkaksi ?>&act=koreksi&id=<?php echo $m['id'] ?>" ><button class="btn btn-primary btn-sm">Koreksi</button> </a>							
		                                   --> 
		                                        <a href="<?php echo $linkaksi ?>&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												<a href="<?php echo $aksi ?>?mod=quiz&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

												
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
		case 'show':
			$s="SELECT * FROM `siswa` WHERE `nis` = '$_SESSION[id_user]'";
			$sql_s = mysqli_query($conn,$s);
			$siswa = mysqli_fetch_assoc($sql_s);
    		$query = "SELECT a.`id`, a.`judul`, a.`idkelas`, b.`kelas`, a.`idpelajaran`,c.`kode`, c.`nama` as pelajaran, a.`tgl_buat`, a.`pembuat`, d.`nama`, a.`waktu_pengerjaan`, a.`info`, a.`terbit`
				FROM `topik_quiz`  as a
				JOIN `kelas` AS b ON a.`idkelas` = b.`id`
				JOIN `pelajaran` AS c on a.`idpelajaran` = c.`id`
				JOIN `pegawai` AS d on a.`pembuat` = d.`nip`
				WHERE b.`id` = '$siswa[idkelas]' AND a.`id` = '$_GET[id]'
";
			$sql_kul = mysqli_query($conn,$query);
			$tra = mysqli_fetch_assoc($sql_kul);
			?>
			<div class="row">
	            <div class="col-md-12">
	                <section class="panel">
	                    <div class="panel-body profile-information">
	                       <div align="center" class="col-md-12">
	                       		<div class="tab-pane ">                
					                <div class="prf-contacts sttng">
					                    <h2>DATA NILAI QUIZ <b><?php echo $siswa['nama'] ?></b></h2>
					                </div>      
					            </div>
	                       </div>
	                       <div class="col-md-2">
	                               <div align="center" >
					           		<img src="images/ect/nilai.png" width="90%" alt=""/>
					            </div>
	                       </div>
	                       <div class="col-md-5">
	                           <div class="profile-desk">
	                               	<table class="table table-striped">                               		
		                               	<tr>
		                                    <td>Judul</td>
		                                    <td>:</td>
		                                    <td><?php echo $tra['judul'] ?></td>
		                                </tr>
		                                <tr>
		                                    <td>Kelas</td>
		                                    <td>:</td>
		                                    <td><?php echo $tra['kelas'] ?></td>
		                                </tr>		                                                            		
		                               	<tr>
		                                    <td>Guru</td>
		                                    <td>:</td>
		                                    <td><?php echo $tra['nama']?></td>
		                                </tr>
		                                <tr>
		                                    <td>Pelajaran</td>
		                                    <td>:</td>
		                                    <td><?php echo $tra['pelajaran'] ?></td>
		                                </tr>
		                               
	                               	</table>
	                           </div>
	                       </div>
	                       <?php
	                        $quiz_pilganda = mysqli_query($conn,"SELECT * FROM quiz_pilganda WHERE idquiz = '$_GET[id]'");
					        $quiz_esay = mysqli_query($conn,"SELECT * FROM quiz_esay WHERE idquiz = '$_GET[id]'");
					        $c_pilganda = mysqli_num_rows($quiz_pilganda);
					        $c_esay = mysqli_num_rows($quiz_esay);
	                       ?>
	                       <div class="col-md-5">
	                           <div class="profile-desk">
	                               	<table class="table table-striped">                               		
		                               	<tr>
		                                    <td>Lama Pengerjaan</td>
		                                    <td>:</td>
		                                    <td><?php echo round($tra['waktu_pengerjaan']/60) ?> Menit</td>
		                                </tr>
		                                <tr>
		                                    <td>Tanggal Terbit</td>
		                                    <td>:</td>
		                                    <td><?php echo tglindo($tra['tgl_buat']) ?></td>
		                                </tr>
		                                <?php

		                                	$pilganda = mysqli_query($conn,"SELECT * FROM nilai WHERE id_tq = '$_GET[id]' AND id_siswa = '$_SESSION[id_user]'");
									        $cek_pilganda = mysqli_num_rows($pilganda);
									        $esay = mysqli_query($conn,"SELECT * FROM nilai_soal_esay WHERE id_tq = '$_GET[id]' AND id_siswa = '$_SESSION[id_user]'");
									        $cek_esay = mysqli_num_rows($esay);
									        $n_pilganda = mysqli_fetch_array($pilganda);
                      						$n_esay = mysqli_fetch_array($esay);
		                                if (!empty($c_pilganda) AND !empty($c_esay)){

								                if (!empty($cek_pilganda) AND !empty($cek_esay)){
								                ?>
								                <tr>
				                                    <td>Nilai Pilihan Ganda</td>
				                                    <td>:</td>
				                                    <td><?php echo $n_pilganda['persentase'] ?></td>
				                                </tr>
				                                <tr>
				                                    <td>Nilai Essay</td>
				                                    <td>:</td>
				                                    <td><?php echo $n_esay['nilai'] ?></td>
				                                </tr>
				                                <tr>
				                                    <th>Nilai Akhir</th>
				                                    <th>:</th>
				                                    <th><?php echo ($n_pilganda['persentase'] + $n_esay['nilai'])/2 ?></th>
				                                </tr>
								                <?php
								                }
								                elseif (empty($cek_pilganda) AND !empty($cek_esay)){
								                ?>
								                <tr>
				                                    <td>Nilai Pilihan Ganda</td>
				                                    <td>:</td>
				                                    <td>Belum Mengerjakan</td>
				                                </tr>
				                                <tr>
				                                    <td>Nilai Essay</td>
				                                    <td>:</td>
				                                    <td><?php echo $n_esay['nilai'] ?></td>
				                                </tr>
								                <?php
								                }
								                elseif (!empty($cek_pilganda) AND empty($cek_esay)){
								                ?>
								                <tr>
				                                    <td>Nilai Pilihan Ganda</td>
				                                    <td>:</td>
				                                    <td><?php echo $n_pilganda['persentase'] ?></td>
				                                </tr>
				                                <tr>
				                                    <td>Nilai Essay</td>
				                                    <td>:</td>
				                                    <td>Belum Dikoreksi</td>
				                                </tr>
								                <?php
								                }
								                elseif (empty($cek_pilganda) AND empty($cek_esay)){
								                ?>
								                <tr>
				                                    <td>Nilai Pilihan Ganda</td>
				                                    <td>:</td>
				                                    <td>Anda Belum mengerjakan</td>
				                                </tr>
				                                <tr>
				                                    <td>Nilai Essay</td>
				                                    <td>:</td>
				                                    <td>Anda Belum mengerjakan</td>
				                                </tr>
								                <?php	
								                }
		                                }elseif (empty($c_pilganda) AND !empty($c_esay)){
		                                	if (!empty($cek_esay)){
		                                	?>
			                                <tr>
			                                    <td>Nilai Essay/Nilai Akhir</td>
			                                    <td>:</td>
			                                    <td><?php echo $n_esay['nilai'] ?></td>
			                                </tr>
							                <?php
		                                	}elseif (empty($cek_esay)) {
		                                		$kerjakan = mysqli_query($conn,"SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq='$_GET[id]' AND id_siswa = '$_SESSION[id_user]'");
                    							$c_kerjakan = mysqli_num_rows($kerjakan);
                    							if (!empty($c_kerjakan)){
							                        $cek_kerjakan = mysqli_fetch_array($kerjakan);
							                        if ($cek_kerjakan['dikoreksi']=='B'){
							                       	?>
							                       	<tr>
					                                    <td>Nilai Essay</td>
					                                    <td>:</td>
					                                    <td>Belum Dikoreksi</td>
					                                </tr>
							                       	<?php
							                        }elseif (empty($c_kerjakan)){
							                        ?>
							                        <tr>
					                                    <td>Nilai Essay</td>
					                                    <td>:</td>
					                                    <td>Anda Belum mengerjakan</td>
					                                </tr>
							                        <?php
							                        }
							                    }
							                 }
		                                }elseif (!empty($c_pilganda) AND empty($c_esay)){
		                                	if (!empty($cek_pilganda)){
		                                		 ?>
								                <tr>
				                                    <td>Nilai Pilihan Ganda/Nilai Akhir</td>
				                                    <td>:</td>
				                                    <td><?php echo $n_pilganda['persentase'] ?></td>
				                                </tr>
				                                <?php
		                                	}else{
		                                		?>
						                        <tr>
				                                    <td>Nilai Pilihan Ganda</td>
				                                    <td>:</td>
				                                    <td>Anda Belum mengerjakan</td>
				                                </tr>
						                        <?php
		                                	}
		                                }elseif (!empty($c_pilganda) AND !empty($c_esay)){
								            flash('example_message', 'Belum ada Nilai di tugas/quiz ini.' );
											echo"<script>
												window.history.back();
											</script>";	
								        }
		                                ?>
		                                
	                               	</table>
	                           </div>
	                       </div>
	                    </div>
	                </section>
	            </div>
	        </div>
			<?php
			break;
		case 'data':
		if(isset($_GET['id']))
			{
				$sqltrans = mysqli_query($conn,"SELECT q.`id`, q.`judul`, q.`idkelas`, k.`kelas`, q.`idjenis`, j.`jenisujian`, q.`idsemester`, s.`semester`, q.`iddasarpenilaian`,dp.`keterangan` as dasarpenilaian, q.`idrpp`, r.`rpp`, q.`tgl_buat`, q.`waktu_pengerjaan`, q.`info`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
								FROM `topik_quiz` as q
								JOIN `pegawai` as b on b.nip = q.pembuat
								JOIN `pelajaran` as c on q.`idpelajaran` = c.`id`
                                JOIN `guru` as a on a.`nip` = b.`nip`
                                JOIN `kelas` as k on q.`idkelas` = k.`id`
                                JOIN `jenisujian` as j on j.`id` = q.`idjenis`
                                JOIN `semester` as s on s.`id` = q.`idsemester`
                                JOIN `dasarpenilaian` as dp on q.`iddasarpenilaian` = dp.`id`
                                JOIN `rpp` as r on q.`idrpp` = r.`id`
								JOIN `statusguru` as d on d.`id` = a.`statusguru` WHERE a.`nip` = '$_SESSION[id_user]' AND q.`id` = '$_GET[id]'") or die(mysqli_error());
				$tra = mysqli_fetch_assoc($sqltrans);

		?>
		<div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body profile-information">
                       <div align="center" class="col-md-12">
                       		<div class="tab-pane ">                
				                <div class="prf-contacts sttng">
				                    <h2>DATA QUIZ</h2>
				                </div>      
				            </div>
                       </div>
                       <div class="col-md-2">
                               <div align="center" >
				           		<img src="images/ect/nilai.png" width="90%" alt=""/>
				            </div>
                       </div>
                       <div class="col-md-5">
                           <div class="profile-desk">
                               	<table class="table table-striped">                               		
	                               	<tr>
	                                    <td>Judul</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['judul'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Kelas</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['kelas'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Semester</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['semester'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Pelajaran</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['pelajaran'] ?></td>
	                                </tr>
                               	</table>
                           </div>
                       </div>
                       <div class="col-md-5">
                           <div class="profile-desk">
                               	<table class="table table-striped">                               		
	                               	<tr>
	                                    <td>Jenis Pengujian</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['jenisujian'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Aspek Penilaian</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['dasarpenilaian'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Program Pembelajaran</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['rpp'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Durasi</td>
	                                    <td>:</td>
	                                    <td><?php echo round($tra['waktu_pengerjaan']/60) ?> Menit</td>
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
                                    DATA QUIZ ESSAY
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#dataorangtua">
                                   DATA QUIZ PILIHAN GANDA
                                </a>
                            </li>
                        </ul>
                    </header>
                    <div class="panel-body">
                        <div class="tab-content tasi-tab">
                            <div id="datasiswa" class="tab-pane active">
                                <div class="row">
                                    <div class="col-sm-12">
						                <section class="panel">
						                    <header class="panel-heading">
					                        	<a href="med2.php?mod=quiz&act=qesay&esay=<?php echo $tra['id'] ?>">
												<button class="btn btn-primary">
													Tambah <i class="fa fa-plus"></i>
												</button>
												</a>
												
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
						                                    <th class="text-center">Pertanyaan</th>
						                                    <th class="text-center">Gambar</th>
															<th class="text-center">Tanggal Dibuat</th>
															<?php if($_SESSION['level']=='admin' or $_SESSION['level']=='guru'){?>
						                                    <th class="text-center">Aksi</th>
															<?php }?>
														</tr>
						                                </thead>
						                                <tbody>
						                                <?php
						                                		$query = "SELECT * FROM `quiz_esay` WHERE `idquiz` = '$tra[id]'";
															$sql_kul = mysqli_query($conn,$query);	
															
															$i=1;
															while ($m = mysqli_fetch_assoc($sql_kul)) {
														?>
						                                <tr class="">
						                                    <td width="" align="center"><?php echo $i ?></td>
						                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
						                                    <td width="35%"><?php echo $m['pertanyaan']?></td>
						                                    <?php
						                                    if ($m['gambar']!=="") {
						                                    ?>
						                                    <td width="" align="center"><img width="20%" src="images/elearning/<?php echo $m['gambar']?>"></td>
						                                    <?php	
						                                    }else{
						                                    ?>
						                                    <td align="center"></td>
						                                    <?php
						                                    }
						                                    ?>
						                                    
						                                    <td width="15%" align="center"><?php echo tglindo($m['tgl_buat']) ?></td>				
						                                   <?php if($_SESSION['level']=='admin' or $_SESSION['level']=='guru'){?>
						                                   	<td width="10%" align="center">
						                                        <a href="med.php?mod=quiz&act=qesay&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
																<a href="<?php echo $aksi ?>?mod=quiz&act=hapusesay&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

																
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
                            <div id="dataorangtua" class="tab-pane ">
                                <div class="row">
                                    <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">
		                        <a href="med2.php?mod=quiz&act=qpilgan&esay=<?php echo $tra['id'] ?>">
								<button class="btn btn-primary">
									Tambah <i class="fa fa-plus"></i>
								</button>
								</a>
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
		                            <table class="table table-striped table-hover table-bordered" id="examplex">
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>		                                   
						                    <th class="text-center">Pertanyaan</th>
		                                    <th class="text-center">Gambar</th>
											<th class="text-center">A</th>
											<th class="text-center">B</th>
											<th class="text-center">C</th>
											<th class="text-center">D</th>
											<th class="text-center">Kunci Jawaban</th>
											<th class="text-center">Tanggal Buat</th>
											<?php if($_SESSION['level']=='admin' or $_SESSION['level']=='guru'){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
		                                	$query = "SELECT * FROM `quiz_pilganda` WHERE `idquiz` = '$tra[id]'";
											$sql_kul = mysqli_query($conn,$query);	
											
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td width="" align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td width="35%"><?php echo $m['pertanyaan']?></td>
		                                    <?php
		                                    if ($m['gambar']!=="") {
		                                    ?>
		                                    <td width="" align="center"><img width="50%" src="images/elearning/<?php echo $m['gambar']?>"></td>
		                                    <?php	
		                                    }else{
		                                    ?>
		                                    <td align="center"></td>
		                                    <?php
		                                    }
		                                    ?>
		                                    <td width="" align="center"><?php echo $m['pil_a']?></td>
		                                    <td width="" align="center"><?php echo $m['pil_b']?></td>
		                                    <td width="" align="center"><?php echo $m['pil_c']?></td>
		                                    <td width="" align="center"><?php echo $m['pil_d']?></td>
		                                    <td width="" align="center"><?php echo $m['kunci']?></td>
		                                    <td width="15%" align="center"><?php echo tglindo($m['tgl_buat'])?></td>
											
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> <?php if($_SESSION['level']=='admin' or $_SESSION['level']=='guru'){?>
		                                   	<td width="10%" align="center">
		                                        <a href="med2.php?mod=quiz&act=qpilgan&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												<a href="<?php echo $aksi ?>?mod=quiz&act=hapuspilgan&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

												
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
                        </div>
                    </div>
                </section>
            </div>
        </div>
		<?php
			}
		break;
		case 'koreksi':

		flash('example_message');
		if(isset($_GET['id']))
			{
				$sqltrans = mysqli_query($conn,"SELECT q.`id`, q.`judul`, q.`idkelas`, k.`kelas`, q.`idjenis`, j.`jenisujian`, q.`idsemester`, s.`semester`, q.`iddasarpenilaian`,dp.`keterangan` as dasarpenilaian, q.`idrpp`, r.`rpp`, q.`tgl_buat`, q.`waktu_pengerjaan`, q.`info`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
								FROM `topik_quiz` as q
								JOIN `pegawai` as b on b.nip = q.pembuat
								JOIN `pelajaran` as c on q.`idpelajaran` = c.`id`
                                JOIN `guru` as a on a.`nip` = b.`nip`
                                JOIN `kelas` as k on q.`idkelas` = k.`id`
                                JOIN `jenisujian` as j on j.`id` = q.`idjenis`
                                JOIN `semester` as s on s.`id` = q.`idsemester`
                                JOIN `dasarpenilaian` as dp on q.`iddasarpenilaian` = dp.`id`
                                JOIN `rpp` as r on q.`idrpp` = r.`id`
								JOIN `statusguru` as d on d.`id` = a.`statusguru` WHERE a.`nip` = '$_SESSION[id_user]'") or die(mysqli_error());
				$tra = mysqli_fetch_assoc($sqltrans);


				$siswa_yangmengerjakan = mysqli_query($conn,"SELECT id_siswa FROM siswa_sudah_mengerjakan WHERE id_tq = '$_GET[id]'");
		        $cek_siswa = mysqli_num_rows($siswa_yangmengerjakan);

		        $soal_pilganda = mysqli_query($conn,"SELECT * FROM quiz_pilganda WHERE idquiz='$_GET[id]'");
		        $pilganda = mysqli_num_rows($soal_pilganda);
		        $soal_esay = mysqli_query($conn,"SELECT * FROM quiz_esay WHERE idquiz='$_GET[id]'");
		        $esay = mysqli_num_rows($soal_esay);
		?>
		<div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body profile-information">
                       <div align="center" class="col-md-12">
                       		<div class="tab-pane ">                
				                <div class="prf-contacts sttng">
				                    <h2>DATA PESERTA QUIZ</h2>
				                </div>      
				            </div>
                       </div>
                       <div class="col-md-2">
                               <div align="center" >
				           		<img src="images/ect/nilai.png" width="90%" alt=""/>
				            </div>
                       </div>
                       <div class="col-md-5">
                           <div class="profile-desk">
                               	<table class="table table-striped">                               		
	                               	<tr>
	                                    <td>Judul</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['judul'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Kelas</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['kelas'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Semester</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['semester'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Pelajaran</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['pelajaran'] ?></td>
	                                </tr>
                               	</table>
                           </div>
                       </div>
                       <div class="col-md-5">
                           <div class="profile-desk">
                               	<table class="table table-striped">                               		
	                               	<tr>
	                                    <td>Jenis Pengujian</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['jenisujian'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Aspek Penilaian</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['dasarpenilaian'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Program Pembelajaran</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['rpp'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Durasi</td>
	                                    <td>:</td>
	                                    <td><?php echo round($tra['waktu_pengerjaan']/60) ?> Menit</td>
	                                </tr>
                               	</table>
                           </div>
                       </div>
                    </div>
                </section>
            </div>
            <div class="col-md-12">
            	<section class="panel">
                    <header class="panel-heading">
                        Siswa yang telah mengikuti ujian
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>
                    <div class="panel-body table-responsive">
                        <section id="flip-scroll">
                            <table class="table table-bordered table-striped table-condensed cf" id="example">
                                <thead class="cf">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">NIS</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center" class="numeric">Kelas</th>
                                    <th class="text-center" class="numeric">Status</th>
                                    <th class="text-center" class="numeric">Score</th>
                                    <th class="text-center" class="numeric">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no=1;
		        				$siswa_yangmengerjakan2 = mysqli_query($conn,"SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq = '$_GET[id]'");
						        while ($t=mysqli_fetch_array($siswa_yangmengerjakan2)){
						            $siswa = mysqli_query($conn,"SELECT * FROM siswa WHERE nis = '$t[id_siswa]'");
						            $s = mysqli_fetch_array($siswa);
						            $kelas = mysqli_query($conn,"SELECT * FROM kelas WHERE id = '$s[idkelas]'");
						            $k = mysqli_fetch_array($kelas);
						            $nilai = mysqli_query($conn,"SELECT * FROM nilai_soal_esay WHERE id_tq='$_GET[id]' AND id_siswa ='$t[id_siswa]'");
						            $n = mysqli_fetch_array($nilai);
						            $nilai2 = mysqli_query($conn,"SELECT * FROM nilai WHERE id_tq='$_GET[id]' AND id_siswa = '$t[id_siswa]'");
						            $n2 = mysqli_fetch_array($nilai2);
                                ?>
                                <tr>
                                    <td align="center"><?php echo $no ?></td>
                                    <td align="center"><?php echo $s['nis'] ?></td>
                                    <td><?php echo $s['nama'] ?></td>
                                    <td align="center" class="numeric"><?php echo $k['kelas'] ?></td>
                                    <?php
                                    if (!empty($pilganda) AND !empty($esay)){
                                    	if ($t['dikoreksi']=='B'){
				                          ?>				                          
		                                    <td class="numeric">
		                                    	Jawaban soal essay <b>belum di koreksi</b>
				                                <br>Nilai Tugas/Quiz Pilihan Ganda : <?php echo $n2['persentase'] ?>
		                                    </td>
		                                    <td align="center">
		                                    	<?php
		                                    	echo $n2['persentase'];
		                                    	?>
		                                    </td>
		                                    <td align="center" class="numeric">
												<a href="<?php echo $aksi ?>?mod=quiz&act=hapussiswa&id=<?php echo $t['id'] ?>&nis=<?php echo $s['nis'] ?>&id_tq=<?php echo $_GET['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Hapus</button> </a>
				                          		<a href="<?php echo $linkaksi ?>&act=nilai&id=<?php echo $t['id_tq'] ?>&nis=<?php echo $s['nis'] ?>"><button class="btn btn-warning btn-sm"><i class="fa fa-check"></i> Koreksi Jawaban Esay</button></a>
		                                    </td>
				                          <?php
				                      }else{
				                          ?>				                          
		                                    <td class="numeric">
		                                    	Nilai Tugas/Quiz Essay: <?php echo $n['nilai']?>
				                                <br>Nilai Tugas/Quiz Pilihan Ganda : <?php echo $n2['persentase'] ?>
		                                    </td>
		                                    <td align="center">
		                                    	<?php
		                                    	echo ($n['nilai']+$n2['persentase'])/2;
		                                    	?>
		                                    </td>
		                                    <td align="center" class="numeric">
												<a href="<?php echo $aksi ?>?mod=quiz&act=hapussiswa&id=<?php echo $t['id'] ?>&nis=<?php echo $s['nis'] ?>&id_tq=<?php echo $_GET['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i>Hapus</button> </a>
				                          		<a href="<?php echo $linkaksi ?>&act=nilai&id=<?php echo $t['id_tq'] ?>&nis=<?php echo $s['nis'] ?>&idn=<?php echo $n['id'] ?>"><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Koreksi Jawaban Esay</button></a>
		                                    </td>
				                          <?php
				                      }
                                    }elseif (empty($pilganda) AND !empty($esay)){
                                    	if ($t['dikoreksi']=='B'){
					                          ?>				                          
			                                    <td class="numeric">
			                                    	Jawaban soal essay <b>belum di koreksi</b>
			                                    </td>
			                                    <td align="center">0</td>
			                                    <td align="center" class="numeric">
													<a href="<?php echo $aksi ?>?mod=quiz&act=hapussiswa&id=<?php echo $t['id'] ?>&nis=<?php echo $s['nis'] ?>&id_tq=<?php echo $_GET['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i>Hapus</button> </a>
					                          		<a href="<?php echo $linkaksi ?>&act=nilai&id=<?php echo $t['id_tq'] ?>&nis=<?php echo $s['nis'] ?>"><button class="btn btn-warning btn-sm"><i class="fa fa-check"></i> Koreksi Jawaban Esay</button></a>
			                                    </td>
					                          <?php
					                      }else{
						                      ?>				                          
			                                    <td class="numeric">
			                                    	Nilai Tugas/Quiz Essay: <?php echo $n['nilai']?>
			                                    </td>
			                                    <td align="center"><?php echo $n['nilai']?></td>
			                                    <td align="center" class="numeric">
													<a href="<?php echo $aksi ?>?mod=quiz&act=hapussiswa&id=<?php echo $t['id'] ?>&nis=<?php echo $s['nis'] ?>&id_tq=<?php echo $_GET['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>
													<a href="<?php echo $linkaksi ?>&act=nilai&id=<?php echo $t['id_tq'] ?>&nis=<?php echo $s['nis'] ?>&idn=<?php echo $n['id'] ?>"><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Koreksi Jawaban Esay</button></a>
			                                    </td>
			                                  <?php
					                      }
                                    }elseif (!empty($pilganda) AND empty($esay)){
                                    	if ($t['dikoreksi']=='B'){
                                    		  ?>				                          
			                                    <td class="numeric">
					                                Nilai Tugas/Quiz Pilihan Ganda : <?php echo $n2['persentase'] ?>
			                                    </td>
			                                    <td align="center"><?php echo $n2['persentase'] ?></td>
			                                    <td align="center" class="numeric">
													<a href="<?php echo $aksi ?>?mod=quiz&act=hapussiswa&id=<?php echo $t['id'] ?>&nis=<?php echo $s['nis'] ?>&id_tq=<?php echo $_GET['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>
			                                    </td>
					                          <?php
					                      }else{
					                      		?>				                          
			                                    <td class="numeric">
					                                Nilai Tugas/Quiz Pilihan Ganda : <?php echo $n2['persentase'] ?>
			                                    </td>			                                    
			                                    <td align="center"><?php echo $n2['persentase'] ?></td>
			                                    <td align="center" class="numeric">
													<a href="<?php echo $aksi ?>?mod=quiz&act=hapussiswa&id=<?php echo $t['id'] ?>&nis=<?php echo $s['nis'] ?>&id_tq=<?php echo $_GET['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>
			                                    </td>
					                          <?php
					                      }
                                    }
                                    ?>
                                </tr>
                                <?php
                                $no++;
        						}
                                ?>
                                </tbody>
                            </table>
                        </section>
                    </div>
                </section>
            </div>
        </div>
		<?php
			}
		break;
		case 'nilai':
			if(!empty($_GET['idn']))
			{
				$act = "$aksi?mod=quiz&act=editnilai";
				$query = mysqli_query($conn,"SELECT * FROM nilai_soal_esay WHERE id = '$_GET[idn]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=quiz");
				}

			}
			else
			{
				$act = "$aksi?mod=quiz&act=simpannilai";
			}

		?>
		<div class="col-lg-12">
	        <section class="panel">
	            <header class="panel-heading">
	            	<?php
	            		$siswa = mysqli_query($conn,"SELECT * FROM siswa WHERE nis='$_GET[nis]'");
			            $s = mysqli_fetch_array($siswa);
			            $jawaban = mysqli_query($conn,"SELECT * FROM jawaban WHERE id_tq='$_GET[id]' AND id_siswa='$_GET[nis]'");
			            $cek=mysqli_num_rows($jawaban);
	            	?>
	            	<div align="center">
	                	Jawaban Soal Essay Siswa <b><?php echo $s['nama'] ?></b>	            		
	            	</div>
	            </header>
	            <div class="panel-body">
	                <form action="<?php echo $act ?>" class="form-horizontal bucket-form" method="POST">
	                	<?php	                	
			            if (!empty($cek)){
			                $no=1;
			                while ($j=mysqli_fetch_array($jawaban)){
			                    $soal_esay2 = mysqli_query($conn,"SELECT * FROM quiz_esay WHERE idquiz='$j[id_tq]' AND id='$j[id_quiz]'");
			                    $quiz = mysqli_fetch_array($soal_esay2);
			                            if (!empty($quiz['gambar'])){
		                            	?>
					                    <div class="form-group">
					                        <label class="col-sm-3 control-label"><?php echo $no ?>. </label>
					                        <div class="col-lg-8">
					                            <div class="row">
					                                <div align="center"  class="col-lg-2">					                                	
					                                    <img class="img-responsive" src="images/elearning/<?php echo $quiz['gambar']?>">
					                                </div>
					                                <div class="col-lg-6">					       
					                                    <p class="form-control-static">Pertanyaan :</p>                             
					                           			<p class="form-control-static"><?php echo $quiz['pertanyaan'] ?></p>
					                                    <p class="form-control-static">Jawaban : </p>                             
					                           			<p class="form-control-static"><?php echo $j['jawaban'] ?></p>
					                                </div>
					                            </div>

					                        </div>
					                    </div>
		                            	<?php
			                            }
			                            else{
			                            ?>
			                            <div class="form-group">
					                        <label class="col-sm-3 control-label"><?php echo $no ?>. </label>
					                        <div class="col-lg-8">
					                            <p class="form-control-static">Pertanyaan :</p>                             
			                           			<p class="form-control-static"><?php echo $quiz['pertanyaan'] ?></p>
			                                    <p class="form-control-static">Jawaban : </p>                             
			                           			<p class="form-control-static"><?php echo $j['jawaban'] ?></p>

					                        </div>
					                    </div>
			                            <?php
			                            }
			                    $no++;
			                }
			                $jum = $no - 1;
			                    echo "<input type=hidden name=jumlah_soal value='$jum'>
			                          <input type=hidden name=id_topik value='$_GET[id]'>

			                          <input type=hidden name=id_siswa value='$_GET[nis]'>";
			                     ?>
			                     <div class="form-group">
			                        <label class="col-sm-3 control-label">Nilai</label>
			                        <div class="col-sm-6">
			                            <input type="number" value="<?php echo isset($c['nilai']) ? $c['nilai'] : '' ;?>" name="nilai" class="form-control">
			                        </div>
			                    </div>
			                    <div class="form-group">
		                            <div class="col-lg-offset-3 col-lg-10">
						                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
						                <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
		                            </div>
		                        </div>
			                     <?php
			            }else{
			            	flash('example_message', 'Jawaban Siswa Kosong.' );
			                 echo "<script>window.history.back();</script>";
			            }
			        
	                	?>
	                    
	                </form>
	            </div>
	        </section>
	    </div>
		<?php	
		break;
		case 'qesay':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=quiz&act=editesay";
				$query = mysqli_query($conn,"SELECT * FROM `quiz_esay` WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med2.php?mod=quiz");
				}

			}
			else
			{
				$act = "$aksi?mod=quiz&act=simpanesay";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data quiz
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>' enctype="multipart/form-data">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            	<input type="hidden" name="idquiz" value="<?php echo $_GET['esay'] ;?>">
				                            	<input type="hidden" name="gambar" value="<?php echo isset($c['gambar']) ? $c['gambar'] : '' ;?>">
				                            <div class="panel-body">
					                            <div class="form-group">
					                                <label class="control-label col-md-2">Pertanyaan</label>
					                                <div class="col-md-10">
					                                    <textarea name="pertanyaan" class="ckeditor form-control" rows="9"><?php echo isset($c['pertanyaan']) ? $c['pertanyaan'] : '' ;?></textarea>
					                                </div>
					                            </div>
						                    </div>
				                            <div class="form-group last">
				                                <label class="control-label col-md-2">Gambar</label>
				                                <div class="col-md-10">
				                                    <div class="fileupload fileupload-new" data-provides="fileupload">
				                                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
				                                            <img src="<?php echo isset($c['gambar']) ? 'images/elearning/'.$c['gambar'] : 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image' ;?>" alt="" />
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
		case 'qpilgan':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=quiz&act=editpilgan";
				$query = mysqli_query($conn,"SELECT * FROM `quiz_pilganda` WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=quiz");
				}

			}
			else
			{
				$act = "$aksi?mod=quiz&act=simpanpilgan";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data quiz
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>' enctype="multipart/form-data">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            	<input type="hidden" name="idquiz" value="<?php echo $_GET['esay'] ;?>">
				                            	<input type="hidden" name="gambar" value="<?php echo isset($c['gambar']) ? $c['gambar'] : '' ;?>">
				                            <div class="panel-body">
					                            <div class="form-group">
					                                <label class="control-label col-md-2">Pertanyaan</label>
					                                <div class="col-md-10">
					                                    <textarea name="pertanyaan" class="ckeditor form-control" rows="9"><?php echo isset($c['pertanyaan']) ? $c['pertanyaan'] : '' ;?></textarea>
					                                </div>
					                            </div>
						                    </div>
						                    <div class="panel-body">
					                            <div class="form-group">
					                                <label class="control-label col-md-2">Pilihan A</label>
					                                <div class="col-md-10">
					                                    <textarea name="pil_a" class="ckeditor form-control" rows="4"><?php echo isset($c['pil_a']) ? $c['pil_a'] : '' ;?></textarea>
					                                </div>
					                            </div>
						                    </div>
						                    <div class="panel-body">
					                            <div class="form-group">
					                                <label class="control-label col-md-2">Pilihan B</label>
					                                <div class="col-md-10">
					                                    <textarea name="pil_b" class="ckeditor form-control" rows="4"><?php echo isset($c['pil_b']) ? $c['pil_b'] : '' ;?></textarea>
					                                </div>
					                            </div>
						                    </div>
						                    <div class="panel-body">
					                            <div class="form-group">
					                                <label class="control-label col-md-2">Pilihan C</label>
					                                <div class="col-md-10">
					                                    <textarea name="pil_c" class="ckeditor form-control" rows="4"><?php echo isset($c['pil_c']) ? $c['pil_c'] : '' ;?></textarea>
					                                </div>
					                            </div>
						                    </div>
						                    <div class="panel-body">
					                            <div class="form-group">
					                                <label class="control-label col-md-2">Pilihan D</label>
					                                <div class="col-md-10">
					                                    <textarea name="pil_d" class="ckeditor form-control" rows="4"><?php echo isset($c['pil_d']) ? $c['pil_d'] : '' ;?></textarea>
					                                </div>
					                            </div>
						                    </div>
						                    <div class="form-group">
				                                <label class="col-lg-2 col-sm-2 control-label">Kunci Jawaban</label>
				                                <div class="col-lg-6">
				                                    <select class="form-control" name="kunci" id="source">
				                                    	<option value="<?php echo isset($c['kunci']) ? $c['kunci'] : 'Pilih Kunci' ;?>"><?php echo isset($c['kunci']) ? $c['kunci'] : 'Pilih Kunci' ;?></option>
			                                            <option value="A">A</option>
			                                            <option value="B">B</option>
			                                            <option value="C">C</option>
			                                            <option value="D">D</option>
				                                    </select>
				                                </div>
				                            </div>
				                            <div class="form-group last">
				                                <label class="control-label col-md-2">Gambar</label>
				                                <div class="col-md-10">
				                                    <div class="fileupload fileupload-new" data-provides="fileupload">
				                                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
				                                            <img src="<?php echo isset($c['gambar']) ? 'images/elearning/'.$c['gambar'] : 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image' ;?>" alt="" />
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
		case 'kerja':
		?>
		<?php
		if(isset($_GET['id']))
			{
				$sqltrans = mysqli_query($conn,"SELECT q.`id`, q.`judul`, q.`idkelas`, k.`kelas`, q.`idjenis`, j.`jenisujian`, q.`idsemester`, s.`semester`, q.`iddasarpenilaian`,dp.`keterangan` as dasarpenilaian, q.`idrpp`, r.`rpp`, q.`tgl_buat`, q.`waktu_pengerjaan`, q.`info`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
								FROM `topik_quiz` as q
								JOIN `pegawai` as b on b.nip = q.pembuat
								JOIN `pelajaran` as c on q.`idpelajaran` = c.`id`
                                JOIN `guru` as a on a.`nip` = b.`nip`
                                JOIN `kelas` as k on q.`idkelas` = k.`id`
                                JOIN `jenisujian` as j on j.`id` = q.`idjenis`
                                JOIN `semester` as s on s.`id` = q.`idsemester`
                                JOIN `dasarpenilaian` as dp on q.`iddasarpenilaian` = dp.`id`
                                JOIN `rpp` as r on q.`idrpp` = r.`id`
								JOIN `statusguru` as d on d.`id` = a.`statusguru` WHERE q.`id` = '$_GET[id]'") or die(mysqli_error());
				$tra = mysqli_fetch_assoc($sqltrans);

		?>
		
		<div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body profile-information">
                       <div align="center" class="col-md-12">
                       		<div class="tab-pane ">                
				                <div class="prf-contacts sttng">
				                    <h2>DATA QUIZ</h2>
				                </div>      
				            </div>
                       </div>
                       <div class="col-md-2">
                               <div align="center" >
				           		<img src="images/ect/nilai.png" width="90%" alt=""/>
				            </div>
                       </div>
                       <div class="col-md-5">
                           <div class="profile-desk">
                               	<table class="table table-striped">                               		
	                               	<tr>
	                                    <td>Judul</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['judul'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Kelas</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['kelas'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Semester</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['semester'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Pelajaran</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['pelajaran'] ?></td>
	                                </tr>
                               	</table>
                           </div>
                       </div>
                       <div class="col-md-5">
                           <div class="profile-desk">
                               	<table class="table table-striped">                               		
	                               	<tr>
	                                    <td>Jenis Pengujian</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['jenisujian'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Aspek Penilaian</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['dasarpenilaian'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Program Pembelajaran</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['rpp'] ?></td>
	                                </tr>
	                                <tr>
	                                    <td>Durasi</td>
	                                    <td>:</td>
	                                    <td><?php echo $tra['waktu_pengerjaan'] ?></td>
	                                </tr>
                               	</table>
                           </div>
                       </div>
                    </div>
                    
                </section>
            </div>
         </div>
		<?php
	}
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

