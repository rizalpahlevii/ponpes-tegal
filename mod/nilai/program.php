<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['program']) AND $_SESSION['program'] <> 'TRUE')
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
	if ($_SESSION['level']=='guru') {
		$queryg = "SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
		FROM `guru` as a
		JOIN `pegawai` as b on a.nip = b.nip
		JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
		JOIN `statusguru` as d on d.`id` = a.`statusguru` 
		WHERE a.`nip` = '$_SESSION[login_user]'";
		$sql_g = mysqli_query($conn,$queryg);	
		$g = mysqli_fetch_assoc($sql_g);
	}
	//link buat paging
	$linkaksi = 'med.php?mod=program';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/nilai/act_program.php';

	?>
	<?php
	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=program&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM rpp WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					if($_SESSION['level']=='guru'){
						header("location:med2.php?mod=program");
					}elseif ($_SESSION['level']=='admin') {
						header("location:med.php?mod=program");
					}
					
				}

			}
			else
			{
				$act = "$aksi?mod=program&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data Program Pembelajaran
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Kode</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="koderpp" class="form-control round-input" value="<?php echo isset($c['koderpp']) ? $c['koderpp'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Periode</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="periode" class="form-control round-input" value="<?php echo isset($c['periode']) ? $c['periode'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Semester</label>
			                                      <div class="col-lg-6">
			                                          <select name="idsemester" class="form-control round-input" >
			                                              <?php
			                                                        $sql_semester = mysqli_query($conn,"SELECT * FROM semester where aktif='Aktif'");
			                                                while($k = mysqli_fetch_assoc($sql_semester))
			                                                {
			                                                  if(isset($c['id']) && $k['id'] == $c['id'])
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
			                                      <label class="col-lg-2 col-sm-2 control-label">Pelajaran</label>
			                                      <div class="col-lg-6">
			                                          <select name="idpelajaran" class="form-control round-input" >
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
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">KD</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="rpp" class="form-control round-input" value="<?php echo isset($c['rpp']) ? $c['rpp'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            
				                            <div class="form-group">
				                                <label class="control-label col-md-2">Materi</label>
				                                <div class="col-md-10">
				                                    <textarea class="ckeditor form-control" name="deskripsi" rows="5"><?php echo isset($c['deskripsi']) ? $c['deskripsi'] : '' ;?></textarea>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label class="col-lg-2 col-sm-2 control-label">Aktif</label>
				                                <div class="col-lg-6">
				                                    <select class="form-control" name="aktif"  id="source">
				                                    	<option value="<?php echo isset($c['aktif']) ? $c['aktif'] : 'Pilih Status' ;?>"><?php echo isset($c['aktif']) ? $c['aktif'] : 'Pilih Status' ;?></option>
			                                            <option value="Aktif">Aktif</option>
			                                            <option value="Tidak Aktif">Tidak Aktif</option>
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
		                        <?php if($_SESSION['level']=='admin'){?>
		                        	<a href="med.php?mod=program&act=form">
									<button class="btn btn-primary">
										Tambah <i class="fa fa-plus"></i>
									</button>
									</a>
								<?php 
									}elseif ($_SESSION['level']=='guru') {
									?>
									<a href="med2.php?mod=program&act=form">
									<button class="btn btn-primary">
										Tambah <i class="fa fa-plus"></i>
									</button>
									</a>
									<?php
									}{
									?>
									<?php
									}

								?>
		                        <span class="tools pull-right">
		                            <a href="javascript:;" class="fa fa-chevron-down"></a>
		                            <a href="javascript:;" class="fa fa-cog"></a>
		                            <a href="javascript:;" class="fa fa-times"></a>
		                         </span>
		                    </header>
							
							
		                    <div class="panel-body table-responsive">
							
		                        <div class="adv-table editable-table ">
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
		                                    <th class="text-center">Kode</th>
		                                    <th class="text-center">Periode</th>
											<!--<th class="text-center">Semester</th>
											<th class="text-center">Pelajaran</th>-->
											<th class="text-center">KD</th>
											<th class="text-center">Materi</th>
											<th class="text-center">Aktif</th>
											<?php if($_SESSION['level']=='admin' or $_SESSION['level']=='guru'){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
		                                	if ($_SESSION['level']=='guru') {
		                                		$query = "SELECT a.`id`, b.`semester`, c.`kode`,c.`nama`, a.`koderpp`, a.`periode`, a.`rpp`, a.`deskripsi`, a.`aktif` 
												FROM `rpp` AS a
												JOIN `semester` AS b on a.`idsemester` = b.`id`
												JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
												WHERE a.`idpelajaran` = '$g[idpelajaran]'";
											$sql_kul = mysqli_query($conn,$query);	
		                                	}else{
		                                		$query = "SELECT a.`id`, b.`semester`, c.`kode`,c.`nama`, a.`koderpp`, a.`periode`, a.`rpp`, a.`deskripsi`, a.`aktif` 
												FROM `rpp` AS a
												JOIN `semester` AS b on a.`idsemester` = b.`id`
												JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`";
												$sql_kul = mysqli_query($conn,$query);	
		                                	}
											
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td width="" align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td width="" align="center"><?php echo $m['koderpp']?></td>
		                                    <td width="" align="center"><?php echo $m['periode']?></td>
		                                    <!--<td align="center"><?php echo $m['semester']?></td>
		                                    <td align="center"><?php echo $m['kode']?> - <?php echo $m['nama']?></td>-->
		                                    <td width="25%" align="center"><?php echo $m['rpp']?></td>
		                                    <td width="*" ><?php echo $m['deskripsi']?></td>
		                                    <td width="10%" align="center"><?php echo $m['aktif']?></td>
											
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> <?php if($_SESSION['level']=='admin' or $_SESSION['level']=='guru'){?>
		                                   	<td align="center">
		                                        <a href="med.php?mod=program&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												<a href="<?php echo $aksi ?>?mod=program&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

												
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

