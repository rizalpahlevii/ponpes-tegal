<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['pengembalian']) AND $_SESSION['pengembalian'] <> 'TRUE')
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
	$linkaksi = 'med.php?mod=pengembalian';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/perpustakaan/act_pengembalian.php';

	?>
	<?php
	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=pengembalian&act=edit";
				$query = mysqli_query($conn,"SELECT a.`id`, a.`nis`, b.`nama`, a.`idbuku`,c.`kode`,c.`judul`, a.`tgl_pinjam`, a.`tgl_kembali`, a.`status` 
					FROM `datasewa` as a
					JOIN `siswa` as b on a.`nis` = b.`nis`
					JOIN `buku` as c on a.`idbuku` = c.`id`
					WHERE a.id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=pengembalian");
				}

			}
			else
			{
				$act = "$aksi?mod=pengembalian&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data Rak Buku
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Rak</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="rak" class="form-control round-input" value="<?php echo isset($c['rak']) ? $c['rak'] : '' ;?>" required>
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
		                                    <th class="text-center">Buku</th>
		                                    <th class="text-center">Tanggal Pinjam</th>
		                                    <th class="text-center">Tanggal Kembali</th>
		                                    <th class="text-center">Lama</th>
		                                    <th class="text-center">Denda</th>
											<?php if($_SESSION['level']=='admin' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT a.`id`, a.`nis`, b.`nama`, a.`idbuku`,c.`kode`,c.`judul`, a.`tgl_pinjam`, a.`tgl_kembali`,a.`denda`, a.`status`,datediff(current_date(), a.`tgl_kembali`) as selisih 
												FROM `datasewa` as a
												JOIN `siswa` as b on a.`nis` = b.`nis`
												JOIN `buku` as c on a.`idbuku` = c.`id`
												";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
											if ($m['selisih'] < '0') {
												$hsl = 'Kurang '.abs($m['selisih']).' Hari';
											}elseif ($m['selisih'] == '0') {
												$hsl = 'Terakhir Hari Ini';
											}else{
												$hsl = 'Telat '.$m['selisih'].' Hari';
											}
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td><?php echo $m['nis']?> - <?php echo $m['nama']?></td>
		                                    <td><?php echo $m['kode']?> - <?php echo $m['judul']?></td>
		                                    <td><?php echo $m['tgl_pinjam']?></td>
		                                    <td><?php echo $m['tgl_kembali']?></td>
		                                    <?php
		                                    if ($m['status']=='pinjam') {
		                                    ?>
		                                    <td><?php echo $hsl?></td>
		                                    <td><?php echo $m['denda']?></td>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>	
		                                       <a href="<?php echo $aksi ?>?mod=peminjaman&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>
						
		                                   --> 
		                                        <a href="<?php echo $aksi ?>?mod=pengembalian&act=edit&id=<?php echo $m['id'] ?>" ><button class="btn btn-danger btn-sm"><i class="fa fa-arrow-right"></i> Kembalikan</button>  </a>
												
											</td>
		                                    <?php
		                                    }else{
		                                    ?>
		                                    <td><?php echo $m['tgl_kembali']?></td>
		                                    <td><?php echo number_format($m['denda'],2) ?></td>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>	
		                                       <a href="<?php echo $aksi ?>?mod=peminjaman&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>
						
		                                   --> 
		                                   		<button class="btn btn-warning btn-sm"><i class="fa  fa-check"></i></button>
		                                        
												
												
											</td>
		                                    <?php
		                                    }
		                                    ?>
		                                    
											 
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

