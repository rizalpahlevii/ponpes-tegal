<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['tahunajaran']) AND $_SESSION['tahunajaran'] <> 'TRUE')
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
	$linkaksi = 'med.php?mod=tahunajaran';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/data_master/tahunajaran/act_tahunajaran.php';

	?>
	<?php
	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=tahunajaran&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM tahunajaran WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=tahunajaran");
				}

			}
			else
			{
				$act = "$aksi?mod=tahunajaran&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data Tahun Ajaran
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Tahun Ajaran</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="tahunajaran" class="form-control round-input" value="<?php echo isset($c['tahunajaran']) ? $c['tahunajaran'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label class="control-label col-lg-2 col-sm-2">Tanggal Mulai</label>
				                                <div class="col-lg-10">
				                                    <input name="tglmulai" class="form-control form-control-inline input-medium default-date-picker  round-input"  size="16" type="text" value="<?php echo isset($c['tglmulai']) ? $c['tglmulai'] : '' ;?>" />
				                                </div>
				                            </div>

				                            <div class="form-group">
				                                <label class="control-label col-lg-2 col-sm-2">Tanggal Akhir</label>
				                                <div class="col-lg-10">
				                                    <input name="tglakhir" class="form-control form-control-inline input-medium default-date-picker  round-input"  size="16" type="text" value="<?php echo isset($c['tglakhir']) ? $c['tglakhir'] : '' ;?>" />
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label class="control-label col-md-2">Keterangan</label>
				                                <div class="col-md-10">
				                                    <textarea name="keterangan" class="wysihtml5 form-control " rows="9"><?php echo isset($c['keterangan']) ? $c['keterangan'] : '' ;?></textarea>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label class="col-lg-2 col-sm-2 control-label">Status</label>
				                                <div class="col-lg-6">
				                                    <select class="form-control" name="aktif" style="width: 100%" id="source">
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
		                        	<a href="med.php?mod=tahunajaran&act=form">
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
		                                    <th class="text-center">Tahun Ajaran</th>
											<th class="text-center">Tanggal Mulai</th>
											<th class="text-center">Tanggal Akhir</th>
											<th class="text-center">Keterangan</th>
											<th class="text-center">Aktif</th>
											<?php if($_SESSION['level']=='admin' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT * FROM tahunajaran";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['tahunajaran']?></td>
		                                    <td align="center"><?php echo $m['tglmulai']?></td>
		                                    <td align="center"><?php echo $m['tglakhir']?></td>
		                                    <td ><?php echo $m['keterangan']?></td>
		                                    <td align="center"><?php echo $m['aktif']?></td>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> <?php if($_SESSION['level']=='admin' ){?>
		                                        <a href="med.php?mod=tahunajaran&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												<a href="<?php echo $aksi ?>?mod=tahunajaran&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

												
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

