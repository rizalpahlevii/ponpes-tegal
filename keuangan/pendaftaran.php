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
	if($_SESSION['level']=='keuangan' OR $_SESSION['level']=='keuangan mahad' OR $_SESSION['level']=='keuangan madrasah' OR $_SESSION['level']=='keuangan kemaarifan' OR $_SESSION['level']=='pendaftaran'){
		$linkaksi = 'med2.php?mod=pendaftaran';
		$linkaksit = 'med2.php?mod=transaksi';
	}elseif ($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin') {
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
		        <div class="row">

        	        <form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=detail' enctype="multipart/form-data">
        	            <div class="col-lg-12">
        	                <section class="panel">
        	                    <header class="panel-heading">
        	                    </header>
        	                    <div class="panel-body">
        	                        <div class="position-center">
        
        	                            <div class="form-group">
                                          <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
                                          	<div class="col-lg-10">
                                              	<select id="e2" class="populate " name="kelas" class="form-control round-input" style="width: 100%">
                                              		   <option value="semua">Semua Kelas</option>
        	                                          <?php
        	                                                    $sql_angkatan = mysqli_query($conn,"SELECT a.* 
        																	FROM `kelas` as a 
        																	JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
        																	WHERE b.`aktif` = 'Aktif'");
        	                                            while($k = mysqli_fetch_assoc($sql_angkatan))
        	                                            {
        	                                              
        	                                                echo"<option value='$k[id]'>$k[kelas]</option>";
        	                                              
        	                                            }
        	                                                    ?>
        	                                    </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="col-lg-2 col-sm-2 control-label">Tahun Ajaran</label>
                                          	<div class="col-lg-10">
                                              	<select  id="e1" class="populate" name="idtahunajaran" class="form-control round-input" style="width: 100%">
                                                  <?php
                                                            $sql_penilaian = mysqli_query($conn,"SELECT * FROM `tahunajaran` WHERE `aktif` = 'Aktif'");
                                                    while($k = mysqli_fetch_assoc($sql_penilaian))
                                                    {
                                                      
                                                        echo"<option value='$k[id]'>$k[tahunajaran]</option>";
                                                      
                                                    }
                                                            ?>
                                              	</select>
                                            </div>
                                        </div>
        	                            
        	                                                     
        	                            <div class="form-group">
        	                                <div class="col-lg-offset-2 col-lg-10">
        						                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Next</button>
        						                <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
        	                                </div>
        	                            </div>
        	                        </div>
        
        		                    
        	                    </div>
        
        	                    
        	                </section>
        
        	            </div>
        
        	        </form>    
	            </div>
			<?php
		break;
		case 'detail':
		    flash('example_message');
		    if ($_POST['kelas']!=='semua') {
				$qkls="WHERE b.idkelas='$_POST[kelas]'";
				$qkls1="AND b.idkelas='$_POST[kelas]'";
			}else{
				$qkls='';
				$qkls1='';
			}
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
							
		                        <div class="adv-table editable-table table-responsive" style="overflow-x:auto;">
		                            <div class="clearfix">
		                                <div class="btn-group">
		                                </div>
		                                <div class="btn-group pull-right">
		                                   
		                                </div>
		                            </div>
		                            <div class="space12"></div>
		                            <table class="table table-striped table-hover table-bordered" id="example" >
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>
											<th class="text-center">NO. TRANSAKSI</th>
											<th class="text-center">NAMA</th>
											<th class="text-center">KELAS</th>
											<th class="text-center">TGL. TRANSAKSI</th>
											<th class="text-center">POTONGAN</th>
											<th class="text-center">TOTAL BAYAR</th>
											<th class="text-center">BAYAR</th>
											<th class="text-center">SISA BAYAR</th>
											<th class="text-center">KEMBALIAN</th>
											<th class="text-center">STATUS</th>
											<th class="text-center">PEMBAYARAN</th>
											<th class="text-center">Aksi</th>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
		                                	if ($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin' OR $_SESSION['level']=='keuangan mahad' OR $_SESSION['level']=='keuangan madrasah') {
		                                		
												$query = "SELECT a.*, b.`nis`, b.`nama`, c.`kelas`
														FROM `transaksi` as a
														JOIN `siswa` as b ON a.`nis` = b.`nis`
                                                        LEFT JOIN `kelas` as c ON b.`idkelas` = c.`id` 
                                                        $qkls
                                                        ORDER BY a.tgl_transaksi";
		                                	}elseif($_SESSION['level']=='keuangan kemaarifan'){
		                                	    $query = "SELECT DISTINCT a.*, b.`nis`, b.`nama`, c.`kelas`
														FROM `transaksi` as a
														JOIN `siswa` as b ON a.`nis` = b.`nis`
                                                        LEFT JOIN `kelas` as c ON b.`idkelas` = c.`id` 
                                                        RIGHT JOIN `detail_transaksi` AS d ON a.`no_transaksi` = d.`no_transaksi`
                                                        RIGHT JOIN `pembayaran` as e 
														ON d.idpembayaran = e.`id`
                                                        WHERE e.idjenispembayaran IN ('5','6') $qkls1
                                                        ORDER BY a.tgl_transaksi";
		                                	}else{

												$query = "SELECT a.*, b.`nis`, b.`nama`, c.`kelas`
														FROM `transaksi` as a
														JOIN `siswa` as b ON a.`nis` = b.`nis`
                                                        LEFT JOIN `kelas` as c ON b.`idkelas` = c.`id`
                                                        WHERE a.`petugas` = '$_SESSION[id_user]' $qkls1
                                                        ORDER BY a.tgl_transaksi";
		                                	}
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
											$qttl = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `detail_transaksi` WHERE no_transaksi='$m[no_transaksi]'");
							                	$ttl = mysqli_fetch_assoc($qttl);

							                	$qttlx = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `bayarcicilan` WHERE no_transaksi='$m[no_transaksi]'");
							                	$ttlx = mysqli_fetch_assoc($qttlx);
							                	
												if ($m['status'] == 'Hutang'){
												    $total_bayar = $ttl['total'] - $m['potongan'];
    												$bayar = $m['bayar'] + $ttlx['total'];
    												 $sisa = $m['bayar'] - $total_bayar;
    												$result = preg_replace("/[^0-9]/", "", $sisa);
    												$jdc = $bayar - $total_bayar;
							                	    
							                	}else{
							                	    $total_bayar = $ttl['total'] - $m['potongan'];
    												$sisa = $m['bayar'] - $total_bayar;
    												$bayar = $m['bayar'] + $ttlx['total'];
    												$result = preg_replace("/[^0-9]/", "", $sisa);
    												$jdc = $sisa;
							                	}
												$tsisa = $result - $ttlx['total'];
												$hsisa = $total_bayar - $bayar;
												
												
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['no_transaksi'] ?></td>
		                                    <td align="center"><?php echo $m['nama'] ?></td>
		                                    <td align="center"><?php echo $m['kelas'] ?></td>
		                                    <td align="center"><?php echo tglindo($m['tgl_transaksi'])?> </td>
		                                    <td align="center">Rp. <?php echo number_format($m['potongan']) ?></td>
		                                    <td align="center">Rp. <?php echo number_format($total_bayar) ?></td>
		                                    <td align="center">Rp. <?php echo number_format($bayar) ?></td>
		                                    <?php
		                                   		if ($sisa<0) {
		                                   		?>
    		                                    <td align="center">
    		                                        Rp. <?php echo number_format($tsisa) ?>
    		                                    </td>
    		                                    <td align="center"></td>
		                                   		<?php	
		                                   		}else{
		                                   		?>
		                                   		<td align="center"></td>
		                                   		<td align="center">
    		                                        Rp. <?php echo number_format($tsisa) ?>
    		                                    </td>
		                                   		<?php	
		                                   		}
		                                   		?>
		                                    
		                                    <td align="center">
		                                    	<?php
		                                   		if ($jdc<0) {
		                                   		    //echo $jdc;
		                                   		?>
		                                   		Hutang 
		                                   		<?php	
		                                   		}else{
		                                   		   //echo $jdc;
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
		                                        if($_SESSION['level']=='admin' OR $_SESSION['level']=='keuangan mahad' OR $_SESSION['level']=='keuangan madrasah'){
		                                        } 
		                                        ?>
		                                        <a href="#" data-toggle="modal" class="btn btn-success btn-sm" data-target="#mdlbayaredit<?php echo $m['no_transaksi']; ?>">
				                                    <i class="fa fa-edit"></i>
				                                </a>
				                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="mdlbayaredit<?php echo $m['no_transaksi']; ?>" class="modal fade">
						                            <div class="modal-dialog">
						                                <div class="modal-content">
						                                    <div class="modal-header">
						                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
						                                        <h4 class="modal-title">Pembayaran Pertama</h4>
						                                    </div>
						                                    <div class="modal-body">

						                                        <form class="form-horizontal" role="form" method='POST' action="<?php echo $aksi ?>?mod=transaksi&act=editbayar">
						                                            <input type="hidden" class="form-control round-input" name="id" value="<?php echo $m['no_transaksi'] ?>">
						                                            <div class="form-group">
										                                <label class="col-lg-2 col-sm-2 control-label">Jumlah Bayar (Rp.)</label>
										                                <div class="col-lg-10">
										                                    <input type="text" value="<?php echo $m['bayar'] ?>" name="nominal" class="form-control currency4">
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
		                                   		if ($jdc<0) {
		                                   		?>
		                                   		<a href="#" data-toggle="modal" class="btn btn-primary btn-sm" data-target="#mdlbaruedit<?php echo $m['no_transaksi']; ?>">
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

