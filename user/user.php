<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['level']) AND $_SESSION['level'] <> 'admin')
	{
		?>
		  <div class="alert alert-danger alert-dismissible" id="succsess-alert">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	        Dilarang mengakses file ini.
	      </div>
		<?php
	}

	//link buat paging
	$linkaksi = "med.php?mod=user";

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= "&act=".$act;
	}
	else
	{
		$act = "";
	}

	$aksi = "mod/user/act_user.php";

	switch ($act) {
		case 'form':
			$akses_master = array();
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=user&act=edit";
				$query = mysqli_query($conn,"SELECT a.`id`, b.`nip`, b.`nama`, a.`username`, a.`password`, a.`level`, a.`last_login`
												FROM `user` as a
												JOIN `pegawai` as b on a.id_user = b.nip
												WHERE a.id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);

				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);


					//echo print_r($akses_master);
				}
				else
				{
					header("location:med.php?mod=user");
				}

			}
			else
			{
				$act = "$aksi?mod=user&act=simpan";	
			}
			flash('example_message');
			?>
			<!-- page start-->

				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data User
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            	
				                            <div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Pegawai</label>
			                                      <div class="col-lg-10">
			                                          <select id="e2" class="populate " name="id_user" class="form-control round-input" style="width: 100%">
			                                              <?php
			                                                        $sql_angkatan = mysqli_query($conn,"SELECT * FROM `pegawai`");
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
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Username</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="username" class="form-control round-input" value="<?php echo isset($c['username']) ? $c['username'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Password</label>
				                                <div class="col-lg-10">
				                                    <input type="password" name="password" class="form-control round-input" value="" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Repeat Password</label>
				                                <div class="col-lg-10">
				                                    <input type="password" name="rpassword" class="form-control round-input" value="" required>
				                                </div>
				                            </div>

			                                <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Level</label>
		                                      	<div class="col-lg-10">
		                                          	<select  name="level" class="form-control round-input" style="width: 100%">
		                                          		<option value="<?php echo isset($c['level']) ? $c['level'] : 'Pilih Level' ;?>"><?php echo isset($c['level']) ? $c['level'] : 'Pilih Level' ;?></option>
		                                              <option value="superadmin">Superadmin</option>
		                                              <option value="admin">Admin</option>
		                                              <option value="pendaftaran">Pendaftaran</option>
		                                              <option value="keuangan">Keuangan</option>
		                                              <option value="keuangan mahad">Keuangan Ma'had</option>
		                                              <option value="keuangan madrasah">Keuangan Madrasah</option>
		                                              <option value="keuangan kemaarifan">Keuangan Kemaarifan</option>
		                                              <option value="absensi sp">Absensi SP</option>
		                                              <option value="absensi ibt">Absensi IBT</option>
		                                              <option value="absensi ts">Absensi TS</option>
		                                              <option value="absensi aly">Absensi ALY</option>
		                                              <option value="absensi sorogan">Absensi Sorogan </option>
		                                              <option value="absensi pengajar">Absensi Pengajar </option>
		                                              <option value="nilai ibt">Nilai IBT</option>
		                                              <option value="nilai ts">Nilai TS</option>
		                                              <option value="nilai aly">Nilai ALY</option>
		                                              <option value="nilai bulanan">Nilai Bulanan</option>
		                                              <option value="nilai">Nilai</option>
		                                              <option value="perpustakaan">Perpustakaan</option>
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
		                        	<a href="med.php?mod=user&act=form">
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
		                                    <th class="text-center">Username</th>
		                                    <th class="text-center">Level</th>
		                                    <th class="text-center">Terakhir Login</th>
											<?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin'){?>
		                                    <th class="text-center">Status</th>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT a.`id`,a.`id_user`, b.`nip`, b.`nama`, a.`username`, a.`password`, a.`level`, a.`last_login`
												FROM `user` as a
												JOIN `pegawai` as b on a.id_user = b.nip";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['nip']?></td>
		                                    <td align="center"><?php echo $m['nama']?></td>
		                                    <td align="center"><?php echo $m['username']?></td>
		                                    <td align="center"><?php echo $m['level']?></td>
		                                    <td align="center"><?php echo $m['last_login']?></td>
		                                    <?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin'){
		                                    	$sqla = "SELECT * FROM `user_nonaktif` WHERE `id_user` = '$m[id_user]'";
												$qakt = mysqli_query($conn, $sqla);
												if(mysqli_num_rows($qakt) > 0){
													$akt = mysqli_fetch_assoc($qakt);
												?>												
												<td align="center">
													<a href="<?php echo $aksi ?>?mod=user&act=aktif&user=<?php echo $m['id_user'] ?>"><button class="btn btn-warning btn-sm"><i class="fa fa-check-circle"></i> Aktifkan</button> </a>
												</td>
												<?php
												}else{
												?>												
												<td align="center">
													<a href="<?php echo $aksi ?>?mod=user&act=nonaktif&user=<?php echo $m['id_user'] ?>"><button class="btn btn-danger btn-sm"><i class="fa fa-times-circle"></i> Non-Aktifkan</button> </a>
												</td>
												<?php
												}
		                                    ?>

											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> 
		                                        <a href="med.php?mod=user&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												<a href="<?php echo $aksi ?>?mod=user&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

												
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
		case 'admin':
			if(!empty($_SESSION['login_id']))
			{
				$acta = "$aksi?mod=userakun&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM `user` WHERE `id` = '$_SESSION[login_id]'");
				$temukan = mysqli_num_rows($query);

				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);


					//echo print_r($akses_master);
				}
				else
				{
					header("location:med.php?mod=userakun");
				}

			}
			else
			{
				$acta = "$aksi?mod=userakun&act=simpan";	
			}
			flash('example_message');
			?>
			<!-- page start-->

				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data User
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $acta ?>'>
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            	
				                            
			                                <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Username</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="username" class="form-control round-input" value="<?php echo isset($c['username']) ? $c['username'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Password</label>
				                                <div class="col-lg-10">
				                                    <input type="password" name="password" class="form-control round-input" value="" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Repeat Password</label>
				                                <div class="col-lg-10">
				                                    <input type="password" name="rpassword" class="form-control round-input" value="" required>
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