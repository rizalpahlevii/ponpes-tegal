<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['absensisiswa']) AND $_SESSION['absensisiswa'] <> 'TRUE')
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
	if($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin' OR $_SESSION['level']=='ortu'){
		$linkaksi = 'med.php?mod=absensisiswa';
		$WHERE = "";
		$urt = "";
	}else {
		$linkaksi = 'med2.php?mod=absensisiswa';
		if ($_SESSION['level']=='absensi sorogan') {
			$WHERE = "WHERE `nama` LIKE '%kemaarifan%'";
			$urt = "WHERE id_absensi = '2'";
		}else{
			$WHERE = "WHERE `nama` NOT LIKE '%kemaarifan%'";
			$urt = "WHERE id_absensi = '1'";
		}
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

	$aksi = 'mod/absensi/act_absensisiswa.php';

	?>
	<?php
	switch ($act) {
		case 'form':
				$act = "$aksi?mod=absensi&act=simpan";

			?>
			        <!-- page start-->
				        <div class="row">
				            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
					            <div class="col-lg-12">
					                <section class="panel">
					                    <header class="panel-heading">
					                        Data Absensi
					                    </header>
					                    <div class="panel-body">
					                        <div class="position-center">
					                            <input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
					                            <div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Jenis Absensi</label>
			                                      <div class="col-lg-10">
			                                          <select name="id_jenisabsensi" class="form-control" id="js">
			                                          		<option value="">Absensi</option>
			                                              <?php
			                                                        $sql_kelas = mysqli_query($conn,"SELECT * FROM jenisabsensi $urt ORDER BY urutan ASC");
			                                                while($k = mysqli_fetch_assoc($sql_kelas))
			                                                {
			                                                 
			                                                    echo"<option value='$k[id]'>$k[nama]</option>";  
			                                                  
			                                                }
			                                                        ?>
			                                          </select>
			                                      	</div>
			                                  	</div>
					                            
					                            <div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
			                                      <div class="col-lg-10">
			                                          <select name="idkelas" class="select2" onchange="showUser(this.value)" style="width: 100%">
			                                          		<option>Kelas</option>
			                                              <?php
			                                              
			                                              if ($_SESSION['level']=='absensi ibt') {
			                                                  $subk = substr($_SESSION['login_user'],4);
			                                                  $subk1 = substr($_SESSION['login_user'],3,1);
			                                                  $kls=$subk;
			                                                  $kls1=$subk1;
			                                              	$sql_kelas = mysqli_query($conn,"SELECT a.* 
															FROM `kelas` as a 
															JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
															WHERE b.`aktif` = 'Aktif' AND a.`kelas` = '$kls1 IBT $kls'  AND a.`tingkat` BETWEEN 3 AND 6 ORDER BY `tingkat`");
			                                              }elseif ($_SESSION['level']=='absensi ts') {
			                                                  
			                                                  $subk = substr($_SESSION['login_user'],3);
			                                                  $subk1 = substr($_SESSION['login_user'],2,1);
			                                                  $kls=$subk;
			                                                  $kls1=$subk1;
			                                                  
			                                              	$sql_kelas = mysqli_query($conn,"SELECT a.* 
															FROM `kelas` as a 
															JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
															WHERE b.`aktif` = 'Aktif' AND a.`kelas` = '$kls1 TS $kls' AND a.`tingkat` BETWEEN 7 AND 9 ORDER BY `tingkat`");
			                                              }elseif ($_SESSION['level']=='absensi aly') {
			                                                  
			                                                  $subk = substr($_SESSION['login_user'],4);
			                                                  $subk1 = substr($_SESSION['login_user'],3,1);
			                                                  $kls=$subk;
			                                                  $kls1=$subk1;
			                                                  
			                                              	$sql_kelas = mysqli_query($conn,"SELECT a.* 
															FROM `kelas` as a 
															JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
															WHERE b.`aktif` = 'Aktif' AND a.`kelas` = '$kls1 ALY $kls' AND a.`tingkat` BETWEEN 10 AND 12 ORDER BY `tingkat`");
			                                              }elseif ($_SESSION['level']=='absensi sp') {
			                                                  
			                                                  $subk = substr($_SESSION['login_user'],2);
			                                                  $kls=$subk;
			                                                  //echo $kls;
			                                              	$sql_kelas = mysqli_query($conn,"SELECT a.* 
															FROM `kelas` as a 
															JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
															WHERE b.`aktif` = 'Aktif' AND a.`kelas` = 'SP $kls' AND a.`tingkat` = '2' ORDER BY `tingkat`");
			                                              }else{
			                                              	$sql_kelas = mysqli_query($conn,"SELECT a.* 
															FROM `kelas` as a 
															JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
															WHERE b.`aktif` = 'Aktif'");
			                                              }
			                                                        
			                                                while($k = mysqli_fetch_assoc($sql_kelas))
			                                                {
			                                                 
			                                                    echo"<option value='$k[id]'>$k[kelas]</option>";  
			                                                  
			                                                }
			                                                        ?>
			                                          </select>
			                                      	</div>
			                                  	</div>
			                                  	
					                        </div>
					                    </div>
					                </section>

                    				<div id="txtHint" align="center"><b>Info will be listed here...</b></div>

					                
					            </div>				            
				            </form>
				        </div>

			<?php
		break;

		default :
		flash('example_message');
			?>
		        <!-- page start-->
		        <div class="row">
		            <div class="col-sm-12">
		            	 <?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin' OR $_SESSION['level']=='superadmin' OR $_SESSION['level']=='absensi sp' OR $_SESSION['level']=='absensi ibt' OR $_SESSION['level']=='absensi ts' OR $_SESSION['level']=='absensi aly' OR $_SESSION['level']=='absensi sorogan'){?>
		                        	<a href="<?php echo $linkaksi ?>&act=form">
									<button class="btn btn-primary">
										Tambah <i class="fa fa-plus"></i>
									</button>
									</a>
									<a href="<?php echo $linkaksi ?>&act=laporan">
									<button class="btn btn-warning">
										Rekap Absensi <i class="fa fa-calendar"></i>
									</button>
									</a>
								<?php }?>
								<a><span class="badge label-primary pull-right r-activity" id="dates"><i class="fa fa-calendar fa-lg"></i> <marquee width="170px" scrollamount="3"><span id="the-day">Hari, 00 Bulan 0000</span></marquee> | <span style="font-weight: bold;" id="the-time">00:00:00</span></a>
								<br>
								<br>
								<br>
		                <div class="row">
		                    <div class="col-md-12">
		                        <!--collapse start-->
		                        
			                        <div class="panel-group m-bot20" id="accordion">
			                            <?php

			                               $u=1;
			                                $sql_ja = mysqli_query($conn,"SELECT * FROM absensi $WHERE ORDER BY urutan ASC");
			                                while($ja = mysqli_fetch_assoc($sql_ja))
			                                {
			                                 
			                                   ?>                                    
			                                    <div class="panel">
			                                        <div class="panel-heading terques-bg">
			                                            <h4 class="panel-title">
			                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $ja['id'] ?>">
			                                                    <?php echo $ja['nama'] ?>
			                                                </a>
			                                            </h4>
			                                        </div>
			                                        <div id="collapse<?php echo $ja['id'] ?>" class="panel-collapse collapse <?php if ($u=='1'){ ?>
			                                                in
			                                                <?php } ?>">
			                                            <div class="panel-body">
			                                                <section class="panel">
			                                                    <header class="panel-heading tab-bg-dark-navy-blue ">
			                                                        <ul class="nav nav-tabs nav-justified">
			                                                            <?php
			                                                                $sql_kelas = mysqli_query($conn,"SELECT * FROM jenisabsensi WHERE id_absensi='$ja[id]' ORDER BY urutan ASC");
			                                                                while($k = mysqli_fetch_assoc($sql_kelas))
			                                                                {
			                                                                 
			                                                                   ?>                                          
			                                                                    <li <?php if ($k['urutan']=="1"){ ?>
			                                                                        class="active"
			                                                                        <?php } ?> >
			                                                                        <a data-toggle="tab" href="#<?php echo $k['id'] ?>"><?php echo $k['nama'] ?></a>
			                                                                    </li>
			                                                                   <?php
			                                                                  
			                                                                }
			                                                            ?>
			                                                        </ul>
			                                                    </header>
			                                                    <div class="panel-body">
			                                                        <div class="tab-content">
			                                                            <?php
			                                                                $a=1;
			                                                                $sql_kelas = mysqli_query($conn,"SELECT * FROM jenisabsensi WHERE id_absensi='$ja[id]' ORDER BY urutan ASC");
			                                                                while($k = mysqli_fetch_assoc($sql_kelas))
			                                                                {
			                                                                 
			                                                                   ?>   
			                                                                        <div id="<?php echo $k['id'] ?>" class="tab-pane <?php if ($k['urutan']=='1'){ ?>
			                                                                        active
			                                                                        <?php } ?>" >                   
			                                                                            <div class="panel-body">
			                                                                            	<?php //echo $k['id'] ?>
			                                                                            	<?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin'){?>
			                                                                            	<?php
			                                                                            	$qkx = "SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`
                                                											FROM `kelas` as a
                                                											JOIN `pegawai` as b on a.nipwali = b.nip
                                                											JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
                                                											WHERE c.aktif = 'Aktif'
                                                											ORDER BY a.`kelas`,a.`tingkat`
                                                                                                ";
                                                											$sqqkx = mysqli_query($conn,$qkx);
			                                                                                $jmkl = mysqli_num_rows($sqqkx);
			                                                                            	$qbs = "SELECT c.`id`, c.`kelas`, a.`id_jenisabsensi`, a.`date` 
                                                                                                                FROM `absensi_siswa` as a
                                                                                                                JOIN `siswa` as b ON a.`nis` = b.`nis`
                                                                                                                JOIN `kelas` as c ON b.`idkelas` = c.`id`
                                                                                                                WHERE a.`date`= CURDATE() AND a.`id_jenisabsensi`='$k[id]'
                                                                                                                GROUP BY c.`id` ORDER BY c.`kelas`,c.`tingkat`";
                                                                                            $sqlbs = mysqli_query($conn,$qbs);  
			                                                                                            $i=1;
			                                                                                 $jmsk = mysqli_num_rows($sqlbs);
			                                                                                 
                                                											$jmbs = $jmkl - $jmsk;
			                                                                            	?>
			                                                                            	<div class="col-md-4">
                                                                                              <div class="card-counter info">
                                                                                                <i class="fa fa-bell-o"></i>
                                                                                                <span class="count-numbers"><?php echo number_format($jmsk) ?></span>
                                                                                                <span class="count-name">Kelas Sudah Absen</span>
                                                                                              </div>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                              <div class="card-counter danger">
                                                                                                <i class="fa fa-bell-o"></i>
                                                                                                <span class="count-numbers"><?php echo number_format($jmbs) ?></span>
                                                                                                <span class="count-name">Kelas Belum Absen</span>
                                                                                              </div>
                                                                                            </div>
                                                                                            <a href="<?php echo $linkaksi ?>&act=detail_kelas&idjenis=<?php echo $k['id'] ?>">
                                                                                            <div class="col-md-4">
                                                                                              <div class="card-counter inverse">
                                                                                                <i class="fa fa-bell-o"></i>
                                                                                                <span class="count-numbers">Detail Kelas</span>
                                                                                                <span class="count-name">Klik Lihat Detail Kelas</span>
                                                                                              </div>
                                                                                            </div> 
                                                        									</a>
                                                        									<?php 
			                                                                            	}else{
			                                                                            	?>
			                                                                            	<div class="adv-table editable-table table-responsive">
			                                                                                    <div class="clearfix">
			                                                                                        <div class="btn-group">
			                                                                                        </div>
			                                                                                        <div class="btn-group pull-right">
			                                                                                           
			                                                                                        </div>
			                                                                                    </div>
			                                                                                    <div class="space12"></div>
			                                                                                    <table class="table table-striped table-hover table-bordered" id="example<?php echo $k['id']?>">
			                                                                                        <thead>
			                                                                                        <tr>
			                                                                                            <th class="text-center">No</th>
			                                                                                            <th class="text-center">Kelas</th>
			                                                                                            <?php
			                                                                                            $qk = "SELECT * FROM kehadiran order by urutan asc";
			                                                                                            $sqlk = mysqli_query($conn,$qk);
			                                                                                            while ($kh = mysqli_fetch_assoc($sqlk)) {
			                                                                                            ?>
			                                                                                            <th class="text-center"><?php echo $kh['kehadiran']?></th>
			                                                                                            <?php
			                                                                                            }
			                                                                                            ?>
			                                                                                            <th class="text-center">Aksi</th>
			                                                                                        </tr>
			                                                                                        </thead>
			                                                                                        <tbody>
			                                                                                        <?php
			                                                                                        if ($_SESSION['level']=='absensi ibt') {
                                                    		                                	            $subk = substr($_SESSION['login_user'],4);
                                                    			                                                  $subk1 = substr($_SESSION['login_user'],3,1);
                                                    			                                                  $kls=$subk;
                                                    			                                                  $kls1=$subk1;
                                                                                                  	
                                                                                                            $query = "SELECT c.`id`, c.`kelas`, a.`id_jenisabsensi`, a.`date` 
			                                                                                                        FROM `absensi_siswa` as a
			                                                                                                        JOIN `siswa` as b ON a.`nis` = b.`nis`
			                                                                                                        JOIN `kelas` as c ON b.`idkelas` = c.`id`
			                                                                                                        WHERE a.`date`= CURDATE() AND a.`id_jenisabsensi`='$k[id]' AND c.`kelas` = '$kls1 IBT $kls' AND c.`tingkat` BETWEEN 3 AND 6
			                                                                                                        GROUP BY c.`id`";
                                                                                                  }elseif ($_SESSION['level']=='absensi ts') {
                                                    			                                                  $subk = substr($_SESSION['login_user'],3);
                                                    			                                                  $subk1 = substr($_SESSION['login_user'],2,1);
                                                    			                                                  $kls=$subk;
                                                    			                                                  $kls1=$subk1;
                                                    			                                                  $query = "SELECT c.`id`, c.`kelas`, a.`id_jenisabsensi`, a.`date` 
			                                                                                                        FROM `absensi_siswa` as a
			                                                                                                        JOIN `siswa` as b ON a.`nis` = b.`nis`
			                                                                                                        JOIN `kelas` as c ON b.`idkelas` = c.`id`
			                                                                                                        WHERE a.`date`= CURDATE() AND a.`id_jenisabsensi`='$k[id]' AND c.`kelas` = '$kls1 TS $kls' AND c.`tingkat` BETWEEN 7 AND 9
			                                                                                                        GROUP BY c.`id`";
			                                                                                            $sql_kul = mysqli_query($conn,$query);  
                                                                                                  	
                                                                                                  }elseif ($_SESSION['level']=='absensi aly') {
                                                    			                                                  $subk = substr($_SESSION['login_user'],4);
                                                    			                                                  $subk1 = substr($_SESSION['login_user'],3,1);
                                                    			                                                  $kls=$subk;
                                                    			                                                  $kls1=$subk1;
                                                    			                                            $query = "SELECT c.`id`, c.`kelas`, a.`id_jenisabsensi`, a.`date` 
			                                                                                                        FROM `absensi_siswa` as a
			                                                                                                        JOIN `siswa` as b ON a.`nis` = b.`nis`
			                                                                                                        JOIN `kelas` as c ON b.`idkelas` = c.`id`
			                                                                                                        WHERE a.`date`= CURDATE() AND a.`id_jenisabsensi`='$k[id]'  AND c.`kelas` = '$kls1 ALY $kls' AND c.`tingkat` BETWEEN 10 AND 12
			                                                                                                        GROUP BY c.`id`";
                                                                                                  	
                                                                                                  }elseif ($_SESSION['level']=='absensi sp') {
                                                    			                                                  $subk = substr($_SESSION['login_user'],2);
                                                    			                                                  $kls=$subk;
                                                    			                                                  //echo $kls;
                                                    			                                                  $query = "SELECT c.`id`, c.`kelas`, a.`id_jenisabsensi`, a.`date` 
			                                                                                                        FROM `absensi_siswa` as a
			                                                                                                        JOIN `siswa` as b ON a.`nis` = b.`nis`
			                                                                                                        JOIN `kelas` as c ON b.`idkelas` = c.`id`
			                                                                                                        WHERE a.`date`= CURDATE() AND a.`id_jenisabsensi`='$k[id]' AND c.`kelas` = 'SP $kls' AND c.`tingkat` ='2'
			                                                                                                        GROUP BY c.`id`";
                                                                                                  }else{
                                                                                              		$query = "SELECT c.`id`, c.`kelas`, a.`id_jenisabsensi`, a.`date` 
                                                                                                                FROM `absensi_siswa` as a
                                                                                                                JOIN `siswa` as b ON a.`nis` = b.`nis`
                                                                                                                JOIN `kelas` as c ON b.`idkelas` = c.`id`
                                                                                                                WHERE a.`date`= CURDATE() AND a.`id_jenisabsensi`='$k[id]'
                                                                                                                GROUP BY c.`id` ORDER BY c.`kelas`,c.`tingkat`";
                                                                                                  }
			                                                                                            
			                                                                                            $sql_kul = mysqli_query($conn,$query);  
			                                                                                            $i=1;
			                                                                                            while ($m = mysqli_fetch_assoc($sql_kul)) {
			                                                                                        ?>
			                                                                                        <tr class="">
			                                                                                            <td align="center"><?php echo $i ?></td>
			                                                                                            <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
			                                                                                            <td align="center"><?php echo $m['kelas']?></td>
			                                                                                             <?php
			                                                                                             $x=1;
			                                                                                            $qk = "SELECT * FROM kehadiran order by urutan asc";
			                                                                                            $sqlk = mysqli_query($conn,$qk);
			                                                                                            while ($kh = mysqli_fetch_assoc($sqlk)) {
			                                                                                                $sql[$x] = "SELECT COUNT(a.`kehadiran`) as kehadiran
			                                                                                                        FROM `absensi_siswa` as a
			                                                                                                        JOIN `siswa` as b ON a.`nis` = b.`nis`
			                                                                                                        JOIN `kelas` as c ON b.`idkelas` = c.`id` 
			                                                                                                        WHERE `kehadiran` =  '$kh[id]' AND a.`date`= CURDATE() AND c.`id` = '$m[id]' AND a.`id_jenisabsensi`='$k[id]'";
			                                                                                                $hasil[$x]= mysqli_query($conn,$sql[$x]);   
			                                                                                                $absen[$x] = mysqli_fetch_assoc($hasil[$x]);
			                                                                                            ?>
			                                                                                            <td align="center"><?php echo $absen[$x]['kehadiran']?></td>
			                                                                                            <?php
			                                                                                            $x++; }
			                                                                                            ?>
			                                                                                            <td align="center">
			                                                                                               <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>    
			                                                                                               <a href="<?php echo $aksi ?>?mod=absensisiswa&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>                        
			                                                                                           --> 
			                                                                                                <a href="<?php echo $linkaksi ?>&act=detail&id=<?php echo $m['id'] ?>&tgl=<?php echo $m['date']?>&idjs=<?php echo $m['id_jenisabsensi'] ?>" ><button class="btn btn-info btn-sm"><i class="fa fa-search"></i></button> </a>
			                                                                                                <a href="<?php echo $linkaksi ?>&act=edit&id=<?php echo $m['id'] ?>&tgl=<?php echo $m['date']?>&idjs=<?php echo $m['id_jenisabsensi'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
			                                                                                                

			                                                                                                
			                                                                                            </td>
			                                                                                        </tr>
			                                                                                        
			                                                                                        <?php
			                                                                                             $i++;
			                                                                                         }
			                                                                                        ?>
			                                                                                        </tbody>
			                                                                                    </table>
			                                                                                </div>
			                                                                            	<?php
                                                        									} 
                                                        									?>
			                                                                                
			                                                                            </div>

			                                                                        </div>
			                                                                   <?php
			                                                                 $a++; 
			                                                                }
			                                                            ?>
			                                                        </div>
			                                                    </div>
			                                                </section>
			                                            </div>
			                                        </div>
			                                    </div> 
			                                   <?php
			                                
			                                 $u++;  
			                                }
			                            ?>
			                            
			                        </div>
		                        <!--collapse end-->
		                    </div>
		                </div>

           			</div>
		        
			<?php
		break;
		case 'edit':
			$q = $_GET['id'];
			$js = $_GET['idjs'];
			$tgl = $_GET['tgl'];
			$queryx = "SELECT c.`id`, c.`kelas`, a.`id_jenisabsensi` , d.`nama` 
						FROM `absensi_siswa` as a
						JOIN `siswa` as b ON a.`nis` = b.`nis`
						JOIN `kelas` as c ON b.`idkelas` = c.`id`
						JOIN `jenisabsensi` as d ON a.`id_jenisabsensi` = d.`id`
						WHERE a.`date`= '$tgl' AND a.`id_jenisabsensi`='$js' AND b.`idkelas` = '$q'
						GROUP BY c.`id`";
			$sqlx = mysqli_query($conn,$queryx);	
			$qkls = mysqli_fetch_assoc($sqlx);

			?>

		        <!-- page start-->

		        <div class="row">

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">		                        
        						Data Absensi Santri <?php echo $qkls['nama'] ?> Kelas <?php echo $qkls['kelas'] ?> Tanggal <b><?php echo tglindo($tgl) ?></b>
		                        <span class="tools pull-right">
		                            <a href="javascript:;" class="fa fa-chevron-down"></a>
		                            <a href="javascript:;" class="fa fa-cog"></a>
		                            <a href="javascript:;" class="fa fa-times"></a>
		                         </span>
		                    </header>
							
							
				            <form class="form-horizontal" role="form" method='POST' action='<?php echo $aksi ?>?mod=absensi&act=edit'>
		                    <div class="panel-body">
							
		                        <div class="adv-table editable-table table-responsive">
		                            <div class="clearfix">
		                                <div class="btn-group">
		                                </div>
		                                <div class="btn-group pull-right">
		                                   
		                                </div>
		                            </div>
		                            <div class="space12"></div>
		                            <table class="table table-striped table-hover table-bordered" id="examplea">
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>
						                    <th class="text-center">NIS</th>
											<th class="text-center">Nama Santri</th>
											<th class="text-center">Absen</th>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT a.`id`, b.`nis`, b.`nama`, a.`id_jenisabsensi`, a.`kehadiran`
													FROM `absensi_siswa` as a
													JOIN `siswa` as b ON a.`nis` = b.`nis`
													JOIN `kelas` as c ON b.`idkelas` = c.`id` 
                                                    WHERE a.`date`='$tgl' AND a.`id_jenisabsensi` = '$js' AND c.`id` = '$q'";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id[]" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['nis']?></td>
		                                    <td><?php echo $m['nama']?></td>
											<td align="center">
												<select name="kehadiran[]" class="form-control" style="width: 100%">
		                                              <?php
		                                                        $sql_kelas = mysqli_query($conn,"SELECT * FROM kehadiran ORDER BY urutan ASC");
		                                                while($k = mysqli_fetch_assoc($sql_kelas))
		                                                {
		                                                  if(isset($m['kehadiran']) && $k['id'] == $m['kehadiran'])
		                                                  {
		                                                    echo"<option value='$k[id]' selected>$k[kehadiran]</option>";  
		                                                  }
		                                                  else
		                                                  {
		                                                    echo"<option value='$k[id]'>$k[kehadiran]</option>";
		                                                  }
		                                                  
		                                                }
		                                                        ?>
		                                          </select>
											</td>
		                                </tr>
										
		                                <?php
		 									 $i++;
		 								 }
		 								?>
		                                </tbody>
		                            </table>
		                        </div>


						        <div class="form-group">
						            <div align="center" class="col-lg-12">
						                <button type="submit" name="submit" value="simpan" class="btn btn-warning"><i class='fa fa-save'></i> Simpan</button>
						            </div>
						        </div>
		                    </div>
		                	</form>
		                </section>
		            </div>
		        </div>

		            <!-- page end-->
			<?php
		break;
		case 'detail':
			$q = $_GET['id'];
			$js = $_GET['idjs'];
			$tgl = $_GET['tgl'];
			$queryx = "SELECT c.`id`, c.`kelas`, a.`id_jenisabsensi` , d.`nama` 
						FROM `absensi_siswa` as a
						JOIN `siswa` as b ON a.`nis` = b.`nis`
						JOIN `kelas` as c ON b.`idkelas` = c.`id`
						JOIN `jenisabsensi` as d ON a.`id_jenisabsensi` = d.`id`
						WHERE a.`date`= '$tgl' AND a.`id_jenisabsensi`='$js' AND b.`idkelas` = '$q'
						GROUP BY c.`id`";
			$sqlx = mysqli_query($conn,$queryx);	
			$qkls = mysqli_fetch_assoc($sqlx);
			?>
		        <!-- page start-->

		        <div class="row">

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">
		                        Data Absensi Santri <?php echo $qkls['nama'] ?> Kelas <?php echo $qkls['kelas'] ?> Tanggal <b><?php echo tglindo($tgl) ?></b>
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
						                    <th class="text-center">NIS</th>
											<th class="text-center">Nama Santri</th>
											<th class="text-center">Absen</th>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT a.`id`, b.`nis`, b.`nama`, a.`id_jenisabsensi`, d.`kehadiran`
													FROM `absensi_siswa` as a
													JOIN `siswa` as b ON a.`nis` = b.`nis`
													JOIN `kelas` as c ON b.`idkelas` = c.`id` 												
													JOIN `kehadiran` as d ON a.`kehadiran` = d.`id`
                                                    WHERE a.`date`='$tgl' AND a.`id_jenisabsensi` = '$js' AND c.`id` = '$q'";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['nis']?></td>
		                                    <td><?php echo $m['nama']?></td>
											<td align="center"><?php echo $m['kehadiran']?></td>
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
		case 'laporan':
		?>
		<div class="row">

			<div class="col-lg-12">
            <!--tab nav start-->
	            <section class="panel">
	                <header class="panel-heading tab-bg-dark-navy-blue ">
	                    <ul class="nav nav-tabs nav-justified">
	                        <li class="active">
	                            <a data-toggle="tab" href="#home">Rekap Per-tanggal</a>
	                        </li>
	                        <li class="">
	                            <a data-toggle="tab" href="#about">Rekap Per-kelas</a>
	                        </li>
	                    </ul>
	                </header>
	                <div class="panel-body">
	                    <div class="tab-content">
	                        <div id="home" class="tab-pane active">                            

					            
				            <form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=laporandetail'>
					            <div class="col-lg-12">
					                <section class="panel">
					                    <header class="panel-heading">
					                        Data Absensi
					                    </header>
					                    <div class="panel-body">
					                        <div class="position-center">
					                            <input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
					                            <div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Jenis Absensi</label>
			                                      <div class="col-lg-10">
			                                          <select name="idjs" class="form-control">
			                                          		<option value="">Absensi</option>
			                                              <?php
			                                                        $sql_kelas = mysqli_query($conn,"SELECT * FROM jenisabsensi $urt ORDER BY urutan ASC");
			                                                while($k = mysqli_fetch_assoc($sql_kelas))
			                                                {
			                                                 
			                                                    echo"<option value='$k[id]'>$k[nama]</option>";  
			                                                  
			                                                }
			                                                        ?>
			                                          </select>
			                                      	</div>
			                                  	</div>
					                            
					                            <div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Dari Tanggal</label>
			                                      <div class="col-lg-10">
			                                          <input name="tgl1" class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" />
			                                      	</div>
			                                  	</div>
			                                  	<div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Sampai</label>
			                                      <div class="col-lg-10">
			                                          <input name="tgl2" class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" />
			                                      	</div>
			                                  	</div>
			                                  	<div class="form-group">
				                                <div class="col-lg-offset-2 col-lg-10">
									                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Submit</button>
									                <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
				                                </div>
				                            </div>
					                        </div>
					                    </div>
					                </section>					                
					            </div>				            
				            </form>
	                        </div>
	                        <div id="about" class="tab-pane">
		                        
				            <form class="form-horizontal" role="form" method='POST' action='<?php echo $linkaksi ?>&act=laporandetailkelas'>
					            <div class="col-lg-12">
					                <section class="panel">
					                    <header class="panel-heading">
					                        Data Absensi
					                    </header>
					                    <div class="panel-body">
					                        <div class="position-center">
					                            <input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
					                            <div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Jenis Absensi</label>
			                                      <div class="col-lg-10">
			                                          <select name="idjs" class="form-control">
			                                          		<option value="">Absensi</option>
			                                              <?php
			                                                        $sql_kelas = mysqli_query($conn,"SELECT * FROM jenisabsensi $urt ORDER BY urutan ASC");
			                                                while($k = mysqli_fetch_assoc($sql_kelas))
			                                                {
			                                                 
			                                                    echo"<option value='$k[id]'>$k[nama]</option>";  
			                                                  
			                                                }
			                                                        ?>
			                                          </select>
			                                      	</div>
			                                  	</div>
					                            <div class="form-group">
				                                  <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
				                                  <div class="col-lg-10">
				                                      <select name="idkls" class="select2" style="width: 100%">
				                                      		<option value="">Kelas</option>
				                                          <?php
			                                              
			                                              if ($_SESSION['level']=='absensi ibt') {
			                                                  $subk = substr($_SESSION['login_user'],4);
			                                                  $subk1 = substr($_SESSION['login_user'],3,1);
			                                                  $kls=$subk;
			                                                  $kls1=$subk1;
			                                              	$sql_kelas = mysqli_query($conn,"SELECT a.* 
															FROM `kelas` as a 
															JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
															WHERE b.`aktif` = 'Aktif' AND a.`kelas` = '$kls1 IBT $kls'  AND a.`tingkat` BETWEEN 3 AND 6 ORDER BY `tingkat`");
			                                              }elseif ($_SESSION['level']=='absensi ts') {
			                                                  
			                                                  $subk = substr($_SESSION['login_user'],3);
			                                                  $subk1 = substr($_SESSION['login_user'],2,1);
			                                                  $kls=$subk;
			                                                  $kls1=$subk1;
			                                                  
			                                              	$sql_kelas = mysqli_query($conn,"SELECT a.* 
															FROM `kelas` as a 
															JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
															WHERE b.`aktif` = 'Aktif' AND a.`kelas` = '$kls1 TS $kls' AND a.`tingkat` BETWEEN 7 AND 9 ORDER BY `tingkat`");
			                                              }elseif ($_SESSION['level']=='absensi aly') {
			                                                  
			                                                  $subk = substr($_SESSION['login_user'],4);
			                                                  $subk1 = substr($_SESSION['login_user'],3,1);
			                                                  $kls=$subk;
			                                                  $kls1=$subk1;
			                                                  
			                                              	$sql_kelas = mysqli_query($conn,"SELECT a.* 
															FROM `kelas` as a 
															JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
															WHERE b.`aktif` = 'Aktif' AND a.`kelas` = '$kls1 ALY $kls' AND a.`tingkat` BETWEEN 10 AND 12 ORDER BY `tingkat`");
			                                              }elseif ($_SESSION['level']=='absensi sp') {
			                                                  
			                                                  $subk = substr($_SESSION['login_user'],2);
			                                                  $kls=$subk;
			                                                  //echo $kls;
			                                              	$sql_kelas = mysqli_query($conn,"SELECT a.* 
															FROM `kelas` as a 
															JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
															WHERE b.`aktif` = 'Aktif' AND a.`kelas` = 'SP $kls' AND a.`tingkat` = '2' ORDER BY `tingkat`");
			                                              }else{
			                                              	$sql_kelas = mysqli_query($conn,"SELECT a.* 
															FROM `kelas` as a 
															JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
															WHERE b.`aktif` = 'Aktif'");
			                                              }
				                                            while($k = mysqli_fetch_assoc($sql_kelas))
				                                            {
				                                             
				                                                echo"<option value='$k[id]'>$k[kelas]</option>";  
				                                              
				                                            }
				                                                    ?>
				                                      </select>
				                                  	</div>
				                              	</div>
					                            <div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Dari Tanggal</label>
			                                      <div class="col-lg-10">
			                                          <input name="tgl1" class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" />
			                                      	</div>
			                                  	</div>
			                                  	<div class="form-group">
			                                      <label class="col-lg-2 col-sm-2 control-label">Sampai</label>
			                                      <div class="col-lg-10">
			                                          <input name="tgl2" class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" />
			                                      	</div>
			                                  	</div>
			                                  	<div class="form-group">
				                                <div class="col-lg-offset-2 col-lg-10">
									                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Submit</button>
									                <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
				                                </div>
				                            </div>
					                        </div>
					                    </div>
					                </section>					                
					            </div>				            
				            </form>
		                    </div>
	                    </div>
	                </div>
	            </section>
	        </div>
        </div>
		<?php
		break;
		case 'laporandetail':

			$js = $_POST['idjs'];
			$tgl1 = $_POST['tgl1'];
			$tgl2 = $_POST['tgl2'];
			$queryx = "SELECT * FROM jenisabsensi WHERE `id`='$js'";
			$sqlx = mysqli_query($conn,$queryx);	
			$qkls = mysqli_fetch_assoc($sqlx);
			?>
		        <!-- page start-->

		        <div class="row">

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">
		                        Data Absensi Santri <?php echo $qkls['nama'] ?> Tanggal <?php echo tglindo($tgl1) ?> - <?php echo tglindo($tgl2) ?>
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
		                                    <th class="text-center">Kelas</th>
		                                    <th class="text-center">Tanggal</th>
		                                    <?php
		                                    $qk = "SELECT * FROM kehadiran order by urutan asc";
											$sqlk = mysqli_query($conn,$qk);
											while ($kh = mysqli_fetch_assoc($sqlk)) {
											?>
											<th class="text-center"><?php echo $kh['kehadiran']?></th>
											<?php
											}
		                                    ?>
											<?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='absensi ibt' OR $_SESSION['level']=='absensi ts' OR $_SESSION['level']=='absensi aly' OR $_SESSION['level']=='absensi sorogan'){?>
		                                    <th class="text-center">Aksi</th>
											<?php }?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT c.`id`, c.`kelas`, a.`id_jenisabsensi`, a.`date` 
														FROM `absensi_siswa` as a
														JOIN `siswa` as b ON a.`nis` = b.`nis`
														JOIN `kelas` as c ON b.`idkelas` = c.`id`
														WHERE a.`date` BETWEEN '$tgl1' AND '$tgl2' AND a.`id_jenisabsensi`='$js'
														GROUP BY c.`id`, a.`date`
														ORDER BY a.`date` ";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td align="center"><?php echo $m['kelas']?></td>
		                                    <td align="center"><?php echo tglindo($m['date'])?></td>
		                                     <?php
		                                     $x=1;
		                                    $qk = "SELECT * FROM kehadiran order by urutan asc";
											$sqlk = mysqli_query($conn,$qk);
											while ($kh = mysqli_fetch_assoc($sqlk)) {
												$sql[$x] = "SELECT COUNT(a.`kehadiran`) as kehadiran
														FROM `absensi_siswa` as a
														JOIN `siswa` as b ON a.`nis` = b.`nis`
														JOIN `kelas` as c ON b.`idkelas` = c.`id` 
														WHERE `kehadiran` =  '$kh[id]' AND a.`date`= '$m[date]' AND c.`id` = '$m[id]' AND a.`id_jenisabsensi`='$js'";
												$hasil[$x]= mysqli_query($conn,$sql[$x]);	
												$absen[$x] = mysqli_fetch_assoc($hasil[$x]);
											?>
											<td align="center"><?php echo $absen[$x]['kehadiran']?></td>
											<?php
											$x++; }
		                                    ?>
		                                    <?php if($_SESSION['level']=='admin' OR $_SESSION['level']=='absensi ibt' OR $_SESSION['level']=='absensi ts' OR $_SESSION['level']=='absensi aly' OR $_SESSION['level']=='absensi sorogan'){?>
											<td align="center">
		                                       <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>	
		                                       <a href="<?php echo $aksi ?>?mod=absensisiswa&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>						
		                                   --> 
		                                   		<a href="<?php echo $linkaksi ?>&act=detail&id=<?php echo $m['id'] ?>&tgl=<?php echo $m['date']?>&idjs=<?php echo $m['id_jenisabsensi'] ?>" ><button class="btn btn-info btn-sm"><i class="fa fa-search"></i></button> </a>
		                                        <a href="<?php echo $linkaksi ?>&act=edit&id=<?php echo $m['id'] ?>&tgl=<?php echo $m['date']?>&idjs=<?php echo $m['id_jenisabsensi'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
												

												
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
		case 'laporandetailkelas':
			$js = $_POST['idjs'];
			$idkls = $_POST['idkls'];
			$tgl1 = $_POST['tgl1'];
			$tgl2 = $_POST['tgl2'];
			$queryx = "SELECT * FROM jenisabsensi WHERE `id`='$js'";
			$sqlx = mysqli_query($conn,$queryx);	
			$qkls = mysqli_fetch_assoc($sqlx);
			?>
		        <!-- page start-->

		        <div class="row">

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">
		                        Data Absensi Santri  <?php echo $qkls['nama'] ?> Tanggal <?php echo tglindo($tgl1) ?> - <?php echo tglindo($tgl2) ?>
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
		                            <table class="table" id="example">
		                                <thead>
		                                <tr>
											<th class="text-center">No</th>
		                                    <th class="text-center">Nama</th>
		                                    <th class="text-center">Kelas</th>
		                                    <?php
		                                    $qk = "SELECT * FROM kehadiran order by urutan asc";
											$sqlk = mysqli_query($conn,$qk);
											while ($kh = mysqli_fetch_assoc($sqlk)) {
											?>
											<th class="text-center"><?php echo $kh['kehadiran']?></th>
											<?php
											}
		                                    ?>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT c.`id`,b.`nis`,b.`nama`, c.`kelas`, a.`id_jenisabsensi`, a.`date` 
														FROM `absensi_siswa` as a
														JOIN `siswa` as b ON a.`nis` = b.`nis`
														JOIN `kelas` as c ON b.`idkelas` = c.`id`
														WHERE a.`date` BETWEEN '$tgl1' AND '$tgl2' AND a.`id_jenisabsensi`='$js' AND c.`id` = '$idkls'
														GROUP BY b.`nis`
														ORDER BY b.`nis` ";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
											    $queryk = "SELECT COUNT(a.`kehadiran`) as kehadiran
														FROM `absensi_siswa` as a
														JOIN `siswa` as b ON a.`nis` = b.`nis`
														JOIN `kelas` as c ON b.`idkelas` = c.`id` 
														WHERE `kehadiran` =  '1' AND b.`nis` = '$m[nis]' AND a.`id_jenisabsensi`='$js' AND a.`date` BETWEEN '$tgl1' AND '$tgl2'";
    											$sqlk = mysqli_query($conn,$queryk);	
    											$qjml = mysqli_fetch_assoc($sqlk);
    											if ($qjml['kehadiran'] >= "60") {
    												$class = 'style="background-color:#FF3F3F"';
    												$bg = "merah";
    											}elseif ($qjml['kehadiran'] >= "30") {												
    												$class = 'style="background-color:#F6FA76"';
    												
    												$bg = "kuning";
    											}else{												
    												$class = '';
    												
    												$bg = "normal";
    											}
										?>
		                                <tr <?php echo $class ?>>
		                                    <td align="center"><?php echo $i ?></td>
		                                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
		                                    <td><?php echo $m['nis']?>- <?php echo $m['nama']?></td>
		                                    <td align="center"><?php echo $m['kelas']?></td>
		                                     <?php
		                                     $x=1;
		                                    $qk = "SELECT * FROM kehadiran order by urutan asc";
											$sqlk = mysqli_query($conn,$qk);
											while ($kh = mysqli_fetch_assoc($sqlk)) {
												$sql[$x] = "SELECT COUNT(a.`kehadiran`) as kehadiran
														FROM `absensi_siswa` as a
														JOIN `siswa` as b ON a.`nis` = b.`nis`
														JOIN `kelas` as c ON b.`idkelas` = c.`id` 
														WHERE `kehadiran` =  '$kh[id]' AND b.`nis` = '$m[nis]' AND a.`id_jenisabsensi`='$js' AND a.`date` BETWEEN '$tgl1' AND '$tgl2'";
												$hasil[$x]= mysqli_query($conn,$sql[$x]);	
												$absen[$x] = mysqli_fetch_assoc($hasil[$x]);
											?>
											<td align="center"><?php echo $absen[$x]['kehadiran']?></td>
													
											</td>
											<?php
											$x++; }
		                                    ?>
		                                    
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
		case 'siswa':
			?>
		        <!-- page start-->
		        <div class="row">
		            <div class="col-sm-12">
		                <div class="row">
		                    <div class="col-md-12">
		                        <!--collapse start-->
		                        
			                        <div class="panel-group m-bot20" id="accordion">
			                            <?php

			                               $u=1;
			                                $sql_ja = mysqli_query($conn,"SELECT * FROM absensi $WHERE ORDER BY urutan ASC");
			                                while($ja = mysqli_fetch_assoc($sql_ja))
			                                {
			                                 
			                                   ?>                                    
			                                    <div class="panel">
			                                        <div class="panel-heading terques-bg">
			                                            <h4 class="panel-title">
			                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $ja['id'] ?>">
			                                                    <?php echo $ja['nama'] ?>
			                                                </a>
			                                            </h4>
			                                        </div>
			                                        <div id="collapse<?php echo $ja['id'] ?>" class="panel-collapse collapse <?php if ($u=='1'){ ?>
			                                                in
			                                                <?php } ?>">
			                                            <div class="panel-body">
			                                                <section class="panel">
			                                                    <header class="panel-heading tab-bg-dark-navy-blue ">
			                                                        <ul class="nav nav-tabs nav-justified">
			                                                            <?php
			                                                                $sql_kelas = mysqli_query($conn,"SELECT * FROM jenisabsensi WHERE id_absensi='$ja[id]' ORDER BY urutan ASC");
			                                                                while($k = mysqli_fetch_assoc($sql_kelas))
			                                                                {
			                                                                 
			                                                                   ?>                                          
			                                                                    <li <?php if ($k['urutan']=="1"){ ?>
			                                                                        class="active"
			                                                                        <?php } ?> >
			                                                                        <a data-toggle="tab" href="#<?php echo $k['id'] ?>"><?php echo $k['nama'] ?></a>
			                                                                    </li>
			                                                                   <?php
			                                                                  
			                                                                }
			                                                            ?>
			                                                        </ul>
			                                                    </header>
			                                                    <div class="panel-body">
			                                                        
			                                                        
                                                                    
			                                                        <div class="tab-content">
			                                                            
			                                                            <?php
			                                                                $a=1;
			                                                                $sql_kelas = mysqli_query($conn,"SELECT * FROM jenisabsensi WHERE id_absensi='$ja[id]' ORDER BY urutan ASC");
			                                                                while($k = mysqli_fetch_assoc($sql_kelas))
			                                                                {
			                                                                 
			                                                                   ?>   
			                                                                        <div id="<?php echo $k['id'] ?>" class="tab-pane <?php if ($k['urutan']=='1'){ ?>
			                                                                        active
			                                                                        <?php } ?>" >                   
			                                                                            <div class="panel-body">
			                                                                                <div class="row">
                        			                                                            <?php
                        			                                                            $bg=array(1=>"primary","warning","success","info","danger");
                        			                                                            $fa=array(1=>"fa-check-square-o","fa-stethoscope","fa-envelope","fa-shield","fa-exclamation-circle");
                        			                                                            $i=1;
                        		                                                                $sqlkh = mysqli_query($conn,"SELECT * FROM `kehadiran` ORDER BY urutan ASC");
                        		                                                                while($kh = mysqli_fetch_assoc($sqlkh))
                        		                                                                {
                        		                                                                    $sqc = mysqli_query($conn,"SELECT COUNT(*) as jml 
                                                                                                                        FROM `absensi_siswa` as a
                                                            														JOIN `siswa` as b ON a.`nis` = b.`nis`
                                                            														JOIN `kelas` as c ON b.`idkelas` = c.`id`
                                                                                                                    JOIN `kehadiran` as k ON a.`kehadiran` = k.`id`
                                                                                                                    WHERE a.`id_jenisabsensi`='$k[id]' AND b.`id` = '$_SESSION[login_id]' AND a.`kehadiran` = '$kh[id]' ");
                        			                                                                $dc = mysqli_fetch_assoc($sqc);
                        			                                                            ?>
                        			                                                            
                                                                                                <a href="med2.php?mod=absensisiswa&act=siswa_detail&idj=<?php echo $k['id'] ?>&idk=<?php echo $kh['id'] ?>">
                            			                                                        <div class="col-md-4">
                                                                                                  <div class="card-counter <?php echo $bg[$i] ?>">
                                                                                                    <i class="fa <?php echo $fa[$i] ?>"></i>
                                                                                                    <span class="count-numbers"><?php echo number_format($dc['jml']) ?></span>
                                                                                                    <span class="count-name"><?php echo $kh['kehadiran'] ?></span>
                                                                                                  </div>
                                                                                                </div>
                                                                                                </a>
                                                                                                <?php
                                                                                                $i++;
                        		                                                                }
                                                                                                ?>
                                                                                                
                                                                                                <a href="med2.php?mod=absensisiswa&act=siswa_detail&idj=<?php echo $k['id'] ?>&idk=all">
                                                                                                <div class="col-md-4">
                                                                                                  <div class="card-counter inverse">
                                                                                                    <i class="fa fa-cloud-upload"></i>
                                                                                                    <span class="count-numbers">Detail Absensi</span>
                                                                                                    <span class="count-name">Rekap seluruh absensi</span>
                                                                                                  </div>
                                                                                                </div>
                                                                                                </a>
                                                                                            </div>
			                                                                            	<?php //echo $k['id'] ?>
			                                                                                
			                                                                            </div>

			                                                                        </div>
			                                                                   <?php
			                                                                 $a++; 
			                                                                }
			                                                            ?>
			                                                        </div>
			                                                    </div>
			                                                </section>
			                                            </div>
			                                        </div>
			                                    </div> 
			                                   <?php
			                                
			                                 $u++;  
			                                }
			                            ?>
			                            
			                        </div>
		                        <!--collapse end-->
		                    </div>
		                </div>

           			</div>
		        
			<?php
		break;
		case 'siswa_detail':
            
            $idj = $_GET['idj'];
            $idk = $_GET['idk'];
            if($idk == "all"){
                $wh="";
            }else{
                $wh=" AND a.`kehadiran` = '$idk'";
            }
            
            $queryx = "SELECT * FROM siswa WHERE `id`='$_SESSION[login_id]'";
            $sqlx = mysqli_query($conn,$queryx);    
            $qkls = mysqli_fetch_assoc($sqlx);
            $sqlj = mysqli_query($conn,"SELECT * FROM jenisabsensi WHERE id='$idj'");
            $js = mysqli_fetch_assoc($sqlj);
            ?>
            <div class="row">

                    <div class="clearfix">
            
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Data Absensi Santri <b><?php echo $qkls['nama'] ?></b>  <?php echo $js['nama'] ?> 
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
                                    <table class="table table-striped table-hover table-bordered" id="example1">
                                        <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $query = "SELECT DISTINCT c.`id`,b.`nis`,b.`nama`, c.`kelas`, a.`id_jenisabsensi`,k.`kehadiran`, a.`date` 
                                                        FROM `absensi_siswa` as a
                                                        JOIN `siswa` as b ON a.`nis` = b.`nis`
                                                        JOIN `kelas` as c ON b.`idkelas` = c.`id`
                                                        JOIN `kehadiran` as k ON a.`kehadiran` = k.`id`
                                                        WHERE a.`id_jenisabsensi`='$idj' AND b.`id` = '$_SESSION[login_id]' $wh
                                                        ORDER BY a.`date` DESC";
                                            $sql_kul = mysqli_query($conn,$query);  
                                            $i=1;
                                            while ($m = mysqli_fetch_assoc($sql_kul)) {
                                        ?>
                                        <tr class="">
                                            <td align="center"><?php echo $i ?></td>
                                            <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
                                            <td align="center"><?php echo tglindo($m['date']) ?></td>
                                            <td align="center"><?php echo $m['kehadiran']?></td>
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
              </div>
            <?php
        break;
        case 'detail_kelas':
            
            $idj = $_GET['idjenis'];
            $sqlj = mysqli_query($conn,"SELECT * FROM jenisabsensi WHERE id='$idj'");
            $k = mysqli_fetch_assoc($sqlj);
            ?>
            <div class="row">

                    <div class="clearfix">
            
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Data Delain Absensi <b><?php echo $k['nama'] ?> </b>  
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
                                    <table class="table table-striped table-hover table-bordered" id="example1">
                                        <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Kelas</th>
                                            <?php
                                            $qk = "SELECT * FROM kehadiran order by urutan asc";
                                            $sqlk = mysqli_query($conn,$qk);
                                            while ($kh = mysqli_fetch_assoc($sqlk)) {
                                            ?>
                                            <th class="text-center"><?php echo $kh['kehadiran']?></th>
                                            <?php
                                            }
                                            ?>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $qp = "SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`
											FROM `kelas` as a
											JOIN `pegawai` as b on a.nipwali = b.nip
											JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
											WHERE c.aktif = 'Aktif'
											ORDER BY a.`kelas`,a.`tingkat`
                                                ";
											$sqlp = mysqli_query($conn,$qp);	
											$i=1;
											while ($p = mysqli_fetch_assoc($sqlp)) {
											    $query = "SELECT c.`id`, c.`kelas`, a.`id_jenisabsensi`, a.`date` 
                                                FROM `absensi_siswa` as a
                                                JOIN `siswa` as b ON a.`nis` = b.`nis`
                                                JOIN `kelas` as c ON b.`idkelas` = c.`id`
                                                WHERE a.`date`= CURDATE() AND a.`id_jenisabsensi`='$k[id]' AND c.`id` = '$p[id]'
                                                GROUP BY c.`id` ORDER BY c.`kelas`,c.`tingkat`";
                                                $sql_kul = mysqli_query($conn,$query);  
			                                    $m = mysqli_fetch_assoc($sql_kul);
                                        ?>
                                        <tr class="">
                                            <td align="center"><?php echo $i ?></td>
                                            <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
                                            <td align="center"><?php echo $p['kelas']?></td>
                                             <?php
                                             $x=1;
                                            $qk = "SELECT * FROM kehadiran order by urutan asc";
                                            $sqlk = mysqli_query($conn,$qk);
                                            while ($kh = mysqli_fetch_assoc($sqlk)) {
                                                $sql[$x] = "SELECT COUNT(a.`kehadiran`) as kehadiran
                                                        FROM `absensi_siswa` as a
                                                        JOIN `siswa` as b ON a.`nis` = b.`nis`
                                                        JOIN `kelas` as c ON b.`idkelas` = c.`id` 
                                                        WHERE `kehadiran` =  '$kh[id]' AND a.`date`= CURDATE() AND c.`id` = '$m[id]' AND a.`id_jenisabsensi`='$k[id]'";
                                                $hasil[$x]= mysqli_query($conn,$sql[$x]);   
                                                $absen[$x] = mysqli_fetch_assoc($hasil[$x]);
                                            ?>
                                            <td align="center"><?php echo $absen[$x]['kehadiran']?></td>
                                            <?php
                                            $x++; }
                                            ?>
                                            <td align="center">
                                               <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>    
                                               <a href="<?php echo $aksi ?>?mod=absensisiswa&act=hapus&id=<?php echo $m['id'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>                        
                                           --> 
                                                <?php
                                                if($m['date']==""){
                                                ?>
                                                <button class="btn btn-danger btn-sm">Belum Input Absensi</button> 
                                                <?php
                                                }else{
                                                ?>
                                                <a href="<?php echo $linkaksi ?>&act=detail&id=<?php echo $m['id'] ?>&tgl=<?php echo $m['date']?>&idjs=<?php echo $m['id_jenisabsensi'] ?>" ><button class="btn btn-info btn-sm"><i class="fa fa-search"></i></button> </a>
                                                <a href="<?php echo $linkaksi ?>&act=edit&id=<?php echo $m['id'] ?>&tgl=<?php echo $m['date']?>&idjs=<?php echo $m['id_jenisabsensi'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
                                                
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
                        </section>
                    </div>
                </div>
              </div>
            <?php
        break;
	}   

	}
?>
<script>
function showUser(str) {
  var xhttp;    
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("txtHint").innerHTML = this.responseText;
    }
  };
  var district = document.getElementById('js');
    var js = district.value;
  xhttp.open("GET", "mod/absensi/getkelas.php?q="+str+"&js="+js, true);
  xhttp.send();
}
</script>
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

