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

	if($mod == "perhitungan_nilai" AND $act == "simpan")
	{
		$nipguru = anti_inject($_POST['nipguru']);
		$idpelajaran = anti_inject($_POST['idpelajaran']);
		$dasarpenilaian = anti_inject($_POST['dasarpenilaian']);
		$idjenisujianx = $_POST['idjenisujian'];
		$bobotx = $_POST['bobot'];
		$number = count($idjenisujianx);
		for ($i=0; $i < $number ; $i++) { 
			$idjenisujian = anti_inject($idjenisujianx[$i]);
			$bobot = anti_inject($bobotx[$i]);

			mysqli_query($conn,"INSERT INTO `aturannhb`(`nipguru`, `idpelajaran`, `dasarpenilaian`, `idjenisujian`, `bobot`) VALUES ('$nipguru','$idpelajaran','$dasarpenilaian','$idjenisujian','$bobot')") ;
			flash('example_message', 'Berhasil menambah data aspek penilaian.' );

			echo"<script>
				window.history.go(-3);
			</script>";
		}
		
	}

	elseif ($mod == "perhitungan_nilai" AND $act == "edit") 
	{
		$idx = $_POST['idb'];
		$nipguru = anti_inject($_POST['nipguru']);
		$idpelajaran = anti_inject($_POST['idpelajaran']);
		$bobotx = $_POST['bobot'];
		$number = count($bobotx);
		for ($i=0; $i < $number ; $i++) { 
			$bobot = anti_inject($bobotx[$i]);
			$id = anti_inject($idx[$i]);
			mysqli_query($conn,"UPDATE aturannhb SET bobot='$bobot' WHERE id = '$id'") ;

		flash('example_message', 'Berhasil mengubah data aspek penilaian.');

		echo "<meta http-equiv='refresh' content='0;url=../../med.php?mod=perhitungan_nilai&act=detail&nipguru=$nipguru&idpelajaran=$idpelajaran' />";
		}
		
	}

	elseif ($mod == "perhitungan_nilai" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM aturannhb WHERE dasarpenilaian = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data aspek penilaian.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>