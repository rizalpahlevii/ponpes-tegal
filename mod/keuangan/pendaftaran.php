<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['pendaftaran']) AND $_SESSION['pendaftaran'] <> 'TRUE')
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
	if($_SESSION['level']=='keuangan'){
		$linkaksi = 'med2.php?mod=pendaftaran';
		$linkaksit = 'med2.php?mod=transaksi';
	}elseif ($_SESSION['level']=='admin') {
		$linkaksit = 'med.php?mod=transaksi';
		$linkaksi = 'med.php?mod=pendaftaran';
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

	$aksi = 'mod/keuangan/act_transaksi.php';

	?>
	<?php
	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=pendaftaran&act=edit";
				$query = mysqli_query($conn,"SELECT * FROM pendaftaran WHERE id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=pendaftaran");
				}

			}
			else
			{
				$act = "$aksi?mod=pendaftaran&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data Jenis Pembayaran
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

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">
		                        Data Transaksi
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
											<th class="text-center">NO. TRANSAKSI</th>
											<th class="text-center">TGL. TRANSAKSI</th>
											<th class="text-center">POTONGAN</th>
											<th class="text-center">TOTAL BAYAR</th>
											<th class="text-center">BAYAR</th>
											<th class="text-center">SISA BAYAR</th>
											<th class="text-center">STATUS</th>
											<th class="text-center">PEMBAYARAN</th>
											<th class="text-center">Aksi</th>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT a.*, b.`nis`, b.`nama`
														FROM `transaksi` as a
														JOIN `siswa` as b ON a.`nis` = b.`nis`";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
											$qttl = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `detail_transaksi` WHERE no_transaksi='$m[no_transaksi]'");
							                	$ttl = mysqli_fetch_assoc($qttl);

							                	$qttlx = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `bayarcicilan` WHERE no_transaksi='$m[no_transaksi]'");
							                	$ttlx = mysqli_fetch_assoc($qttlx);
							                	
												$total_bayar = $ttl['total'] - $m['potongan'];
												$sisa = $m['bayar'] - $total_bayar;
												$bayar = $m['bayar'] + $ttlx['total'];
												$result = preg_replace("/[^0-9]/", "", $sisa);
												$tsisa = $result - $ttlx['total'];
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['no_transaksi'] ?></td>
		                                    <td align="center"><?php echo tglindo($m['tgl_transaksi'])?> </td>
		                                    <td align="center">Rp. <?php echo number_format($m['potongan']) ?></td>
		                                    <td align="center">Rp. <?php echo number_format($total_bayar) ?></td>
		                                    <td align="center">Rp. <?php echo number_format($bayar) ?></td>
		                                    <td align="center">Rp. <?php echo number_format($tsisa) ?></td>
		                                    <td align="center">
		                                    	<?php
		                                   		if ($tsisa!=0) {
		                                   		?>
		                                   		Hutang
		                                   		<?php	
		                                   		}else{
		                                   		?>
		                                   		Lunas
		                                   		<?php	
		                                   		}
		                                   		?>
		                                    </td>
		                                    <td align="center">Pendaftaran <?php echo $m['jenis'] ?></td>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>		
		                                        <a href="<?php echo $linkaksi ?>&act=aksi&id=<?php echo $m['no_transaksi'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>					
		                                   --> 
		                                   		<?php
		                                   		if ($tsisa!=0) {
		                                   		?>
		                                   		<a href="#" data-toggle="modal" class="btn btn-success btn-sm" data-target="#mdlbaruedit<?php echo $m['no_transaksi']; ?>">
				                                    Bayar
				                                </a>
				                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="mdlbaruedit<?php echo $m['no_transaksi']; ?>" class="modal fade">
						                            <div class="modal-dialog">
						                                <div class="modal-content">
						                                    <div class="modal-header">
						                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
						                                        <h4 class="modal-title">Bayar Cicilan</h4>
						                                    </div>
						                                    <div class="modal-body">

						                                        <form class="form-horizontal" role="form" method='POST' action="<?php echo $aksi ?>?mod=transaksi&act=bayar">
						                                            <input type="hidden" class="form-control round-input" name="id" value="<?php echo $m['no_transaksi'] ?>">
						                                            <div class="form-group">
										                                <label class="col-lg-2 col-sm-2 control-label">Jumlah Cicilan (Rp.)</label>
										                                <div class="col-lg-10">
										                                    <input type="text" name="nominal" class="form-control currency4">
										                                </div>
										                            </div>
										                            <br>
						                                            <div class="form-group">
						                                                <div class="col-lg-12">
						                                                    <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
						                                                </div>
						                                            </div>
						                                        </form>

						                                    </div>

						                                </div>
						                            </div>
						                        </div>
		                                   		<?php	
		                                   		}
		                                   		?>
		                                   		<a href="<?php echo $linkaksit ?>&act=printout&id=<?php echo $m['no_transaksi'] ?>" ><button class="btn btn-info btn-sm"><i class="fa fa-search"></i></button> </a>
												<a href="<?php echo $aksi ?>?mod=transaksi&act=hapus&id=<?php echo $m['no_transaksi'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>


												
											</td>
											 
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

