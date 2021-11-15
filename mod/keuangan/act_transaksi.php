<?php
	session_start();
	include"../../lib/conn.php";
	include"../../lib/all_function.php";
	include"../../lib/fungsi_transaction.php";

	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
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
		$qtmp = mysqli_query($conn,"SELECT * FROM detail_transaksi_tmp 
							ORDER BY timestmp ASC");

		if (mysqli_num_rows($qtmp) > 0) {
			$no_transaksi = no_kwitansi_auto(); //no transaksi automatis
			$jmlbayar = str_replace(",", "", anti_inject($_POST['jmlbayar']));
			$total_bayar = 0;

			$tgl = date('Y-m-d');
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
			$jenis = anti_inject($_POST['jenis']);
			$nama_ok = str_replace('"',"",$kodep);
			$pecah=explode(" - ",$nama_ok);
			$kodepl = $pecah[1];

			//print_r($chart);
			$qpel = mysqli_query($conn,"SELECT * FROM siswa 
								WHERE nis = '$kodepl'");
			if(mysqli_num_rows($qpel) > 0)
			{
				$p = mysqli_fetch_assoc($qpel);
				$nis = $p['nis'];
				$namas = anti_inject($p['nama']);
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
																		`tgl_transaksi`, 
																		`status`, 
																		`bayar`, 
																		`potongan`, 
																		`jenis`, 
																		`timestmp`)
																VALUES('$no_transaksi',
																		'$nis', 
																		'$tgl', 
																		'$_POST[status]',
																		'$jmlbayar',  
																		'$_POST[potongan2]',
																		'$jenis', 
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
																						`timestmp`)
																				VALUES('$no_transaksi', 
																						'$row[idpembayaran]',
																						'$row[harga]', 
																						'$row[timestmp]')");
						if (!$qsimpandetail) {
							rollback();
							flash('example_message', 'Transaksi gagal.', 'alert-danger' );
							echo"<script>
								window.history.back();
							</script>";	
						}
					}

					mysqli_query($conn,"DELETE FROM detail_transaksi_tmp");
					commit();
					header("location:../../med.php?mod=transaksi&act=printout&id=".$no_transaksi);
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
		mysqli_query($conn,"INSERT INTO `detail_transaksi_tmp`(`idpembayaran`, `harga`, `timestmp`) VALUES ('$_POST[id]','$_POST[harga]',NOW())") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data pembayaran.');

		echo"<script>
			window.history.go(-1);
		</script>";
		
	}
	elseif ($mod == "transaksi" AND $act == "batal") {
		mysqli_query($conn,"DELETE FROM detail_transaksi_tmp 
					WHERE id= '$_GET[id]'") or die(mysqli_error());

		echo"<script>
			window.history.back();
		</script>";	
	}
	elseif ($mod == "transaksi" AND $act == "bayar") 
	{
		$jmlbayar = str_replace(",", "", anti_inject($_POST['nominal']));
		mysqli_query($conn,"INSERT INTO `bayarcicilan`(`no_transaksi`,
														`harga`, 
														`timestmp`) 
												VALUES ('$_POST[id]','$jmlbayar',NOW())") or die(mysqli_error());

		flash('example_message', 'Berhasil menambah data pembayaran.');
		header("location:../../med.php?mod=transaksi&act=printout&id=".$_POST[id]);

		echo"<script>
			window.history.go(-1);
		</script>";
	}
	elseif ($mod == "transaksi" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE transaksi SET `pembayaran`='$_POST[pembayaran]',`jenis`='$_POST[jenis]',`urutan`='$_POST[urutan]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data pembayaran pendaftaran lama.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "transaksi" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM transaksi WHERE no_transaksi = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data pembayaran pendaftaran lama.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>