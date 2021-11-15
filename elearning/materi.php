<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['materi']) AND $_SESSION['materi'] <> 'TRUE')
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
		$linkaksi = 'med.php?mod=materi';		
	}elseif ($_SESSION['level']=='guru') {
		$queryg = "SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
		FROM `guru` as a
		JOIN `pegawai` as b on a.nip = b.nip
		JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
		JOIN `statusguru` as d on d.`id` = a.`statusguru` 
		WHERE a.`nip` = '$_SESSION[login_user]'";
		$sql_g = mysqli_query($conn,$queryg);	
		$g = mysqli_fetch_assoc($sql_g);		
		$linkaksi = 'med2.php?mod=materi';
	}else{
		$linkaksi = 'med2.php?mod=materi';
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

	$aksi = 'mod/elearning/act_materi.php';

	?>
	<?php
	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=materi&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM materi WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med2.php?mod=materi");
				}

			}
			else
			{
				$act = "$aksi?mod=materi&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data materi
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>' enctype="multipart/form-data">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            	<input type="hidden" name="fupload" value="<?php echo isset($c['file']) ? $c['file'] : '' ;?>">
				                            	<input type="hidden" name="nip" value="<?php echo $_SESSION['id_user'] ?>">
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Judul</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="judul" class="form-control round-input" value="<?php echo isset($c['judul']) ? $c['judul'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
		                                      <div class="col-lg-6">
		                                          <select name="idkelas" class="form-control round-input">
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
			                                      <label class="col-lg-2 col-sm-2 control-label">Pelajaran</label>
			                                      <div class="col-lg-6">
			                                          <select name="idpelajaran" class="form-control round-input">
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
				                                <label class="control-label col-lg-2 col-sm-2 ">File</label>
				                                <div class="controls col-md-10">
				                                    <div class="fileupload fileupload-new" data-provides="fileupload">
				                                                <span class="btn btn-white btn-file">
				                                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select file</span>
				                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
				                                                <input type="file" name="file" class="default" value="<?php echo isset($c['file']) ? $c['file'] : '' ;?>" />
				                                                </span>
				                                        <span class="fileupload-preview" style="margin-left:5px;"></span>
				                                        <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
				                                    </div>

				                                	<label><?php echo isset($c['file']) ? $c['file'] : '' ;?></label>
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
		                        	<a href="med2.php?mod=materi&act=form">
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
		                                    <th class="text-center">Nama File</th>
		                                    <th class="text-center">Tanggal Upload</th>
		                                    <th class="text-center">Pengapload</th>
											<?php if($_SESSION['level']=='guru' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
		                                	if ($_SESSION['level']=='guru') {		

												$query = "SELECT a.`id`, a.`judul`, a.`idkelas`, b.`kelas`, a.`idpelajaran`,c.`kode`, c.`nama` as pelajaran, a.`file`, a.`tgl_posting`, a.`nip`, d.`nama` 
													FROM `materi` as a
													JOIN `kelas` AS b ON a.`idkelas` = b.`id`
													JOIN `pelajaran` AS c on a.`idpelajaran` = c.`id`
													JOIN `pegawai` AS d on a.`nip` = d.`nip`
													WHERE d.`nip` = '$_SESSION[id_user]'
";
												$sql_kul = mysqli_query($conn,$query);
		                                	}elseif($_SESSION['level']=='siswa'){
		                                		$s="SELECT * FROM `siswa` WHERE `nis` = '$_SESSION[id_user]'";
												$sql_s = mysqli_query($conn,$s);
												$siswa = mysqli_fetch_assoc($sql_s);
		                                		$query = "SELECT a.`id`, a.`judul`, a.`idkelas`, b.`kelas`, a.`idpelajaran`,c.`kode`, c.`nama` as pelajaran, a.`file`, a.`tgl_posting`, a.`nip`, d.`nama` 
													FROM `materi` as a
													JOIN `kelas` AS b ON a.`idkelas` = b.`id`
													JOIN `pelajaran` AS c on a.`idpelajaran` = c.`id`
													JOIN `pegawai` AS d on a.`nip` = d.`nip`
													WHERE a.`idkelas` = '$siswa[idkelas]'
";
												$sql_kul = mysqli_query($conn,$query);

		                                	}else{
		                                		$query = "SELECT a.`id`, a.`judul`, a.`idkelas`, b.`kelas`, a.`idpelajaran`,c.`kode`, c.`nama` as pelajaran, a.`file`, a.`tgl_posting`, a.`nip`, d.`nama` 
													FROM `materi` as a
													JOIN `kelas` AS b ON a.`idkelas` = b.`id`
													JOIN `pelajaran` AS c on a.`idpelajaran` = c.`id`
													JOIN `pegawai` AS d on a.`nip` = d.`nip`
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
		                                    <td align="center"><a target="_blank" href="file/<?php echo $m['file']?>"><?php echo $m['file']?></a></td>
		                                    <td align="center"><?php echo $m['tgl_posting']?></td>
		                                    <td align="center"><?php echo $m['nama']?></td>
		                                    <?php if($_SESSION['level']=='guru' ){?>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> 
		                                        <a href="<?php echo $linkaksi?>&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												<a href="<?php echo $aksi ?>?mod=materi&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

												
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

