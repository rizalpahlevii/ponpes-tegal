<?php
	session_start();
	include"../../lib/conn.php";
	include"../../lib/all_function.php";
	include"../../lib/fungsi_transaction.php";

	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}
	if($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin'){
		$linkaksi = 'med.php?';
	}else {
		$linkaksi = 'med2.php?';
	}
	if(isset($_GET['mod']) && isset($_GET['act']))
	{
		$mod = $_GET['mod'];
		$act = $_GET['act'];
	}
	else
	{
		$mod = "";
		$act = "";
	}

	if($mod == "transaksi" AND $act == "simpan")
	{

			$jenis = anti_inject($_POST['jenis']);
		if ($_SESSION['level']=='xmahad') {
			$qtmp = mysqli_query($conn,"SELECT a.*
						FROM detail_transaksi_tmp a
                        JOIN pembayaran b on a.idpembayaran = b.id
                        JOIN jenispembayaran c ON b.`idjenispembayaran` = c.id WHERE `jenis` = '$jenis' AND `pembayaran` LIKE '%Mahad%' AND a.`petugas` = '$_SESSION[id_user]'
						ORDER BY a.timestmp ASC");
		}elseif ($_SESSION['level']=='xmadrasah') {     
			$qtmp = mysqli_query($conn,"SELECT a.*
						FROM detail_transaksi_tmp a
                        JOIN pembayaran b on a.idpembayaran = b.id
                        JOIN jenispembayaran c ON b.`idjenispembayaran` = c.id WHERE `jenis` = '$jenis' AND `pembayaran` LIKE '%Madrasah%' AND a.`petugas` = '$_SESSION[id_user]'
						ORDER BY a.timestmp ASC");                   			
		}else{                    
			$qtmp = mysqli_query($conn,"SELECT a.*
						FROM detail_transaksi_tmp a
                        JOIN pembayaran b on a.idpembayaran = b.id
                        JOIN jenispembayaran c ON b.`idjenispembayaran` = c.id WHERE `jenis` = '$jenis' AND a.`petugas` = '$_SESSION[id_user]'
						ORDER BY a.timestmp ASC");      
		}		

			$tgl= $_POST['tgl'];
		if (mysqli_num_rows($qtmp) > 0) {
			$no_transaksi = no_kwitansi_auto($tgl); //no transaksi automatis
			$jmlbayar = str_replace(",", "", anti_inject($_POST['jmlbayar']));
			$total_bayar = 0;
			while($tmp = mysqli_fetch_assoc($qtmp))
				{
					$chart[] = $tmp;

					//hitung total
					$sub_total = $tmp['harga'];

					$total_bayar =  $total_bayar + $sub_total;
				}
			if ($_POST['potongan2'] > 0) {
				$total_bayar = $total_bayar - $_POST['potongan2'];
			}
			else
			{
				$total_bayar = $total_bayar;
			}
			$kodep = anti_inject($_POST['nis']);
			$nama_ok = str_replace('"',"",$kodep);
			$pecah=explode(" - ",$nama_ok);
			$kodepl = $pecah[1];

			//print_r($chart);
			$qpel = mysqli_query($conn,"SELECT * FROM siswa 
								WHERE nis = '$kodep'");
			if(mysqli_num_rows($qpel) > 0)
			{
				$p = mysqli_fetch_assoc($qpel);
				$nis = $p['nis'];
				$namas = anti_inject($p['nama']);
				$thnaj = $p['id'];
			}
			else
			{
				$c1 = "SELECT max(nis)as kode FROM siswa";
				  $d1 = mysqli_query($conn,$c1);
				  $e1 = mysqli_fetch_array($d1);
				  $kode=substr($e1['kode'],1,5); //mengambil string mulai dari karakter pertama 'A' dan mengambil 4 karakter setelahnya. 
				  $tambah=$kode+1; //kode yang sudah di pecah di tambah 1
				   if($tambah<10){ //jika kode lebih kecil dari 10 (9,8,7,6 dst) maka
				    $idi="S0000".$tambah;
				    }elseif ($tambah<100) {
				      $idi="S000".$tambah;
				    }elseif ($tambah<1000) {
				      $idi="S00".$tambah;
				    } else{
				    $idi="S0".$tambah;
				    }

				$nis = $idi;
				$nama_pelanggan = $pecah[0];
			    mysqli_query($conn,"INSERT INTO siswa(nis, 
									nama)
								VALUES ('$idi', 
									'$nama_pelanggan')");
			}
			//apakah pembayaran sudah cukup
			if (($total_bayar <= $jmlbayar) OR ($_POST['status'] == "Hutang")) {
				//start transaction
				start_transaction();

				//pembuatan header
				$qsimpanheader = mysqli_query($conn,"INSERT INTO `transaksi`(`no_transaksi`, 
																		`nis`, 
																		`bulan`, 
																		`tgl_transaksi`, 
																		`status`, 
																		`bayar`, 
																		`potongan`, 
																		`jenis`,
																		`petugas`,  
																		`timestmp`)
																VALUES('$no_transaksi',
																		'$nis', 
																		'$_POST[bulan]',
																		'$tgl', 
																		'$_POST[status]',
																		'$jmlbayar',  
																		'$_POST[potongan2]',
																		'$jenis', 
																		'$_SESSION[id_user]',
																		NOW())");
				if (!$qsimpanheader) {
					rollback();
					flash('example_message', 'Transaksi Gagal.', 'alert-danger');
					echo"<script>
						window.history.back();
					</script>";	
				}
				else
				{
					foreach ($chart as $row) {
						$qsimpandetail = mysqli_query($conn,"INSERT INTO detail_transaksi(`no_transaksi`, 
																						`idpembayaran`, 
																						`harga`, 
																						`petugas`,  
																						`timestmp`)
																				VALUES('$no_transaksi', 
																						'$row[idpembayaran]',
																						'$row[harga]', 
																						'$_SESSION[id_user]',
																						'$row[timestmp]')");
					    $query = "SELECT nis,nama,t.id
												FROM siswa as s 
                                                left join kelas k on s.idkelas = k.id
                                                left join tahunajaran t on t.id = k.idtahunajaran
                                                where t.aktif = 'Aktif' AND s.nis = '$nis'";
                        $sql_kul = mysqli_query($conn,$query);	
                        $m = mysqli_fetch_assoc($sql_kul);
						if($row['idpembayaran']==8){
						    	mysqli_query($conn,"INSERT INTO `kemaarifan`(`nis`, `idtahunajaran`, `bulanke`, `nominal`, `potongan`, `date`) 
						    	                     VALUES ('$nis','$m[id]','10','$row[harga]','','$tgl')") or die(mysqli_error());
						}elseif($row['idpembayaran']==11){
						    	mysqli_query($conn,"INSERT INTO `spp`(`nis`, `idtahunajaran`, `bulanke`, `nominal`, `potongan`, `date`) 
						    	VALUES ('$nis','$m[id]','10','$row[harga]','','$tgl')") or die(mysqli_error());
						}elseif($row['idpembayaran']==15){
						    	mysqli_query($conn,"INSERT INTO `kemaarifan`(`nis`, `idtahunajaran`, `bulanke`, `nominal`, `potongan`, `date`) 
						    	                     VALUES ('$nis','$m[id]','10','$row[harga]','','$tgl')") or die(mysqli_error());
						}elseif($row['idpembayaran']==25){
						    	mysqli_query($conn,"INSERT INTO `spp`(`nis`, `idtahunajaran`, `bulanke`, `nominal`, `potongan`, `date`) 
						    	VALUES ('$nis','$m[id]','10','$row[harga]','','$tgl')") or die(mysqli_error());
						}
						if (!$qsimpandetail) {
							rollback();
							flash('example_message', 'Transaksi gagal.', 'alert-danger' );
							echo"<script>
								window.history.back();
							</script>";	
						}
					}

					mysqli_query($conn,"DELETE FROM detail_transaksi_tmp WHERE `petugas` = '$_SESSION[id_user]'");
					log_insert('$no_transaksi',"transaksi","Menambahakan Data Pembayaran Santri ".$nis." - ".$m['nama'],$_SESSION['id_user'] );
					commit();
					header("location:../../".$linkaksi."mod=transaksi&act=printout&id=".$no_transaksi);
				}
				//commit();
			}
			else {
				flash('example_message', 'Pembayaran tidak cukup!' );
				echo"<script>
					window.history.back();
				</script>";	
			}

				
		}
		else
		{
			flash('example_message', 'Tidak ada barang yang di jual!', 'alert-danger');
			echo"<script>
				window.history.back();
			</script>";	
		}
	}
	elseif ($mod == "transaksi" AND $act == "add") 
	{
		mysqli_query($conn,"INSERT INTO `detail_transaksi_tmp`(`idpembayaran`, `harga`, `petugas`, `timestmp`) VALUES ('$_POST[id]','$_POST[harga]','$_SESSION[id_user]',NOW())") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data pembayaran.');
		if ($_GET['jenis']=="baru") {
			header("location:../../".$linkaksi."mod=transaksi&act=baru&nis=".$_POST[nis]."&nama=".$_POST[nama]);
		}elseif ($_GET['jenis']=="lama") {			
			header("location:../../".$linkaksi."mod=transaksi&act=aksi&nis=".$_POST[nis]."&thn=".$_POST[thn]);
		}else{
			echo"<script>
					window.history.back();
				</script>";	
		}
		
	}
	elseif ($mod == "transaksi" AND $act == "batal") {
		mysqli_query($conn,"DELETE FROM detail_transaksi_tmp 
					WHERE id= '$_GET[id]'") or die(mysqli_error());

		if ($_GET['jenis']=="baru") {
			header("location:../../".$linkaksi."mod=transaksi&act=baru&nis=".$_GET[nis]."&nama=".$_GET[nama]);
		}elseif ($_GET['jenis']=="lama") {			
			header("location:../../".$linkaksi."mod=transaksi&act=aksi&nis=".$_GET[nis]."&thn=".$_GET[thn]);
		}else{
			echo"<script>
					window.history.back();
				</script>";	
		}
	}
	elseif ($mod == "transaksi" AND $act == "bayar") 
	{
		$jmlbayar = str_replace(",", "", anti_inject($_POST['nominal']));
		mysqli_query($conn,"INSERT INTO `bayarcicilan`(`no_transaksi`,
														`harga`, 
														`timestmp`) 
												VALUES ('$_POST[id]','$jmlbayar',NOW())") or die(mysqli_error());

		flash('example_message', 'Berhasil menambah data pembayaran.');
		header("location:../../".$linkaksi."mod=transaksi&act=printout&id=".$_POST[id]);

		echo"<script>
			window.history.go(-1);
		</script>";
	}
	elseif ($mod == "transaksi" AND $act == "editbayar") 
	{
		$jmlbayar = str_replace(",", "", anti_inject($_POST['nominal']));
		mysqli_query($conn,"UPDATE `transaksi` SET `bayar`='$jmlbayar' WHERE `no_transaksi` = '$_POST[id]'") or die(mysqli_error());
        $qrby = "SELECT * FROM `transaksi` WHERE `no_transaksi` = '$_POST[id]'";
		$sqqrby = mysqli_query($conn,$qrby);	
		$by = mysqli_fetch_assoc($sqqrby);
	    $query = "SELECT nis,nama,t.id
					FROM siswa as s 
                    left join kelas k on s.idkelas = k.id
                    left join tahunajaran t on t.id = k.idtahunajaran
                    where t.aktif = 'Aktif' AND s.nis = '$by[nis]'";
		$sql_kul = mysqli_query($conn,$query);	
		$m = mysqli_fetch_assoc($sql_kul);
		
        log_update($_POST['id'],"transaksi","Mengubah Data Pembayaran Santri ".$m['nis']." - ".$m['nama'],$_SESSION['id_user'] );
		flash('example_message', 'Berhasil mengubah pembayaran.');

		echo"<script>
			window.history.go(-1);
		</script>";
	}
	elseif ($mod == "transaksi" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE transaksi SET `pembayaran`='$_POST[pembayaran]',`jenis`='$_POST[jenis]',`urutan`='$_POST[urutan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data pembayaran pendaftaran.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "transaksi" AND $act == "hapus") 
	{	
	    $qrby = "SELECT * FROM `transaksi` WHERE `no_transaksi` = '$_GET[id]'";
		$sqqrby = mysqli_query($conn,$qrby);	
		$by = mysqli_fetch_assoc($sqqrby);
	    $query = "SELECT nis,nama,t.id
					FROM siswa as s 
                    left join kelas k on s.idkelas = k.id
                    left join tahunajaran t on t.id = k.idtahunajaran
                    where t.aktif = 'Aktif' AND s.nis = '$by[nis]'";
		$sql_kul = mysqli_query($conn,$query);	
		$m = mysqli_fetch_assoc($sql_kul);
		
        log_delete($_POST['id'],"transaksi","Menhapus Data Pembayaran Santri ".$m['nis']." - ".$m['nama'],$_SESSION['id_user'] );
		mysqli_query($conn,"DELETE FROM `detail_transaksi` WHERE no_transaksi = '$_GET[id]'") or die(mysqli_error());
		mysqli_query($conn,"DELETE FROM `bayarcicilan` WHERE `no_transaksi` = '$_GET[id]'") or die(mysqli_error());
		mysqli_query($conn,"DELETE FROM transaksi WHERE no_transaksi = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data pembayaran pendaftaran.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>