<?php
	session_start();
	include"../../lib/conn.php";
	include"../../lib/all_function.php";
  	$upload_dir = '../../images/buku/';
	if(!isset($_SESSION['login_user'])){
		header('location: ../../../login.php'); // Mengarahkan ke Home Page
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

	if($mod == "buku" AND $act == "simpan")
	{
		$kode = anti_inject($_POST['kode']);		
		$judul = anti_inject($_POST['judul']);		
		$pengarang = anti_inject($_POST['pengarang']);		
		$penerbit = anti_inject($_POST['penerbit']);		
		$th_terbit = anti_inject($_POST['th_terbit']);		
		$tmp_terbit = anti_inject($_POST['tmp_terbit']);		
		$tinggi = anti_inject($_POST['tinggi']);		
		$jumlah = anti_inject($_POST['jumlah']);		
		$sumber = anti_inject($_POST['sumber']);		
		$tanggal = anti_inject($_POST['tanggal']);		
		$hal = anti_inject($_POST['hal']);		
		$no_inv = anti_inject($_POST['no_inv']);		
		$rak = anti_inject($_POST['rak']);		
		$kategori = anti_inject($_POST['kategori']);
		$ket = anti_inject($_POST['ket']);
		$imgName = $_FILES['foto']['name'];
		$imgTmp = $_FILES['foto']['tmp_name'];
		$imgSize = $_FILES['foto']['size'];
		$imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

		$allowExt  = array('jpeg', 'jpg', 'png', 'gif');

		$userPic = time().'_'.rand(1000,9999).'.'.$imgExt;

		if(in_array($imgExt, $allowExt)){

			if($imgSize < 5000000){
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
		if(!isset($errorMsg)){
			$sql = "INSERT INTO `buku`(`kode`, `judul`, `pengarang`, `penerbit`, `th_terbit`, `tmp_terbit`, `hal`, `tinggi`, `jumlah`, `sumber`, `tanggal`, `no_inv`, `rak`, `ket`, `kategori`, `image`) VALUES ('$kode','$judul','$pengarang','$penerbit','$th_terbit','$tmp_terbit','$hal','$tinggi','$jumlah','$sumber','$tanggal','$no_inv','$rak','$ket','$kategori','$userPic')";
			$result = mysqli_query($conn, $sql);
			if($result){
				$successMsg = 'Berhasil menambah data buku.';
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

	elseif ($mod == "buku" AND $act == "edit") 
	{
		$kode = anti_inject($_POST['kode']);		
		$judul = anti_inject($_POST['judul']);		
		$pengarang = anti_inject($_POST['pengarang']);		
		$penerbit = anti_inject($_POST['penerbit']);		
		$th_terbit = anti_inject($_POST['th_terbit']);		
		$tmp_terbit = anti_inject($_POST['tmp_terbit']);		
		$tinggi = anti_inject($_POST['tinggi']);		
		$jumlah = anti_inject($_POST['jumlah']);	
		$hal = anti_inject($_POST['hal']);			
		$sumber = anti_inject($_POST['sumber']);		
		$tanggal = anti_inject($_POST['tanggal']);		
		$no_inv = anti_inject($_POST['no_inv']);		
		$rak = anti_inject($_POST['rak']);		
		$kategori = anti_inject($_POST['kategori']);
		$ket = anti_inject($_POST['ket']);
		$foto = anti_inject($_POST['img']);
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
			$sql = "UPDATE `buku` SET `kode`='$kode',`judul`='$judul',`pengarang`='$pengarang',`penerbit`='$penerbit',`th_terbit`='$th_terbit',`tmp_terbit`='$tmp_terbit',`hal`='$hal',`tinggi`='$tinggi',`jumlah`='$jumlah',`sumber`='$sumber',`tanggal`='$tanggal',`no_inv`='$no_inv',`rak`='$rak',`ket`='$ket',`kategori`='$kategori',`image`='$userPic' WHERE `id` = '$_POST[id]'";
			$result = mysqli_query($conn, $sql);
			if($result){
				$successMsg = 'Berhasil merubah data buku.';
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

	elseif ($mod == "buku" AND $act == "hapus") 
	{
		$sql = "select * from buku where id = '$_GET[id]'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			$image = $row['image'];
			unlink($upload_dir.$image);
			mysqli_query($conn,"DELETE FROM buku WHERE id = '$_GET[id]'") or die(mysqli_error());
			flash('example_message', 'Berhasil menghapus data buku.' );
			echo"<script>
				window.history.back();
			</script>";	
		}		
	}

?>