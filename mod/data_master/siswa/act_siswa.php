<?php
session_start();
include "../../../lib/conn.php";
include "../../../lib/all_function.php";
include "../../../lib/fungsi_transaction.php";
require_once '../../../PHPExcel/PHPExcel.php';
$upload_dir = '../../../images/siswa/';
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
	$pinortu = anti_inject($_POST['pinortu']);
	$pinsiswa = anti_inject($_POST['pinsiswa']);
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
		$sql = "INSERT INTO siswa (`nis`, `nisn`, `nama`, `panggilan`, `tahunmasuk`, `idangkatan`, `idkelas`, `agama`, `status`, `kondisi`, `kelamin`, `tmplahir`, `tgllahir`, `warga`, `anakke`, `jsaudara`, `bahasa`, `berat`, `tinggi`, `darah`, `foto`, `alamatsiswa`, `kodepossiswa`, `hpsiswa`, `emailsiswa`, `kesehatan`, `asalsekolah`, `noijasah`, `tglijasah`, `ketsekolah`, `namaayah`, `namaibu`, `tmplahirayah`, `tmplahiribu`, `tgllahirayah`, `tgllahiribu`, `pendidikanayah`, `pendidikanibu`, `pekerjaanayah`, `pekerjaanibu`, `wali`, `penghasilanayah`, `penghasilanibu`, `alamatortu`, `hportu`, `emailayah`, `alamatsurat`, `keterangan`, `hobi`, `frompsb`, `ketpsb`, `statusmutasi`, `alumni`, `pinsiswa`, `pinortu`, `pinortuibu`, `emailibu`, `info`)
				VALUES ('$nis','$nisn','$nama','$panggilan','$tahunmasuk','$idangkatan','$idkelas','$agama','$status','$kondisi','$kelamin','$tmplahir','$tgllahir','$warga','$anakke','$jsaudara','$bahasa','$berat','$tinggi','$darah','$userPic','$alamatsiswa','$kodepossiswa','$hpsiswa','$emailsiswa','$kesehatan','$asalsekolah','','','','$namaayah','$namaibu','','','','','$pendidikanayah','$pendidikanibu','$pekerjaanayah','$pekerjaanibu','$wali','$penghasilanayah','$penghasilanibu','$alamatortu','$hportu','$emailayah','$alamatsurat','$keterangan','','','','','','md5('$pinortu')',md5('$pinortu'),'','$emailibu','')";
		$result = mysqli_query($conn, $sql);
		if ($result) {
			$successMsg = 'Berhasil menambah data siswa.';
			flash('example_message', $successMsg);


			commit();
			header("location:../../../med.php?mod=transaksi&act=baru&nis=" . $nis . "&nama=" . $nama);
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
	$pinsiswa = anti_inject($_POST['pinsiswa']);
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
		$sql = "UPDATE `siswa` SET `nis`='$nis',`nisn`='$nisn',`nama`='$nama',`panggilan`='$panggilan',`tahunmasuk`='$tahunmasuk',`idangkatan`='$idangkatan',`idkelas`='$idkelas',`agama`='$agama',`status`='$status',`kondisi`='$kondisi',`kelamin`='$kelamin',`tmplahir`='$tmplahir',`tgllahir`='$tgllahir',`warga`='$warga',`anakke`='$anakke',`jsaudara`='$jsaudara',`bahasa`='$bahasa',`berat`='$berat',`tinggi`='$tinggi',`darah`='$darah',`foto`='$userPic',`alamatsiswa`='$alamatsiswa',`kodepossiswa`='$kodepossiswa',`hpsiswa`='$hpsiswa',`emailsiswa`='$emailsiswa',`kesehatan`='$kesehatan',`asalsekolah`='$asalsekolah',`namaayah`='$namaayah',`namaibu`='$namaibu',`tmplahirayah`='',`tmplahiribu`='',`tgllahirayah`='',`tgllahiribu`='',`pendidikanayah`='$pendidikanayah',`pendidikanibu`='$pendidikanibu',`pekerjaanayah`='$pekerjaanayah',`pekerjaanibu`='$pekerjaanibu',`wali`='$wali',`penghasilanayah`='$penghasilanayah',`penghasilanibu`='$penghasilanibu',`alamatortu`='$alamatortu',`hportu`='$hportu',`emailayah`='$emailayah',`alamatsurat`='$alamatsurat',`keterangan`='$keterangan',`pinsiswa`='$pass',`pinortu`='$passo',`emailibu`='$emailibu' WHERE `id` = '$_POST[id]'";
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
		$tahunmasuk = date('Y');
		$kelasn = $row['L'];

		// Cek jika semua data tidak diisi
		if ($nis == "" && $nama == "" && $panggilan == "" && $tahunajaran == "" && $jeniskelamin == "" && $tmplahir == "" && $tgllahir == "" && $hp == "" && $alamat == "" && $email == "" && $asal == "")
			continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

		$kelas = mysqli_fetch_row(mysqli_query($conn, "SELECT * FROM kelas WHERE kelas = '3 IBT Q'"));

		if ($kelas) {
			$idKelas = (int)$kelas[0];
		} else {
			$idKelas = null;
		}

		// Cek $numrow apakah lebih dari 1
		// Artinya karena baris pertama adalah nama-nama kolom
		// Jadi dilewat saja, tidak usah diimport
		if ($numrow > 1) {
			// Buat query Insert
			$query = "INSERT INTO siswa (`nis`, `nisn`, `nama`, `panggilan`, `tahunmasuk`, `idangkatan`, `idkelas`, `agama`, `status`, `kondisi`, `kelamin`, `tmplahir`, `tgllahir`, `warga`, `anakke`, `jsaudara`, `bahasa`, `berat`, `tinggi`, `darah`, `foto`, `alamatsiswa`, `kodepossiswa`, `hpsiswa`, `emailsiswa`, `kesehatan`, `asalsekolah`, `noijasah`, `tglijasah`, `ketsekolah`, `namaayah`, `namaibu`, `tmplahirayah`, `tmplahiribu`, `tgllahirayah`, `tgllahiribu`, `pendidikanayah`, `pendidikanibu`, `pekerjaanayah`, `pekerjaanibu`, `wali`, `penghasilanayah`, `penghasilanibu`, `alamatortu`, `hportu`, `emailayah`, `alamatsurat`, `keterangan`, `hobi`, `frompsb`, `ketpsb`, `statusmutasi`, `alumni`, `pinsiswa`, `pinortu`, `pinortuibu`, `emailibu`, `info`)
				VALUES ('$nis','','$nama','$panggilan','$tahunmasuk',null,'$idKelas','','','','$jeniskelamin','$tmplahir','$tgllahir','',0,0,'',0.0,0.0,'','','$alamat','','$hp','$email','','$asal','','','','','','','','','','','','','','',0,0,0,'','','','','',0,'',0,0,'',md5('$nis'),'','','')";

			// Eksekusi $query
			mysqli_query($conn, $query) or die(mysqli_error($conn));
		}

		$numrow++; // Tambah 1 setiap kali looping
	}
	flash('example_message', 'Berhasil mengimport data siswa.');
	echo "<script>
			window.history.go(-2);
		</script>";
} elseif ($mod == "siswa" and $act == "hapus") {
	$sql = "select * from siswa where id = '$_GET[id]'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$image = $row['foto'];
		unlink($upload_dir . $image);
		mysqli_query($conn, "DELETE FROM siswa WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data siswa.');
		echo "<script>
				window.history.back();
			</script>";
	}
}
