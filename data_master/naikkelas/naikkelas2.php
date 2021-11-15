<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['naikkelas2']) AND $_SESSION['naikkelas2'] <> 'TRUE')
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
	if($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin'){
			
	$linkaksi = 'med.php?mod=naikkelas2';
	}else {
	$linkaksi = 'med2.php?mod=naikkelas2';
	}

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/data_master/naikkelas/act_naikkelas2.php';

	?>
	<?php
	switch ($act) {
		case 'form':
		if(empty($_GET['kelas']))
			{				
				$kelas1 = $_POST['tahunajaran'];
				$kelas2 = $_POST['tahunajaran2'];
			}else{

				$kelas1 = $_GET['tahunajaran'];
				$kelas2 = $_GET['tahunajaran2'];
			}
			if ($kelas2=="Lulus") {
				$qkls = mysqli_query($conn,"SELECT *FROM `tahunajaran` WHERE id='$kelas1'");
		    	$kls = mysqli_fetch_assoc($qkls);

		    	$klsi = "<b>Lulus</b>";
		    	$kls2 = "Lulus";
		    	$idkls2 = "Lulus";
			}else{

				$qkls = mysqli_query($conn,"SELECT *FROM `tahunajaran` WHERE id='$kelas1'");
		    	$kls = mysqli_fetch_assoc($qkls);
		    	
		    	$qklsx = mysqli_query($conn,"SELECT *FROM `tahunajaran` WHERE id='$kelas2'");
		    	$klsx = mysqli_fetch_assoc($qklsx);

		    	$klsi = "ke Tahun Ajaran ".$klsx['tahunajaran'];
		    	$kls2 = $klsx['tahunajaran'];
		    	$idkls2 = $klsx['id'];
			}
		?>
		<div class="col-sm-12">
			<div class="row">
				<form class="form-horizontal" role="form" method='POST' action='<?php echo $aksi ?>?mod=naikkelas2&act=simpan'>
                    <div class="col-md-12">
                        <!--progress bar start-->
                        <section class="panel panel-success">
                            <header class="panel-heading">
                               Dari Tahun Ajaran <?php echo $kls['tahunajaran'] ?> <?php echo $klsi ?>
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
		                            <table class="table table-striped table-hover table-bordered" id="example">
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>
											<th class="text-center">Nis</th>
		                                    <th class="text-center">Nama Santri</th>
											<th class="text-center">Kelas</th>
		                                    <th class="text-center">Nilai</th>
											<th class="text-center">Naik Ke</th>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT s.nis,nama,asalsekolah,tmplahir,tgllahir,DAY(tgllahir) as tgl,MONTH(tgllahir) as bln,YEAR(tgllahir) as thn,s.id,s.statusmutasi,s.alumni,s.nisn , k.kelas,k.idtahunajaran, k.tingkat 
														FROM siswa as s 
                                                        left join kelas k on s.idkelas = k.id
                                                        left join tahunajaran t on t.id = k.idtahunajaran          
                                                        LEFT JOIN `history_tmp` as h ON s.nis = h.nis
                                                        where t.id='$kelas1' AND h.nis IS NULL ";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
											<input type='hidden' name='kelas' value='<?php echo $kls['id'] ?>'>
											<input type='hidden' name='kelas2' value='<?php echo $idkls2 ?>'>
		                                    <td align="center"><?php echo $m['nis']?></td>
		                                    <td align="center"><?php echo $m['nama']?></td>
		                                    <td align="center"><?php echo $m['kelas']?></td>
		                                    <?php
			                                    $qp1 = "SELECT * FROM pelajaran WHERE tingkat = '$m[tingkat]' order by id asc";
							                    $sqlp1 = mysqli_query($conn,$qp1);
												$p1 = mysqli_num_rows($sqlp1);	
												if ($p1==0) {
													$jm1 = 0;
													?>
													<!--<td align="center">0</td>-->
													<?php
												}else{

								                    $jm1 = 0;
								                    while ($p1 = mysqli_fetch_assoc($sqlp1)) {
			                                    		$qu = mysqli_query($conn,"SELECT a.`id`, a.`idpelajaran`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`, a.`deskripsi`, a.`tanggal` 
														FROM `ujian` as a
														JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
														JOIN `kelas` as c ON a.`idkelas` = c.`id`
														JOIN `semester` as d ON a.`idsemester` = d.`id`
														WHERE a.`idpelajaran` = '$p1[id]' AND a.`idsemester` = '22'");
														$jml = mysqli_num_rows($qu);
								      					$sumn=0;
								      					while($u = mysqli_fetch_assoc($qu)){
								      						$qn = mysqli_query($conn,"SELECT * FROM `nilaiujian` WHERE `idujian` = '$u[id]' AND `nis` = '$m[nis]'");
							      							$n = mysqli_fetch_assoc($qn);
								      						$sumn+=$n['nilaiujian'];
									      					}
									      					$rata=($sumn!=0)?($sumn/$jml):0; 
									      					$jrata = round($rata,1);
									      			?>	
									      			<?php
                            							$jm1 = $jm1 + floatval($jrata);
									      			}
												}
			                                    ?>
		                                    <td align="center"><?php echo $jm1?></td>
		                                    <td align="center">
		                                    	<?php
		                                    	if ($kelas2=="Lulus") {
		                                    		?>
		                                    			<?php echo "Lulus" ?>
														<input type='hidden' name='naik' value='Lulus'>
		                                    		<?php
		                                    	}else{
		                                    	?>
		                                    	<select name="naik[]" class="form-control" style="width: 100%">
					                              <?php
					                                        $sqla = mysqli_query($conn,"SELECT * FROM kelas WHERE idtahunajaran = '$kelas2'");
					                                while($k = mysqli_fetch_assoc($sqla))
					                                {
					                                 
					                                    echo"<option value='$k[id]'>$k[kelas]</option>";  
					                                  
					                                }
					                                        ?>
					                          	</select>
		                                    	<?php
		                                    	}
		                                    	?>
					                            
					                        </td>
		                                </tr>
										
		                                <?php
		 									 $i++;
		 								 }
		 								?>
		                                </tbody>
		                            </table>
		                        	</div>
		                        </div>

						        <div class="form-group">
						            <div class="col-lg-12">
						                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
						            </div>
						        </div>
                            </div>
                        </section>
                        <!--progress bar end-->

                    </div>
                </form>
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
		                                  <label class="col-lg-2 col-sm-2 control-label">Dari</label>
		                                  	<div class="col-lg-10">
		                                      	<select id="e2" class="populate " name="tahunajaran" class="form-control round-input" style="width: 100%">
			                                          <?php
			                                                    $sql_angkatan = mysqli_query($conn,"SELECT * FROM tahunajaran");
			                                            while($k = mysqli_fetch_assoc($sql_angkatan))
			                                            {
			                                              
			                                                
			                                               echo"<option value='$k[id]'>Tahun Ajaran: $k[tahunajaran]</option>";
			                                              
			                                            }
			                                                    ?>
			                                    </select>
		                                    </div>
		                                </div>
		                                <div class="form-group">
		                                  <label class="col-lg-2 col-sm-2 control-label">Naik Ke</label>
		                                  	<div class="col-lg-10">
		                                      	<select  id="e1" class="populate" name="tahunajaran2" class="form-control round-input" style="width: 100%">
		                                          <?php
		                                                    $sql_penilaian = mysqli_query($conn,"SELECT * FROM tahunajaran");
		                                            while($k = mysqli_fetch_assoc($sql_penilaian))
		                                            {
		                                              	echo"<option value='$k[id]'>Tahun Ajaran: $k[tahunajaran] </option>";
		                                              
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

