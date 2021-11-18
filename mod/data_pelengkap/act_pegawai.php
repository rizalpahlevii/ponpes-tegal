<?php
session_start();

include "../../lib/conn.php";
include "../../lib/all_function.php";
$upload_dir = '../../images/pegawai/';
if (!isset($_SESSION['login_user'])) {
	header('location: ../../login.php'); // Mengarahkan ke Home Page
}

if (isset($_GET['mod']) && isset($_GET['act'])) {
	$mod = $_GET['mod'];
	$act = $_GET['act'];
} else {
	$mod = "";
	$act = "";
}

if ($mod == "pegawai" and $act == "simpan") {
	$nip = anti_inject($_POST['nip']);
	$pinpegawai = anti_inject($_POST['pinpegawai']);
	$nama = anti_inject($_POST['nama']);
	$panggilan = anti_inject($_POST['panggilan']);
	$bagian = anti_inject($_POST['bagian']);
	$gelarawal = anti_inject($_POST['gelarawal']);
	$gelarakhir = anti_inject($_POST['gelarakhir']);
	$agama = anti_inject($_POST['agama']);
	$nikah = anti_inject($_POST['nikah']);
	$kelamin = anti_inject($_POST['kelamin']);
	$tmplahir = anti_inject($_POST['tmplahir']);
	$tgllahir = anti_inject($_POST['tgllahir']);
	$noid = anti_inject($_POST['noid']);
	$alamat = anti_inject($_POST['alamat']);
	$handphone = anti_inject($_POST['handphone']);
	$email = anti_inject($_POST['email']);
	$keterangan = anti_inject($_POST['keterangan']);
	$imgName = $_FILES['foto']['name'];
	$imgTmp = $_FILES['foto']['tmp_name'];
	$imgSize = $_FILES['foto']['size'];
	$imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

	$allowExt  = array('jpeg', 'jpg', 'png', 'gif');

	$userPic = time() . '_' . rand(1000, 9999) . '.' . $imgExt;

	if (in_array($imgExt, $allowExt)) {

		if ($imgSize < 5000000) {
			move_uploaded_file($imgTmp, $upload_dir . $userPic);
		} else {
			$errorMsg = 'Image too large';
			flash('example_message', $errorMsg);

			echo "<script>
					window.history.go(-2);
				</script>";
		}
	} else {
		$errorMsg = 'Please select a valid image';
		flash('example_message', $errorMsg);

		echo "<script>
				window.history.go(-2);
			</script>";
	}
	if (!isset($errorMsg)) {
		$sql = "INSERT INTO `pegawai`(`nip`, `nrp`, `nuptk`, `nama`, `panggilan`, `gelarawal`, `gelarakhir`, `tmplahir`, `tgllahir`, `agama`, `noid`, `alamat`, `handphone`, `email`, `foto`, `bagian`, `nikah`, `keterangan`, `kelamin`, `pinpegawai`, `mulaikerja`, `status`, `ketnonaktif`, `pensiun`, `doaudit`) VALUES ('$nip','','','$nama','$panggilan','$gelarawal','$gelarakhir','$tmplahir','$tgllahir','$agama','$noid','$alamat','$handphone','$email','$userPic','$bagian','$nikah','$keterangan','$kelamin', md5('$pinpegawai'),null,null,null,null,null)";
		$result = mysqli_query($conn, $sql);

		if ($result) {
			$successMsg = 'Berhasil menambah data pegawai.';
			flash('example_message', $successMsg);

			echo "<script>
					window.history.go(-2);
				</script>";
		} else {
			$errorMsg = 'Error ' . mysqli_error($conn);

			flash('example_message', $errorMsg);

			echo "<script>
					window.history.go(-2);
				</script>";
		}
	}
} elseif ($mod == "pegawai" and $act == "edit") {
	$nip = anti_inject($_POST['nip']);
	$pinpegawai = anti_inject($_POST['pinpegawai']);
	$nama = anti_inject($_POST['nama']);
	$panggilan = anti_inject($_POST['panggilan']);
	$bagian = anti_inject($_POST['bagian']);
	$gelarawal = anti_inject($_POST['gelarawal']);
	$gelarakhir = anti_inject($_POST['gelarakhir']);
	$agama = anti_inject($_POST['agama']);
	$nikah = anti_inject($_POST['nikah']);
	$kelamin = anti_inject($_POST['kelamin']);
	$tmplahir = anti_inject($_POST['tmplahir']);
	$tgllahir = anti_inject($_POST['tgllahir']);
	$noid = anti_inject($_POST['noid']);
	$alamat = anti_inject($_POST['alamat']);
	$handphone = anti_inject($_POST['handphone']);
	$email = anti_inject($_POST['email']);
	$keterangan = anti_inject($_POST['keterangan']);
	$foto = anti_inject($_POST['img']);
	$pin = anti_inject($_POST['pin']);
	if ($pin == $pinpegawai) {
		$pass = $pin;
	} else {
		$pass = md5($pinpegawai);
	}
	$imgName = $_FILES['foto']['name'];
	$imgTmp = $_FILES['foto']['tmp_name'];
	$imgSize = $_FILES['foto']['size'];

	if ($imgName) {
		$imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

		$allowExt  = array('jpeg', 'jpg', 'png', 'gif');

		$userPic = time() . '_' . rand(1000, 9999) . '.' . $imgExt;

		if (in_array($imgExt, $allowExt)) {

			if ($imgSize < 5000000) {
				unlink($upload_dir . $foto);
				move_uploaded_file($imgTmp, $upload_dir . $userPic);
			} else {
				$errorMsg = 'Image too large';
				flash('example_message', $errorMsg);

				echo "<script>
						window.history.go(-2);
					</script>";
			}
		} else {
			$errorMsg = 'Please select a valid image';
			flash('example_message', $errorMsg);

			echo "<script>
					window.history.go(-2);
				</script>";
		}
	} else {

		$userPic = $foto;
	}
	if (!isset($errorMsg)) {
		$sql = "UPDATE `pegawai` SET `nip`='$nip',`nama`='$nama',`panggilan`='$panggilan',`gelarawal`='$gelarawal',`gelarakhir`='$gelarakhir',`tmplahir`='$tmplahir',`tgllahir`='$tgllahir',`agama`='$agama',`noid`='$noid',`alamat`='$alamat',`handphone`='$handphone',`email`='$email',`foto`='$userPic',`bagian`='$bagian',`nikah`='$nikah',`keterangan`='$keterangan',`kelamin`='$kelamin',`pinpegawai`='$pass' WHERE `id` = '$_POST[id]'";
		$result = mysqli_query($conn, $sql);
		if ($result) {
			$successMsg = 'Berhasil merubah data pegawai.';
			flash('example_message', $successMsg);

			echo "<script>
					window.history.go(-2);
				</script>";
		} else {
			$errorMsg = 'Error ' . mysqli_error($conn);
			flash('example_message', $errorMsg);

			echo "<script>
					window.history.go(-2);
				</script>";
		}
	}
} elseif ($mod == "pegawai" and $act == "import") {
	$nama_file_baru = 'data.xlsx';
	$excelreader = new PHPExcel_Reader_Excel2007();
	$loadexcel = $excelreader->load('../../import/tmp/' . $nama_file_baru); // Load file excel yang tadi diupload ke folder tmp
	$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

	$numrow = 1;
	foreach ($sheet as $row) {
		// Ambil data pada excel sesuai Kolom
		$nip = $row['A']; // Ambil data NIS
		$nama = $row['B']; // Ambil data nama
		$panggilan = $row['C'];
		$gelar = $row['D'];
		$bagian = $row['E'];
		$jeniskelamin = $row['F']; // Ambil data jenis kelamin
		$tmplahir = $row['G'];
		$tgllahir = $row['H'];
		$nikah = $row['I'];
		$noid = $row['J'];
		$hp = $row['K']; // Ambil data telepon
		$alamat = $row['L']; // Ambil data alamat
		$email = $row['M'];
		$ket = $row['N']; // Ambil data alamat

		// Cek jika semua data tidak diisi
		if ($nip == "" && $nama == "" && $panggilan == "" && $gelar == "" && $bagian == "" && $jeniskelamin == "" && $tmplahir == "" && $tgllahir == "" && $nikah == "" && $noid == "" && $hp == "" && $alamat == "" && $email == "" && $ket == "")
			continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

		// Cek $numrow apakah lebih dari 1
		// Artinya karena baris pertama adalah nama-nama kolom
		// Jadi dilewat saja, tidak usah diimport
		if ($numrow > 1) {
			// Buat query Insert
			$query = "INSERT INTO `pegawai`(`nip`, `nrp`, `nuptk`, `nama`, `panggilan`, `gelarawal`, `gelarakhir`, `tmplahir`, `tgllahir`, `agama`, `noid`, `alamat`, `handphone`, `email`, `foto`, `bagian`, `nikah`, `keterangan`, `kelamin`, `pinpegawai`, `mulaikerja`, `status`, `ketnonaktif`, `pensiun`, `doaudit`) VALUES ('$nip','','','$nama','$panggilan','$gelar','','$tmplahir','$tgllahir','','$noid','$alamat','$hp','$email','user.png','$bagian','$nikah','$ket','$jeniskelamin', md5('$nip'),'','','','','')";

			// Eksekusi $query
			mysqli_query($conn, $query) or die(mysqli_error());
		}

		$numrow++; // Tambah 1 setiap kali looping
	}
	flash('example_message', 'Berhasil mengimport data pegawai.');
	echo "<script>
			window.history.go(-4);
		</script>";
} elseif ($mod == "pegawai" and $act == "hapus") {
	$sql = "select * from pegawai where id = '$_GET[id]'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$image = $row['foto'];
		unlink($upload_dir . $image);
		mysqli_query($conn, "DELETE FROM pegawai WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data pegawai.');
		echo "<script>
				window.history.back();
			</script>";
	}
}
