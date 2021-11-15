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
	if($_SESSION['level']=='keuangan'){
		$linkaksi = 'med2.php?mod=laporanpendaftaran';
	}elseif ($_SESSION['level']=='admin') {
		$linkaksi = 'med.php?mod=laporanpendaftaran';
	}else{	
		$linkaksi = 'med2.php?mod=laporanpendaftaran';
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

	$aksi = 'mod/keuangan/act_laporanpendaftaran.php';

	?>
	<?php
	switch ($act) {
		case 'aksi':
			
        	$sqltrans = mysqli_query($conn,"SELECT c.nis, c.nama, c.panggilan, c.tahunmasuk, c.idkelas, c.agama, b.status, a.kondisi, c.kelamin,
				   c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.tgllahir, c.warga,
				   c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa,
				   c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanayah ) as pendidikanayah
				   , (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanibu ) as pendidikanibu, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanayah) as pekerjaanayah, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanibu) as pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu,
				   c.alamatortu, c.hportu, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan, t.tahunajaran, t.id AS idtahunajaran,
				   k.kelas, c.nisn, 
	               c.noijasah,c.tglijasah,c.tmplahirayah,c.tmplahiribu,c.tgllahirayah,c.tgllahiribu,c.hobi
			  FROM siswa as c
              JOIN kelas AS k ON k.id = c.idkelas 
              JOIN tahunajaran AS t ON t.id = k.idtahunajaran
              LEFT JOIN kondisisiswa AS a ON a.id = c.kondisi
              LEFT JOIN statussiswa AS b ON b.id = c.status
			 WHERE c.nis='$_SESSION[login_user]'") or die(mysqli_error());	  
			$tra = mysqli_fetch_assoc($sqltrans);
			$nis = $tra['nis'];
			flash('example_message');
			?>
			        <!-- page start-->
				        <!-- page start-->
				  
						
				        <div class="row">
				            <div class="col-sm-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        DATA PEMBAYARAN PENDAFTARAN
				                    </header>
				                    <div class="panel-body table-responsive">
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
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT * FROM `transaksi` WHERE `nis` = '$nis'";
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
		                                    <td align="center"><?php echo $m['status'] ?></td>
		                                    <td align="center">Pendaftaran <?php echo $m['jenis'] ?></td>
											 
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
		case 'form':
			if ($_POST['kelas']!=='semua') {
				$qkls="AND c.idkelas='$_POST[kelas]'";
			}else{
				$qkls='';
			}
        	$sqltrans = mysqli_query($conn,"SELECT d.no_transaksi, d.`tgl_transaksi`, d.`status` as jp, d.`bayar`, d.`potongan`, d.`jenis`, c.nis, c.nama, c.panggilan, c.tahunmasuk, c.idkelas, c.agama, b.status, a.kondisi, c.kelamin,
				   c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.tgllahir, c.warga,
				   c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa,
				   c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanayah ) as pendidikanayah
				   , (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanibu ) as pendidikanibu, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanayah) as pekerjaanayah, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanibu) as pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu,
				   c.alamatortu, c.hportu, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan, t.tahunajaran, t.id AS idtahunajaran,
				   k.kelas, c.nisn, 
	               c.noijasah,c.tglijasah,c.tmplahirayah,c.tmplahiribu,c.tgllahirayah,c.tgllahiribu,c.hobi
			  FROM siswa as c
              LEFT JOIN kelas as k ON k.id = c.idkelas
              LEFT JOIN tahunajaran as t ON t.id = k.idtahunajaran
              LEFT JOIN kondisisiswa as a ON a.id = c.kondisi
              LEFT JOIN statussiswa as b ON b.id = c.status
              LEFT JOIN transaksi AS d ON c.nis = d.nis
			 WHERE k.idtahunajaran = '$_POST[idtahunajaran]' $qkls ") or die(mysqli_error());	        
	        
			
			flash('example_message');
			?>
			        <!-- page start-->
				        <!-- page start-->
				  
						
				        <div class="row">
				            <div class="col-sm-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        DATA PEMBAYARAN PENDAFTARAN
				                    </header>
				                    <div class="panel-body table-responsive" style="overflow-x:auto;">
				                        <table class="table table-striped table-hover table-bordered" id="example" >
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>
											<th class="text-center">NIS</th>
											<th class="text-center">NAMA</th>
											<th class="text-center">KELAS</th>
											<th class="text-center">NO. TRANSAKSI</th>
											<th class="text-center">TGL. TRANSAKSI</th>
											<th class="text-center">POTONGAN</th>
											<th class="text-center">TOTAL BAYAR</th>
											<th class="text-center">BAYAR</th>
											<th class="text-center">SISA BAYAR</th>
											<th class="text-center">KEMBALIAN</th>
											<th class="text-center">STATUS</th>
											<th class="text-center">PEMBAYARAN</th>

										</tr>
		                                </thead>
		                                <tbody>
		                                <?php	
											$i=1;
											$subtot=0;
                                			 $subbayar=0;
                                			 $subsisa=0;
                                			  $subkmb=0;
                                			  $subpt=0;
											while ($m = mysqli_fetch_assoc($sqltrans)) {
											$qttl = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `detail_transaksi` WHERE no_transaksi='$m[no_transaksi]'");
							                	$ttl = mysqli_fetch_assoc($qttl);

							                	$qttlx = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `bayarcicilan` WHERE no_transaksi='$m[no_transaksi]'");
							                	$ttlx = mysqli_fetch_assoc($qttlx);
							                	
												if ($m['status'] == 'Hutang'){
												    $total_bayar = $ttl['total'] - $m['potongan'];
    												$bayar = $m['bayar'] + $ttlx['total'];
    												 $sisa = $m['bayar'] - $total_bayar;
    												$result = preg_replace("/[^0-9]/", "", $sisa);
    												$jdc = $total_bayar - $bayar;
							                	    
							                	}else{
							                	    $total_bayar = $ttl['total'] - $m['potongan'];
    												$sisa = $m['bayar'] - $total_bayar;
    												$bayar = $m['bayar'] + $ttlx['total'];
    												$result = preg_replace("/[^0-9]/", "", $sisa);
    												$jdc = $sisa;
							                	}
												$tsisa = $result - $ttlx['total'];
												$hsisa = $total_bayar - $bayar;
												$subtot += $total_bayar;
                        						$subbayar += $bayar;
                                			    $subpt += $m['potongan'];
                        						    
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['nis'] ?></td>
		                                    <td align="center"><?php echo $m['nama'] ?></td>
		                                    <td align="center"><?php echo $m['kelas'] ?></td>
		                                    <td align="center"><?php echo $m['no_transaksi'] ?></td>
		                                    <td align="center"><?php echo tglindo($m['tgl_transaksi'])?> </td>
		                                    <td align="center">Rp. <?php echo number_format($m['potongan']) ?></td>
		                                    <td align="center">Rp. <?php echo number_format($total_bayar) ?></td>
		                                    <td align="center">Rp. <?php echo number_format($bayar) ?></td>
		                                    
		                                    <?php
		                                   		if ($sisa<0) {
		                                   		    $subsisa += $tsisa;
		                                   		?>
    		                                    <td align="center">
    		                                        Rp. <?php echo number_format($tsisa) ?>
    		                                    </td>
    		                                    <td align="center"></td>
		                                   		<?php	
		                                   		}else{
		                                   		    $subkmb += $tsisa;
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
		                                   		   // echo $jdc;
		                                   		?>
		                                   		Lunas
		                                   		<?php	
		                                   		}
		                                   		?>
		                                    </td>
		                                    <td align="center">Pendaftaran <?php echo $m['jenis'] ?></td>
		                                    
											 
		                                </tr>
										
		                                <?php
		 									 $i++;
		 								 }
		 								?>
		                                </tbody>
		                                <tfoot>
		                                    <tr class='bg-info'>
		                                        <td colspan="6">TOTAL</td>
		                                        <td align="right"><?php echo number_format($subpt); ?></td>
		                                        <td align="right"><?php echo number_format($subtot); ?></td>
		                                        <td align="right"><?php echo number_format($subbayar); ?></td>
		                                        <td align="right"><?php echo number_format($subsisa); ?></td>
		                                        <td align="right"><?php echo number_format($subkmb); ?></td>
		                                        <td></td>
		                                    </tr>
		                                </tfoot>
		                            </table>
				                    </div>
				                </section>
				            </div>
				        </div>
			<?php
		
		break;
		default :
		flash('example_message');
			    $query = "SELECT * FROM `tahunajaran` WHERE `aktif` = 'Aktif' ORDER BY `tglmulai` DESC LIMIT 1";
				$sql_kul = mysqli_query($conn,$query);	
				$thnajr = mysqli_fetch_assoc($sql_kul);
				
		        $sqltrans = mysqli_query($conn,"SELECT d.no_transaksi, d.`tgl_transaksi`, d.`status` as jp, d.`bayar`, d.`potongan`, d.`jenis`, c.nis, c.nama, c.panggilan, c.tahunmasuk, c.idkelas, c.agama, b.status, a.kondisi, c.kelamin,
				   c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.tgllahir, c.warga,
				   c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa,
				   c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanayah ) as pendidikanayah
				   , (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanibu ) as pendidikanibu, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanayah) as pekerjaanayah, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanibu) as pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu,
				   c.alamatortu, c.hportu, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan, t.tahunajaran, t.id AS idtahunajaran,
				   k.kelas, c.nisn, 
	               c.noijasah,c.tglijasah,c.tmplahirayah,c.tmplahiribu,c.tgllahirayah,c.tgllahiribu,c.hobi
    			  FROM siswa as c
                  LEFT JOIN kelas as k ON k.id = c.idkelas
                  LEFT JOIN tahunajaran as t ON t.id = k.idtahunajaran
                  LEFT JOIN kondisisiswa as a ON a.id = c.kondisi
                  LEFT JOIN statussiswa as b ON b.id = c.status
                  LEFT JOIN transaksi AS d ON c.nis = d.nis
    			 WHERE k.idtahunajaran = '$thnajr[id]' ") or die(mysqli_error());
    			 $subtot=0;
    			 $subbayar=0;
    			 $subsisa=0;
    			 while ($m = mysqli_fetch_assoc($sqltrans)) {
					$qttl = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `detail_transaksi` WHERE no_transaksi='$m[no_transaksi]'");
	                	$ttl = mysqli_fetch_assoc($qttl);

	                	$qttlx = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `bayarcicilan` WHERE no_transaksi='$m[no_transaksi]'");
	                	$ttlx = mysqli_fetch_assoc($qttlx);
	                	
						if ($m['status'] == 'Hutang'){
						    $total_bayar = $ttl['total'] - $m['potongan'];
							$bayar = $m['bayar'] + $ttlx['total'];
							 $sisa = $m['bayar'] - $total_bayar;
							$result = preg_replace("/[^0-9]/", "", $sisa);
							$jdc = $total_bayar - $bayar;
	                	    
	                	}else{
	                	    $total_bayar = $ttl['total'] - $m['potongan'];
							$sisa = $m['bayar'] - $total_bayar;
							$bayar = $m['bayar'] + $ttlx['total'];
							$result = preg_replace("/[^0-9]/", "", $sisa);
							$jdc = $sisa;
	                	}
						$tsisa = $result - $ttlx['total'];
						$hsisa = $total_bayar - $bayar;
						
						$subtot += $total_bayar;
						$subbayar += $bayar;
						    
				    	if ($sisa<0) {
				    	 $subsisa += $tsisa;   
				    	}
						
    			 }
    			 
    			 $sqltransx = mysqli_query($conn,"SELECT d.no_transaksi, d.`tgl_transaksi`, d.`status` as jp, d.`bayar`, d.`potongan`, d.`jenis`, c.nis, c.nama, c.panggilan, c.tahunmasuk, c.idkelas, c.agama, b.status, a.kondisi, c.kelamin,
				   c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.tgllahir, c.warga,
				   c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa,
				   c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanayah ) as pendidikanayah
				   , (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanibu ) as pendidikanibu, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanayah) as pekerjaanayah, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanibu) as pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu,
				   c.alamatortu, c.hportu, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan, t.tahunajaran, t.id AS idtahunajaran,
				   k.kelas, c.nisn, 
	               c.noijasah,c.tglijasah,c.tmplahirayah,c.tmplahiribu,c.tgllahirayah,c.tgllahiribu,c.hobi
    			  FROM siswa as c
                  LEFT JOIN kelas as k ON k.id = c.idkelas
                  LEFT JOIN tahunajaran as t ON t.id = k.idtahunajaran
                  LEFT JOIN kondisisiswa as a ON a.id = c.kondisi
                  LEFT JOIN statussiswa as b ON b.id = c.status
                  LEFT JOIN transaksi AS d ON c.nis = d.nis
    			 WHERE d.jenis='Baru' AND k.idtahunajaran = '$thnajr[id]' ") or die(mysqli_error());
    			 $subtota=0;
    			 $subbayara=0;
    			 $subsisaa=0;
    			 while ($x = mysqli_fetch_assoc($sqltransx)) {
					$qttlx = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `detail_transaksi` WHERE no_transaksi='$x[no_transaksi]'");
	                	$ttlx = mysqli_fetch_assoc($qttlx);

	                	$qttlx1 = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `bayarcicilan` WHERE no_transaksi='$x[no_transaksi]'");
	                	$ttlx1 = mysqli_fetch_assoc($qttlx1);
	                	
						if ($x['status'] == 'Hutang'){
						    $total_bayarx = $ttlx['total'] - $x['potongan'];
							$bayarx = $x['bayar'] + $ttlx1['total'];
							 $sisax = $x['bayar'] - $total_bayarx;
							$resultx = preg_replace("/[^0-9]/", "", $sisax);
							$jdcx = $total_bayarx - $bayarx;
	                	    
	                	}else{
	                	    $total_bayarx = $ttlx['total'] - $x['potongan'];
							$sisax = $x['bayar'] - $total_bayarx;
							$bayarx = $x['bayar'] + $ttlx1['total'];
							$resultx = preg_replace("/[^0-9]/", "", $sisax);
							$jdcx = $sisax;
	                	}
						$tsisax = $resultx - $ttlx1['total'];
						$hsisax = $total_bayarx - $bayarx;
						
						$subtota += $total_bayarx;
						$subbayara += $bayarx;
						    
				    	if ($sisax<0) {
				    	 $subsisaa += $tsisax;   
				    	}
						
    			 }
    			 $sqltransp = mysqli_query($conn,"SELECT d.no_transaksi, d.`tgl_transaksi`, d.`status` as jp, d.`bayar`, d.`potongan`, d.`jenis`, c.nis, c.nama, c.panggilan, c.tahunmasuk, c.idkelas, c.agama, b.status, a.kondisi, c.kelamin,
				   c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.tgllahir, c.warga,
				   c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa,
				   c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanayah ) as pendidikanayah
				   , (SELECT `pendidikan` FROM `tingkatpendidikan` WHERE `id` = c.pendidikanibu ) as pendidikanibu, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanayah) as pekerjaanayah, (SELECT `pekerjaan` FROM `jenispekerjaan` WHERE `id` = c.pekerjaanibu) as pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu,
				   c.alamatortu, c.hportu, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan, t.tahunajaran, t.id AS idtahunajaran,
				   k.kelas, c.nisn, 
	               c.noijasah,c.tglijasah,c.tmplahirayah,c.tmplahiribu,c.tgllahirayah,c.tgllahiribu,c.hobi
    			  FROM siswa as c
                  LEFT JOIN kelas as k ON k.id = c.idkelas
                  LEFT JOIN tahunajaran as t ON t.id = k.idtahunajaran
                  LEFT JOIN kondisisiswa as a ON a.id = c.kondisi
                  LEFT JOIN statussiswa as b ON b.id = c.status
                  LEFT JOIN transaksi AS d ON c.nis = d.nis
    			 WHERE d.jenis='Lama' AND k.idtahunajaran = '$thnajr[id]' ") or die(mysqli_error());
    			 $subtotp=0;
    			 $subbayarp=0;
    			 $subsisap=0;
    			 while ($p = mysqli_fetch_assoc($sqltransp)) {
					$qttlp = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `detail_transaksi` WHERE no_transaksi='$p[no_transaksi]'");
	                	$ttlp = mysqli_fetch_assoc($qttlp);

	                	$qttlp1 = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `bayarcicilan` WHERE no_transaksi='$p[no_transaksi]'");
	                	$ttlp1 = mysqli_fetch_assoc($qttlp1);
	                	
						if ($p['status'] == 'Hutang'){
						    $total_bayarp = $ttlp['total'] - $p['potongan'];
							$bayarp = $p['bayar'] + $ttlp1['total'];
							 $sisap = $p['bayar'] - $total_bayarp;
							$resultp = preg_replace("/[^0-9]/", "", $sisap);
							$jdcp = $total_bayarp - $bayarp;
	                	    
	                	}else{
	                	    $total_bayarp = $ttlp['total'] - $p['potongan'];
							$sisap = $p['bayar'] - $total_bayarp;
							$bayarp = $p['bayar'] + $ttlp1['total'];
							$resultp = preg_replace("/[^0-9]/", "", $sisap);
							$jdcp = $sisap;
	                	}
						$tsisap = $resultp - $ttlp1['total'];
						$hsisap = $total_bayarp - $bayarp;
						
						$subtotp += $total_bayarp;
						$subbayarp += $bayarp;
						    
				    	if ($sisax<0) {
				    	 $subsisaa += $tsisax;   
				    	}
						
    			 }
	        
		
				//$query = "SELECT sum(`bayar`)as bayar, sum(`potongan`)as potongan FROM `transaksi`";
				//$sql_kul = mysqli_query($conn,$query);	
				//$m = mysqli_fetch_assoc($sql_kul);
				//$qttl = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `detail_transaksi`");
            	//$ttl = mysqli_fetch_assoc($qttl);

            	//$qttlx = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `bayarcicilan`");
            	//$ttlx = mysqli_fetch_assoc($qttlx);
            	
				//$total_bayar = $ttl['total'] - $m['potongan'];
				//$sisa = $m['bayar'] - $total_bayar;
				//$bayar = $m['bayar'] + $ttlx['total'];
				//$result = preg_replace("/[^0-9]/", "", $sisa);
				//$tsisa = $result - $ttlx['total'];
				?>
		        <!-- page start-->
		        <div class="row">
		        	<div class="col-lg-4">
				        <div class="mini-stat clearfix">
				            <span class="mini-stat-icon tar"><i class="fa fa-money"></i></span>
				            <div class="mini-stat-info">
				                <span><?php echo number_format($subtot) ?></span>
				                TOTAL PEMBAYARAN PENDAFTARAN
				            </div>
				        </div>
				    </div>
				    <div class="col-lg-4">
				        <div class="mini-stat clearfix">
				            <span class="mini-stat-icon green"><i class="fa fa-money"></i></span>
				            <div class="mini-stat-info">
				                <span><?php echo number_format($subbayar) ?></span>
				                TOTAL PEMBAYARAN
				            </div>
				        </div>
				    </div>
				    <div class="col-lg-4">
				        <div class="mini-stat clearfix">
				            <span class="mini-stat-icon orange"><i class="fa fa-money"></i></span>
				            <div class="mini-stat-info">
				                <span><?php echo number_format($subsisa) ?></span>
				                TOTAL SISA PEMBAYARAN
				            </div>
				        </div>
				    </div>
				    <div class="col-lg-6">
				        <div class="mini-stat clearfix">
				            <span class="mini-stat-icon pink"><i class="fa fa-money"></i></span>
				            <div class="mini-stat-info">
				                <span><?php echo number_format($subbayara) ?></span>
				                TOTAL PEMBAYARAN SANTRI BARU
				            </div>
				        </div>
				    </div>
				    <div class="col-lg-6">
				        <div class="mini-stat clearfix">
				            <span class="mini-stat-icon pink"><i class="fa fa-money"></i></span>
				            <div class="mini-stat-info">
				                <span><?php echo number_format($subbayarp) ?></span>
				                TOTAL PEMBAYARAN DAFTAR ULANG
				            </div>
				        </div>
				    </div>
				</div>
		        <div class="row">

        	        <form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=form' enctype="multipart/form-data">
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

