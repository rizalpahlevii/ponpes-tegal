<?php
session_start();
include "../../lib/conn.php";

if (!isset($_SESSION['login_user'])) {
	header('location: ../../login.php'); // Mengarahkan ke Home Page
}

if (isset($_SESSION['level']) and $_SESSION['level'] <> 'admin') {
	echo "<div class='w3-container w3-red'>Dilarang mengakses file ini.</div>";
	die();
}

if (isset($_GET['mod']) && isset($_GET['act'])) {
	$mod = $_GET['mod'];
	$act = $_GET['act'];
} else {
	$mod = "";
	$act = "";
}

if ($mod == "user" and $act == "edit") {

	if ($_POST['password'] !== "") {
		mysqli_query($conn, "UPDATE user SET id_user = '$_POST[id_user]',
										username = '$_POST[username]',
										level = '$_POST[level]'
						WHERE id = '$_POST[id]'") or die(mysqli_error($conn));
		flash('example_message', 'Berhasil menambah data user.');

		echo "<script>
				window.history.go(-2);
			</script>";
	} else {
		if ($_POST['password'] == $_POST['rpassword']) {
			$pass = md5($_POST['password']);
			mysqli_query($conn, "UPDATE user SET id_user = '$_POST[id_user]',
										username = '$_POST[username]',
										password = '$pass',
										level = '$_POST[level]'
						WHERE id = '$_POST[id]'") or die(mysqli_error($conn));
			flash('example_message', 'Berhasil mengubah data user.');

			echo "<script>
					window.history.go(-2);
				</script>";
		} else {
			flash('example_message', 'Password tidak sama..', 'w3-red');

			echo "<script>
					window.history.back();
				</script>";
		}
	}
} elseif ($mod == "user" and $act == "simpan") {
	if (!empty($_POST['password'])) {
		if ($_POST['password'] == $_POST['rpassword']) {
			$pass = md5($_POST['password']);
			$lastLogin = date('Y-m-d H:i:s');
			mysqli_query($conn, "INSERT INTO `user`(`id_user`, `id_sekolah`, `nama`, `username`, `password`, `level`, `last_login`, `akses_master`) VALUES ('$_POST[id_user]',null,'','$_POST[username]','$pass','$_POST[level]','$lastLogin','')") or die(mysqli_error($conn));
			flash('example_message', 'Berhasil menambah data user.');

			echo "<script>
					window.history.go(-2);
				</script>";
		} else {
			flash('example_message', 'Password tidak sama..', 'w3-red');

			echo "<script>
					window.history.back();
				</script>";
		}
	} else {
		flash('example_message', 'Password Kosong', 'w3-yellow');

		echo "<script>
				window.history.back();
			</script>";
	}
} elseif ($mod == "user" and $act == "hapus") {
	mysqli_query($conn, "DELETE FROM user WHERE id = '$_GET[id]'");
	flash('example_message', 'Berhasil menghapus data user.');
	echo "<script>
			window.history.back();
		</script>";
}
