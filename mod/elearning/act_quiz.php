<?php
	session_start();
	include"../../lib/conn.php";
	date_default_timezone_set('Asia/Jakarta'); 
  	$upload_dir = '../../images/elearning/';

	$tgl_sekarang = date("Y-m-d");
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

	if($mod == "quiz" AND $act == "simpan")
	{
		
    	$wpengerjaan = $_POST['pengerjaan'] * 60;
		$queryg = mysqli_query($conn,"SELECT * FROM guru WHERE `nip` = '$_POST[nip]'");
		$g = mysqli_fetch_assoc($queryg);

		$query = mysqli_query($conn,"SELECT * FROM `aturannhb` WHERE `nipguru` = '$g[id]' AND `idpelajaran` ='$_POST[idpelajaran]' AND `dasarpenilaian` = '$_POST[iddasarpenilaian]' AND `idjenisujian` = '$_POST[idjenis]'");
		$c = mysqli_fetch_assoc($query);

		$selectedOptionCount = count($_POST['idkelas']);
		
		for ($i=0; $i < $selectedOptionCount ; $i++) { 	
			$kelas=	$_POST['idkelas'][$i];
			
			mysqli_query($conn,"INSERT INTO `topik_quiz`(`judul`, `idkelas`, `idpelajaran`, `idjenis`, `idsemester`, `iddasarpenilaian` ,`idrpp`, `tgl_buat`, `pembuat`, `waktu_pengerjaan`, `info`, `terbit`) VALUES ('$_POST[judul]','$kelas','$_POST[idpelajaran]','$_POST[idjenis]','$_POST[idsemester]','$_POST[iddasarpenilaian]','$_POST[idrpp]','$tgl_sekarang','$_POST[nip]','$wpengerjaan','$_POST[info]','$_POST[terbit]')") or die(mysqli_error());
		}
		
		flash('example_message', 'Berhasil menambah data Quiz.' );

		echo"<script>
			window.history.go(-2);
		</script>";
	}

	elseif ($mod == "quiz" AND $act == "edit") 
	{
		$wpengerjaan = $_POST['pengerjaan'] * 60;
		$querye = mysqli_query($conn,"SELECT * FROM `aturannhb` WHERE `nipguru` = '$_POST[nip]' AND `idpelajaran` ='$_POST[idpelajaran]' AND `dasarpenilaian` = '$_POST[iddasarpenilaian]' AND `idjenisujian` = '$_POST[idjenis]'");
		$e = mysqli_fetch_assoc($querye);

		mysqli_query($conn,"UPDATE `topik_quiz` SET `judul`='$_POST[judul]',`idkelas`='$_POST[idkelas]',`idpelajaran`='$_POST[idpelajaran]', `idjenis` = '$_POST[idjenis]', `idsemester` = '$_POST[idsemester]', `iddasarpenilaian` = '$_POST[iddasarpenilaian]',`idrpp` = '$_POST[idrpp]' ,`tgl_buat`='$tgl_sekarang',`pembuat`='$_POST[nip]',`waktu_pengerjaan`='$wpengerjaan',`info`='$_POST[info]',`terbit`='$_POST[terbit]' WHERE id = '$_POST[id]'") or die(mysqli_error());

		flash('example_message', 'Berhasil mengubah data Quiz.');

		echo"<script>
			window.history.go(-2);
		</script>";
	}elseif ($mod == "quiz" AND $act == "simpanesay") 
	{
		
		$imgName = $_FILES['foto']['name'];
		if ($imgName!=="") {
			$imgTmp = $_FILES['foto']['tmp_name'];
			$imgSize = $_FILES['foto']['size'];
			$imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

			$allowExt  = array('jpeg', 'jpg', 'png', 'gif');

			$userPic = time().'_'.rand(1000,9999).'.'.$imgExt;
		}else{
			$userPic = "";
		}
		
	
		$sql = "INSERT INTO `quiz_esay`(`idquiz`, `pertanyaan`, `gambar`, `tgl_buat`) VALUES ('$_POST[idquiz]','$_POST[pertanyaan]','$userPic','$tgl_sekarang')";
		$result = mysqli_query($conn, $sql);
		if($result){
			$successMsg = 'Berhasil menambah data quiz.';
			flash('example_message', $successMsg );

			echo"<script>
				window.history.go(-2);
			</script>";
		}else{
			$errorMsg = 'Error '.mysqli_error($conn);
			flash('example_message', $errorMsg );

			echo"<script>
				window.history.go(-2);
			</script>";
		}
	}elseif ($mod == "quiz" AND $act == "editesay") 
	{
		
		$foto = $_POST['gambar'];
		
		$imgName = $_FILES['foto']['name'];
		$imgTmp = $_FILES['foto']['tmp_name'];
		$imgSize = $_FILES['foto']['size'];

		if($imgName){
			$imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

			$allowExt  = array('jpeg', 'jpg', 'png', 'gif');

			$userPic = time().'_'.rand(1000,9999).'.'.$imgExt;

			if(in_array($imgExt, $allowExt)){

				if($imgSize < 5000000){
					unlink($upload_dir.$foto);
					move_uploaded_file($imgTmp ,$upload_dir.$userPic);
				}else{
					$errorMsg = 'Image too large';
					flash('example_message', $errorMsg );

					echo"<script>
						window.history.go(-2);
					</script>";
				}
			}else{
				$errorMsg = 'Please select a valid image';
				flash('example_message', $errorMsg );

				echo"<script>
					window.history.go(-2);
				</script>";
			}
		}else{

			$userPic = $foto;
		}
		if(!isset($errorMsg)){
			$sql = "UPDATE `quiz_esay` SET `pertanyaan`='$_POST[pertanyaan]',`gambar`='$userPic',`tgl_buat`='$tgl_sekarang' WHERE `id` = '$_POST[id]'";
			$result = mysqli_query($conn, $sql);
			if($result){
				$successMsg = 'Berhasil merubah data quiz.';
				flash('example_message', $successMsg );

				echo"<script>
					window.history.go(-2);
				</script>";
			}else{
				$errorMsg = 'Error '.mysqli_error($conn);
				flash('example_message', $errorMsg );

				echo"<script>
					window.history.go(-2);
				</script>";
			}
		}
	}

	elseif ($mod == "quiz" AND $act == "simpanpilgan") 
	{
		$imgName = $_FILES['foto']['name'];
		if ($imgName!=="") {
			$imgTmp = $_FILES['foto']['tmp_name'];
			$imgSize = $_FILES['foto']['size'];
			$imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

			$allowExt  = array('jpeg', 'jpg', 'png', 'gif');

			$userPic = time().'_'.rand(1000,9999).'.'.$imgExt;
		}else{
			$userPic = "";
		}
		$sql = "INSERT INTO `quiz_pilganda`(`idquiz`, `pertanyaan`, `gambar`, `pil_a`, `pil_b`, `pil_c`, `pil_d`, `kunci`, `tgl_buat`) VALUES ('$_POST[idquiz]','$_POST[pertanyaan]','$userPic','$_POST[pil_a]','$_POST[pil_b]','$_POST[pil_c]','$_POST[pil_d]','$_POST[kunci]','$tgl_sekarang')";
		$result = mysqli_query($conn, $sql);
		if($result){
			$successMsg = 'Berhasil menambah data quiz.';
			flash('example_message', $successMsg );

			echo"<script>
				window.history.go(-2);
			</script>";
		}else{
			$errorMsg = 'Error '.mysqli_error($conn);
			flash('example_message', $errorMsg );

			echo"<script>
				window.history.go(-2);
			</script>";
		}
	}elseif ($mod == "quiz" AND $act == "editpilgan") 
	{
		
		$foto = $_POST['gambar'];
		
		$imgName = $_FILES['foto']['name'];
		$imgTmp = $_FILES['foto']['tmp_name'];
		$imgSize = $_FILES['foto']['size'];

		if($imgName){
			$imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

			$allowExt  = array('jpeg', 'jpg', 'png', 'gif');

			$userPic = time().'_'.rand(1000,9999).'.'.$imgExt;

			if(in_array($imgExt, $allowExt)){

				if($imgSize < 5000000){
					unlink($upload_dir.$foto);
					move_uploaded_file($imgTmp ,$upload_dir.$userPic);
				}else{
					$errorMsg = 'Image too large';
					flash('example_message', $errorMsg );

					echo"<script>
						window.history.go(-2);
					</script>";
				}
			}else{
				$errorMsg = 'Please select a valid image';
				flash('example_message', $errorMsg );

				echo"<script>
					window.history.go(-2);
				</script>";
			}
		}else{

			$userPic = $foto;
		}
		if(!isset($errorMsg)){
			$sql = "UPDATE `quiz_pilganda` SET `pertanyaan`='$_POST[pertanyaan]',`gambar`='$userPic',`pil_a`='$_POST[pil_a]',`pil_b`='$_POST[pil_b]',`pil_c`='$_POST[pil_c]',`pil_d`='$_POST[pil_d]',`kunci`='$_POST[kunci]',`tgl_buat`='$tgl_sekarang' WHERE `id` = '$_POST[id]'";
			$result = mysqli_query($conn, $sql);
			if($result){
				$successMsg = 'Berhasil merubah data quiz.';
				flash('example_message', $successMsg );

				echo"<script>
					window.history.go(-2);
				</script>";
			}else{
				$errorMsg = 'Error '.mysqli_error($conn);
				flash('example_message', $errorMsg );

				echo"<script>
					window.history.go(-2);
				</script>";
			}
		}
	}
	elseif ($mod == "quiz" AND $act == "simpannilai") 
	{
		 mysqli_query($conn,"UPDATE siswa_sudah_mengerjakan SET dikoreksi = 'S'
                                                WHERE id_tq ='$_POST[id_topik]' AND id_siswa = '$_POST[id_siswa]'") or die(mysqli_error());
    	mysqli_query($conn,"INSERT INTO nilai_soal_esay (id_tq,id_siswa,nilai)
                                   VALUES ('$_POST[id_topik]','$_POST[id_siswa]','$_POST[nilai]')") or die(mysqli_error());
    	flash('example_message', 'Berhasil menginputkan data nilai essay.' );
		echo"<script>
					window.history.go(-2);
				</script>";	
	}
	elseif ($mod == "quiz" AND $act == "editnilai") 
	{
		mysqli_query($conn,"UPDATE nilai_soal_esay SET nilai = '$_POST[nilai]' WHERE id_tq ='$_POST[id_topik]' AND id_siswa = '$_POST[id_siswa]' ") or die(mysqli_error());
		flash('example_message', 'Berhasil mengubah data nilai essay.' );
			echo"<script>
					window.history.go(-2);
				</script>";
	}
	elseif ($mod == "quiz" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM topik_quiz WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data Quiz.' );
		echo"<script>
			window.history.back();
		</script>";	
	}
	elseif ($mod == "quiz" AND $act == "hapusesay") 
	{
		$sql = "select * from quiz_esay where id = '$_GET[id]'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			$image = $row['gambar'];
			unlink($upload_dir.$image);
			mysqli_query($conn,"DELETE FROM quiz_esay WHERE id = '$_GET[id]'") or die(mysqli_error());
			flash('example_message', 'Berhasil menghapus data Quiz.' );
			echo"<script>
				window.history.back();
			</script>";	
		}		
		
	}elseif ($mod == "quiz" AND $act == "hapuspilgan") 
	{
		$sql = "select * from quiz_pilganda where id = '$_GET[id]'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			$image = $row['gambar'];
			unlink($upload_dir.$image);
			mysqli_query($conn,"DELETE FROM quiz_pilganda WHERE id = '$_GET[id]'") or die(mysqli_error());
			flash('example_message', 'Berhasil menghapus data Quiz.' );
			echo"<script>
				window.history.back();
			</script>";	
		}		
		
	}elseif ($mod == "quiz" AND $act == "hapussiswa") 
	{
		mysqli_query($conn,"DELETE FROM siswa_sudah_mengerjakan WHERE id_siswa='$_GET[nis]' AND id = '$_GET[id]'")or die(mysqli_error());
	    mysqli_query($conn,"DELETE FROM nilai_soal_esay WHERE id_tq='$_GET[id_tq]' AND id_siswa='$_GET[nis]'")or die(mysqli_error());
	    mysqli_query($conn,"DELETE FROM nilai WHERE id_tq='$_GET[id_tq]' AND id_siswa='$_GET[nis]'")or die(mysqli_error());
	    mysqli_query($conn,"DELETE FROM jawaban WHERE id_tq='$_GET[id_tq]' AND id_siswa ='$_GET[nis]'")or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data siswa.' );
		echo"<script>
			window.history.back();
		</script>";	
		
	}

?>