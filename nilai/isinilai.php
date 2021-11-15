<?php
if(isset($_GET['aks']))
	{
		$aks = $_GET['aks'];
	}
	else
	{
		$aks = '';
	}
switch ($aks) {
	case 'nilai':
		?>
		<?php
			$idpel = $_GET['idpel'];
			$qsms = mysqli_query($conn,"SELECT * FROM semester WHERE id = '$idsemester'");
			$sms = mysqli_fetch_assoc($qsms);
			$qdtl = "SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` and d.alumni='0' ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
				FROM `kelas` as a
				JOIN `pegawai` as b on a.nipwali = b.nip
				JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
				WHERE a.id = '$idkelas'
";
			$sqldtl = mysqli_query($conn,$qdtl);	
			$dtl = mysqli_fetch_assoc($sqldtl);
			$qisi = "SELECT a.`id`, a.`kode`, a.`nama`, a.`kkm`, a.`tingkat`, a.`sifat`, b.`kode` as kelompok, b.`keterangan` 
					FROM `pelajaran` as a
					JOIN `aspekkelompok` as b ON a.`sifat` = b.`id`
					WHERE a.`id` = '$idpel'
			";
			$sqlisi = mysqli_query($conn,$qisi);
			$isi = mysqli_fetch_assoc($sqlisi);
			?>
			<div class="col-sm-9">
			<section class="panel">
			    <section class="panel">
			        <div class="panel-body profile-information">

			           <div class="col-md-3">
			           		<br>
			           		<br>
				           	<div align="center" >
				           		<img src="images/ect/nilai.png" width="80%" alt=""/>
				            </div>
			           </div>
			           <div class="col-md-9 table-responsive">
			               <div class="profile-desk">
			               	<div class="tab-pane ">                
				                <div class="prf-contacts sttng">
				                    <h2>NILAI TAMRIN <?php echo $dtl['tahunajaran'] ?></h2>
				                </div>      
				            </div>`
			               	<table class="table table-borderless" >
			               		<tr>
			               			<td>Pelajaran</td>
			               			<td>:</td>
			               			<td><?php echo $isi['nama']?></td>
			               		</tr>
			               		<tr>
			               			<td>Wali Kelas</td>
			               			<td>:</td>
			               			<td><?php echo $dtl['nama']?></td>
			               		</tr>
			               		<tr>
			               			<td>Semester</td>
			               			<td>:</td>
			               			<td><?php echo $sms['semester']?></td>
			               		</tr>
			               	</table>                   
			               </div>
			           </div>
			        </div>
			    </section>
			</section>
			</div>
			<div class="col-sm-3">
			</div>
			<div class="col-sm-9">
				<div class="panel-body">
				        <?php
            	    	if ($_SESSION['level']!=='siswa' or $_SESSION['level']!=='ortu') {
            	    	?>
    		            <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">Export <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu">
                                <li><a target="_blank" href="popup/popup.php?mod=nilai_kelas&idkelas=<?php echo $idkelas ?>&idsemester=<?php echo $idsemester ?>&idpel=<?php echo $idpel ?>">PDF</a></li>
                                <li><a href="popup/nilai_kelas_excel.php?idkelas=<?php echo $idkelas ?>&idsemester=<?php echo $idsemester ?>&idpel=<?php echo $idpel ?>">Excel</a></li>
                            </ul>
                        </div><!-- /btn-group -->
                        <?php	
            	    	}
            	    	?>
            	    	<div class="pull-right">
            	    	    
        					<a onclick="window.location.reload();" class="btn btn-warning">
        			            <i class="fa fa-refresh"></i> Refresh
        			        </a>
        					
        			        <a onClick="tambah();" class="btn btn-success">
        			            Tambah Bulan
        			        </a>
            	    	</div>
			        
			        
			    </div>
			</div>
			<div class="col-sm-3">
			</div>
			<div class="col-md-9">
			<section class="panel">
			    <div class="panel-body">
			        <div class="table-responsive">
			        	 <table class="table table-striped table-hover table-bordered" >
			        	 	<thead>
			        	 		<tr>
			        	 			<th class="text-center">No</th>
			        	 			<th class="text-center">NIS</th>
			        	 			<th class="text-center">Nama</th>
			        	 			<?php
							      	$qu = mysqli_query($conn,"SELECT a.`id`, a.`idpelajaran`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`, a.`deskripsi`, a.`tanggal` 
										FROM `ujian` as a
										JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
										JOIN `kelas` as c ON a.`idkelas` = c.`id`
										JOIN `semester` as d ON a.`idsemester` = d.`id`
										WHERE a.`idpelajaran` = '$isi[id]' AND a.`idkelas` = '$idkelas' AND a.`idsemester` = '$idsemester'");
							      	$i=1;

							      	while($u = mysqli_fetch_assoc($qu)){
							      	?>
							      	<th class="text-center" >
							      		<font class="popovers" data-original-title="<?php echo getBulanHijriah($u['deskripsi']) ?>" data-content="<?php echo getBulanHijriah($u['deskripsi']) ?>, <?php echo tglindo($u['tanggal']) ?>" data-placement="top" data-trigger="hover" ><?php echo getBulanHijriah($u['deskripsi']) ?></font> 
							      		<br>
							      		<a onclick="window.open('modal.php?act=tambahpenilaian&idpel=<?php echo $idpel ?>&idsemester=<?php echo $idsemester?>&idkelas=<?php echo $idkelas?>&id=<?php echo $u['id'] ?>','TambahNilai','680','600','resizable=1,scrollbars=1,status=0,toolbar=0');" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>
										<a href="act_modal.php?act=hapus&id=<?php echo $u['id'] ?>" onclick="return myFunction();" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> </a>
							      	</th>
							      	<?php
									$i++;
							      	}
							      	
							    	?>				    	
			        	 			<th class="text-center">Jumlah</th>		
			        	 			<th class="text-center">Rata - Rata</th>		
			        	 		</tr>        	 	
			        	 	</thead>	
			        	 	<tbody>
			        	 		<?php
							      	$querys = mysqli_query($conn,"SELECT * FROM siswa WHERE idkelas = '$idkelas'");
							      	$is=1;
							      	while($k = mysqli_fetch_assoc($querys)){
							    ?>
							    <tr>
							      	<th class="text-center"><?php echo $is ?></th>
							        <td align="center"><?php echo $k['nis'] ?></td>
							        <td><?php echo $k['nama'] ?></td>		
							        <?php
							      	$qu = mysqli_query($conn,"SELECT a.`id`, a.`idpelajaran`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`, a.`deskripsi`, a.`tanggal` 
										FROM `ujian` as a
										JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
										JOIN `kelas` as c ON a.`idkelas` = c.`id`
										JOIN `semester` as d ON a.`idsemester` = d.`id`
										WHERE a.`idpelajaran` = '$isi[id]' AND a.`idkelas` = '$idkelas' AND a.`idsemester` = '$idsemester'");
							      	$jml = mysqli_num_rows($qu);
							      	$i=1;
							      	$sumn=0;
							      	while($u = mysqli_fetch_assoc($qu)){
							      	?>
							        <td align="center">
							        	<?php
							        	$qn = mysqli_query($conn,"SELECT * FROM `nilaiujian` WHERE `idujian` = '$u[id]' AND `nis` = '$k[nis]'");
								      	$n = mysqli_fetch_assoc($qn);
							        	?>
							        	<input type="hidden" name="idujian[]" class="form-control " value="<?php echo $u['id'] ?>" >
							        	<input type="hidden" name="nis[]" class="form-control " value="<?php echo $k['nis'] ?>" >
										<input type="text" name="nilai[]" class="form-control " value="<?php echo $n['nilaiujian'] ?>" >
							        	<input type="hidden" name="idpel" class="form-control " value="<?php echo $idpel ?>" >
							        	
							        </td>	
							        <?php
							        $sumn+=$n['nilaiujian'];
							      	$i++;
							      	}							      	
						      		$rata=($sumn!=0)?($sumn/$jml):0;
						   			?>	
							        	<td align="center"><?php echo $sumn ?></td>							      	
							        	<td align="center"><?php echo round($rata,1) ?></td>							      	
				    
			        	 		</tr>
						      	<?php
							      	$is++;
							      	}
						      	?>
			        	 	</tbody>
			        	 			
			        	 </table>
			        </div>
			    </div>
			</section>
			<div class="form-group">
			    <div class="col-lg-12" align="center">
			        <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
			        <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
			    </div>
			</div>
			</div>
			<script type="text/javascript">
				function tambah()
				{
					window.open('modal.php?act=tambahpenilaian&idpel=<?php echo $isi['id'] ?>&idsemester=<?php echo $idsemester?>&idkelas=<?php echo $idkelas?>','TambahNilai','680','600','resizable=1,scrollbars=1,status=0,toolbar=0');
				}
			</script>
		<?php
		break;
	
	default:
		?>
		<?php
		$idpel = $_GET['idpel'];
			$idsemester = $_GET['idsemester'];
			$qsms = mysqli_query($conn,"SELECT * FROM semester WHERE id = '$idsemester'");
			$sms = mysqli_fetch_assoc($qsms);
			$qdtl = "SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` and d.alumni='0' ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
				FROM `kelas` as a
				JOIN `pegawai` as b on a.nipwali = b.nip
				JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
				WHERE a.id = '$idkelas'
";
			$sqldtl = mysqli_query($conn,$qdtl);	
			$dtl = mysqli_fetch_assoc($sqldtl);
			$qisi = "SELECT a.`id`, a.`kode`, a.`nama`, a.`kkm`, a.`tingkat`, a.`sifat`, b.`kode` as kelompok, b.`keterangan` 
					FROM `pelajaran` as a
					JOIN `aspekkelompok` as b ON a.`sifat` = b.`id`
					WHERE a.`id` = '$idpel'
			";
			$sqlisi = mysqli_query($conn,$qisi);
			$isi = mysqli_fetch_assoc($sqlisi);
		?>
		<?php
		if ($_SESSION['level']=='admin' ) {
		?>
		<div class="col-sm-9">
			<section class="panel">
			    <section class="panel">
			        <div class="panel-body profile-information">

			           <div class="col-md-3">
			           		<br>
			           		<br>
				           	<div align="center" >
				           		<img src="images/ect/nilai.png" width="80%" alt=""/>
				            </div>
			           </div>
			           <div class="col-md-9 table-responsive">
			               <div class="profile-desk">
			               	<div class="tab-pane ">                
				                <div class="prf-contacts sttng">
				                    <h2>NILAI TAMRIN <?php echo $dtl['tahunajaran'] ?></h2>
				                </div>      
				            </div>`
			               	<table class="table table-borderless" >
			               		<tr>
			               			<td>Pelajaran</td>
			               			<td>:</td>
			               			<td><?php echo $isi['nama']?></td>
			               		</tr>
			               		<tr>
			               			<td>Wali Kelas</td>
			               			<td>:</td>
			               			<td><?php echo $dtl['nama']?></td>
			               		</tr>
			               		<tr>
			               			<td>Semester</td>
			               			<td>:</td>
			               			<td><?php echo $sms['semester']?></td>
			               		</tr>
			               	</table>                   
			               </div>
			           </div>
			        </div>
			    </section>
			</section>
		</div>
			<div class="col-sm-3">
			</div>
			<div class="col-md-9">
				<section class="panel">
				    <div class="panel-body">
				        <?php
            	    	if ($_SESSION['level']!=='siswa' or $_SESSION['level']!=='ortu') {
            	    	?>
			            <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm" type="button">Export <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu">
                                <li><a target="_blank" href="popup/popup.php?mod=nilai_kelas&idkelas=<?php echo $idkelas ?>&idsemester=<?php echo $idsemester ?>&idpel=<?php echo $idpel ?>">PDF</a></li>
                                <li><a href="popup/nilai_kelas_excel.php?idkelas=<?php echo $idkelas ?>&idsemester=<?php echo $idsemester ?>&idpel=<?php echo $idpel ?>">Excel</a></li>
                            </ul>
                        </div><!-- /btn-group -->
                        <br><br>
                        <?php	
            	    	}
            	    	?>
				        <section id="flip-scroll">
				        	<div class="table-responsive">
				        	 <table class="table table-striped table-hover table-bordered" id="examplea">
				        	 	<thead>
				        	 		<tr>
				        	 			<th class="text-center">No</th>
				        	 			<th class="text-center">NIS</th>
				        	 			<th class="text-center">Nama</th>
				        	 			<?php
				        	 			$qsms = "SELECT * FROM semester WHERE id = '$idsemester'";
											$asms = mysqli_query($conn,$qsms);	
											while ($ss = mysqli_fetch_assoc($asms)) {
										      	$qu = mysqli_query($conn,"SELECT a.`id`, a.`idpelajaran`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`, a.`deskripsi`, a.`tanggal` 
												FROM `ujian` as a
												JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
												JOIN `kelas` as c ON a.`idkelas` = c.`id`
												JOIN `semester` as d ON a.`idsemester` = d.`id`
												WHERE a.`idpelajaran` = '$isi[id]' AND a.`idkelas` = '$idkelas' AND a.`idsemester` = '$ss[id]'");
												$jml = mysqli_num_rows($qu);
										      	$i=1;
										      	
										      	while($u = mysqli_fetch_assoc($qu)){
								      	?>
								      	<th class="text-center" >
								      		<font class="popovers" data-original-title="<?php echo getBulanHijriah($u['deskripsi']) ?>" data-content="<?php echo getBulanHijriah($u['deskripsi']) ?>" data-placement="top" data-trigger="hover" ><?php echo getBulanHijriah($u['deskripsi']) ?></font> 
								      		
								      	</th>
								      	<?php
									      	$i++;
									      	}
									     ?>									     
					        	 			<th class="text-center">Jumlah</th>		
					        	 			<th class="text-center">Rata - Rata</th>
									     <?php
									      }
									    ?>				    			
				        	 		</tr>        	 	
				        	 	</thead>	
				        	 	<tbody>
				        	 		<?php
								      	$querys = mysqli_query($conn,"SELECT * FROM siswa WHERE idkelas = '$idkelas'");
								      	$is=1;
								      	while($k = mysqli_fetch_assoc($querys)){
								    ?>
								    <tr>
								      	<th class="text-center"><?php echo $is ?></th>
								        <td align="center"><?php echo $k['nis'] ?></td>
								        <td><?php echo $k['nama'] ?></td>		
								        <?php
								        $qsms = "SELECT * FROM semester WHERE id = '$idsemester'";
											$asms = mysqli_query($conn,$qsms);	
											while ($ss = mysqli_fetch_assoc($asms)) {
										      	$qu = mysqli_query($conn,"SELECT a.`id`, a.`idpelajaran`, b.`nama` as pelajaran, a.`idkelas`, c.`kelas`, a.`idsemester`, d.`semester`, a.`deskripsi`, a.`tanggal` 
												FROM `ujian` as a
												JOIN `pelajaran` AS b ON a.`idpelajaran` = b.`id`
												JOIN `kelas` as c ON a.`idkelas` = c.`id`
												JOIN `semester` as d ON a.`idsemester` = d.`id`
												WHERE a.`idpelajaran` = '$isi[id]' AND a.`idkelas` = '$idkelas' AND a.`idsemester` = '$ss[id]'");
										      	$jml = mysqli_num_rows($qu);
										      	$i=1;
										      	$sumn=0;
										      	while($u = mysqli_fetch_assoc($qu)){
								      	?>
								        <td align="center">
								        	<?php
									        	$qn = mysqli_query($conn,"SELECT * FROM `nilaiujian` WHERE `idujian` = '$u[id]' AND `nis` = '$k[nis]'");
										      	$n = mysqli_fetch_assoc($qn);
									        	?>
									        	<?php echo $n['nilaiujian'] ?>
								        	
								        	
								        </td>	
								        <?php
								      	$sumn+=$n['nilaiujian'];
								      	$i++;
								      	}							     	
							      		$rata=($sumn!=0)?($sumn/$jml):0; 
							   			?>	
							        	<td align="center"><?php echo $sumn ?></td>							      	
							        	<td align="center"><?php echo round($rata,1) ?></td>							      	
				    					<?php
									      }
									    ?>	
					    
				        	 		</tr>
							      	<?php
								      	$is++;
								      	}
							      	?>
				        	 	</tbody>
				        	 			
				        	 </table>
				        	</div>
				        </section>
				    </div>
				</section>
			</div>
		<?php	
		}
		?>
		
		<?php
		break;
		case 'siswa':
		break;
}
?>

