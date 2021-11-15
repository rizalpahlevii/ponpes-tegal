<?php

	if(!isset($_SESSION['login_user'])){
		header('location: ../../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['guru']) AND $_SESSION['guru'] <> 'TRUE')
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
	$linkaksi = 'med.php?mod=guru';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/data_master/guru/act_guru.php';

	?>
	<?php
	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=guru&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM guru WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=guru");
				}

			}
			else
			{
				$act = "$aksi?mod=guru&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">

				       <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>' enctype="multipart/form-data">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data Guru
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            	<input type="hidden" name="img" value="<?php echo isset($c['foto']) ? $c['foto'] : '' ;?>">
				                            	<div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Pelajaran</label>
			                                      <div class="col-lg-6">
			                                          <select id="e1" class="populate " name="idpelajaran" class="form-control round-input" style="width: 100%">
			                                              <?php
			                                                        $sql_kelas = mysqli_query($conn,"SELECT * FROM pelajaran");
			                                                while($k = mysqli_fetch_assoc($sql_kelas))
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
			                                                        ?>
			                                          </select>
			                                      	</div>
			                                  	</div>
					                            <div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Guru</label>
			                                      <div class="col-lg-6">
			                                          <select id="e2" class="populate " name="nip" class="form-control round-input" style="width: 100%">
			                                              <?php
			                                                        $sql_angkatan = mysqli_query($conn,"SELECT * FROM `pegawai` WHERE `bagian` = 'Akademik'");
			                                                while($k = mysqli_fetch_assoc($sql_angkatan))
			                                                {
			                                                  if(isset($c['nip']) && $k['nip'] == $c['nip'])
			                                                  {
			                                                    echo"<option value='$k[nip]' selected>$k[nip] - $k[nama]</option>";  
			                                                  }
			                                                  else
			                                                  {
			                                                    echo"<option value='$k[nip]'>$k[nip] - $k[nama]</option>";
			                                                  }
			                                                  
			                                                }
			                                                        ?>
			                                          </select>
			                                      </div>
			                                  </div>
			                                <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Status</label>
		                                      	<div class="col-lg-6">
		                                          	<select  name="status" class="form-control round-input" style="width: 100%">
		                                              <?php
		                                                        $sql_status = mysqli_query($conn,"SELECT * FROM statusguru");
		                                                while($k = mysqli_fetch_assoc($sql_status))
		                                                {
		                                                  if(isset($c['id']) && $k['id'] == $c['id'])
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
				                                <label class="control-label col-md-2">Keterangan</label>
				                                <div class="col-md-10">
				                                    <textarea class="form-control" name="keterangan" rows="5"><?php echo isset($c['keterangan']) ? $c['keterangan'] : '' ;?></textarea>
				                                </div>
				                            </div>
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
		                        	<a href="med.php?mod=guru&act=form">
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
											<th class="text-center">NIP</th>
											<th class="text-center">Guru</th>
		                                    <th class="text-center">Pelajaran</th>
											<th class="text-center">Status</th>
											<th class="text-center">Keterangan</th>
											<?php if($_SESSION['level']=='admin' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
												FROM `guru` as a
												JOIN `pegawai` as b on a.nip = b.nip
												JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
												JOIN `statusguru` as d on d.`id` = a.`statusguru`";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['nip']?></td>
		                                    <td align="center"><?php echo $m['guru']?></td>
		                                    <td align="center"><?php echo $m['pelajaran']?></td>
		                                    <td align="center"><?php echo $m['status']?></td>
		                                    <td ><?php echo $m['keterangan']?></td>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> <?php if($_SESSION['level']=='admin' ){?>
		                                        <a href="med.php?mod=guru&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												<a href="<?php echo $aksi ?>?mod=guru&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

												
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

