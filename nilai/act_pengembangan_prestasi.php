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

	if($mod == "pengembangan_prestasi" AND $act == "simpan")
	{
		$date = $_POST['date'];
		$nisx = $_POST['nis'];
		$info1x = $_POST['info1'];
		$info2x = $_POST['info2'];
		$info3x = $_POST['info3'];
		$ketx = $_POST['ket'];
		$number = count($nisx);
	       for($i=0;$i<$number;$i++){
	        $nis = $nisx[$i];
	        $ket = $ketx[$i];
	        $info1 = $info1x[$i];
	        $info2 = $info2x[$i];
	        $info3 = $info3x[$i];
			mysqli_query($conn,"INSERT INTO `pengembangan_prestasi`(`nis`, `info1`, `info2`, `info3`, `ket`, `date`) VALUES ('$nis','$info1','$info2','$info3','$ket','$date')") or die(mysqli_error());
        }

		flash('example_message', 'Berhasil menambah data pengembangan prestasi.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "pengembangan_prestasi" AND $act == "edit") 
	{	
		$idx = $_POST['id'];
		$info1x = $_POST['info1'];
		$info2x = $_POST['info2'];
		$info3x = $_POST['info3'];
		$ketx = $_POST['ket'];
		$number = count($idx);
	       for($i=0;$i<$number;$i++){
	       	$id = $idx[$i];
	         $ket = $ketx[$i];
	        $info1 = $info1x[$i];
	        $info2 = $info2x[$i];
	        $info3 = $info3x[$i];	
			mysqli_query($conn,"UPDATE `pengembangan_prestasi` SET `info1`='$info1',`info2`='$info2',`info3`='$info3',`ket`='$ket' WHERE `id` = '$id'") or die(mysqli_error());
        }

		flash('example_message', 'Berhasil mengubah data pengembangan prestasi.');

		echo"<script>
			window.history.go(-1);
		</script>";
	}

	elseif ($mod == "pengembangan_prestasi" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM pengembangan_prestasi WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data pengembangan prestasi.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>