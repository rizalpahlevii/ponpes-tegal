<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['pembayaran']) AND $_SESSION['pembayaran'] <> 'TRUE')
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
	if($_SESSION['level']=='keuangan' OR $_SESSION['level']=='keuangan mahad' OR $_SESSION['level']=='keuangan madrasah'){
		$linkaksi = 'med2.php?mod=pembayaran';
	}elseif ($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin') {
		$linkaksi = 'med.php?mod=pembayaran';
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

	$aksi = 'mod/keuangan/act_pembayaran.php';

	?>
	<?php
	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=pembayaran&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM pembayaran WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=pembayaran");
				}

			}
			else
			{
				$act = "$aksi?mod=pembayaran&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data Pembayaran
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            <div class="form-group">
				                                <label class="col-lg-2 col-sm-2 control-label">Jenis Pembayaran</label>
				                                <div class="col-lg-6">
				                                    <select class="form-control round-input" name="jenis" style="width: 540px" id="source">
				                                    	<option value="<?php echo isset($c['jenis']) ? $c['jenis'] : 'Pilih Jenis Pembayaran' ;?>"><?php echo isset($c['jenis']) ? $c['jenis'] : 'Pilih Jenis Pembayaran' ;?></option>
			                                            <option value="Baru">Baru</option>
			                                            <option value="Lama">Lama</option>
				                                    </select>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Pembayaran</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="pembayaran" class="form-control round-input" value="<?php echo isset($c['pembayaran']) ? $c['pembayaran'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Urutan</label>
				                                <div class="col-lg-10">
				                                    <input type="number" name="urutan" class="form-control round-input" value="<?php echo isset($c['urutan']) ? $c['urutan'] : '' ;?>" required>
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
                <div class="col-xs-12 col-lg-6">
                    <section class="panel panel-info">
                        <header class="panel-heading">
                            Pendaftaran Baru
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                        	<?php
                        		if ($_SESSION['level']=='keuangan mahad') {
                        			$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Baru' AND `pembayaran` LIKE '%Mahad%' order by urutan asc";
									$sqljp = mysqli_query($conn,$qjp);
                        		}elseif ($_SESSION['level']=='keuangan madrasah') {                        			
									$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Baru' AND `pembayaran` LIKE '%Madrasah%' order by urutan asc";
									$sqljp = mysqli_query($conn,$qjp);	
                        		}else{                        			
									$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Baru' order by urutan asc";
									$sqljp = mysqli_query($conn,$qjp);	
                        		}
								$i=1;
								while ($jp = mysqli_fetch_assoc($sqljp)) {
							?>

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th colspan="4"><?php echo $jp['pembayaran'] ?>
                                    	
                                    	<a href="#" data-toggle="modal" class="btn btn-primary btn-sm" data-target="#mdlbaru<?php echo $jp['id']; ?>">
		                                    <i class="fa fa-plus"></i>
		                                </a>
		                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="mdlbaru<?php echo $jp['id']; ?>" class="modal fade">
				                            <div class="modal-dialog">
				                                <div class="modal-content">
				                                    <div class="modal-header">
				                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				                                        <h4 class="modal-title">Input <?php echo $jp['pembayaran'] ?></h4>
				                                    </div>
				                                    <div class="modal-body">

				                                        <form class="form-horizontal" role="form" method='POST' action="<?php echo $aksi ?>?mod=pembayaran&act=simpan">
				                                            <input type="hidden" class="form-control round-input" name="id" value="<?php echo $jp['id'] ?>">
				                                            <div class="form-group">
				                                                <label class="col-lg-2 col-sm-2 control-label">Pembayaran</label>
				                                                <div class="col-lg-10">
				                                                    <input type="text" class="form-control round-input" name="nama">
				                                                </div>
				                                            </div>
				                                            <div class="form-group">
								                                <label class="col-lg-2 col-sm-2 control-label">Harga (Rp.)</label>
								                                <div class="col-lg-10">
								                                    <input type="text" name="nominal" class="form-control round-input currency4" required>
								                                </div>
								                            </div>
				                                            <div class="form-group">
				                                                <div class="col-lg-offset-2 col-lg-10">
				                                                    <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
				                                                </div>
				                                            </div>
				                                        </form>

				                                    </div>

				                                </div>
				                            </div>
				                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                            	<?php
									$query = "SELECT * FROM pembayaran WHERE `idjenispembayaran` = '$jp[id]'";
									$sql_kul = mysqli_query($conn,$query);	
									$x=1;
									while ($m = mysqli_fetch_assoc($sql_kul)) {
								?>
                                <tr>
                                    <td><?php echo $x ?></td>
                                    <td><?php echo $m['nama'] ?></td>
                                    <td align="right">Rp. <?php echo number_format($m['harga']) ?></td>
                                    <td>

                                    	<a href="#" data-toggle="modal" class="btn btn-success btn-xs" data-target="#mdlbaruedit<?php echo $m['id']; ?>">
		                                    <i class="fa fa-edit"></i>
		                                </a>
		                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="mdlbaruedit<?php echo $m['id']; ?>" class="modal fade">
				                            <div class="modal-dialog">
				                                <div class="modal-content">
				                                    <div class="modal-header">
				                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				                                        <h4 class="modal-title">Input <?php echo $jp['pembayaran'] ?></h4>
				                                    </div>
				                                    <div class="modal-body">

				                                        <form class="form-horizontal" role="form" method='POST' action="<?php echo $aksi ?>?mod=pembayaran&act=edit">
				                                            <input type="hidden" class="form-control round-input" name="id" value="<?php echo $m['id'] ?>">
				                                            <div class="form-group">
				                                                <label class="col-lg-2 col-sm-2 control-label">Pembayaran</label>
				                                                <div class="col-lg-10">
				                                                    <input type="text" class="form-control round-input" name="nama" value="<?php echo $m['nama'] ?>">
				                                                </div>
				                                            </div>
				                                            <div class="form-group">
								                                <label class="col-lg-2 col-sm-2 control-label">Harga (Rp.)</label>
								                                <div class="col-lg-10">
								                                    <input type="text" name="nominal" class="form-control round-input currency4" value="<?php echo $m['harga'] ?>">
								                                </div>
								                            </div>
				                                            <div class="form-group">
				                                                <div class="col-lg-offset-2 col-lg-10">
				                                                    <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
				                                                </div>
				                                            </div>
				                                        </form>

				                                    </div>

				                                </div>
				                            </div>
				                        </div>
										<a href="<?php echo $aksi ?>?mod=pembayaran&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button> </a>

                                    </td>
                                </tr>
                                <?php
 									 $x++;
 								 }
 								?>
                                </tbody>
                            </table>

                            <?php
								 $i++;
							 }
							?>
                        </div>

                    </section>
                </div>
                <div class="col-xs-12 col-lg-6">
                    <section class="panel panel-info">
                        <header class="panel-heading">
                            Pendaftaran Lama
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                             </span>
                        </header><div class="panel-body">
                        	<?php
                        		if ($_SESSION['level']=='keuangan mahad') {
                        			$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Lama' AND `pembayaran` LIKE '%Mahad%' order by urutan asc";
									$sqljp = mysqli_query($conn,$qjp);
                        		}elseif ($_SESSION['level']=='keuangan madrasah') {                        			
									$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Lama' AND `pembayaran` LIKE '%Madrasah%' order by urutan asc";
									$sqljp = mysqli_query($conn,$qjp);	
                        		}else{                        			
									$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Lama' order by urutan asc";
									$sqljp = mysqli_query($conn,$qjp);	
                        		}	
								$i=1;
								while ($jp = mysqli_fetch_assoc($sqljp)) {
							?>

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th colspan="4"><?php echo $jp['pembayaran'] ?>
                                    	
                                    	<a href="#" data-toggle="modal" class="btn btn-primary btn-sm" data-target="#mdllama<?php echo $jp['id']; ?>">
		                                    <i class="fa fa-plus"></i>
		                                </a>
		                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="mdllama<?php echo $jp['id']; ?>" class="modal fade">
				                            <div class="modal-dialog">
				                                <div class="modal-content">
				                                    <div class="modal-header">
				                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				                                        <h4 class="modal-title">Input <?php echo $jp['pembayaran'] ?></h4>
				                                    </div>
				                                    <div class="modal-body">

				                                        <form class="form-horizontal" role="form" method='POST' action="<?php echo $aksi ?>?mod=pembayaran&act=simpan">
				                                            <input type="hidden" class="form-control round-input" name="id" value="<?php echo $jp['id'] ?>">
				                                            <div class="form-group">
				                                                <label class="col-lg-2 col-sm-2 control-label">Pembayaran</label>
				                                                <div class="col-lg-10">
				                                                    <input type="text" class="form-control round-input" name="nama">
				                                                </div>
				                                            </div>
				                                            <div class="form-group">
								                                <label class="col-lg-2 col-sm-2 control-label">Harga (Rp.)</label>
								                                <div class="col-lg-10">
								                                    <input type="text" name="nominal" class="form-control round-input currency4" required>
								                                </div>
								                            </div>
				                                            <div class="form-group">
				                                                <div class="col-lg-offset-2 col-lg-10">
				                                                    <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
				                                                </div>
				                                            </div>
				                                        </form>

				                                    </div>

				                                </div>
				                            </div>
				                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                            	<?php
									$query = "SELECT * FROM pembayaran WHERE `idjenispembayaran` = '$jp[id]'";
									$sql_kul = mysqli_query($conn,$query);	
									$x=1;
									while ($m = mysqli_fetch_assoc($sql_kul)) {
								?>
                                <tr>
                                    <td><?php echo $x ?></td>
                                    <td><?php echo $m['nama'] ?></td>
                                    <td align="right">Rp. <?php echo number_format($m['harga']) ?></td>
                                    <td>

                                    	<a href="#" data-toggle="modal" class="btn btn-success btn-xs" data-target="#mdllamaedit<?php echo $m['id']; ?>">
		                                    <i class="fa fa-edit"></i>
		                                </a>
		                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="mdllamaedit<?php echo $m['id']; ?>" class="modal fade">
				                            <div class="modal-dialog">
				                                <div class="modal-content">
				                                    <div class="modal-header">
				                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				                                        <h4 class="modal-title">Input <?php echo $jp['pembayaran'] ?></h4>
				                                    </div>
				                                    <div class="modal-body">

				                                        <form class="form-horizontal" role="form" method='POST' action="<?php echo $aksi ?>?mod=pembayaran&act=edit">
				                                            <input type="hidden" class="form-control round-input" name="id" value="<?php echo $m['id'] ?>">
				                                            <div class="form-group">
				                                                <label class="col-lg-2 col-sm-2 control-label">Pembayaran</label>
				                                                <div class="col-lg-10">
				                                                    <input type="text" class="form-control round-input" name="nama" value="<?php echo $m['nama'] ?>">
				                                                </div>
				                                            </div>
				                                            <div class="form-group">
								                                <label class="col-lg-2 col-sm-2 control-label">Harga (Rp.)</label>
								                                <div class="col-lg-10">
								                                    <input type="text" name="nominal" class="form-control round-input currency4" value="<?php echo $m['harga'] ?>">
								                                </div>
								                            </div>
				                                            <div class="form-group">
				                                                <div class="col-lg-offset-2 col-lg-10">
				                                                    <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
				                                                </div>
				                                            </div>
				                                        </form>

				                                    </div>

				                                </div>
				                            </div>
				                        </div>
										<a href="<?php echo $aksi ?>?mod=pembayaran&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button> </a>

                                    </td>
                                </tr>
                                <?php
 									 $x++;
 								 }
 								?>
                                </tbody>
                            </table>

                            <?php
								 $i++;
							 }
							?>
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

