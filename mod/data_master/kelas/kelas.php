<?php

	if(!isset($_SESSION['login_user'])){
		header('location: ../../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['kelas']) AND $_SESSION['kelas'] <> 'TRUE')
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
	$linkaksi = 'med.php?mod=kelas';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/data_master/kelas/act_kelas.php';

	?>
	<?php
	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=kelas&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM kelas WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=kelas");
				}

			}
			else
			{
				$act = "$aksi?mod=kelas&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">

				       <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>' enctype="multipart/form-data">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data Kelas
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            	<div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Tingkat</label>
			                                      <div class="col-lg-6">
			                                          <select name="tingkat" class="form-control round-input" style="width: 550px">
			                                          	  <option value="<?php echo isset($c['tingkat']) ? $c['tingkat'] : '' ;?>"><?php echo isset($c['tingkat']) ? $c['tingkat'] : '' ;?></option>
			                                              <option value="1">1</option>
			                                              <option value="2">2</option>
			                                              <option value="3">3</option>
			                                              <option value="4">4</option>
			                                              <option value="5">5</option>
			                                              <option value="6">6</option>
			                                              <option value="7">7</option>
			                                              <option value="8">8</option>
			                                              <option value="9">9</option>
			                                              <option value="10">10</option>
			                                              <option value="11">11</option>
			                                              <option value="12">12</option>
			                                          </select>
			                                      	</div>
			                                  	</div>
				                            	<div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Tahun Ajaran</label>
			                                      <div class="col-lg-6">
			                                          <select name="idtahunajaran" class="form-control round-input" style="width: 550px">
			                                              <?php
			                                                        $sql_angkatan = mysqli_query($conn,"SELECT * FROM tahunajaran");
			                                                while($k = mysqli_fetch_assoc($sql_angkatan))
			                                                {
			                                                  if(isset($c['id']) && $k['id'] == $c['id'])
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
					                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Nama Kelas</label>
					                                <div class="col-lg-10">
					                                    <input type="text" name="kelas" class="form-control round-input" value="<?php echo isset($c['kelas']) ? $c['kelas'] : '' ;?>" required>
					                                </div>
					                            </div>
					                            <div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Wali Kelas</label>
			                                      <div class="col-lg-6">
			                                          <select id="e2" class="populate " name="nip" class="form-control round-input" style="width: 550px">
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
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Kapasitas Kelas</label>
				                                <div class="col-lg-10">
				                                    <input type="number" name="kapasitas" class="form-control round-input" value="<?php echo isset($c['kapasitas']) ? $c['kapasitas'] : '' ;?>" required>
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
		                        	<a href="med.php?mod=kelas&act=form">
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
		                            <table class="table table-striped table-hover table-bordered" id="example">
		                                <thead>
		                                <tr>

											<th class="text-center">No</th>
											<th class="text-center">Tingkat</th>
											<th class="text-center">Kelas</th>
											<th class="text-center">Wali Kelas</th>
		                                    <th class="text-center">Kapasitas</th>
											<th class="text-center">Terisi</th>
											<th class="text-center">Tahun Ajaran</th>
											<?php if($_SESSION['level']=='admin' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` and d.alumni='0' ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
												FROM `kelas` as a
												JOIN `pegawai` as b on a.nipwali = b.nip
												JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
												WHERE c.aktif = 'Aktif'
";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['tingkat']?></td>
		                                    <td align="center"><?php echo $m['kelas']?></td>
		                                    <td align="center"><?php echo $m['nama']?></td>
		                                    <td align="center"><?php echo $m['kapasitas']?></td>
		                                    <td align="center"><?php echo $m['tersisa']?></td>
		                                    <td align="center"><?php echo $m['tahunajaran']?></td>
											<td align="center">
		                                       <!-- <a href="kelas_data.php?hal=kelas_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> <?php if($_SESSION['level']=='admin' ){?>
		                                        <a href="med.php?mod=kelas&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												<a href="<?php echo $aksi ?>?mod=kelas&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

												
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

