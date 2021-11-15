<?php
	date_default_timezone_set("Asia/Jakarta");
	$sqltrans = mysqli_query($conn,"SELECT * FROM `transaksi` WHERE `no_transaksi` = '$_GET[id]'") or die(mysqli_error());
				$tra = mysqli_fetch_assoc($sqltrans);
				$querypsn = "SELECT s.nis,s.nama,s.asalsekolah,s.tmplahir,s.tgllahir,DAY(s.tgllahir) as tgl,MONTH(s.tgllahir) as bln,YEAR(s.tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas,t.`tglmulai`, t.`tglakhir`, t.`tahunajaran`
														FROM siswa as s 
                                                        left join kelas k on s.idkelas = k.id
                                                        left join tahunajaran t on t.id = k.idtahunajaran
                                                        where s.alumni=0 AND s.nis = '$tra[nis]'";
				$sqlpsn = mysqli_query($conn,$querypsn);				
				$psn1 = mysqli_fetch_assoc($sqlpsn);	
?>
<div class="w3-row">
	<div class="w3-col s2 w3-center">
		<img src="../assets/print/logo.png" alt="Lights" style="width:100%;max-width:100px">
	</div>
	<div class="w3-col s8 w3-center">
		<h4 class="w3-text-blue" style="padding-bottom:0;margin-bottom:0;"><b>Pondok Pesantren Attauhidiyyah Syaikh Sa'id Bin Armia</b></h4>
		<!--alamat-->
		Giren - Talang - Tegal <br>
		Tahun Ajaran <?php echo $psn1['tahunajaran'] ?>
	</div>
	<div class="w3-col s2 w3-center">
	</div>
	<!--<div class="w3-col s6 w3-tiny">
		<span class="w3-right">
		Tahun Ajaran <?php echo $psn['tglmulai'] ?> - <?php echo $psn['tgllahir'] ?></span>
	</div>-->
</div>

<div style="border-bottom:3px solid #ccc;"></div>
<center><font>KWITANSI PEMBAYARAN</font></center>
<center><font style="font-size:10px"><?php echo getBulanHijriah($tra['bulan'])?> - <?php echo tglindo($tra['tgl_transaksi']) ?></font></center>

<?php
	echo"<div class='w3-tiny'>
	<b>NO : #$tra[no_transaksi]</b><br>
	Kepada Yth, <br>
	$psn1[nama] / "?><?php echo !empty($tra['nis']) ? $tra['nis'] : "-"; ?>
	<?php echo"</div>
	<div style='height:5px;'></div>";

	echo"<table class='w3-table w3-tiny w3-hoverable w3-bordered tbl' cellpadding='0'>
		<thead>
		<tr class='w3-dark-grey'>
			<th>#</th>
			<th>Pembayaran</th>
			<th>HARGA</th>
		</tr>
		</thead>

		<tbody>";
		$qjp = "SELECT * FROM jenispembayaran WHERE `jenis` = '$tra[jenis]' order by urutan asc";
		$sqljp = mysqli_query($conn,$qjp);	
		$i=1;
		while ($jp = mysqli_fetch_assoc($sqljp)) {
		echo "<tr>
				<th colspan='3'>$jp[pembayaran]</th>
			</tr>";
		$sql = mysqli_query($conn,"SELECT a.*, b.nama
							FROM detail_transaksi a LEFT JOIN pembayaran b 
							ON a.idpembayaran = b.id
							WHERE a.no_transaksi = '$_GET[id]'
							AND b.idjenispembayaran='$jp[id]'") or die(mysqli_error());
		
		$no = 1;
		while ($p = mysqli_fetch_assoc($sql)) {
		echo"<tr>
			<td>$no</td>
			<td>$p[nama]</td>
			<td>Rp. ".number_format($p['harga'],0)."</td>
		</tr>";

		$no++;
	}
	 $i++;
	}
	$qttl = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `detail_transaksi` WHERE no_transaksi='$_GET[id]'");
	$ttl = mysqli_fetch_assoc($qttl);
	
	$qttlx = mysqli_query($conn,"SELECT sum(`harga`)as total FROM `bayarcicilan` WHERE no_transaksi='$_GET[id]'");
	$ttlx = mysqli_fetch_assoc($qttlx);
	$total_bayar = $ttl['total'] - $tra['potongan'];
	$sisa = $tra['bayar'] - $total_bayar;

	$result = preg_replace("/[^0-9]/", "", $sisa);
	$tsisa = $result - $ttlx['total'];

	echo"</tbody>
		<tfoot>
		<tr class='w3-light-grey'>
			<td colspan='2'>Total Harga</b></td>
			<td>Rp. ".number_format($ttl['total'])."</td>
		</tr>
		<tr class='w3-light-grey'>
			<td colspan='2'>Potongan Harga</td>
			<td>Rp. ".number_format($tra['potongan'])."</td>
		</tr>
		<tr class='w3-light-grey'>
			<td colspan='2'><b>Total Bayar</b></td>
			<td><b>Rp. ".number_format($total_bayar)."</b></td>
		</tr>
		<tr class='w3-light-grey'>
			<td colspan='2'><b>Pembayaran</b></td>
			<td><b>Rp. ".number_format($tra['bayar'])."</b></td>
		</tr>";
	if ($sisa<0) {
		echo"
		<tr class='w3-light-grey'>
			<td colspan='2'><b>Total Bayar Cicilan</b></td>
			<td><b>Rp. ".number_format($ttlx['total'])."</b></td>
		</tr>
		<tr class='w3-light-grey'>
			<td colspan='2'><b>Sisa Pembayaran</b></td>
			<td><b>Rp. ".number_format($tsisa)."</b></td>
		</tr>";
	}else{
		echo"<tr class='w3-light-grey'>
			<td colspan='2'><b>Kembali</b></td>
			<td><b>Rp. ".number_format($sisa)."</b></td>
		</tr>";
	}
	echo"
		</tfoot>
	</table>";

?>
<br>
<div class="w3-row-padding w3-tiny">
	<div class="w3-col s4 w3-center">
		<br>
		<p>Tanda Terima,</p>
		<br>
		<br>

		<p>( _________________________ )</p>
	</div>

	<div class="w3-col s4">
		<div class="w3-border w3-padding" style="font-size:8px;text-align:justify;">
			<b>KETENTUAN PEMBAYARAN SYAHRIYAH</b>
				<br><span style="margin-left:1em">* Pembayaran dihitung mulai masuk Pesantren</span>
				<br><span style="margin-left:1em">* Pembayaran tiap bulan & paling lambat tanggal 10 tiap bulannya</span>
			<br>
			<b>TAMBAHAN</b>
				<br><span style="margin-left:1em">* Minimal administrasi pendaftaran santri baru 60% (Rp. 1.000.000,-)</span>
				<br><span style="margin-left:1em">* Pendaftaran Ma'had bisa diangsur dua kali paling lambat 3 bulan setelah masuk Pesantren</span>
				<br><span style="margin-left:1em">* Rincian pendaftaran ini hanya bersifat sementara dan bisa berubah suatu saat</span>
				<br><span style="margin-left:1em">* Uang yang telah diberikan sebagai infaq untuk kemaslahatan Pondok Pesantren</span>

			<br>
			
		</div>

	</div>

	<div class="w3-col s4 w3-center">
		<!--<p>Jambi, <?php echo date('d-m-Y', strtotime($tra['tgl_transaksi'])); ?>-->
		<br>Hormat Kami,</p>
		<br>
		<br>

		<p>( _________________________ )</p>
	</div>

</div>