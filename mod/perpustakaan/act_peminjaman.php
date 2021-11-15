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

	if($mod == "peminjaman" AND $act == "simpan")

	{
		$query = "SELECT * FROM `tmp_datasewa`";
		$sql_kul = mysqli_query($conn,$query);	
		while ($m = mysqli_fetch_assoc($sql_kul)) {
		mysqli_query($conn,"INSERT INTO `datasewa`(`nis`, `idbuku`, `tgl_pinjam`, `tgl_kembali`, `denda`, `status`) VALUES ('$m[nis]','$m[idbuku]','$m[tgl_pinjam]','$m[tgl_kembali]','','pinjam')") or die(mysqli_error());
		mysqli_query($conn,"DELETE FROM `tmp_datasewa` WHERE id = '$m[id]'") or die(mysqli_error());
		}
		
		flash('example_message', 'Berhasil menambah data Peminjaman.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "peminjaman" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE `datasewa` SET `nis`='$_POST[nis]',`idbuku`='$_POST[idbuku]',`tgl_pinjam`='$_POST[tgl_pinjam]',`tgl_kembali`='$_POST[tgl_kembali]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data Peminjaman.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}
	elseif ($mod == "peminjaman" AND $act == "dump") 
	{
		mysqli_query($conn,"INSERT INTO `tmp_datasewa`(`nis`, `idbuku`, `tgl_pinjam`, `tgl_kembali`) VALUES ('$_POST[nis]','$_POST[idbuku]','$_POST[tgl_pinjam]','$_POST[tgl_kembali]')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data Peminjaman.' );
		echo"<script>
			window.history.back();
		</script>";	
	}
	elseif ($mod == "peminjaman" AND $act == "hapusdump") 
	{
		mysqli_query($conn,"DELETE FROM `tmp_datasewa` WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data Peminjaman.' );
		echo"<script>
			window.history.back();
		</script>";	
	}else{
		echo "zonk";
	}

?>