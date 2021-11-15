						
						<div class="row">
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data raport katagori
				                    </header>
				                    <div class="panel-body">
				                        <form action="" method="">
				                        	<div class="table-responsive">
					                          <table class="table table-hover table-bordered">			  
											    <thead>
											      <tr>
											        <th width="10" style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center">No</th>
											        <th width="40" style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center">Mata Pelajaran</th>
											        <th colspan="3" class="text-center">Pengetahuan</th>
											        <th colspan="3" class="text-center">Keterampilan</th>
											        <th style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center">Rata -Rata Nilai</th>
											      	<th style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center">Kelas Katagori</th>
											      </tr>
											      <tr>
											        <th class="text-center">UH 1</th>
											        <th class="text-center">UH 2</th>
											        <th class="text-center">UH 3</th>
											      	
											        <th class="text-center">UH 1</th>
											        <th class="text-center">UH 2</th>
											        <th class="text-center">UH 3</th>
											      	
											      </tr>
											    </thead>
											    <tbody>
											    	<?php
											      	$querys = mysqli_query($conn,"SELECT * FROM dasarpenilaian order by posisi");
											      	$is=1;
											      	while($k = mysqli_fetch_assoc($querys)){									      		
											      	?>
											      <tr>
											      	
											        <th colspan="10"><?php echo $k['keterangan'] ?></th>
 												 </tr>
											        <?php
											        $queryp = mysqli_query($conn,"SELECT * FROM pelajaran where sifat='$k[id]'");
											      	$ip=1;
											      	while($p = mysqli_fetch_assoc($queryp)){
											        ?>
											        <tr>
											        <th class="text-center"><?php echo $ip ?></th>
											        <td><?php echo $p['nama'] ?></td>
											        <td colspan="7"></td>
											       	
											      		
											      		<?php
												        $queryk = mysqli_query($conn,"SELECT * FROM `rpp` WHERE `idpelajaran` = '$p[id]' AND idsemester = '$_GET[id]'");
												        $queryk1 = mysqli_query($conn,"SELECT * FROM `rpp` WHERE `idpelajaran` = '$p[id]' AND idsemester = '$_GET[id]'");
												        
												      	$temukan = mysqli_num_rows($queryk);
												      	$hs=$temukan+1;
													    $jmkodep = 0;
												        $jmkodek = 0;
												      	while ($c = mysqli_fetch_assoc($queryk1)) {
															
												        	$qtp = mysqli_query($conn,"SELECT  max(`uhke`) as totp FROM `raport_katagori` WHERE `idpelajaran` = '$p[id]' and `idrpp` ='$c[id]' and `jenisujian` ='Pengetahuan' ");
												        	$tp = mysqli_fetch_assoc($qtp);
												        	$qtk = mysqli_query($conn,"SELECT  max(`uhke`) as totk FROM `raport_katagori` WHERE `idpelajaran` = '$p[id]' and `idrpp` ='$c[id]' and `jenisujian` ='Keterampilan' ");
												        	$tk = mysqli_fetch_assoc($qtk);
												        	
												        $jmkodep += $tp['totp'];
												        $jmkodek += $tk['totk'];
														}	
														$qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$_SESSION[login_user]' and `idpelajaran` = '$p[id]'");
											        	$tps = mysqli_fetch_assoc($qtps);
											        	$jrt = $tps['totp'];
											        	$kodeb = $jmkodep + $jmkodek;
											        	if ($kodeb <= 0) $kodeb = 1;
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
												     	<td>KD-<?php echo $ik ?></td>
												        <td><?php echo $kd['rpp'] ?></td>
												        <?php
												        $no=1;
												        for ($x=0; $x < 3; $x++) { 
											        		$q = mysqli_query($conn,"SELECT * FROM `raport_katagori` WHERE `nis`='$_SESSION[login_user]' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]' and `jenisujian` ='Pengetahuan' and `uhke` ='$no'");
															$te = mysqli_num_rows($q);
															if($te > 0)
															{
																$t = mysqli_fetch_assoc($q);
																$nilai = $t['nilai'];
																$jnp[] = $t['nilai']; 
															}else{
																$nilai = '-';
															}
												        ?>
												        <td align="center" ><?php echo $nilai ?></td>
												        <?php
												        $no++;
												    	}
												        ?>
												        <?php
												        $no=1;
												        for ($x=0; $x < 3; $x++) { 
											        		$q = mysqli_query($conn,"SELECT * FROM `raport_katagori` WHERE `nis`='$_SESSION[login_user]' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]' and `jenisujian` ='Keterampilan' and `uhke` ='$no'");
															$te = mysqli_num_rows($q);
															if($te > 0)
															{
																$t = mysqli_fetch_assoc($q);
																$nilai = $t['nilai'];
																$jnp[] = $t['nilai']; 
															}else{
																$nilai = '-';
															}
												        ?>
												        <td align="center" ><?php echo $nilai ?></td>

												        <?php
												        $no++;
												    	}
												        ?>
												        <?php
												        $qtp = mysqli_query($conn,"SELECT  max(`uhke`) as totp FROM `raport_katagori` WHERE `nis`='$_SESSION[login_user]' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]' and `jenisujian` ='Pengetahuan' ");
											        	$tp = mysqli_fetch_assoc($qtp);
											        	$qtk = mysqli_query($conn,"SELECT  max(`uhke`) as totk FROM `raport_katagori`  WHERE `nis`='$_SESSION[login_user]' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]' and `jenisujian` ='Keterampilan' ");
											        	$tk = mysqli_fetch_assoc($qtk);
											        	
											        	$qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$_SESSION[login_user]' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]'");
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
											      	$ip++;
											      	}
											      	$is++;
											      	}
											      	?>

											    </tbody>
											  </table>												
											</div>
				                        </form>
				                    </div>

				                </section>
				                <?php
				                $querys = mysqli_query($conn,"SELECT * FROM dasarpenilaian WHERE keterangan LIKE '%Peminatan%'");
								$sqlp = mysqli_fetch_assoc($querys);
								$q= mysqli_query($conn,"SELECT * FROM pelajaran WHERE sifat = '$sqlp[id]'");
								$jmqmk = mysqli_num_rows($q);	
								$jrtp = 0;
								while($kd = mysqli_fetch_assoc($q)){
									$qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$_SESSION[login_user]' and `idpelajaran` = '$kd[id]'");
									$tps = mysqli_fetch_assoc($qtps);
									$jrtp += $tps['totp'];
								}		  
								$rtnp = ($jrtp!=0)?($jrtp/$jmqmk):0;    
								if ($rtnp >= 95) {
					        		$kelas = "A";
					        	}elseif ($rtnp >= 90) {
					        		$kelas = "B";
					        	}elseif ($rtnp >= 85) {
					        		$kelas = "C";
					        	}elseif ($rtnp >= 80) {
					        		$kelas = "D";
					        	}elseif ($rtnp <= 80) {
					        		$kelas = "E";
					        	}	
				                ?>
				                <div class="row" align="center">
					                <div class="col-sm-6">
					                    <section class="panel">
					                        <div class="panel-body"><b>Rata - Rata Nilai Perminatan : <?php echo round($rtnp,1) ?></b></div>
					                    </section>
					                </div>
					                <div class="col-sm-6">
					                    <section class="panel">
					                        <div class="panel-body"><b>Kelas Katagori : <?php echo $kelas ?></b></div>
					                    </section>
					                </div>
					            </div>
				            </div>
				        </div>
