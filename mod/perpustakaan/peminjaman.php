<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['peminjaman']) AND $_SESSION['peminjaman'] <> 'TRUE')
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
	$linkaksi = 'med.php?mod=peminjaman';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/perpustakaan/act_peminjaman.php';

	?>
	<?php
	switch ($act) {
		case 'form':
			if(!empty($_GET['id']))
			{
				$act = "$aksi?mod=peminjaman&act=edit";
				$query = mysqli_query($conn,"SELECT a.`id`, a.`nis`, b.`nama`, a.`idbuku`,c.`kode`,c.`judul`, a.`tgl_pinjam`, a.`tgl_kembali`, a.`status` 
					FROM `datasewa` as a
					JOIN `siswa` as b on a.`nis` = b.`nis`
					JOIN `buku` as c on a.`idbuku` = c.`id`
					WHERE a.id = '$_GET[id]'");
				$temukan = mysqli_num_rows($query);
				if($temukan > 0)
				{
					$c = mysqli_fetch_assoc($query);
				}
				else
				{
					header("location:med.php?mod=peminjaman");
				}

			}
			else
			{
				$act = "$aksi?mod=peminjaman&act=simpan";
			}

			?>
			        <!-- page start-->
				        <div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data peminjaman
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>' enctype="multipart/form-data">
				                            	<input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
				                            	<div class="form-group">
					                              <label class="col-lg-2 col-sm-2 control-label">Siswa</label>
					                              	<div class="col-lg-6">
					                                  	<select id="e2" class="populate " name="nis" class="form-control round-input" style="width: 350px">
					                                  		<?php
		                                                        $sql_nis = mysqli_query($conn,"SELECT nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas
																		FROM siswa as s 
					                                                    left join kelas k on s.idkelas = k.id
					                                                    left join tahunajaran t on t.id = k.idtahunajaran
					                                                    where s.alumni=0");
				                                                while($k = mysqli_fetch_assoc($sql_nis))
				                                                {
				                                                  if(isset($c['nis']) && $k['nis'] == $c['nis'])
				                                                  {
				                                                    echo"<option value='$k[nis]' selected>$k[nis] - $k[nama]</option>";  
				                                                  }
				                                                  else
				                                                  {
				                                                    echo"<option value='$k[nis]'>$k[nis] - $k[nama]</option>";
				                                                  }
				                                                  
				                                                }
		                                                        ?>
					                                          
					                                    </select>
					                                </div>
					                            </div>
					                        	<div class="form-group">
					                              <label class="col-lg-2 col-sm-2 control-label">Buku</label>
					                              	<div class="col-lg-6">
					                                  	<select id="e1" class="populate " name="idbuku" class="form-control round-input" style="width: 350px">
					                                           <?php
		                                                        $sql_buku = mysqli_query($conn,"SELECT * FROM `buku`
																	");
				                                                while($k = mysqli_fetch_assoc($sql_buku))
				                                                {
				                                                  if(isset($c['idbuku']) && $k['id'] == $c['idbuku'])
				                                                  {
				                                                    echo"<option value='$k[id]' selected>$k[kode] - $k[judul]</option>";  
				                                                  }
				                                                  else
				                                                  {
				                                                    echo"<option value='$k[id]'>$k[kode] - $k[judul]</option>";
				                                                  }
				                                                  
				                                                }
		                                                        ?>
					                                    </select>
					                                </div>
					                            </div>                            
						                        <div class="form-group">
						                            <label class="control-label col-lg-2 col-sm-2">Tanggal Pinjam</label>
						                            <div class="col-lg-10">
						                                <input name="tgl_pinjam" class="form-control form-control-inline input-medium default-date-picker  "  type="text" value="<?php echo isset($c['tgl_pinjam']) ? $c['tgl_pinjam'] : '' ;?>" />
						                            </div>
						                        </div>
						                        <div class="form-group">
						                            <label class="control-label col-lg-2 col-sm-2">Tanggal Kembali</label>
						                            <div class="col-lg-10">
						                                <input name="tgl_kembali" class="form-control form-control-inline input-medium default-date-picker  "  type="text" value="<?php echo isset($c['tgl_kembali']) ? $c['tgl_kembali'] : '' ;?>" />
						                            </div>
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
		                        	<a href="med.php?mod=peminjaman&act=pinjam">
									<button class="btn btn-primary">
										Peminjaman <i class="fa fa-plus"></i>
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
		                                    <th class="text-center">Siswa</th>
		                                    <th class="text-center">Buku</th>
		                                    <th class="text-center">Tanggal Pinjam</th>
		                                    <th class="text-center">Tanggal Kembali</th>
											<?php if($_SESSION['level']=='admin' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT a.`id`, a.`nis`, b.`nama`, a.`idbuku`,c.`kode`,c.`judul`, a.`tgl_pinjam`, a.`tgl_kembali`, a.`status` 
												FROM `datasewa` as a
												JOIN `siswa` as b on a.`nis` = b.`nis`
												JOIN `buku` as c on a.`idbuku` = c.`id`
												WHERE a.`status` = 'pinjam'";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td><?php echo $m['nis']?> - <?php echo $m['nama']?></td>
		                                    <td><?php echo $m['kode']?> - <?php echo $m['judul']?></td>
		                                    <td><?php echo $m['tgl_pinjam']?></td>
		                                    <td><?php echo $m['tgl_kembali']?></td>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>	
		                                       <a href="<?php echo $aksi ?>?mod=peminjaman&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>
						
		                                   --> <?php if($_SESSION['level']=='admin' ){?>
		                                        <a href="med.php?mod=peminjaman&act=form&id=<?php echo $m['id'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												
												
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

		case 'pinjam':
		?>
		<div class="row">
            <div class="col-sm-6">
                <section class="panel">
                    <header class="panel-heading">
                        Peminjaman
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>
                    <form class="form-horizontal" method='POST' action='<?php echo $aksi ?>?mod=peminjaman&act=dump'>
                    <div class="panel-body">
                        <div class="position-center">
                        	<div class="form-group">
                              <label class="col-lg-2 col-sm-2 control-label">Siswa</label>
                              	<div class="col-lg-6">
                                  	<select id="e2" class="populate " name="nis" class="form-control round-input" style="width: 350px">
                                          <?php
                                                    $sql_angkatan = mysqli_query($conn,"SELECT nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas
													FROM siswa as s 
                                                    left join kelas k on s.idkelas = k.id
                                                    left join tahunajaran t on t.id = k.idtahunajaran
                                                    where s.alumni=0");
                                            while($k = mysqli_fetch_assoc($sql_angkatan))
                                            {
                                              
                                                echo"<option value='$k[nis]'>$k[nis] - $k[nama]</option>";
                                              
                                            }
                                                    ?>
                                    </select>
                                </div>
                            </div>
                        	<div class="form-group">
                              <label class="col-lg-2 col-sm-2 control-label">Buku</label>
                              	<div class="col-lg-6">
                                  	<select id="e1" class="populate " name="idbuku" class="form-control round-input" style="width: 350px">
                                          <?php
                                                    $sql_angkatan = mysqli_query($conn,"SELECT a.`id`, a.`kode`, a.`judul`, a.`jumlah`, count(b.idbuku) as pinjam , (a.`jumlah` - count(b.idbuku)) as sisa
														FROM `buku` as a
														JOIN `datasewa` as b ON a.id = b.idbuku
														GROUP BY b.idbuku
														HAVING sisa <> 0
														");
                                            while($k = mysqli_fetch_assoc($sql_angkatan))
                                            {
                                              
                                                echo"<option value='$k[id]'>$k[kode] - $k[judul]</option>";
                                              
                                            }
                                                    ?>
                                    </select>
                                </div>
                            </div>                            
	                        <div class="form-group">
	                            <label class="control-label col-lg-2 col-sm-2">Tanggal Pinjam</label>
	                            <div class="col-lg-10">
	                                <input name="tgl_pinjam" class="form-control form-control-inline input-medium default-date-picker  "  type="text" value="<?php echo isset($c['tgl_pinjam']) ? $c['tgl_pinjam'] : '' ;?>" />
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="control-label col-lg-2 col-sm-2">Tanggal Kembali</label>
	                            <div class="col-lg-10">
	                                <input name="tgl_kembali" class="form-control form-control-inline input-medium default-date-picker  "  type="text" value="<?php echo isset($c['tgl_kembali']) ? $c['tgl_kembali'] : '' ;?>" />
	                            </div>
	                        </div>
	                        <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
					                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-plus'></i> Tambah</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </section>
            </div>
            <div class="col-sm-6">
                <section class="panel">
                    <header class="panel-heading btn-warning">
                        Proses Peminjaman
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>
                    <?php flash('example_message'); ?>
                    <div class="panel-body">
                    	<div class="">
                    		
	                        <table class="table table-striped">
	                            <thead>
	                            <tr>
	                                <th>#</th>
	                                <th>Siswa</th>
	                                <th>Buku</th>
	                                <th>Tanggal Pinjam</th>
	                                <th>Tanggal Kembali</th>
	                                <th></th>
	                            </tr>
	                            </thead>
	                            <tbody>
	                            	<?php
										$query = "SELECT a.`id`, a.`nis`, b.`nama`, a.`idbuku`,c.`kode`,c.`judul`, a.`tgl_pinjam`, a.`tgl_kembali`
												FROM `tmp_datasewa` as a
												JOIN `siswa` as b on a.`nis` = b.`nis`
												JOIN `buku` as c on a.`idbuku` = c.`id`
												";
										$sql_kul = mysqli_query($conn,$query);	
										$i=1;
										while ($m = mysqli_fetch_assoc($sql_kul)) {
									?>
	                                <tr class="">
	                                    <td align="center"><?php echo $i ?></td>
	                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
	                                    <td><?php echo $m['nis']?> - <?php echo $m['nama']?></td>
	                                    <td><?php echo $m['kode']?> - <?php echo $m['judul']?></td>
	                                    <td align="center"><?php echo $m['tgl_pinjam']?></td>
	                                    <td align="center"><?php echo $m['tgl_kembali']?></td>
										<td align="center">
	                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>		
	                                       				
	                                   --> 
	                                        
											<a href="<?php echo $aksi ?>?mod=peminjaman&act=hapusdump&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>


											
										</td>
										 
	                                </tr>
									
	                                <?php
	 									 $i++;
	 								 }
	 								?>
	                            </tbody>
	                        </table>
	                        <div class="form-group">
                                <div align="center">
                                	<a href="<?php echo $aksi ?>?mod=peminjaman&act=simpan"><button class="btn btn-primary">Save</button></a>
					                
                                </div>
                            </div>
                    	</div>
                    </div>
                </section>
            </div>
        </div>
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

