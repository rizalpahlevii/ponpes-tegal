<?php
	session_start();
	include"../../lib/conn.php";

	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['level']) AND $_SESSION['level'] <> 'admin')
	{
		echo"<div class='w3-container w3-red'>Dilarang mengakses file ini.</div>";
		die();
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
	$linkaksi = 'med.php?';

	if ($mod == "user" AND $act == "edit") {

		if ($_POST['password'] == $_POST['rpassword']) {
				$pass = md5($_POST['password']);
				mysqli_query($conn,"UPDATE user SET id_user = '$_POST[id_user]',
										username = '$_POST[username]',
										password = '$pass',
										level = '$_POST[level]'
						WHERE id = '$_POST[id]'") or die(mysqli_error());
				flash('example_message', 'Berhasil mengubah data user.' );

				echo"<script>
					window.history.go(-2);
				</script>";
			}
			else
			{
				flash('example_message', 'Password tidak sama..', 'w3-red');

				

				header("location:../../".$linkaksi."mod=user");
			}
	}
	elseif($mod == "user" AND $act == "simpan")
	{
		if(!empty($_POST['password']))
		{
			if ($_POST['password'] == $_POST['rpassword']) {
				$pass = md5($_POST['password']);
				mysqli_query($conn,"INSERT INTO `user`(`id_user`, `id_sekolah`, `nama`, `username`, `password`, `level`, `last_login`, `akses_master`) VALUES ('$_POST[id_user]','','','$_POST[username]','$pass','$_POST[level]','','')") or die(mysqli_error());
				flash('example_message', 'Berhasil menambah data user.' );

				

				header("location:../../".$linkaksi."mod=user");
			}
			else
			{
				flash('example_message', 'Password tidak sama..', 'w3-red');


				header("location:../../".$linkaksi."mod=user");
			}
		}
		else
		{
			flash('example_message', 'Password Kosong', 'w3-yellow');


			header("location:../../".$linkaksi."mod=user");
		}
		
	}
	elseif ($mod == "user" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM user WHERE id = '$_GET[id]'");
		flash('example_message', 'Berhasil menghapus data user.' );

		header("location:../../".$linkaksi."mod=user");
	}
	elseif ($mod == "user" AND $act == "aktif") {


		mysqli_query($conn,"DELETE FROM `user_nonaktif` WHERE `id_user` = '$_GET[user]'") or die(mysqli_error());

		flash('example_message', 'Berhasil Mengaktifkan User.');

		header("location:../../".$linkaksi."mod=user");
	}
	elseif ($mod == "user" AND $act == "nonaktif") {


		mysqli_query($conn,"INSERT INTO `user_nonaktif`(`id_user`) VALUES ('$_GET[user]')") or die(mysqli_error());

		flash('example_message', 'Berhasil Menonaktifkan User.');

		header("location:../../".$linkaksi."mod=user");
	}
	elseif ($mod == "userakun" AND $act == "edit") 
	{
		
			if ($_POST['password'] == $_POST['rpassword']) {
				$pass = md5($_POST['password']);
				mysqli_query($conn,"UPDATE user SET 
										username = '$_POST[username]',
										password = '$pass'
						WHERE id = '$_POST[id]'") or die(mysqli_error());
				flash('example_message', 'Berhasil mengubah akses login.' );

				header("location:../../logout.php");
			}
			else
			{
				flash('example_message', 'Password tidak sama..', 'w3-red');

				

				header("location:../../logout.php");
			}
	}
?>