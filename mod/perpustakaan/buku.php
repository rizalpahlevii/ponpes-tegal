<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['buku']) AND $_SESSION['buku'] <> 'TRUE')
	{
		?>
		  <div class="alert alert-danger alert-dismissible" id="succsess-alert">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	        Dilarang mengakses file ini.
	      </div>
		<?php
	}
	else{

	//link buat paging
	$linkaksi = 'med.php?mod=buku';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/perpustakaan/act_buku.php';

	?>
	<?php
	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=buku&act=edit";
				$query = mysqli_query($conn,"SELECT a.`id`, a.`kode`, a.`judul`, a.`pengarang`, a.`penerbit`, a.`th_terbit`, a.`tmp_terbit`, a.`hal`, a.`tinggi`, a.`jumlah`, b.`id` as idsumber, b.`sumber`, a.`tanggal`, a.`no_inv`, c.`id` as idrak, c.`rak`, a.`ket`, d.`id` as idkategori, d.`kategori`, a.`image` 
					FROM `buku` as a
					JOIN `sumber` as b ON a.`sumber` = b.`id`
					JOIN  `rak` as c ON a.`rak` = c.`id`
					JOIN `kategori` as d ON a.`kategori` = d.`id`
					WHERE a.id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=buku");
				}

			}
			else
			{
				$act = "$aksi?mod=buku&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data Buku
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>' enctype="multipart/form-data">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            	<input type="hidden" name="img" value="<?php echo isset($c['image']) ? $c['image'] : '' ;?>">
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Kode Buku</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="kode" class="form-control round-input" value="<?php echo isset($c['kode']) ? $c['kode'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Judul Buku</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="judul" class="form-control round-input" value="<?php echo isset($c['judul']) ? $c['judul'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Pengarang</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="pengarang" class="form-control round-input" value="<?php echo isset($c['pengarang']) ? $c['pengarang'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Penerbit</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="penerbit" class="form-control round-input" value="<?php echo isset($c['penerbit']) ? $c['penerbit'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Tahun Terbit</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="th_terbit" class="form-control round-input" value="<?php echo isset($c['th_terbit']) ? $c['th_terbit'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Tempat Terbit</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="tmp_terbit" class="form-control round-input" value="<?php echo isset($c['tmp_terbit']) ? $c['tmp_terbit'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Total Halaman</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="hal" class="form-control round-input" value="<?php echo isset($c['hal']) ? $c['hal'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Tinggi Buku</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="tinggi" class="form-control round-input" value="<?php echo isset($c['tinggi']) ? $c['tinggi'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Jumlah Buku</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="jumlah" class="form-control round-input" value="<?php echo isset($c['jumlah']) ? $c['jumlah'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Tanggal Buku</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="tanggal" class="form-control form-control-inline input-medium default-date-picker  round-input" value="<?php echo isset($c['tanggal']) ? $c['tanggal'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label class="col-lg-2 col-sm-2 control-label">Sumber Buku</label>
				                                <div class="col-lg-6">
				                                    <select  name="sumber" class="form-control round-input" style="width: 550px">
		                                              <?php
		                                                        $sql_sumber = mysqli_query($conn,"SELECT * FROM sumber");
		                                                while($k = mysqli_fetch_assoc($sql_sumber))
		                                                {
		                                                  if(isset($c['idsumber']) && $k['id'] == $c['idsumber'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[sumber]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[sumber]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label class="col-lg-2 col-sm-2 control-label">Kategori Buku</label>
				                                <div class="col-lg-6">
				                                    <select  name="kategori" class="form-control round-input" style="width: 550px">
		                                              <?php
		                                                        $sql_sumber = mysqli_query($conn,"SELECT * FROM kategori");
		                                                while($k = mysqli_fetch_assoc($sql_sumber))
		                                                {
		                                                  if(isset($c['idkategori']) && $k['id'] == $c['idkategori'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[kategori]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[kategori]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label class="col-lg-2 col-sm-2 control-label">Rak Buku</label>
				                                <div class="col-lg-6">
				                                    <select  name="rak" class="form-control round-input" style="width: 550px">
		                                              <?php
		                                                        $sql_sumber = mysqli_query($conn,"SELECT * FROM rak");
		                                                while($k = mysqli_fetch_assoc($sql_sumber))
		                                                {
		                                                  if(isset($c['idrak']) && $k['id'] == $c['idrak'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[rak]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[rak]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          	</select>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">No Inventaris</label>
				                                <div class="col-lg-10">
				                                    <input type="text" name="no_inv" class="form-control round-input" value="<?php echo isset($c['no_inv']) ? $c['no_inv'] : '' ;?>" required>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label class="control-label col-md-2">Deskripsi</label>
				                                <div class="col-md-10">
				                                    <textarea class="form-control" name="ket" rows="5"><?php echo isset($c['ket']) ? $c['ket'] : '' ;?></textarea>
				                                </div>
				                            </div>
				                            <div class="form-group last">
				                                <label class="control-label col-md-2">Foto</label>
				                                <div class="col-md-10">
				                                    <div class="fileupload fileupload-new" data-provides="fileupload">
				                                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
				                                            <img src="<?php echo isset($c['image']) ? 'images/buku/'.$c['image'] : 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image' ;?>" alt="" />
				                                        </div>
				                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
				                                        <div>
				                                                   <span class="btn btn-white btn-file">
				                                                   <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
				                                                   <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
				                                                   <input type="file" name="foto" class="default" />
				                                                   </span>
				                                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
				                                        </div>
				                                    </div>
				                                    <span class="label label-danger">NOTE!</span>
				                                             <span>
				                                             Attached image thumbnail is
				                                             supported in Latest Firefox, Chrome, Opera,
				                                             Safari and Internet Explorer 10 only
				                                             </span>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <div class="col-lg-offset-2 col-lg-10">
									                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
									                <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
				                                </div>
				                            </div>
				                        </form>
				                        </div>
				                    </div>
				                </section>

				            </div>
				        </div>

			<?php
		break;

		default :
		flash('example_message');
			?>
		        <!-- page start-->

		        <div class="row">

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">
		                        <?php if($_SESSION['level']=='admin'){?>
		                        	<a href="med.php?mod=buku&act=form">
									<button class="btn btn-primary">
										Tambah <i class="fa fa-plus"></i>
									</button>
									</a>
								<?php }?>
		                        <span class="tools pull-right">
		                            <a href="javascript:;" class="fa fa-chevron-down"></a>
		                            <a href="javascript:;" class="fa fa-cog"></a>
		                            <a href="javascript:;" class="fa fa-times"></a>
		                         </span>
		                    </header>
							
							
		                    <div class="panel-body">
							
		                        <div class="adv-table editable-table table-responsive">
		                            <div class="clearfix">
		                                <div class="btn-group">
		                                </div>
		                                <div class="btn-group pull-right">
		                                   
		                                </div>
		                            </div>
		                            <div class="space12"></div>
		                            <table class="table table-striped table-hover table-bordered" id="example">
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>
		                                    <th class="text-center">Judul Buku</th>
		                                    <th class="text-center">Pengarang</th>
		                                    <th class="text-center">Penerbit</th>
		                                    <th class="text-center">Rak</th>
		                                    <th class="text-center">Jumlah Buku</th>
		                                    <th class="text-center">Img</th>
											<?php if($_SESSION['level']=='admin' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT a.`id`, a.`kode`, a.`judul`, a.`pengarang`, a.`penerbit`, a.`th_terbit`, a.`tmp_terbit`, a.`hal`, a.`tinggi`, a.`jumlah`, b.`id` as idsumber, b.`sumber`, a.`tanggal`, a.`no_inv`, c.`id` as idrak, c.`rak`, a.`ket`, d.`id` as idkategori, d.`kategori`, a.`image` 
												FROM `buku` as a
												JOIN `sumber` as b ON a.`sumber` = b.`id`
												JOIN  `rak` as c ON a.`rak` = c.`id`
												JOIN `kategori` as d ON a.`kategori` = d.`id`";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td><?php echo $m['judul']?></td>
		                                    <td><?php echo $m['pengarang']?></td>
		                                    <td><?php echo $m['penerbit']?></td>
		                                    <td align="center"><?php echo $m['rak']?></td>
		                                    <td align="center"><?php echo $m['jumlah']?></td>
								            <td align="center"><img src="images/buku/<?php echo $m['image'];?>" width="30" height="30"></td>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> <?php if($_SESSION['level']=='admin' ){?>
		                                        <a href="med.php?mod=buku&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												<a href="<?php echo $aksi ?>?mod=buku&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

												
											</td>
											 <?php }?>
		                                </tr>
										
		                                <?php
		 									 $i++;
		 								 }
		 								?>
		                                </tbody>
		                            </table>
		                        </div>
		                    </div>
		                </section>
		            </div>
		        </div>

		            <!-- page end-->
			<?php
		break;
	}

	}
?>
<script>
													
function myFunction() {
  var msg;
	msg= "Apakah Anda Yakin Akan Menghapus Data ? " ;
	var agree=confirm(msg);
	if (agree)
	return true ;
	else
	return false ;
}
</script>

