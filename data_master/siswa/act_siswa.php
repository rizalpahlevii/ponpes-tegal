<?php
session_start();
var_dump($_POST['pinortu']);
include "../../../lib/conn.php";
include "../../../lib/all_function.php";
include "../../../lib/fungsi_transaction.php";
require_once '../../../PHPExcel/PHPExcel.php';
$upload_dir = '../../../images/siswa/';
if ($_SESSION['level'] == 'admin' or $_SESSION['level'] == 'superadmin') {
	$linkaksi = 'med.php?';
} else {
	$linkaksi = 'med2.php?';
}
if (!isset($_SESSION['login_user'])) {
	header('location: ../../../login.php'); // Mengarahkan ke Home Page
}

if (isset($_GET['mod']) && isset($_GET['act'])) {
	$mod = $_GET['mod'];
	$act = $_GET['act'];
} else {
	$mod = "";
	$act = "";
}

if ($mod == "siswa" and $act == "simpan") {
	$hijri = HijriCalendar::GregorianToHijri(time());
	$huruf = $hijri['2'];
	// mengambil data barang dengan kode paling besar
	$queryn = mysqli_query($conn, "SELECT max(nis) as kodeTerbesar FROM siswa WHERE `nis` LIKE '$huruf%'");
	$datan = mysqli_fetch_array($queryn);
	$nis = $datan['kodeTerbesar'];

	// mengambil angka dari kode barang terbesar, menggunakan fungsi substr
	// dan diubah ke integer dengan (int)
	$urutan = (int) substr($nis, 4, 4);

	// bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
	$urutan++;

	// membentuk kode barang baru
	// perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
	// misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
	// angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
	$nis = $huruf . sprintf("%04s", $urutan);

	$pinortu = anti_inject($_POST['pinortu']);
	$pinsiswa = anti_inject($_POST['pinortu']);
	//$nis = anti_inject($_POST['nis']);
	$nisn = anti_inject($_POST['nisn']);
	$nama = anti_inject($_POST['nama']);
	$idkelas = anti_inject($_POST['idkelas']);
	$panggilan = anti_inject($_POST['panggilan']);
	$tahunmasuk = anti_inject($_POST['tahunmasuk']);
	$idangkatan = anti_inject($_POST['idangkatan']);
	$agama = anti_inject($_POST['agama']);
	$status = anti_inject($_POST['status']);
	$kondisi = anti_inject($_POST['kondisi']);
	$kelamin = anti_inject($_POST['kelamin']);
	$tmplahir = anti_inject($_POST['tmplahir']);
	$tgllahir = anti_inject($_POST['tgllahir']);
	$warga = anti_inject($_POST['warga']);
	$anakke = anti_inject($_POST['anakke']);
	$jsaudara = anti_inject($_POST['jsaudara']);
	$bahasa = anti_inject($_POST['bahasa']);
	$berat = anti_inject($_POST['berat']);
	$tinggi = anti_inject($_POST['tinggi']);
	$darah = anti_inject($_POST['darah']);
	$alamatsiswa = anti_inject($_POST['alamatsiswa']);
	$kodepossiswa = anti_inject($_POST['kodepossiswa']);
	$hpsiswa = anti_inject($_POST['hpsiswa']);
	$emailsiswa = anti_inject($_POST['emailsiswa']);
	$kesehatan = anti_inject($_POST['kesehatan']);
	$asalsekolah = anti_inject($_POST['asalsekolah']);
	$namaayah = anti_inject($_POST['namaayah']);
	$namaibu = anti_inject($_POST['namaibu']);
	$pendidikanayah = anti_inject($_POST['pendidikanayah']);
	$pendidikanibu = anti_inject($_POST['pendidikanibu']);
	$pekerjaanayah = anti_inject($_POST['pekerjaanayah']);
	$pekerjaanibu = anti_inject($_POST['pekerjaanibu']);
	$wali = anti_inject($_POST['wali']);
	$penghasilanayah = str_replace(",", "", anti_inject($_POST['penghasilanayah']));
	$penghasilanibu = str_replace(",", "", anti_inject($_POST['penghasilanibu']));
	$alamatortu = anti_inject($_POST['alamatortu']);
	$hportu = anti_inject($_POST['hportu']);
	$emailayah = anti_inject($_POST['emailayah']);
	$emailibu = anti_inject($_POST['emailibu']);
	$alamatsurat = anti_inject($_POST['alamatsurat']);
	$keterangan = anti_inject($_POST['keterangan']);
	$imgName = $_FILES['foto']['name'];
	$imgTmp = $_FILES['foto']['tmp_name'];
	$imgSize = $_FILES['foto']['size'];
	$imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

	$allowExt  = array('jpeg', 'jpg', 'png', 'gif');

	if (in_array($imgExt, $allowExt)) {

		if ($imgSize < 5000000) {
			$userPic = time() . '_' . rand(1000, 9999) . '.' . $imgExt;
			move_uploaded_file($imgTmp, $upload_dir . $userPic);
		} else {
			$errorMsg = 'Image too large';
			flash('example_message', $errorMsg);

			echo "<script>
					window.history.go(-2);
				</script>";
		}
	} else {
		$userPic = "";
	}
	if (!isset($errorMsg)) {
		$sql = "INSERT INTO siswa (`nis`, `nisn`, `nama`, `panggilan`, `tahunmasuk`, `idangkatan`, `idkelas`, `agama`, `status`, `kondisi`, `kelamin`, `tmplahir`, `tgllahir`, `warga`, `anakke`, `jsaudara`, `bahasa`, `berat`, `tinggi`, `darah`, `foto`, `alamatsiswa`, `kodepossiswa`, `hpsiswa`, `emailsiswa`, `kesehatan`, `asalsekolah`, `noijasah`, `tglijasah`, `ketsekolah`, `namaayah`, `namaibu`, `tmplahirayah`, `tmplahiribu`, `tgllahirayah`, `tgllahiribu`, `pendidikanayah`, `pendidikanibu`, `pekerjaanayah`, `pekerjaanibu`, `wali`, `penghasilanayah`, `penghasilanibu`, `alamatortu`, `hportu`, `emailayah`, `alamatsurat`, `keterangan`, `hobi`, `frompsb`, `ketpsb`, `statusmutasi`, `alumni`, `pinsiswa`, `pinortu`, `pinortuibu`, `emailibu`, `info`,`create_by`)
				VALUES ('$nis','$nisn','$nama','$panggilan','$tahunmasuk','$idangkatan','$idkelas','$agama','$status','$kondisi','$kelamin','$tmplahir','$tgllahir','$warga','$anakke','$jsaudara','$bahasa','$berat','$tinggi','$darah','$userPic','$alamatsiswa','$kodepossiswa','$hpsiswa','$emailsiswa','$kesehatan','$asalsekolah','','','','$namaayah','$namaibu','','','','','$pendidikanayah','$pendidikanibu','$pekerjaanayah','$pekerjaanibu','$wali','$penghasilanayah','$penghasilanibu','$alamatortu','$hportu','$emailayah','$alamatsurat','$keterangan','','','','','',md5('$pinortu'),md5('$nis'),'','$emailibu','','$_SESSION[id_user]')";
		$result = mysqli_query($conn, $sql);
		if ($result) {
			$successMsg = 'Berhasil menambah data siswa.';
			flash('example_message', $successMsg);


			commit();
			header("location:../../../" . $linkaksi . "mod=transaksi&act=baru&nis=" . $nis . "&nama=" . $nama);
		} else {
			$errorMsg = 'Error ' . mysqli_error($conn);
			flash('example_message', $errorMsg);

			echo "<script>
					window.history.go(-2);
				</script>";
		}
	}
} elseif ($mod == "siswa" and $act == "edit") {
	$pinortu = anti_inject($_POST['pinortu']);
	$pinsiswa = anti_inject($_POST['pinortu']);
	$nis = anti_inject($_POST['nis']);
	$nisn = anti_inject($_POST['nisn']);
	$nama = anti_inject($_POST['nama']);
	$idkelas = anti_inject($_POST['idkelas']);
	$panggilan = anti_inject($_POST['panggilan']);
	$tahunmasuk = anti_inject($_POST['tahunmasuk']);
	$idangkatan = anti_inject($_POST['idangkatan']);
	$agama = anti_inject($_POST['agama']);
	$status = anti_inject($_POST['status']);
	$kondisi = anti_inject($_POST['kondisi']);
	$kelamin = anti_inject($_POST['kelamin']);
	$tmplahir = anti_inject($_POST['tmplahir']);
	$tgllahir = anti_inject($_POST['tgllahir']);
	$warga = anti_inject($_POST['warga']);
	$anakke = anti_inject($_POST['anakke']);
	$jsaudara = anti_inject($_POST['jsaudara']);
	$bahasa = anti_inject($_POST['bahasa']);
	$berat = anti_inject($_POST['berat']);
	$tinggi = anti_inject($_POST['tinggi']);
	$darah = anti_inject($_POST['darah']);
	$alamatsiswa = anti_inject($_POST['alamatsiswa']);
	$kodepossiswa = anti_inject($_POST['kodepossiswa']);
	$hpsiswa = anti_inject($_POST['hpsiswa']);
	$emailsiswa = anti_inject($_POST['emailsiswa']);
	$kesehatan = anti_inject($_POST['kesehatan']);
	$asalsekolah = anti_inject($_POST['asalsekolah']);
	$namaayah = anti_inject($_POST['namaayah']);
	$namaibu = anti_inject($_POST['namaibu']);
	$pendidikanayah = anti_inject($_POST['pendidikanayah']);
	$pendidikanibu = anti_inject($_POST['pendidikanibu']);
	$pekerjaanayah = anti_inject($_POST['pekerjaanayah']);
	$pekerjaanibu = anti_inject($_POST['pekerjaanibu']);
	$wali = anti_inject($_POST['wali']);
	$penghasilanayah = str_replace(",", "", anti_inject($_POST['penghasilanayah']));
	$penghasilanibu = str_replace(",", "", anti_inject($_POST['penghasilanibu']));
	$alamatortu = anti_inject($_POST['alamatortu']);
	$hportu = anti_inject($_POST['hportu']);
	$emailayah = anti_inject($_POST['emailayah']);
	$emailibu = anti_inject($_POST['emailibu']);
	$alamatsurat = anti_inject($_POST['alamatsurat']);
	$keterangan = anti_inject($_POST['keterangan']);
	$foto = anti_inject($_POST['img']);
	$pino = anti_inject($_POST['pino']);
	$pins = anti_inject($_POST['pins']);
	if ($pino == $pinortu) {
		$passo = $pino;
	} else {
		$passo = md5($pinortu);
	}
	if ($pins == $pinsiswa) {
		$pass = $pins;
	} else {
		$pass = md5($pinsiswa);
	}
	$imgName = $_FILES['foto']['name'];
	$imgTmp = $_FILES['foto']['tmp_name'];
	$imgSize = $_FILES['foto']['size'];

	if ($imgName) {
		$imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

		$allowExt  = array('jpeg', 'jpg', 'png', 'gif');


		if (in_array($imgExt, $allowExt)) {

			if ($imgSize < 5000000) {
				unlink($upload_dir . $foto);
				$userPic = time() . '_' . rand(1000, 9999) . '.' . $imgExt;
				move_uploaded_file($imgTmp, $upload_dir . $userPic);
			} else {
				$errorMsg = 'Image too large';
				flash('example_message', $errorMsg);

				echo "<script>
						window.history.go(-2);
					</script>";
			}
		} else {
			$userPic = "";
		}
	} else {

		$userPic = $foto;
	}
	if (!isset($errorMsg)) {
		$sql = "UPDATE `siswa` SET `nama`='$nama',`panggilan`='$panggilan',`tahunmasuk`='$tahunmasuk',`idangkatan`='$idangkatan',`idkelas`='$idkelas',`agama`='$agama',`status`='$status',`kondisi`='$kondisi',`kelamin`='$kelamin',`tmplahir`='$tmplahir',`tgllahir`='$tgllahir',`warga`='$warga',`anakke`='$anakke',`jsaudara`='$jsaudara',`bahasa`='$bahasa',`berat`='$berat',`tinggi`='$tinggi',`darah`='$darah',`foto`='$userPic',`alamatsiswa`='$alamatsiswa',`kodepossiswa`='$kodepossiswa',`hpsiswa`='$hpsiswa',`emailsiswa`='$emailsiswa',`kesehatan`='$kesehatan',`asalsekolah`='$asalsekolah',`namaayah`='$namaayah',`namaibu`='$namaibu',`tmplahirayah`='',`tmplahiribu`='',`tgllahirayah`='',`tgllahiribu`='',`pendidikanayah`='$pendidikanayah',`pendidikanibu`='$pendidikanibu',`pekerjaanayah`='$pekerjaanayah',`pekerjaanibu`='$pekerjaanibu',`wali`='$wali',`penghasilanayah`='$penghasilanayah',`penghasilanibu`='$penghasilanibu',`alamatortu`='$alamatortu',`hportu`='$hportu',`emailayah`='$emailayah',`alamatsurat`='$alamatsurat',`keterangan`='$keterangan',`pinortu`='$passo',`emailibu`='$emailibu' WHERE `id` = '$_POST[id]'";
		$result = mysqli_query($conn, $sql);
		if ($result) {
			$successMsg = 'Berhasil merubah data siswa.';
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
} elseif ($mod == "siswa" and $act == "import") {
	die;
	$nama_file_baru = 'datasiswa.xlsx';
	$excelreader = new PHPExcel_Reader_Excel2007();
	$loadexcel = $excelreader->load('../../../import/tmp/' . $nama_file_baru); // Load file excel yang tadi diupload ke folder tmp
	$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

	$numrow = 1;
	foreach ($sheet as $row) {
		// Ambil data pada excel sesuai Kolom
		$nis = $row['A']; // Ambil data NIS
		$nama = $row['B']; // Ambil data nama
		$panggilan = $row['C'];
		$tahunajaran = $row['D'];
		$jeniskelamin = $row['E']; // Ambil data jenis kelamin
		$tmplahir = $row['F'];
		$tgllahir = $row['G'];
		$alamat = $row['H']; // Ambil data alamat
		$hp = $row['I']; // Ambil data telepon
		$email = $row['J'];
		$asal = $row['K']; // Ambil data alamat
		$idkelas = $row['L']; // Ambil data alamat
		$ortu = $row['M']; // Ambil data alamat
		$kerja = $row['N']; // Ambil data alamat
		$hobi = $row['O']; // Ambil data alamat
		$idangkatan = $row['P']; // Ambil data alamat


		// Cek jika semua data tidak diisi
		if ($nis == "" && $nama == "" && $panggilan == "" && $tahunajaran == "" && $jeniskelamin == "" && $tmplahir == "" && $tgllahir == "" && $hp == "" && $alamat == "" && $email == "" && $asal == "" && $idkelas == "" && $ortu == "" && $kerja == "" && $hobi == "" && $idangkatan == "")
			continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

		// Cek $numrow apakah lebih dari 1
		// Artinya karena baris pertama adalah nama-nama kolom
		// Jadi dilewat saja, tidak usah diimport
		if ($numrow > 1) {
			// Buat query Insert
			$query = "INSERT INTO siswa (`nis`, `nisn`, `nama`, `panggilan`, `tahunmasuk`, `idangkatan`, `idkelas`, `agama`, `status`, `kondisi`, `kelamin`, `tmplahir`, `tgllahir`, `warga`, `anakke`, `jsaudara`, `bahasa`, `berat`, `tinggi`, `darah`, `foto`, `alamatsiswa`, `kodepossiswa`, `hpsiswa`, `emailsiswa`, `kesehatan`, `asalsekolah`, `noijasah`, `tglijasah`, `ketsekolah`, `namaayah`, `namaibu`, `tmplahirayah`, `tmplahiribu`, `tgllahirayah`, `tgllahiribu`, `pendidikanayah`, `pendidikanibu`, `pekerjaanayah`, `pekerjaanibu`, `wali`, `penghasilanayah`, `penghasilanibu`, `alamatortu`, `hportu`, `emailayah`, `alamatsurat`, `keterangan`, `hobi`, `frompsb`, `ketpsb`, `statusmutasi`, `alumni`, `pinsiswa`, `pinortu`, `pinortuibu`, `emailibu`, `info`,`create_by`)
				VALUES ('$nis','','$nama','$panggilan','','$idangkatan','$idkelas','','','','$jeniskelamin','$tmplahir','$tgllahir','','','','','','','','','$alamat','','$hp','$email','','$asal','','','','$ortu','','','','','','','','$kerja','','','','','$alamat','','','','','$hobi','','','','','',md5('$nis'),'','','','$_SESSION[id_user]')";

			// Eksekusi $query
			mysqli_query($conn, $query) or die(mysqli_error());
		}

		$numrow++; // Tambah 1 setiap kali looping
	}
	flash('example_message', 'Berhasil mengimport data siswa.');
	echo "<script>
			window.history.go(-2);
		</script>";
} elseif ($mod == "siswa" and $act == "kelas") {


	$nis = anti_inject($_POST['nis']);
	$nama = anti_inject($_POST['nama']);
	mysqli_query($conn, "UPDATE `siswa` SET `idkelas` = '$_POST[idkelas]' WHERE `nis` = '$_POST[nis]'") or die(mysqli_error());

	flash('example_message', 'Berhasil menambah data pembayaran pendaftaran baru.');

	header("location:../../../" . $linkaksi . "mod=transaksi&act=baru&nis=" . $nis . "&nama=" . $nama);
} elseif ($mod == "siswa" and $act == "hapus") {
	$sql = "select * from siswa where id = '$_GET[id]'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$image = $row['foto'];
		unlink($upload_dir . $image);

		mysqli_query($conn, "DELETE FROM `nilaiujian` WHERE `nis` = '$row[nis]'") or die(mysqli_error());
		mysqli_query($conn, "DELETE FROM siswa WHERE id = '$_GET[id]'") or die(mysqli_error());
		mysqli_query($conn, "DELETE FROM `siswa_nonaktif` WHERE `nis` = '$row[nis]'") or die(mysqli_error());
		$sqlt = "select * from `transaksi` where `nis` = '$row[nis]'";
		$resultt = mysqli_query($conn, $sqlt);
		$rowt = mysqli_fetch_assoc($resultt);
		mysqli_query($conn, "DELETE FROM `detail_transaksi` WHERE `no_transaksi` = '$rowt[no_transaksi]'") or die(mysqli_error());
		mysqli_query($conn, "DELETE FROM `bayarcicilan` WHERE `no_transaksi` = '$rowt[no_transaksi]'") or die(mysqli_error());

		mysqli_query($conn, "DELETE FROM `transaksi` WHERE `nis` = '$row[nis]'") or die(mysqli_error());
		mysqli_query($conn, "DELETE FROM `spp` WHERE `nis` = '$row[nis]'") or die(mysqli_error());
		mysqli_query($conn, "DELETE FROM `kemaarifan` WHERE `nis` = '$row[nis]'") or die(mysqli_error());
		mysqli_query($conn, "DELETE FROM `absensi_siswa` WHERE `nis` = '$row[nis]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data siswa.');
		echo "<script>
				window.history.back();
			</script>";
	}
} elseif ($mod == "siswa" and $act == "aktif") {

	mysqli_query($conn, "DELETE FROM `siswa_nonaktif` WHERE `nis` = '$_GET[nis]'") or die(mysqli_error());

	flash('example_message', 'Berhasil Mengaktifkan Santri.');

	header("location:../../../" . $linkaksi . "mod=siswa");
} elseif ($mod == "siswa" and $act == "nonaktif") {

	mysqli_query($conn, "INSERT INTO `siswa_nonaktif`(`nis`) VALUES ('$_GET[nis]')") or die(mysqli_error());

	flash('example_message', 'Berhasil Menonaktifkan Santri.');

	header("location:../../../" . $linkaksi . "mod=siswa");
}
