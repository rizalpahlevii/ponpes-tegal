<?php
	session_start();
	include"../../lib/conn.php";
	include"../../lib/all_function.php";

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
	if($_SESSION['level']=='keuangan' OR $_SESSION['level']=='keuangan mahad' OR $_SESSION['level']=='keuangan madrasah'){
		$linkaksi = 'med2.php?mod=spp';
	}elseif ($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin') {
		$linkaksi = 'med.php?mod=spp';
	}

	if($mod == "spp" AND $act == "simpan")
	{
		$jmlbayar = str_replace(",", "", anti_inject($_POST['nominal']));
		
		$potongan = str_replace(",", "", anti_inject($_POST['potongan']));
		mysqli_query($conn,"INSERT INTO `spp`(`nis`, `idtahunajaran`, `bulanke`, `nominal`, `potongan`, `date`) VALUES ('$_POST[nis]','$_POST[idtahunajaran]','$_POST[bulan]','$jmlbayar','$potongan','$_POST[tgl]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah SPP.' );
        $query = "SELECT nis,nama,t.id
								FROM siswa as s 
                                left join kelas k on s.idkelas = k.id
                                left join tahunajaran t on t.id = k.idtahunajaran
                                where t.aktif = 'Aktif' AND s.nis = '$_POST[nis]'";
        $sql_kul = mysqli_query($conn,$query);	
        $m = mysqli_fetch_assoc($sql_kul);
		log_insert('',"spp","Menambahakan Data Pembayaran SPP MADRASAH Santri ".$_POST['nis']." - ".$m['nama'],$_SESSION['id_user'] );
		header("location:../../$linkaksi&act=form&nis=$_POST[nis]&idtahunajaran=$_POST[idtahunajaran]");
	}

	elseif ($mod == "spp" AND $act == "edit") 
	{
		$jmlbayar = str_replace(",", "", anti_inject($_POST['nominal']));
		$potongan = str_replace(",", "", anti_inject($_POST['potongan']));
		mysqli_query($conn,"UPDATE `spp` SET `nis`='$_POST[nis]',`idtahunajaran`='$_POST[idtahunajaran]',`bulanke`='$_POST[bulan]',`nominal`='$jmlbayar',`potongan`='jpotongan',`date`='$_POST[tgl]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah SPP.');
		$query = "SELECT nis,nama,t.id
								FROM siswa as s 
                                left join kelas k on s.idkelas = k.id
                                left join tahunajaran t on t.id = k.idtahunajaran
                                where t.aktif = 'Aktif' AND s.nis = '$_POST[nis]'";
        $sql_kul = mysqli_query($conn,$query);	
        $m = mysqli_fetch_assoc($sql_kul);
		log_update('',"spp","Mengubah Data Pembayaran SPP MADRASAH Santri ".$_POST['nis']." - ".$m['nama'],$_SESSION['id_user'] );
		header("location:../../$linkaksi&act=form&nis=$_POST[nis]&idtahunajaran=$_POST[idtahunajaran]");
	}

	elseif ($mod == "spp" AND $act == "hapus") 
	{
	    $qrby = "SELECT * FROM `spp` WHERE `id` = '$_GET[id]'";
		$sqqrby = mysqli_query($conn,$qrby);	
		$by = mysqli_fetch_assoc($sqqrby);
	    $query = "SELECT nis,nama,t.id
								FROM siswa as s 
                                left join kelas k on s.idkelas = k.id
                                left join tahunajaran t on t.id = k.idtahunajaran
                                where t.aktif = 'Aktif' AND s.nis = '$by[nis]'";
        $sql_kul = mysqli_query($conn,$query);	
        $m = mysqli_fetch_assoc($sql_kul);
		log_delete('',"spp","Menghapus Data Pembayaran SPP MADRASAH Santri ".$m['nis']." - ".$m['nama'],$_SESSION['id_user'] );
		mysqli_query($conn,"DELETE FROM spp WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data SPP.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>