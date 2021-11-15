<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['kas']) AND $_SESSION['kas'] <> 'TRUE')
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
	$linkaksi = 'med.php?mod=kas';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/perpustakaan/act_kas.php';

	?>
	<?php
	switch ($act) {
		case 'masuk':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=kas&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM kas WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=kas");
				}

			}
			else
			{
				$act = "$aksi?mod=kasmasuk&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data Kas Masuk
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            <div class="form-group">
				                                <label class="control-label col-lg-2 col-sm-2">Tanggal</label>
				                                <div class="col-lg-10">
				                                    <input name="tanggal" class="form-control form-control-inline input-medium default-date-picker  round-input"  size="16" type="text" value="<?php echo isset($c['tanggal']) ? $c['tanggal'] : '' ;?>" />
				                                </div>
				                            </div>
			                                <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Jumlah (Rp.)</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="nominal" class="form-control round-input currency4" value="<?php echo isset($c['nominal']) ? $c['nominal'] : '' ;?>" required>
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
			$sqlmasuk = "SELECT sum(`nominal`) as nominal FROM `kas` WHERE `jenis` = 'masuk'";
			$kmasuk = mysqli_query($conn, $sqlmasuk);
			$masuk = mysqli_fetch_assoc($kmasuk);

			$sqlkeluar = "SELECT sum(`nominal`) as nominal FROM `kas` WHERE `jenis` = 'keluar'";
			$kkeluar = mysqli_query($conn, $sqlkeluar);
			$keluar = mysqli_fetch_assoc($kkeluar);

			$saldo = $masuk['nominal'] - $keluar['nominal'];
			?>
		        <!-- page start-->
		        <div class="row">
				    <div class="col-md-4">
				        <div class="mini-stat clearfix">
				            <span class="mini-stat-icon pink"><i class="fa fa-money"></i></span>
				            <div class="mini-stat-info">
				                <span><?php echo number_format($masuk['nominal']) ?></span>
				                Kas Masuk
				            </div>
				        </div>
				    </div>				    
				    <div class="col-md-4">
				        <div class="mini-stat clearfix">
				            <span class="mini-stat-icon orange"><i class="fa fa-money"></i></span>
				            <div class="mini-stat-info">
				                <span><?php echo number_format($keluar['nominal']) ?></span>
				                Kas Keluar
				            </div>
				        </div>
				    </div>
				    <div class="col-md-4">
				        <div class="mini-stat clearfix">
				            <span class="mini-stat-icon tar"><i class="fa fa-money"></i></span>
				            <div class="mini-stat-info">				                
				                <span><?php echo number_format($saldo) ?></span>
				                Saldo
				            </div>
				        </div>
				    </div>
				</div>

		        <div class="row">

		            <div class="clearfix">
			
		            <div class="col-sm-12">

		                <section class="panel">
			                <header class="panel-heading tab-bg-dark-navy-blue">
			                    <ul class="nav nav-tabs nav-justified" >
			                        <li class="active">
			                            <a data-toggle="tab" href="#home">Kas Masuk</a>
			                        </li>
			                        <li class="">
			                            <a data-toggle="tab" href="#about">Kas Keluar</a>
			                        </li>
			                        
			                    </ul>
			                </header>
			                <div class="panel-body">
			                    <div class="tab-content">
			                        <div id="home" class="tab-pane active">
			                             <div class="row">

								            <div class="clearfix">
									
								            <div class="col-sm-12">
								                <section class="panel">
								                    <header class="panel-heading">
								                        <?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin' OR $_SESSION['level']=='perpustakaan'){?>
								                        	<a href="med.php?mod=kas&act=masuk">
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
								                                    <th class="text-center">Tanggal</th>
								                                    <th class="text-center">Keterangan</th>
								                                    <th class="text-center">Nominal</th>
																	<?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin' OR $_SESSION['level']=='perpustakaan'){?>
								                                    <th class="text-center">Aksi</th>
																	<?php }?>
																</tr>
								                                </thead>
								                                <tbody>
								                                <?php
																	$query = "SELECT * FROM kas WHERE jenis = 'masuk'";
																	$sql_kul = mysqli_query($conn,$query);	
																	$i=1;
																	while ($m = mysqli_fetch_assoc($sql_kul)) {
																?>
								                                <tr class="">
								                                    <td align="center"><?php echo $i ?></td>
								                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
								                                    <td align="center"><?php echo $m['tanggal']?></td>
								                                    <td><?php echo $m['keterangan']?></td>
								                                    <td><?php echo number_format($m['nominal'],2) ?></td>
								                                    <?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin' OR $_SESSION['level']=='perpustakaan'){?>
																	<td align="center">
								                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
								                                   --> 
								                                        <a href="med.php?mod=kas&act=masuk&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
																		<a href="<?php echo $aksi ?>?mod=kas&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

																		
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
			                        <div id="about" class="tab-pane">
			                        	<div class="row">

								            <div class="clearfix">
									
								            <div class="col-sm-12">
								                <section class="panel">
								                    <header class="panel-heading">
								                        <?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin' OR $_SESSION['level']=='perpustakaan'){?>
								                        	<a href="med.php?mod=kas&act=keluar">
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
								                            <table class="table table-striped table-hover table-bordered" id="examplex">
								                                <thead>
								                                <tr>
																	<th class="text-center">No</th>
								                                    <th class="text-center">Tanggal</th>
								                                    <th class="text-center">Keterangan</th>
								                                    <th class="text-center">Nominal</th>
																	<?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin' OR $_SESSION['level']=='perpustakaan'){?>
								                                    <th class="text-center">Aksi</th>
																	<?php }?>
																</tr>
								                                </thead>
								                                <tbody>
								                                <?php
																	$query = "SELECT * FROM kas WHERE jenis = 'keluar'";
																	$sql_kul = mysqli_query($conn,$query);	
																	$i=1;
																	while ($m = mysqli_fetch_assoc($sql_kul)) {
																?>
								                                <tr class="">
								                                    <td align="center"><?php echo $i ?></td>
								                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
								                                    <td align="center"><?php echo $m['tanggal']?></td>
								                                    <td><?php echo $m['keterangan']?></td>
								                                    <td><?php echo number_format($m['nominal'],2) ?></td>
								                                    <?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin' OR $_SESSION['level']=='perpustakaan'){?>
																	<td align="center">
								                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
								                                   --> 
								                                        <a href="med.php?mod=kas&act=keluar&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
																		<a href="<?php echo $aksi ?>?mod=kas&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

																		
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
			                </div>
			            </section>
		            </div>
		        </div>

		            <!-- page end-->
			<?php
		break;

		
		case 'keluar':
		if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=kaskeluar&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM kas WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=kas");
				}

			}
			else
			{
				$act = "$aksi?mod=kaskeluar&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data Kas Keluar
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            <div class="form-group">
				                                <label class="control-label col-lg-2 col-sm-2">Tanggal</label>
				                                <div class="col-lg-10">
				                                    <input name="tanggal" class="form-control form-control-inline input-medium default-date-picker  round-input"  size="16" type="text" value="<?php echo isset($c['tanggal']) ? $c['tanggal'] : '' ;?>" />
				                                </div>
				                            </div>
			                                <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Jumlah (Rp.)</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="nominal" class="form-control round-input currency4" value="<?php echo isset($c['nominal']) ? $c['nominal'] : '' ;?>" required>
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
				                        </form>
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

