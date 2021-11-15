<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['pengaturan_bk']) AND $_SESSION['pengaturan_bk'] <> 'TRUE')
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
	$linkaksi = 'med.php?mod=pengaturan_bk';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/bk/act_pengaturan_bk.php';

	?>
	<?php
	switch ($act) {
		default :
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=pengaturan_bk&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM `pengaturan_bk` WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=pengaturan_bk");
				}

			}
			else
			{
				$act = "$aksi?mod=pengaturan_bk&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
				                <section class="panel">
				                    <header class="panel-heading btn-info">
				                        PENGATURAN BK
				                    </header>

				                    <div class="panel-body">
				                        <div class="position-center">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Poin Awal Siswa</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="poinawal" class="form-control round-input currency4" value="<?php echo isset($c['poinawal']) ? $c['poinawal'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
			                                  <label class="col-lg-2 col-sm-2 control-label">Fitur Reward</label>
			                                  	<div class="col-lg-6">
			                                      	<select name="reward" class="form-control round-input" style="width: 550px">
				                                         <option value="<?php echo isset($c['reward']) ? $c['reward'] : '' ;?>"><?php echo isset($c['reward']) ? $c['reward'] : '' ;?></option>
				                                         <option value="Ada">Ada</option>
				                                         <option value="Tidak Ada">Tidak Ada</option>
				                                    </select>
			                                    </div>
			                                </div>
			                                <div class="form-group">
			                                  <label class="col-lg-2 col-sm-2 control-label">Jika Terjadi Pelanggaran</label>
			                                  	<div class="col-lg-6">
			                                      	<select name="sistempelanggaran" class="form-control round-input" style="width: 550px">
				                                         <option value="<?php echo isset($c['sistempelanggaran']) ? $c['sistempelanggaran'] : '' ;?>"><?php echo isset($c['sistempelanggaran']) ? $c['sistempelanggaran'] : '' ;?></option>
				                                         <option value="Dikurangi">Dikurangi</option>
				                                         <option value="Ditambah">Ditambah</option>
				                                    </select>
			                                    </div>
			                                </div>
				                            
				                            		                        
				                        </div>
				                    </div>
				                    <!--
				                    <header class="panel-heading btn-info">
				                        PENGATURAN SURAT
				                    </header>

				                    <div class="panel-body">
				                    <div class="position-center">
				                    	<div class="form-group">
			                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Text Kop Surat 1</label>
			                                <div class="col-lg-10">
			                                    <input type="text" name="text1" class="form-control round-input currency4" value="<?php echo isset($c['text1']) ? $c['text1'] : '' ;?>" required>
			                                </div>
			                            </div>
			                            <div class="form-group">
			                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Text Kop Surat 2</label>
			                                <div class="col-lg-10">
			                                    <input type="text" name="text2" class="form-control round-input currency4" value="<?php echo isset($c['text2']) ? $c['text2'] : '' ;?>" required>
			                                </div>
			                            </div>
			                            <div class="form-group">
			                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Text Kop Surat 3</label>
			                                <div class="col-lg-10">
			                                    <input type="text" name="text3" class="form-control round-input currency4" value="<?php echo isset($c['text3']) ? $c['text3'] : '' ;?>" required>
			                                </div>
			                            </div>
			                            <div class="form-group">
			                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Text Kop Surat 4</label>
			                                <div class="col-lg-10">
			                                    <input type="text" name="text4" class="form-control round-input currency4" value="<?php echo isset($c['text4']) ? $c['text4'] : '' ;?>" required>
			                                </div>
			                            </div>
				                    </div>
				                	</div>
	-->
				                    <div class="panel-body">
				                    	<div class="position-center">
				                    	<div class="form-group">
			                                <div class="col-lg-offset-2 col-lg-10">
								                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
								                <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
			                                </div>
			                            </div>	
			                            </div>	
				                    </div>
				                </section>				                
				            </form>
				            </div>
				        </div>

			<?php
		break;

		case 'form':
		flash('example_message');
			?>
		        <!-- page start-->

		        <div class="row">

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">
		                        <?php if($_SESSION['level']=='admin'){?>
		                        	<a href="med.php?mod=pengaturan_bk&act=form">
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
											<th class="text-center">Siswa</th>
		                                    <th class="text-center">Kejadian</th>
											<th class="text-center">Poin Kejadian</th>
											<th class="text-center">Tanggal Kejadian</th>
											<?php if($_SESSION['level']=='admin' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT a.id,a.nis,b.nama,c.nama as kejadian,c.poin,a.tanggal from 
														pengaturan_bk a
														inner join siswa b
														on a.nis = b.nis
														inner join daftar_kejadian c
														on a.iddaftarkejadian = c.id order by a.tanggal desc";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td><?php echo $m['nis']?> - <?php echo $m['nama']?></td>
		                                    <td><?php echo $m['kejadian']?></td>
		                                    <td align="center"><?php echo $m['poin']?></td>
		                                    <td align="center"><?php echo $m['tanggal']?></td>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> <?php if($_SESSION['level']=='admin' ){?>
		                                        <a href="med.php?mod=pengaturan_bk&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												<a href="<?php echo $aksi ?>?mod=pengaturan_bk&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

												
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

