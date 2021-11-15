<?php
	session_start();
	include"../../lib/conn.php";

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

	if($mod == "pengembalian" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO rak (`rak`)
									VALUES ('$_POST[rak]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data Rak Buku.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "pengembalian" AND $act == "edit") 
	{
		date_default_timezone_set('Asia/Jakarta');
		$tgl=date('Y-m-d');
		$sql = "SELECT a.`id`, a.`nis`, b.`nama`, a.`idbuku`,c.`kode`,c.`judul`, a.`tgl_pinjam`, a.`tgl_kembali`,a.`denda`, a.`status`,datediff(current_date(), a.`tgl_kembali`) as selisih 
			FROM `datasewa` as a
			JOIN `siswa` as b on a.`nis` = b.`nis`
			JOIN `buku` as c on a.`idbuku` = c.`id` where a.id = '$_GET[id]'";
		$result = mysqli_query($conn, $sql);
		$k = mysqli_fetch_assoc($result);
		if ($k['selisih'] <= 0) {
			$denda = "0";
		}else{
			$denda = $k['selisih']*500;
		}
		mysqli_query($conn,"UPDATE datasewa SET `denda`='$denda', `status`='kembali' WHERE id = '$_GET[id]'") or die(mysqli_error());
		mysqli_query($conn,"INSERT INTO `kas`(`tanggal`, `nominal`, `keterangan`, `jenis`) VALUES ('$tgl','$denda','Denda Peminjam Buku $k[judul]','masuk')") or die(mysqli_error());
		flash('example_message', 'Berhasil mengubah data Pengembalian.');

		echo"<script>
			window.history.back();
		</script>";
	}

	elseif ($mod == "pengembalian" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM rak WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data Rak Buku.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>