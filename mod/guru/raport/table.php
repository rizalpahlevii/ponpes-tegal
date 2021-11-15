<!-- page start-->
				        <?php
				        $queryg = "SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
		FROM `guru` as a
		JOIN `pegawai` as b on a.nip = b.nip
		JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
		JOIN `statusguru` as d on d.`id` = a.`statusguru` 
		WHERE a.`nip` = '$_SESSION[login_user]'";
	$sql_g = mysqli_query($conn,$queryg);	
	$g = mysqli_fetch_assoc($sql_g);

						flash('example_message');
						?>
						<div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data raport katagori
				                    </header>
				                    <div class="panel-body">
				                        <form class="form-horizontal" role="form" method='POST' action='<?php echo $aksi ?>' enctype="multipart/form-data">
				                        	<div class="table-responsive">
					                          <table class="table table-striped table-hover table-bordered">			  
											    <thead>
											      <tr>
											        <th width="10" style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center">No</th>
											        <th width="40" style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center">NIS</th>
											        <th style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center" width="150">Nama</th>
											        <th colspan="3" class="text-center">Pengetahuan</th>
											        <th colspan="3" class="text-center">Keterampilan</th>

											      	<th style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center">Rata -Rata Nilai</th>
											      	<th style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center">Kelas Katagori</th>
											      </tr>
											      	
											      <tr>
											      	<?php
											      	for ($i=0; $i < 2; $i++) { 
											      	?>

											        <th class="text-center">UH1</th>
											        <th class="text-center">UH2</th>
											        <th class="text-center">UH3</th>
											      	
											      	<?php
											      	}
											      	?>
											      </tr>
											    </thead>
											    <tbody>
											    	<?php
											      	$querys = mysqli_query($conn,"SELECT * FROM siswa WHERE idkelas = '$_GET[id]'");
											      	$is=1;
											      	while($k = mysqli_fetch_assoc($querys)){
											      	?>
											      <tr>
											      	
											      	<th class="text-center"><?php echo $is ?></th>
											        <td align="center"><?php echo $k['nis'] ?></td>
											        <td><?php echo $k['nama'] ?></td>
											        <td colspan="7"></td>
 	

											        
											       
											        <?php
												        $queryk = mysqli_query($conn,"SELECT * FROM `rpp` WHERE `idpelajaran` = '$g[idpelajaran]'");
												        $queryk1 = mysqli_query($conn,"SELECT * FROM `rpp` WHERE `idpelajaran` = '$g[idpelajaran]'");
												        
												      	$temukan = mysqli_num_rows($queryk);
												      	$hs=$temukan+1;
													    $jmkodep = 0;
												        $jmkodek = 0;
												      	while ($c = mysqli_fetch_assoc($queryk1)) {
															
												        	$qtp = mysqli_query($conn,"SELECT  max(`uhke`) as totp FROM `raport_katagori` WHERE `idpelajaran` = '$g[idpelajaran]' and `idrpp` ='$c[id]' and `jenisujian` ='Pengetahuan' ");
												        	$tp = mysqli_fetch_assoc($qtp);
												        	$qtk = mysqli_query($conn,"SELECT  max(`uhke`) as totk FROM `raport_katagori` WHERE `idpelajaran` = '$g[idpelajaran]' and `idrpp` ='$c[id]' and `jenisujian` ='Keterampilan' ");
												        	$tk = mysqli_fetch_assoc($qtk);
												        	
												        $jmkodep += $tp['totp'];
												        $jmkodek += $tk['totk'];
														}	
														$qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$k[nis]' and `idpelajaran` = '$g[idpelajaran]'");
											        	$tps = mysqli_fetch_assoc($qtps);
											        	$jrt = $tps['totp'];
											        	$kodeb = $jmkodep + $jmkodek;
											        	$trt = ($jrt!=0)?($jrt/$kodeb):0;

											        	if ($trt >= 95) {
											        		$kelas = "A";
											        	}elseif ($trt >= 90) {
											        		$kelas = "B";
											        	}elseif ($trt >= 85) {
											        		$kelas = "C";
											        	}elseif ($trt >= 80) {
											        		$kelas = "D";
											        	}elseif ($trt <= 80) {
											        		$kelas = "E";
											        	}
												      	?>

										        	<td style="vertical-align : middle;text-align:center;" rowspan="<?php echo $hs ?>"><?php echo $kelas ?></td>
										        	</tr>
											      	<?php
												      	$ik=1;
												      	while($kd = mysqli_fetch_assoc($queryk)){

												        ?>
												     <tr>
												     	<td></td>
												     	<td>KD-<?php echo $ik ?></td>
												        <td><?php echo $kd['rpp'] ?></td>
												        <?php
												        $no=1;
												        for ($x=0; $x < 3; $x++) { 
											        		$q = mysqli_query($conn,"SELECT * FROM `raport_katagori` WHERE `nis`='$k[nis]' and `idpelajaran` = '$g[idpelajaran]' and `idrpp` ='$kd[id]' and `jenisujian` ='Pengetahuan' and `uhke` ='$no'");
															$te = mysqli_num_rows($q);
															if($te > 0)
															{
																$t = mysqli_fetch_assoc($q);
																$nilai = $t['nilai'];
																$jnp[] = $t['nilai']; 
															}else{
																$nilai = '';
															}
												        ?>
												        <td width="150" align="center">
											        			<input type="hidden" name="uhp[]" class="form-control round-input" value="<?php echo $no ?>" >
													        	<input type="text" name="nilaip[]" class="form-control round-input" value="<?php echo $nilai ?>" >
													        	<input type="hidden" name="siswap[]" class="form-control round-input" value="<?php echo $k['nis'] ?>" >
													        	<input type="hidden" name="kodep[]" class="form-control round-input" value="<?php echo $idk[$i] ?>" >
													        </td>
												        <?php
												        $no++;
												    	}
												        ?>
												        <?php
												        $no=1;
												        for ($x=0; $x < 3; $x++) { 
											        		$q = mysqli_query($conn,"SELECT * FROM `raport_katagori` WHERE `nis`='$k[nis]' and `idpelajaran` = '$g[idpelajaran]' and `idrpp` ='$kd[id]' and `jenisujian` ='Keterampilan' and `uhke` ='$no'");
															$te = mysqli_num_rows($q);
															if($te > 0)
															{
																$t = mysqli_fetch_assoc($q);
																$nilai = $t['nilai'];
																$jnp[] = $t['nilai']; 
															}else{
																$nilai = '';
															}
												        ?>
												        <td width="150" align="center">
											        			<input type="hidden" name="uhk[]" class="form-control round-input" value="<?php echo $no ?>" >
													        	<input type="text" name="nilaik[]<?php echo $x?>" class="form-control round-input" value="<?php echo $nilai ;?>" >
													        	<input type="hidden" name="siswak[]" class="form-control round-input" value="<?php echo $k['nis'] ?>" >
													        	<input type="hidden" name="kodek[]" class="form-control round-input" value="<?php echo $idk[$i] ?>" >
													        </td>

												        <?php
												        $no++;
												    	}
												        ?>
												        <?php
												        $qtp = mysqli_query($conn,"SELECT  max(`uhke`) as totp FROM `raport_katagori` WHERE `nis`='$k[nis]' and `idpelajaran` = '$g[idpelajaran]' and `idrpp` ='$kd[id]' and `jenisujian` ='Pengetahuan' ");
											        	$tp = mysqli_fetch_assoc($qtp);
											        	$qtk = mysqli_query($conn,"SELECT  max(`uhke`) as totk FROM `raport_katagori`  WHERE `nis`='$k[nis]' and `idpelajaran` = '$g[idpelajaran]' and `idrpp` ='$kd[id]' and `jenisujian` ='Keterampilan' ");
											        	$tk = mysqli_fetch_assoc($qtk);
											        	
											        	$qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$k[nis]' and `idpelajaran` = '$g[idpelajaran]' and `idrpp` ='$kd[id]'");
											        	$tps = mysqli_fetch_assoc($qtps);
											        	$jrt = $tps['totp'];
												        $kodeb = $tp['totp'] + $tk['totk'];
											        	if ($kodeb <= 0) $kodeb = 1;
											        	$trt = ($jrt!=0)?($jrt/$kodeb):0;
											        	
												        ?>
												        <td align="center"><?php echo round($trt,1) ?></td>
												       
											      	</tr>
											      	<?php
											      	$ik++;
											      	}
											      	$is++;
											      	}
											      	?>
											    </tbody>
											  </table>												
											</div>
											<input type="hidden" name="idp" value="<?php echo $g['idpelajaran'] ?>">
											<div class="form-group">
				                                <div class="col-lg-12" align="center">
									                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
									                <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
				                                </div>
				                            </div>
				                        </form>
				                    </div>
				                </section>

				            </div>
				        </div>