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

	if($mod == "absensi" AND $act == "simpan")
	{
		mysqli_query($conn,"INSERT INTO jam_absen (`jam_masuk`, `jam_pulang`, `batas_telat`, `akses_sekolah`)
									VALUES ('$_POST[jam_masuk]', '$_POST[jam_pulang]', '$_POST[batas_telat]','')") or die(mysqli_error());
		flash('example_message', 'Berhasil menambah data jam absen.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "absensi" AND $act == "edit") 
	{
		mysqli_query($conn,"UPDATE jam_absen SET `jam_masuk`='$_POST[jam_masuk]',`jam_pulang`='$_POST[jam_pulang]',`batas_telat`='$_POST[batas_telat]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data jam absen.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "absensi" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM jam_absen WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data jam absen.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>