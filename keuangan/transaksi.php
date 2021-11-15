<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['admin']) AND $_SESSION['keuangan'] <> 'TRUE')
	{
		?>
		  <div class="alert alert-danger alert-dismissible" id="succsess-alert">
	        <button type="button" class="close" data-dismiss="alert" aria-text="true">&times;</button>
	        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	        Dilarang mengakses file ini.
	      </div>
		<?php
	}
	else{
	
	//link buat paging
	if($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin'){
		$linkaksi = 'med.php?mod=transaksi';
	}else {
		$linkaksi = 'med2.php?mod=transaksi';
	}
	

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		//$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/keuangan/act_transaksi.php';

	?>
	<?php
	switch ($act) {
		case 'aksi':

					$nis = $_GET['nis'];
					$thn = $_GET['thn'];

			flash('example_message');
			?>
			        <!-- page start-->
				        <div class="row">
				            
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
			                        	if ($_SESSION['level']=='xmahad') {
		                        			$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Lama' AND `pembayaran` LIKE '%Mahad%' order by urutan asc";
											$sqljp = mysqli_query($conn,$qjp);
		                        		}elseif ($_SESSION['level']=='xmadrasah') {                        			
											$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Lama' AND `pembayaran` LIKE '%Madrasah%' order by urutan asc";
											$sqljp = mysqli_query($conn,$qjp);	
		                        		}elseif ($_SESSION['level']=='xkemaarifan') {                        			
											$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Lama' AND `pembayaran` LIKE '%Sorogan%' order by urutan asc";
											$sqljp = mysqli_query($conn,$qjp);	
		                        		}else{                        			
											$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Lama' order by urutan asc";
											$sqljp = mysqli_query($conn,$qjp);	
		                        		}	
											$i=1;
											while ($jp = mysqli_fetch_assoc($sqljp)) {
										?>

				                        <div class="table-responsive">
			                            <table class="table table-striped">
			                                <thead>
			                                <tr>
			                                    <th colspan="4"><?php echo $jp['pembayaran'] ?></th>
			                                </tr>
			                                </thead>
			                                <tbody>
			                            	<?php
			                            	   
												$query = "SELECT DISTINCT a.*
														 FROM pembayaran as a 
														 LEFT JOIN `detail_transaksi_tmp` as b ON a.id = b.`idpembayaran` AND b.`petugas` = '$_SESSION[id_user]'
														 WHERE b.id IS NULL AND `idjenispembayaran` = '$jp[id]' OR b.`petugas` != '$_SESSION[id_user]'";
												$sql_kul = mysqli_query($conn,$query);	
												$x=1;
												while ($m = mysqli_fetch_assoc($sql_kul)) {
											?>
			                                <tr>
			                                	<form method="POST" action="<?php echo $aksi ?>?mod=transaksi&act=add&jenis=lama">
			                                    <td><?php echo $x ?></td>
			                                    <td><?php echo $m['nama'] ?></td>
			                                    <td align="right">Rp. <?php echo number_format($m['harga']) ?></td>
			                                    <td>
													<input type='hidden' name='harga' value='<?php echo $m["harga"] ?>'>
													<input type='hidden' name='id' value='<?php echo $m['id'] ?>'>
													<input type='hidden' name='nis' value='<?php echo $nis ?>'>
													<input type='hidden' name='thn' value='<?php echo $thn ?>'>
			                                    	<span class="input-group-btn">
								                      <button type="submit" class="btn btn-info btn-flat btn-xs"><i class='fa fa-shopping-cart'></i> ADD</button>
								                    </span>

			                                    </td>
			                                	</form>
			                                </tr>
			                                <?php
			 									 $x++;
			 								 }
			 								?>
			                                </tbody>
			                            </table>
			                        	</div>
			                            <?php
											 $i++;
										 }
										?>
			                        </div>
			                    </section>
			                </div>

			                <div class="col-xs-12 col-lg-6">
					            <section class="panel">
					                <header class="panel-heading">
					                	Pembayaran
					                    <span class="tools pull-right">
					                        <a href="javascript:;" class="fa fa-chevron-down"></a>
					                        <a href="javascript:;" class="fa fa-cog"></a>
					                        <a href="javascript:;" class="fa fa-times"></a>
					                     </span>
					                </header>
									
									
					                <form action="<?php echo $aksi ?>?mod=transaksi&act=simpan" name='autoSumForm' role="form" method="POST" >
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
				                        		<table class="table table-striped table-hover table-bordered">
				                        				<thead>
										                <tr>
															<th>#</th>
															<th>Pembayaran</th>
															<th>HARGA</th>
															<td></td>
										                </tr>
										                </thead>
										                <tbody>
														

								                        <?php
								                        	if ($_SESSION['level']=='xmahad') {
							                        			$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Lama' AND `pembayaran` LIKE '%Mahad%' order by urutan asc";
																$sqljp = mysqli_query($conn,$qjp);
							                        		}elseif ($_SESSION['level']=='xmadrasah') {                        			
																$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Lama' AND `pembayaran` LIKE '%Madrasah%' order by urutan asc";
																$sqljp = mysqli_query($conn,$qjp);	
							                        		}else{                        			
																$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Lama' order by urutan asc";
																$sqljp = mysqli_query($conn,$qjp);	
							                        		}	
															$i=1;
															while ($jp = mysqli_fetch_assoc($sqljp)) {
														?>	
														<tr>
															<th colspan="4"><?php echo $jp['pembayaran'] ?></th>
														</tr>
														<?php
														$sql_tmp = mysqli_query($conn,"SELECT a.id, a.harga, b.nama
																				FROM detail_transaksi_tmp a, pembayaran b
																				WHERE a.idpembayaran = b.id AND b.`idjenispembayaran` = '$jp[id]' AND a.`petugas` = '$_SESSION[id_user]' 
																				ORDER BY a.timestmp ASC") or die(mysqli_error());
														$no = 1;
														$tot = 0;
														if(mysqli_num_rows($sql_tmp) > 0)
														{ 
															while ($b = mysqli_fetch_assoc($sql_tmp)) {
																$untung = $b['harga'];
																$tyt[] = $untung; 
														?>
															<tr>
																<td><?php echo $no ?></td>
																<td><?php echo $b['nama'] ?></td>
																<td><?php echo number_format($b['harga']) ?> </td>
																<td  align="center">
																<a href="<?php echo $aksi ?>?mod=transaksi&act=batal&id=<?php echo $b['id'] ?>&nis=<?php echo $nis ?>&thn=<?php echo $thn ?>&jenis=lama" onclick="return confirm('Yakin ingin membatalkan?');"><i class="fa fa-times text-danger"></i></a>
																</td>
															</tr>
														<?php
															$tot += $untung;
															$no++;
															}
														}
														else
														{
														    
															$tot = 0;
															$tyt[] = "0";
															?>
															<tr>
																<td colspan="4" align="center"><i>Keranjang Kosong</i></td>
															</tr>
															<?php
														}
														?>

							                            <?php
															 $i++;
														 }
														?>
										                </tbody>

										                <tfoot>
										                	<tr>		                		
											                	<td colspan="2"><b>TOTAL</b></td>
											                	<?php
											                	
                                                                $jml_nilai    =array_sum($tyt);
											                	$qttl = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `detail_transaksi_tmp` WHERE `petugas` = '$_SESSION[id_user]'");
											                	$ttl = mysqli_fetch_assoc($qttl);
											                	?>
											                	<td colspan="2" align="right"><b class="text-danger">Rp. <?php echo number_format($jml_nilai) ?></b></td>
											                	<input type='hidden' name='angsuran_pokok' style="text-align:right;" value="<?php echo $jml_nilai ?>"  size='23'   onFocus="startCalc();" onBlur="stopCalc();" />
										                	</tr>
										                	<tr>
										                		<td colspan="2"><b>POTONGAN HARGA (Rp.)<b></td>
										                		<td colspan="2"><input type='text' name='potongan2' id="potongan" style="text-align:right;"  class='form-control' value='0' onFocus="startCalc();" onBlur="stopCalc();"></td>
										                	</tr>		                	
										                	<tr class="bg-danger">		                		
											                	<td colspan="2"><b>TOTAL BAYAR</b></td>
											                	<td colspan="3"><input type=text value='<?php echo $jml_nilai ?>' name="total" class='form-control' onchange='tryNumberFormat(this.form.thirdBox);' style="text-align:right;" readonly></td>
										                	</tr>
										                </tfoot>
				                        		</table>
						                        <script>

												function startCalc(){
												interval = setInterval("calc()",1);}
												function calc(){
												one = document.autoSumForm.angsuran_pokok.value;
												three = document.autoSumForm.potongan.value; 
												document.autoSumForm.total.value = (one * 1) - (three * 1);}
												function stopCalc(){
												clearInterval(interval);}
												</script>
												<div class="p-3 mb-2 bg-info text-white">


													<input type='hidden' name='jmlbayar2' id='bayar2'>
									              <div class="box-body" >
									                <!--<div class="form-group">
									                  <label >Santri</label>
									                  <select id="e2" class="populate " name="nis" class="form-control round-input" style="width: 490px">
									                  	  <?php
									                  	  $sql_kelas = mysqli_query($conn,"SELECT * FROM kelas");
			                                                while($k = mysqli_fetch_assoc($sql_kelas))
			                                                {
									                  	  ?>
									                  	  <optgroup label="KELAS <u><?php echo $k['kelas'] ?></u>">
				                                          <?php
				                                                    $sql_angkatan = mysqli_query($conn,"SELECT nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas, k.id as idkelas
																	FROM siswa as s 
			                                                        left join kelas k on s.idkelas = k.id
			                                                        left join tahunajaran t on t.id = k.idtahunajaran
			                                                        where k.id ='$k[id]' AND s.alumni=0");
				                                            while($k = mysqli_fetch_assoc($sql_angkatan))
				                                            {
				                                              
				                                                echo"<option value='$k[nis]'>$k[nama] - $k[nis]</option>";
				                                              
				                                            }
				                                                    ?>
				                                            </optgroup>
				                                            <?php
				                                        	}
				                                            ?>
				                                    </select>
									                </div>
									            -->
									                <div class="form-group">
									                  <label >Bayar (Rp.)</label>
									                  <input type="text" class="form-control currency4" required  name="jmlbayar" id='rupiah1' style="text-align:right;">
									                </div>

													<input type='hidden' name='jenis' value='Lama'>
													<input type='hidden' name='nis' value='<?php echo $_GET['nis'] ?>'>
									                <div class="form-group">

					                 					 <label>Pembayaran</label>
									                	<select class="form-control" name="status" required>
									                		<option value="Lunas">Lunas</option>
									                		<option value="Hutang">Hutang</option>
									                	</select>
									                </div>
									                <div class="form-group">
					                                <label>Bulan</label>
			                                          <select name="bulan" class="form-control" required>
															<?php
															$bln=array(1=>'Muharram','Safar','Rabi’ul Awal','Rabi’ul Akhir','Jumadil Awal','Jumadil Akhir','Rajab','Sya’ban','Ramadhan','Syawal','Dzulka’dah','Dzulhijah');
															for($bulan=1; $bulan<=12; $bulan++){
															if($bulan<=9) { echo "<option value='0$bulan'>$bln[$bulan]</option>"; }
															else { echo "<option value='$bulan'>$bln[$bulan]</option>"; }
															}
															?>
			                                          </select>
						                            </div>
						                            <div class="form-group">
						                                <label>Tanggal Pembayaran</label>
						                                  <input name="tgl" class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text"  required/>
						                            </div>
									              </div>
									              <!-- /.box-body -->

									              <div class="box-footer">
									                <button type="submit" class="btn btn-primary" onclick="return confirm('Klik OK untuk melanjutkan');"><i class='fa fa-save'></i> Simpan</button>
									              </div>
									            
											</div>
				                        	</div>
				                       	</div>
				                    </div>
				                    </form>
				                </section>
				            </div>
				        </div>

		<?php
		break;
		case "printout" :
				
			if(isset($_GET['id']))
			{
				?>
				
				<?php
				$sqltrans = mysqli_query($conn,"SELECT * FROM `transaksi` WHERE `no_transaksi` = '$_GET[id]'") or die(mysqli_error());
				$tra = mysqli_fetch_assoc($sqltrans);
				$querypsn = "SELECT s.nis,s.nama,s.asalsekolah,s.tmplahir,s.tgllahir,DAY(s.tgllahir) as tgl,MONTH(s.tgllahir) as bln,YEAR(s.tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas
														FROM siswa as s 
                                                        left join kelas k on s.idkelas = k.id
                                                        left join tahunajaran t on t.id = k.idtahunajaran
                                                        where s.alumni=0 AND s.nis = '$tra[nis]'";
				$sqlpsn = mysqli_query($conn,$querypsn);				
				$psn1 = mysqli_fetch_assoc($sqlpsn);	


					                		
            	$qttl = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `detail_transaksi` WHERE no_transaksi='$_GET[id]'");
            	$ttl = mysqli_fetch_assoc($qttl);
            	
            	$qttlx = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `bayarcicilan` WHERE no_transaksi='$_GET[id]'");
            	$ttlx = mysqli_fetch_assoc($qttlx);
				$total_bayar = $ttl['total'] - $tra['potongan'];
				$sisa = $tra['bayar'] - $total_bayar;

				$result = preg_replace("/[^0-9]/", "", $sisa);
				$tsisa = $result - $ttlx['total'];
				?>
				<div class="row">

			        <div class="clearfix">

			        <div class="col-xs-12">
			            <section class="panel panel-success">			
							
	                	<header class="panel-heading">
	                		<h4>Printout Transaksi Pendaftaran</h4>

				             <p><i>Data Pembayaran</i></p>
		                </header>
			                <div class="panel-body">

								<div class="alert alert-danger alert-dismissible" id="succsess-alert">
				                	<i>Jika terjadi kesalahan harap lapor Administrator.</i>
				              	</div>
								<div class="box-body no-padding table-responsive">
					              <table class="table table-condensed">
					                <tr style='border-bottom:1px dashed #ccc;'>
										<td width='150px'>No. Transaksi</td>
										<td width='10px'>:</td>
										<td><b><?php echo $tra['no_transaksi']?></b></td>
									</tr>

									<tr style='border-bottom:1px dashed #ccc;'>
										<td>Nama / Kelas</td>
										<td>:</td>
										<td><b><?php echo $tra['nis']?> - <?php echo $psn1['nama']?> / <?php echo !empty($psn1['kelas']) ? $psn1['kelas'] : "-"; ?></b></td>
									</tr>
                                    

									<tr style='border-bottom:1px dashed #ccc;'>
										<td>Bulan</td>
										<td>:</td>
										<td><b><?php echo getBulanHijriah($tra['bulan'])?></b></td>
									</tr>
									
									<tr style='border-bottom:1px dashed #ccc;'>
										<td>Tanggal Transaksi</td>
										<td>:</td>
										<td><b><?php echo tglindo($tra['tgl_transaksi']) ?></b></td>
									</tr>

									<tr style='border-bottom:1px dashed #ccc;'>
										<td>Status</td>
										<td>:</td>
										<td><b>
										<?php
                                   		if ($sisa<0) {
                                   		?>
                                   		Hutang
                                   		<?php	
                                   		}else{
                                   		?>
                                   		Lunas
                                   		<?php	
                                   		}
										 ?></b></td>
									</tr>
					              </table>
					            </div>
					            <!-- /.box-body -->
					            <br>
					            <div class="box-header">
					              	 <h3 class="box-title"><b>Detail Pembayaran</b></h3>
					            </div>
					            <!-- /.box-header -->
					            <div class="box-body">
					              <table id="examplex" class="table table-bordered">
					                <thead>
					                <tr>
						                  <th>#</th>
										<th>Pembayaran</th>
										<th>HARGA</th>
					                </tr>
					                </thead>
					                <tbody>
									 <?php
										$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = '$tra[jenis]' order by urutan asc";
										$sqljp = mysqli_query($conn,$qjp);	
										$i=1;
										while ($jp = mysqli_fetch_assoc($sqljp)) {
									?>	
									<tr>
										<th colspan="3"><?php echo $jp['pembayaran'] ?></th>
									</tr>

									<?php
									$sql = mysqli_query($conn,"SELECT a.*, b.nama
														FROM detail_transaksi a LEFT JOIN pembayaran b 
														ON a.idpembayaran = b.id
														WHERE a.no_transaksi = '$_GET[id]'
														AND b.idjenispembayaran='$jp[id]'") or die(mysqli_error());
									
									$no = 1;
									while ($p = mysqli_fetch_assoc($sql)) {
									?>
										<tr>
											<td><?php echo $no ?></td>
											<td><?php echo $p['nama'] ?></td>
											<td>Rp. <?php echo number_format($p['harga'],0) ?> </td>
										</tr>
									<?php
										$no++;
									}
										 $i++;
									 }
									?>

					                
					                </tbody>
					                <tfoot>
					                	<tr class='bg-info'>
											<td colspan='2'>Total Harga</b></td>
											<td>Rp. <?php echo number_format($ttl['total']) ?></td>
										</tr>
										<tr class='bg-info'>
											<td colspan='2'>Potongan Harga</td>
											<td>Rp. <?php echo number_format($tra['potongan']) ?></td>
										</tr>
										<tr class='bg-info'>
											<td colspan='2'><b>Total Bayar</b></td>
											<td><b>Rp. <?php echo number_format($total_bayar) ?></b></td>
										</tr>
										<tr class='bg-info'>
											<td colspan='2'><b>Pembayaran</b></td>
											<td><b>Rp. <?php echo number_format($tra['bayar']) ?></b></td>
										</tr>

										<?php
										if ($sisa<=0) {
										?>											
										<tr class='bg-info'>
											<td colspan='2'><b>Total Bayar Cicilan</b></td>
											<td><b>Rp. <?php echo number_format($ttlx['total']) ?></b></td>
										</tr>
										<?php
										}
										?>
										<tr class='bg-info'>
											<?php
											if ($sisa<=0) {
											?>											
											<td colspan='2'><b>Sisa Pembayaran</b></td>
											<td><b>Rp. <?php echo number_format($tsisa) ?></b></td>
											<?php
											}else{
											?>											
											<td colspan='2'><b>Kembali</b></td>
											<td><b>Rp. <?php echo number_format($sisa) ?></b></td>
											<?php	
											}
											?>
										</tr>
					                </tfoot>
					              </table>
						          <p>
									<!--<button class='btn btn-default btn-sm' onclick="window.history.back()"><i class='fa fa-mail-reply-all'></i> Back</button>-->

		                            <?php if($_SESSION['level']=='admin' or $_SESSION['level']=='keuangan'){?>
									<a href='<?php echo $linkaksi ?>' class='btn btn-info btn-sm'><i class='fa fa-cart-plus'></i> Transaksi Baru</a>
									<?php } ?>
									<a href="popup/popup.php?mod=cetakkwitansi&id=<?php echo $_GET['id'] ?>" class='btn btn-warning btn-sm' target='_blank'><i class='fa fa-print'></i> Cetak Kwitansi</a>
								</p>
					            </div>
			                </div>
			            </section>
			        </div>
			    	</div>
			    </div>

				<?php

			}
		break;
		case 'baru':
		    if (isset($_POST['nis'])=='1') {
	        	$nis=$_POST['nis'];
	        }else{

	        	$nis=$_GET['nis'];
	        }
	        $query = mysqli_query($conn,"SELECT * FROM siswa WHERE nis = '$nis'");
	        $c = mysqli_fetch_assoc($query);
	        $nama=$c['nama'];

		flash('example_message');
		?>
		<div class="row">
				            
            <div class="col-xs-12 col-lg-6">
                <section class="panel panel-info">
                    <header class="panel-heading">
                        Pendaftaran Baru Santri <?php echo $nama ?>
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header><div class="panel-body">
                    	<?php
                    		if ($_SESSION['level']=='xmahad') {
                    			$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Baru' AND `pembayaran` LIKE '%Mahad%' order by urutan asc";
								$sqljp = mysqli_query($conn,$qjp);
                    		}elseif ($_SESSION['level']=='xmadrasah') {                        			
								$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Baru' AND `pembayaran` LIKE '%Madrasah%' order by urutan asc";
								$sqljp = mysqli_query($conn,$qjp);	
                    		}elseif ($_SESSION['level']=='xkemaarifan') {   
                    		    $qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Baru' AND `pembayaran` LIKE '%Kemaarifan%' order by urutan asc";
								$sqljp = mysqli_query($conn,$qjp);	
                    		}else{                        			
								$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Baru' order by urutan asc";
								$sqljp = mysqli_query($conn,$qjp);	
                    		}
							$i=1;
							while ($jp = mysqli_fetch_assoc($sqljp)) {
						?>

                        <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th colspan="4"><?php echo $jp['pembayaran'] ?></th>
                            </tr>
                            </thead>
                            <tbody>
                        	<?php
								$query = "SELECT DISTINCT a.*
														 FROM pembayaran as a 
														 LEFT JOIN `detail_transaksi_tmp` as b ON a.id = b.`idpembayaran` AND b.`petugas` = '$_SESSION[id_user]'
														 WHERE b.id IS NULL AND `idjenispembayaran` = '$jp[id]' OR b.`petugas` != '$_SESSION[id_user]'";
								$sql_kul = mysqli_query($conn,$query);	
								$x=1;
								while ($m = mysqli_fetch_assoc($sql_kul)) {
							?>
                            <tr>
                            	<form method="POST" action="<?php echo $aksi ?>?mod=transaksi&act=add&jenis=baru">
                                <td><?php echo $x ?></td>
                                <td><?php echo $m['nama'] ?></td>
                                <td align="right">Rp. <?php echo number_format($m['harga']) ?></td>
                                <td>
									<input type='hidden' name='harga' value='<?php echo $m["harga"] ?>'>
									<input type='hidden' name='id' value='<?php echo $m['id'] ?>'>
									<input type='hidden' name='nis' value='<?php echo $nis ?>'>
									<input type='hidden' name='nama' value='<?php echo $nama ?>'>
                                	<span class="input-group-btn">
				                      <button type="submit" class="btn btn-info btn-flat btn-xs"><i class='fa fa-shopping-cart'></i> ADD</button>
				                    </span>

                                </td>
                            	</form>
                            </tr>
                            <?php
									 $x++;
								 }
								?>
                            </tbody>
                        </table>
                    	</div>
                        <?php
							 $i++;
						 }
						?>
                    </div>
                </section>
            </div>

            <div class="col-xs-12 col-lg-6">
	            <section class="panel">
	                <header class="panel-heading">
	                	Pembayaran
	                    <span class="tools pull-right">
	                        <a href="javascript:;" class="fa fa-chevron-down"></a>
	                        <a href="javascript:;" class="fa fa-cog"></a>
	                        <a href="javascript:;" class="fa fa-times"></a>
	                     </span>
	                </header>
					
					
	                <form action="<?php echo $aksi ?>?mod=transaksi&act=simpan" name='autoSumForm' role="form" method="POST" autocomplete="off">
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
                        		<table class="table table-striped table-hover table-bordered">
                        				<thead>
						                <tr>
											<th>#</th>
											<th>Pembayaran</th>
											<th>HARGA</th>
											<td></td>
						                </tr>
						                </thead>
						                <tbody>
										

				                        <?php
				                        	if ($_SESSION['level']=='xmahad') {
			                        			$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Baru' AND `pembayaran` LIKE '%Mahad%' order by urutan asc";
												$sqljp = mysqli_query($conn,$qjp);
			                        		}elseif ($_SESSION['level']=='xmadrasah') {                        			
												$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Baru' AND `pembayaran` LIKE '%Madrasah%' order by urutan asc";
												$sqljp = mysqli_query($conn,$qjp);	
			                        		}else{                        			
												$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = 'Baru' order by urutan asc";
												$sqljp = mysqli_query($conn,$qjp);	
			                        		}
											$i=1;
											while ($jp = mysqli_fetch_assoc($sqljp)) {
										?>	
										<tr>
											<th colspan="4"><?php echo $jp['pembayaran'] ?></th>
										</tr>
										<?php
										$sql_tmp = mysqli_query($conn,"SELECT a.id, a.harga, b.nama
																FROM detail_transaksi_tmp a, pembayaran b
																WHERE a.idpembayaran = b.id AND b.`idjenispembayaran` = '$jp[id]' AND a.`petugas` = '$_SESSION[id_user]'
																ORDER BY a.timestmp ASC") or die(mysqli_error());
										$no = 1;
										$tot = 0;
										if(mysqli_num_rows($sql_tmp) > 0)
										{ 
											while ($b = mysqli_fetch_assoc($sql_tmp)) {
												$untung = $b['harga'];
												$tyt[] = $untung; 
										?>
											<tr>
												<td><?php echo $no ?></td>
												<td><?php echo $b['nama'] ?></td>
												<td><?php echo number_format($b['harga']) ?> </td>
												<td  align="center">
												<a href="<?php echo $aksi ?>?mod=transaksi&act=batal&id=<?php echo $b['id'] ?>&nama=<?php echo $nama ?>&nis=<?php echo $nis ?>&jenis=baru" onclick="return confirm('Yakin ingin membatalkan?');"><i class="fa fa-times text-danger"></i></a>
												</td>
											</tr>
										<?php
			                            	$tot += $untung;
											$no++;
											}
										}
										else
										{
											$tot = 0;
											$tyt[] = "0";
											?>
											<tr>
												<td colspan="4" align="center"><i>Keranjang Kosong</i></td>
											</tr>
											<?php
										}
										?>

			                            <?php
											 $i++;
										 }
										?>
						                </tbody>

						                <tfoot>
						                	<tr>		                		
							                	<td colspan="2"><b>TOTAL</b></td>
							                	<?php
							                	
                                                $jml_nilai    =array_sum($tyt);
							                	$qttl = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `detail_transaksi_tmp` WHERE `petugas` = '$_SESSION[id_user]'");
							                	$ttl = mysqli_fetch_assoc($qttl);
							                	?>
							                	<td colspan="2" align="right"><b class="text-danger">Rp. <?php echo number_format($jml_nilai) ?></b></td>
							                	<input type='hidden' name='angsuran_pokok' style="text-align:right;" value="<?php echo $jml_nilai ?>"  size='23'   onFocus="startCalc();" onBlur="stopCalc();" />
						                	</tr>
						                	<tr>
						                		<td colspan="2"><b>POTONGAN HARGA (Rp.)<b></td>
						                		<td colspan="2"><input type='text' name='potongan2' id="potongan" style="text-align:right;"  class='form-control' value='0' onFocus="startCalc();" onBlur="stopCalc();"></td>
						                	</tr>		                	
						                	<tr class="bg-danger">		                		
							                	<td colspan="2"><b>TOTAL BAYAR</b></td>
							                	<td colspan="3"><input type=text value='<?php echo $jml_nilai ?>' name="total" class='form-control' onchange='tryNumberFormat(this.form.thirdBox);' style="text-align:right;" readonly></td>
						                	</tr>
						                </tfoot>
                        		</table>
		                        <script>

								function startCalc(){
								interval = setInterval("calc()",1);}
								function calc(){
								one = document.autoSumForm.angsuran_pokok.value;
								three = document.autoSumForm.potongan.value; 
								document.autoSumForm.total.value = (one * 1) - (three * 1);}
								function stopCalc(){
								clearInterval(interval);}
								</script>
								<div class="p-3 mb-2 bg-info text-white">


									<input type='hidden' name='jmlbayar2' id='bayar2'>
					              <div class="box-body" >
					                <div class="form-group">
					                  <label >Santri</label>

					                  <input type="text" class="form-control" name="<?php echo $nama ?>" size="100" value="<?php echo $nama ?>" Disabled>
					                  <input type="hidden" class="form-control" id="auto" required name="nis" size="100" value="<?php echo $nis ?>">
					                  
					                </div>
					                <div class="form-group">
					                  <label >Bayar (Rp.)</label>
					                  <input type="text" class="form-control currency4" required  name="jmlbayar" id='rupiah1' style="text-align:right;" required>
					                </div>

									<input type='hidden' name='jenis' value='Baru'>
					                <div class="form-group">
					                  <label>Pembayaran</label>
					                	<select class="form-control" name="status" required>
					                		<option value="Lunas">Lunas</option>
					                		<option value="Hutang">Hutang</option>
					                	</select>
					                </div>
					                <div class="form-group">
					                  <label>Bulan</label>
                                      <select name="bulan" class="form-control" required>
											<?php
											$bln=array(1=>'Muharram','Safar','Rabi’ul Awal','Rabi’ul Akhir','Jumadil Awal','Jumadil Akhir','Rajab','Sya’ban','Ramadhan','Syawal','Dzulka’dah','Dzulhijah');
											for($bulan=1; $bulan<=12; $bulan++){
											if($bulan<=9) { echo "<option value='0$bulan'>$bln[$bulan]</option>"; }
											else { echo "<option value='$bulan'>$bln[$bulan]</option>"; }
											}
											?>
                                      </select>
		                            </div>
		                            <div class="form-group">
		                                <label>Tanggal Pembayaran</label>
		                                  <input name="tgl" class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" required />
		                            </div>
					              </div>
					              <!-- /.box-body -->

					              <div class="box-footer">
					                <button type="submit" class="btn btn-primary" onclick="return confirm('Klik OK untuk melanjutkan');"><i class='fa fa-save'></i> Simpan</button>
					              </div>
					            
							</div>
                        	</div>
                       	</div>
                    </div>
                    </form>
                </section>
            </div>
        </div>
		<?php
		break;
		case 'form':
	        if (isset($_POST['nis'])=='1') {
	        	$nis=$_POST['nis'];
	        	$idtahunajaran=$_POST['idtahunajaran'];
	        }else{

	        	$nis=$_GET['nis'];
	        	$idtahunajaran=$_GET['idtahunajaran'];
	        }
        	$sqltrans = mysqli_query($conn,"SELECT c.nis, c.nama, c.panggilan, c.tahunmasuk, c.idkelas, c.agama, b.status, a.kondisi, c.kelamin,
				   c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.tgllahir, c.warga,
				   c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa,
				   c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanayah ) as pendidikanayah
				   , (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanibu ) as pendidikanibu, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanayah) as pekerjaanayah, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanibu) as pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu,
				   c.alamatortu, c.hportu, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan, t.tahunajaran, t.id AS idtahunajaran,
				   k.kelas, c.nisn, 
	               c.noijasah,c.tglijasah,c.tmplahirayah,c.tmplahiribu,c.tgllahirayah,c.tgllahiribu,c.hobi
			  FROM siswa as c 
              JOIN kelas as k ON k.id = c.idkelas 
              JOIN tahunajaran as t ON k.`idtahunajaran` = t.id 
              LEFT JOIN kondisisiswa as a ON a.id = c.kondisi 
              LEFT JOIN statussiswa as b ON b.id = c.status
			 WHERE c.nis='$nis' AND k.idtahunajaran = '$idtahunajaran' ") or die(mysqli_error());
				$tra = mysqli_fetch_assoc($sqltrans);	        
	        
			
			flash('example_message');
			?>
			        <!-- page start-->
				        <!-- page start-->
				  
						<div class="row">
				            <div class="col-md-12">
				                <section class="panel">
				                    <div class="panel-body profile-information">
				                       <div class="col-md-3">
				                           <div class="profile-pic text-center"><?php
				                           		if ($tra['foto']=="") {
				                           			$img = "santri.png";
				                           		}else{
				                           			$img = $tra['foto'];
				                           		}
				                           		?>
				                               <img src="images/siswa/<?php echo $img ?>" alt=""/>
				                           </div>
				                       </div>
				                       <div class="col-md-9 table-responsive">
				                           <div class="profile-desk">
				                               <h1>Data Santri <?php echo $tra['nama'] ?></h1>
				                               <br>
				                               	<table class="table table-striped">                               		
					                               	<tr>
					                                    <td>Tahun Ajaran</td>
					                                    <td>:</td>
					                                    <td><?php echo $tra['tahunajaran'] ?></td>
					                                </tr>
					                                <tr>
					                                    <td>Kelas</td>
					                                    <td>:</td>
					                                    <td><?php echo $tra['kelas'] ?></td>
					                                </tr>
					                                <tr>
					                                    <td>NIS</td>
					                                    <td>:</td>
					                                    <td><?php echo $tra['nis'] ?></td>
					                                </tr>
					                                <!--<tr>
					                                    <td>NISN</td>
					                                    <td>:</td>
					                                    <td><?php echo $tra['nisn'] ?></td>
					                                </tr>-->
				                               	</table>
				                           </div>
				                       </div>
				                    </div>
				                </section>
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-sm-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        DATA PEMBAYARAN PENDAFTARAN
				                        <?php
				                        if ($_SESSION['level']=='siswa' or $_SESSION['level']=='ortu') {
	                                    }else{
	                                    ?>
	                                    <span class="tools pull-right">
				                            <a href="<?php echo $linkaksi ?>&act=aksi&nis=<?php echo $nis ?>&thn=<?php echo $idtahunajaran ?>">
											<button class="btn btn-primary btn-xs">
												Tambah Pembayaran <i class="fa fa-plus"></i>
											</button>
											</a>
				                         </span>
	                                    <?php
	                                    }                         
	                                    ?>
				                    </header>
				                    <div class="panel-body table-responsive">
				                        <table class="table table-striped table-hover table-bordered" id="example">
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>
											<th class="text-center">NO. TRANSAKSI</th>
											<th class="text-center">TGL. TRANSAKSI</th>
											<th class="text-center">BULAN</th>
											<th class="text-center">POTONGAN</th>
											<th class="text-center">TOTAL BAYAR</th>
											<th class="text-center">BAYAR</th>
											<th class="text-center">SISA BAYAR</th>
											<th class="text-center">KEMBALIAN</th>
											<th class="text-center">STATUS</th>
											<th class="text-center">PEMBAYARAN</th>
											<?php
					                        if ($_SESSION['level']=='siswa' or $_SESSION['level']=='ortu') {
		                                    }else{
		                                    ?>
											<th class="text-center">Aksi</th>
											<?php
		                                    }                         
		                                    ?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT * FROM `transaksi` WHERE `nis` = '$nis' ORDER BY tgl_transaksi";
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
		                                    <td align="center"><?php echo tglindo($m['tgl_transaksi'])?> </td>
		                                    <td align="center"><?php echo getBulanHijriah($m['bulan'])?></td>
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
		                                    <?php
					                        if ($_SESSION['level']=='siswa' or $_SESSION['level']=='ortu') {
		                                    }else{
		                                    ?>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>		
		                                        <a href="<?php echo $linkaksi ?>&act=aksi&id=<?php echo $m['no_transaksi'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>					
		                                   --> 
		                                   		<?php
		                                   		if ($sisa<0) {
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
		                                   		<a href="<?php echo $linkaksi ?>&act=printout&id=<?php echo $m['no_transaksi'] ?>" ><button class="btn btn-info btn-sm"><i class="fa fa-search"></i></button> </a>
		                                   		<?php if($_SESSION['level']=='admin' or $_SESSION['level']=='keuangan'){?>
												<a href="<?php echo $linkaksi ?>&act=hapus&id=<?php echo $m['no_transaksi'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

												<?php }?>

												
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
		        <div class="col-lg-12">
		            <section class="panel">
    	                <header class="panel-heading tab-bg-dark-navy-blue ">
    	                    <ul class="nav nav-tabs nav-justified">
    	                        <li class="active">
    	                            <a data-toggle="tab" href="#home">PENDAFTARAN SANTRI BARU</a>
    	                        </li>
    	                        <li class="">
    	                            <a data-toggle="tab" href="#about">PEMBAYARAN SANTRI LAMA</a>
    	                        </li>
    	                    </ul>
    	                </header>
    	                <div class="panel-body">
    	                    <div class="tab-content">
    	                        <div id="home" class="tab-pane active">         
    					            
        				            <form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=baru' enctype="multipart/form-data">
                        	            <div class="col-lg-12">
                        	                <section class="panel">
                        	                    <div class="panel-body">
                        	                        <div class="position-center">
                        
                        	                            <div class="form-group">
                                                          <label class="col-lg-2 col-sm-2 control-label">Santri</label>
                                                          	<div class="col-lg-10">
                                                              	<select class="populate e1p " name="nis"  style="width: 100%">
                        	                                          <?php
                        	                                           $sql_penilaian = mysqli_query($conn,"SELECT a.*
                        		                                                FROM `kelas` as a
                        		                                                JOIN `pegawai` as b on a.nipwali = b.nip
                        		                                                JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
                        		                                                WHERE c.aktif = 'Aktif' ORDER BY a.kelas");
                        		                                            while($k = mysqli_fetch_assoc($sql_penilaian))
                        		                                            {
                        		                                            	 echo"<optgroup label='KELAS $k[kelas]'>";
                        
                        	                                                    $sql_angkatan = mysqli_query($conn,"SELECT nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas
                        														FROM siswa as s 
                        	                                                    left join kelas k on s.idkelas = k.id
                        	                                                    left join tahunajaran t on t.id = k.idtahunajaran
                        	                                                    where s.alumni=0 AND k.id='$k[id]'");
                        			                                            while($s = mysqli_fetch_assoc($sql_angkatan))
                        			                                            {
                        			                                              
                        			                                                echo"<option value='$s[nis]'>( $s[kelas] ) - $s[nis] - $s[nama]</option>";
                        			                                              
                        			                                            }
                        			                                            echo "</optgroup>";
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
    	                        <div id="about" class="tab-pane">
    		                        
    				                <form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=form' enctype="multipart/form-data">
                        	            <div class="col-lg-12">
                        	                <section class="panel">
                        	                    <div class="panel-body">
                        	                        <div class="position-center">
                        
                        	                            <div class="form-group">
                                                          <label class="col-lg-2 col-sm-2 control-label">Santri</label>
                                                          	<div class="col-lg-10">
                                                              	<select id="e2" class="populate " name="nis" class="form-control round-input" style="width: 100%">
                        	                                          <?php
                        	                                           $sql_penilaian = mysqli_query($conn,"SELECT a.*
                        		                                                FROM `kelas` as a
                        		                                                JOIN `pegawai` as b on a.nipwali = b.nip
                        		                                                JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
                        		                                                WHERE c.aktif = 'Aktif' ORDER BY a.kelas");
                        		                                            while($k = mysqli_fetch_assoc($sql_penilaian))
                        		                                            {
                        		                                            	 echo"<optgroup label='KELAS $k[kelas]'>";
                        
                        	                                                    $sql_angkatan = mysqli_query($conn,"SELECT nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas
                        														FROM siswa as s 
                        	                                                    left join kelas k on s.idkelas = k.id
                        	                                                    left join tahunajaran t on t.id = k.idtahunajaran
                        	                                                    where s.alumni=0 AND k.id='$k[id]'");
                        			                                            while($s = mysqli_fetch_assoc($sql_angkatan))
                        			                                            {
                        			                                              
                        			                                                echo"<option value='$s[nis]'>( $s[kelas] ) - $s[nis] - $s[nama]</option>";
                        			                                              
                        			                                            }
                        			                                            echo "</optgroup>";
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
    		                    
    	                    </div>
    	                </div>
    	            </section>
		        <!--
		        <?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='keuangan'){?>
                	<a href="<?php echo $linkaksi ?>&act=baru">
					<button class="btn btn-primary">
						Pembayaran Santri Baru <i class="fa fa-plus"></i>
					</button>
					</a>
				<?php }?>
		        </div>
		        <br>
		        <br>
		        <br>-->
	       
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
<script type="text/javascript">
	$(function(){
		$("#harga").number(true);

		$('#harga').keyup(function(){
			var bayar = $('#harga').val();
			$('#harga2').val(bayar);
			console.log(bayar);
		});
	})
</script>


<script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/
var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/


<?php
	$sqlTags = mysqli_query($conn,"SELECT * FROM `siswa` where alumni=0") or die(mysqli_error());

	$tags = array();
	while($t = mysqli_fetch_assoc($sqlTags))
	{
		$tags[] = '"'.$t['nama'].' - '.$t['nis'].'"';
	}
?>
var availableTags = [<?php echo implode(",",$tags); ?>];
autocomplete(document.getElementById("auto"), availableTags);

</script>