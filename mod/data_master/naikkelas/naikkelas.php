<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['naikkelas']) AND $_SESSION['naikkelas'] <> 'TRUE')
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
	$linkaksi = 'med.php?mod=naikkelas';

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/data_master/naikkelas/act_naikkelas.php';

	?>
	<?php
	switch ($act) {
		case 'form':
		if(empty($_GET['kelas']))
			{				
				$kelas1 = $_POST['kelas'];
				$kelas2 = $_POST['kelas2'];
			}else{

				$kelas1 = $_GET['kelas'];
				$kelas2 = $_GET['kelas2'];
			}
			if ($kelas2=="Lulus") {
				$qkls = mysqli_query($conn,"SELECT *FROM `kelas` WHERE id='$kelas1'");
		    	$kls = mysqli_fetch_assoc($qkls);

		    	$klsi = "<b>Lulus</b>";
		    	$kls2 = "Lulus";
		    	$idkls2 = "Lulus";
			}else{

				$qkls = mysqli_query($conn,"SELECT *FROM `kelas` WHERE id='$kelas1'");
		    	$kls = mysqli_fetch_assoc($qkls);
		    	
		    	$qklsx = mysqli_query($conn,"SELECT *FROM `kelas` WHERE id='$kelas2'");
		    	$klsx = mysqli_fetch_assoc($qklsx);

		    	$klsi = "ke Kelas ".$klsx['kelas'];
		    	$kls2 = $klsx['kelas'];
		    	$idkls2 = $klsx['id'];
			}
		?>
		<div class="col-sm-6">
			<div class="row">
                    <div class="col-md-12">
                        <!--progress bar start-->
                        <section class="panel panel-success">
                            <header class="panel-heading">
                               Pindah Kelas dari Kelas <?php echo $kls['kelas'] ?> <?php echo $klsi ?>
                        <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                            </span>
                            </header>
                            <div class="panel-body">
                                <div class="adv-table editable-table ">
		                            <div class="clearfix">
		                                <div class="btn-group">
		                                </div>
		                                <div class="btn-group pull-right">
		                                   
		                                </div>
		                            </div>
		                            <div class="space12"></div>
		                            <div class="table-responsive">
		                            <table class="table table-striped table-hover table-bordered">
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>
											<th class="text-center">Nis</th>
		                                    <th class="text-center">Nama Santri</th>
											<th class="text-center">Pindah Kelas</th>
											<?php if($_SESSION['level']=='admin' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT s.nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas,k.idtahunajaran 
														FROM siswa as s 
                                                        left join kelas k on s.idkelas = k.id
                                                        left join tahunajaran t on t.id = k.idtahunajaran          
                                                        LEFT JOIN `history_tmp` as h ON s.nis = h.nis
                                                        where s.idkelas='$kelas1' AND h.nis IS NULL ";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">

                            				<form method="POST" action="<?php echo $aksi ?>?mod=naikkelas&act=add">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['nis']?></td>
		                                    <td align="center"><?php echo $m['nama']?></td>
		                                    <td ><?php echo $kls2?></td></td>
		                                    <?php if($_SESSION['level']=='admin' ){?>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>							
		                                   --> 
											<input type='hidden' name='kelas' value='<?php echo $kls['id'] ?>'>
											<input type='hidden' name='kelas2' value='<?php echo $idkls2 ?>'>
											<input type='hidden' name='nis' value='<?php echo $m['nis'] ?>'>
											<input type='hidden' name='idtahunajaran' value='<?php echo $m['idtahunajaran'] ?>'>

			                                	<span class="input-group-btn">
							                      <button type="submit" class="btn btn-danger btn-flat btn-sm"><i class='fa fa-arrow-right'></i></button>
							                    </span>


												
											</td>
											 <?php }?>

                            				</form>
		                                </tr>
										
		                                <?php
		 									 $i++;
		 								 }
		 								?>
		                                </tbody>
		                            </table>
		                        	</div>
		                        </div>
                            </div>
                        </section>
                        <!--progress bar end-->

                    </div>
                </div>
			
		</div>


		<div class="col-sm-6">
			<div class="row">
                    <div class="col-md-12">
                        <!--progress bar start-->
                        <section class="panel panel-danger">
                            <header class="panel-heading">
                                Yang Tidak Pindah Kelas <?php echo $kls2 ?>
                        	<span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                            </span>
                            </header>

	                		<form action="<?php echo $aksi ?>?mod=naikkelas&act=simpan" name='autoSumForm' role="form" method="POST">
                            <div class="panel-body">
                                
                                <div class="adv-table editable-table ">
		                            <div class="clearfix">
		                                <div class="btn-group">
		                                </div>
		                                <div class="btn-group pull-right">
		                                   
		                                </div>
		                            </div>
		                            <div class="space12"></div>
		                            <div class="table-responsive">
		                            <table class="table table-striped table-hover table-bordered">
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>
											<th class="text-center">Nis</th>
		                                    <th class="text-center">Nama Santri</th>
											<th class="text-center">Kelas</th>
											<?php if($_SESSION['level']=='admin' ){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT h.id, s.nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.statusmutasi,s.alumni,s.nisn , k.kelas
														FROM siswa as s 
                                                        join kelas k on s.idkelas = k.id
                                                        join tahunajaran t on t.id = k.idtahunajaran
                                                        RIGHT JOIN `history_tmp` as h ON s.nis = h.nis";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
										if(mysqli_num_rows($sql_kul) > 0)
											{ 
												while ($m = mysqli_fetch_assoc($sql_kul)) {
											?>
			                                <tr class="">
			                                    <td align="center"><?php echo $i ?></td>
			                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
			                                    <td align="center"><?php echo $m['nis']?></td>
			                                    <td align="center"><?php echo $m['nama']?></td>
			                                    <td ><?php echo $kls['kelas']?></td></td>
												<td  align="center">
												<a href="<?php echo $aksi ?>?mod=naikkelas&act=batal&id=<?php echo $m['id'] ?>&kelas=<?php echo $kls['id'] ?>&kelas2=<?php echo $idkls2 ?>" onclick="return confirm('Yakin ingin membatalkan?');"><i class="fa fa-times text-danger"></i></a>
												</td>
			                                </tr>
											
			                                <?php
			 									 $i++;
			 								 }

		 								 }
										else
										{
											?>
											<tr>
												<td colspan="5" align="center"><i>Tidak Ada Yang Naik Kelas</i></td>
											</tr>
											<?php
										}
										?>
		                                </tbody>
		                            </table>
		                        	</div>
		                        </div>

											<input type='hidden' name='kelas' value='<?php echo $kls['id'] ?>'>
											<input type='hidden' name='kelas2' value='<?php echo $idkls2 ?>'>
					              <div class="box-footer">
					                <button type="submit" class="btn btn-primary" onclick="return confirm('Klik OK untuk melanjutkan');"><i class='fa fa-save'></i> Simpan</button>
					              </div>
                            </div>
                            </form>
                        </section>
                        <!--progress bar end-->

                    </div>
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
		                    	Naik Kelas
		                        <span class="tools pull-right">
		                            <a href="javascript:;" class="fa fa-chevron-down"></a>
		                            <a href="javascript:;" class="fa fa-cog"></a>
		                            <a href="javascript:;" class="fa fa-times"></a>
		                         </span>
		                    </header>
							
							
		                    <div class="panel-body">
							
		                        <form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=form' enctype="multipart/form-data">
			                        <div class="position-center">

			                            <div class="form-group">
		                                  <label class="col-lg-2 col-sm-2 control-label">Dari Kelas</label>
		                                  	<div class="col-lg-6">
		                                      	<select id="e2" class="populate " name="kelas" class="form-control round-input" style="width: 550px">
			                                          <?php
			                                                    $sql_angkatan = mysqli_query($conn,"SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
												FROM `kelas` as a
												JOIN `pegawai` as b on a.nipwali = b.nip
												JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`");
			                                            while($k = mysqli_fetch_assoc($sql_angkatan))
			                                            {
			                                              
			                                                
			                                               echo"<option value='$k[id]'>Tahun Ajaran: $k[tahunajaran], $k[kelas]</option>";
			                                              
			                                            }
			                                                    ?>
			                                    </select>
		                                    </div>
		                                </div>
		                                <div class="form-group">
		                                  <label class="col-lg-2 col-sm-2 control-label">Ke Kelas</label>
		                                  	<div class="col-lg-6">
		                                      	<select  id="e1" class="populate" name="kelas2" class="form-control round-input" style="width: 550px">
		                                          <?php
		                                                    $sql_penilaian = mysqli_query($conn,"SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` and d.alumni='0') AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
												FROM `kelas` as a
												JOIN `pegawai` as b on a.nipwali = b.nip
												JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`");
		                                            while($k = mysqli_fetch_assoc($sql_penilaian))
		                                            {
		                                              	echo"<option value='$k[id]'>Tahun Ajaran: $k[tahunajaran], Kelas: $k[kelas] Kapasitas $k[kapasitas] Terisi $k[tersisa] </option>";
		                                              
		                                            }
		                                                    ?>
		                                            <option value="Lulus">Lulus</option>
		                                      	</select>
		                                    </div>
		                                </div>			                                                     
			                            <div class="form-group">
			                                <div class="col-lg-offset-2 col-lg-10">
								                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Next</button>
								                <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
			                                </div>
			                            </div>
			                        </div>
					        </form> 
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

