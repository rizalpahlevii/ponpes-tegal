<?php
	session_start();
	include"../../lib/conn.php";
	date_default_timezone_set('Asia/Jakarta'); 

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

	if($mod == "materi" AND $act == "simpan")
	{
		$lokasi_file = $_FILES['file']['tmp_name'];
		$nama_file   = $_FILES['file']['name'];
		$tipe_file   = $_FILES['file']['type'];
		$direktori_file = "../../file/$nama_file";

		$extensionList = array("zip", "rar", "doc", "docx", "ppt", "pptx", "pdf","csv","xls");
		$pecah = explode(".", $nama_file);
		$ekstensi = $pecah[1];

		if (!empty($lokasi_file)){
  
	      if (file_exists($direktori_file)){
	      		flash('example_message', 'Nama file sudah ada, mohon diganti dulu' );

				echo"<script>
					window.history.go(-2);
				</script>";
	            }
	      elseif (!in_array($ekstensi, $extensionList)){

	      		flash('example_message', 'Tipe file tidak diijinkan' );

				echo"<script>
					window.history.go(-2);
				</script>";
	        }
	        else{
	        			move_uploaded_file($lokasi_file,$direktori_file);
	                    mysqli_query($conn,"INSERT INTO materi(`judul`, `idkelas`, `idpelajaran`, `file`, `tgl_posting`, `nip`)
	                            VALUES('$_POST[judul]',
	                                   '$_POST[idkelas]',
	                                   '$_POST[idpelajaran]',
	                                   '$nama_file',
	                                   '$tgl_sekarang',
	                                    '$_POST[nip]')");
	                    flash('example_message', 'Berhasil menambah data materi.' );

						echo"<script>
							window.history.go(-2);
						</script>";
	            }

	    }
		
	}

	elseif ($mod == "materi" AND $act == "edit") 
	{
		$file = $_POST['fupload'];
		$lokasi_file = $_FILES['file']['tmp_name'];
		$nama_file   = $_FILES['file']['name'];
		$tipe_file   = $_FILES['file']['type'];
		$direktori_file = "../../file/$nama_file";
		$direktori_file1 = "../../file/$file";

		$extensionList = array("zip", "rar", "doc", "docx", "ppt", "pptx", "pdf","csv","xls");
		$pecah = explode(".", $nama_file);
		$ekstensi = $pecah[1];

		if (!empty($lokasi_file)){
  
	      if (file_exists($direktori_file)){
	      		flash('example_message', 'Nama file sudah ada, mohon diganti dulu' );

				echo"<script>
					window.history.go(-2);
				</script>";
	            }
	      elseif (!in_array($ekstensi, $extensionList)){

	      		flash('example_message', 'Tipe file tidak diijinkan' );

				echo"<script>
					window.history.go(-2);
				</script>";
	        }
	        else{
	        			unlink($direktori1_file1);
	        			move_uploaded_file($lokasi_file,$direktori_file1);
	                    mysqli_query($conn,"UPDATE materi SET judul = '$_POST[judul]',
                                    idkelas = '$_POST[idkelas]',
                                    idpelajaran = '$_POST[idpelajaran]',
                                    file = '$file',
                                    tgl_posting = '$tgl_sekarang',
                                    nip = '$_POST[nip]'
                            WHERE id = '$_POST[id]'");
	                    flash('example_message', 'Berhasil mengubah data materi.' );

						echo"<script>
							window.history.go(-2);
						</script>";
	            }

	    }else{
	    	move_uploaded_file($lokasi_file,$direktori_file);
            mysqli_query($conn,"UPDATE materi SET judul = '$_POST[judul]',
                        idkelas = '$_POST[idkelas]',
                        idpelajaran = '$_POST[idpelajaran]',
                        file = '$file',
                        tgl_posting = '$tgl_sekarang',
                        nip = '$_POST[nip]'
                WHERE id = '$_POST[id]'");
            flash('example_message', 'Berhasil mengubah data materi.' );

			echo"<script>
				window.history.go(-2);
			</script>";
	    }
		
	}

	elseif ($mod == "materi" AND $act == "hapus") 
	{
		mysqli_query($conn,"DELETE FROM materi WHERE id = '$_GET[id]'") or die(mysqli_error());
		flash('example_message', 'Berhasil menghapus data aspek penilaian.' );
		echo"<script>
			window.history.back();
		</script>";	
	}

?>