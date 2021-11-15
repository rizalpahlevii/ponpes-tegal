<?PHP
    date_default_timezone_set('Asia/Jakarta');
    include"session.php";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.ico">

    <title><?php include 'title_adm.php' ; ?></title>

    <!--Core CSS -->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />

    <link rel="stylesheet" href="css/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datetimepicker/css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-multi-select/css/multi-select.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-tags-input/jquery.tagsinput.css" />

    <link rel="stylesheet" type="text/css" href="js/select2/select2.css" />
    <link href="js/jvector-map/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <link href="css/clndr.css" rel="stylesheet">
    <!--clock css-->
    <link href="js/css3clock/css/style.css" rel="stylesheet">
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="js/morris-chart/morris.css">
    <!--dynamic table-->
    <link href="js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <!-- DataTables -->
    <link rel="stylesheet" href="css/datatables/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="css/datatables/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="css/datatables/buttons.dataTables.min.css">

    <link rel="stylesheet" href="css/jquery.steps.css?1">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    <!--color
    <link href="css/green-theme.css" rel="stylesheet" />
    -->
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
            .autocomplete {
          position: relative;
          display: inline-block;
        }

        .autocomplete-items {
          position: absolute;
          border: 1px solid #d4d4d4;
          border-bottom: none;
          border-top: none;
          z-index: 99;
          /*position the autocomplete items to be the same width as the container:*/
          top: 100%;
          left: 0;
          right: 0;
        }

        .autocomplete-items div {
          padding: 10px;
          cursor: pointer;
          background-color: #fff; 
          border-bottom: 1px solid #d4d4d4; 
        }

        /*when hovering an item:*/
        .autocomplete-items div:hover {
          background-color: #e9e9e9; 
        }

        /*when navigating through the items using the arrow keys:*/
        .autocomplete-active {
          background-color: DodgerBlue !important; 
          color: #ffffff; 
        }
        .card-counter{
            box-shadow: 2px 2px 10px #DADADA;
            margin: 5px;
            padding: 20px 10px;
            background-color: #fff;
            height: 100px;
            border-radius: 5px;
            transition: .3s linear all;
          }
        
          .card-counter:hover{
            box-shadow: 4px 4px 20px #344860;
            transition: .3s linear all;
          }
        
          .card-counter.primary{
            background-color: #007bff;
            color: #FFF;
          }
          .card-counter.warning{
            background-color: #f3c022;
            color: #FFF;
          }
        
          .card-counter.danger{
            background-color: #ef5350;
            color: #FFF;
          }  
        
          .card-counter.success{
            background-color: #66bb6a;
            color: #FFF;
          }  
        
          .card-counter.info{
            background-color: #26c6da;
            color: #FFF;
          }  
          .card-counter.inverse{
            background-color: #8175c7;
            color: #FFF;
          }  
        
          .card-counter i{
            font-size: 5em;
            opacity: 0.2;
          }
        
          .card-counter .count-numbers{
            position: absolute;
            right: 35px;
            top: 20px;
            font-size: 32px;
            display: block;
          }
        
          .card-counter .count-name{
            position: absolute;
            right: 35px;
            top: 65px;
            font-style: italic;
            text-transform: capitalize;
            opacity: 0.5;
            display: block;
            font-size: 18px;
          }
        
          </style>
</head>

<body class="full-width">

<?php date_default_timezone_set('Asia/Jakarta'); ?>
<section id="container" class="hr-menu" >
<!--header start-->
<header class="header fixed-top">
          <div class="navbar-header">
              <button type="button" class="navbar-toggle hr-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                  <span class="fa fa-bars"></span>
              </button>

              
            <?php
              if ($_SESSION['level']=='siswa' or $_SESSION['level']=='ortu' ) {
                $mw = "siswa"; 
                $id = $_SESSION['login_id'];
              }else{     
                $mw = "pegawai";   
                $id = $nip_session;
              }
              ?>
              <!--logo start-->
              <!--logo start-->
              <div class="brand ">
                  <?php
                  if ($_SESSION['level']=='ortu' or $_SESSION['level']=='siswa') {
                  ?> 
                  <a href="med2.php?mod=<?php echo $mw ?>&act=detail&id=<?php echo $id ?>" class="logo">
                      <img align="center" src="images/logo.png" alt="">
                  </a>
                  
                  <?php
                  }else{
                  ?> 
                  <a href="med2.php?mod=home" class="logo">
                      <img align="center" src="images/logo.png" alt="">
                  </a>
                  <?php   
                  }
                  ?>
                  
              </div>
              <!--logo end-->
              <!--logo end-->
              <div class="horizontal-menu navbar-collapse collapse ">
                  <ul class="nav navbar-nav">
                      <?php
                      if ($_SESSION['level']=='ortu' or $_SESSION['level']=='siswa') {
                      ?> 
                      
                      <li><a href="med2.php?mod=<?php echo $mw ?>&act=detail&id=<?php echo $id ?>">Dashboard</a></li>
                      <?php
                      }else{
                      ?> 
                      <li><a href="med2.php?mod=home">Dashboard</a></li>
                      <?php   
                      }
                      ?>
                      
                      <?php
                      if ($_SESSION['level']=='pendaftaran') {
                      ?>                   
                          <li><a href="med2.php?mod=siswa">Pendaftaran Santri</a></li> 
                          <li class="dropdown">
                          <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Pembayaran <b class=" fa fa-angle-down"></b></a>
                              <ul class="dropdown-menu">                                       
                                
                                <li><a href="med2.php?mod=pembayaran">Data Pembayaran</a></li>
                                <li><a href="med2.php?mod=transaksi">Transaksi Pendaftaran</a></li>
                                <li><a href="med2.php?mod=pendaftaran">Data Transaksi</a></li>
                                <li><a href="med2.php?mod=laporanpendaftaran">Laporan Pendaftaran</a></li>
                              </ul>
                          </li>        
                      <?php
                      }
                      ?>
                      <!--<?php
                        if ($_SESSION['level']=='guru') {
                            $query2 = mysqli_query($conn, "SELECT * FROM guru WHERE nip='$_SESSION[id_user]'");
                            $rows2 = mysqli_num_rows($query2);
                            $a2 = mysqli_fetch_assoc($query2);
                        ?>
                          <li class="dropdown">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Penilaian <b class=" fa fa-angle-down"></b></a>
                            <ul class="dropdown-menu">                        
                              <li><a href="med2.php?mod=program">Program Pembelajaran (KD)</a></li>                   
                              <li><a href="med2.php?mod=perhitungan_nilai&act=detail&nipguru=<?php echo $a2['id'] ?>&idpelajaran=<?php echo $a2['idpelajaran'] ?>">Perhitungan Nilai</a></li>       
                              <li><a href="med2.php?mod=nilai&act=addguru&id=<?php echo $a2['id'] ?>">Input Nilai</a></li>   
                              <li><a href="med2.php?mod=nilai&act=addguru&id=<?php echo $a2['nip'] ?>&aks=raport">Perhitungan Nilai Raport</a></li>                                 
                            </ul>
                          </li>
                        <?php
                        }
                        ?>-->
                      <?php
                        if ($_SESSION['level']=='siswa' or $_SESSION['level']=='ortu') {
                            $query2 = mysqli_query($conn, "SELECT * FROM guru WHERE nip='$_SESSION[id_user]'");
                            $rows2 = mysqli_num_rows($query2);
                            $a2 = mysqli_fetch_assoc($query2);
                        ?>
                          <!--<li class="dropdown">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Nilai Raport <b class=" fa fa-angle-down"></b></a>
                            <ul class="dropdown-menu">                        
                              <?php
                                 $queryp = mysqli_query($conn,"SELECT * FROM semester where aktif='Aktif'");
                                  
                                  while($p = mysqli_fetch_assoc($queryp)){
                                ?>
                                  <li><a href="med2.php?mod=nilai&id=<?php echo $p['id']?>"><?php echo $p['semester'] ?></a></li>
                                <?php
                                }
                                ?>                               
                            </ul>
                          </li>-->
                        <?php
                        }
                        ?>
                        <?php
                      if ($_SESSION['level']=='ortu' OR $_SESSION['level']=='siswa') {
                      ?> 
                      
                      <li><a href="med2.php?mod=absensisiswa&act=siswa">Absensi</a></li>
                      <?php
                      }
                      ?> 
                      <?php
                      if ($_SESSION['level']=='absensi sp' OR $_SESSION['level']=='absensi ibt' OR $_SESSION['level']=='absensi ts' OR $_SESSION['level']=='absensi aly' OR $_SESSION['level']=='absensi sorogan') {
                      ?>                   
                          <li><a href="med2.php?mod=siswa">Data Santri</a></li>                            
                          <li><a href="med2.php?mod=absensisiswa">Absensi Santri</a></li>
                      <?php
                      }
                      ?>
                      <?php
                      if ($_SESSION['level']=='absensi pengajar' ) {
                      ?>                                               
                          <li><a href="med2.php?mod=absensiguru">Absensi Pengajar</a></li>
                      <?php
                      }
                      ?>
                      <?php
                      if ($_SESSION['level']=='absensi sp' OR $_SESSION['level']=='nilai ibt' OR $_SESSION['level']=='nilai ts' OR $_SESSION['level']=='nilai aly' OR $_SESSION['level']=='absensi ibt' OR $_SESSION['level']=='absensi ts' OR $_SESSION['level']=='absensi aly') {
                      ?>                     
                          <li><a href="med2.php?mod=nilaitamrin&act=addguru">Nilai</a></li>
                            <li><a href="med2.php?mod=nilairaport&act=addguru">Nilai Raport</a></li>
                            <li><a href="med2.php?mod=naikkelas">Pindah Kelas</a></li>
                            <li><a href="med2.php?mod=naikkelas2">Naik Kelas</a></li>
                      <?php
                      }
                      ?>
                      <?php
                      if ($_SESSION['level']=='nilai bulanan' OR $_SESSION['level']=='nilai' ) {
                      ?>                                               
                          <li><a href="med2.php?mod=nilaitamrin&act=addguru">Nilai</a></li>
                      <?php
                      }
                      ?>
                      <?php
                      if ($_SESSION['level']=='guru') {
                       ?>                       
                          <li class="dropdown">
                          <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Raport <b class=" fa fa-angle-down"></b></a>
                              <ul class="dropdown-menu">                                        
                                <li><a href="med2.php?mod=nilairaport&act=addguru">Nilai Raport</a></li>
                                <li><a href="med2.php?mod=pembagiannama">Pembagian Nama</a></li>
                              </ul>
                          </li>
                          <li><a href="med2.php?mod=pengembangan_prestasi">Nilai Bulanan</a></li>
                      <?php
                      }elseif ($_SESSION['level']=='siswa' or $_SESSION['level']=='ortu') {
                      ?>
                      <li class="dropdown">
                          <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Nilai <b class=" fa fa-angle-down"></b></a>
                          <ul class="dropdown-menu">
                            <?php
                              $query2 = mysqli_query($conn, "SELECT s.`nis`, k.`id` as idkelas, t.`id` as idtahunajaran
                                                        FROM siswa as s 
                                                        left join kelas k on s.idkelas = k.id
                                                        left join tahunajaran t on t.id = k.idtahunajaran
                                                        where nis='$_SESSION[id_user]'");
                              $a2 = mysqli_fetch_assoc($query2);
                             $queryp = mysqli_query($conn,"SELECT * FROM semester where aktif='Aktif'");
                              
                              while($p = mysqli_fetch_assoc($queryp)){
                            ?>
                              <li><a href="med2.php?mod=nilaitamrin&act=detailsiswa&semester=<?php echo $p['id']?>"><?php echo $p['semester'] ?></a></li>
                            <?php
                            }
                            ?>
                          </ul>
                      </li>
                      <li class="dropdown">
                          <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Raport <b class=" fa fa-angle-down"></b></a>
                          <ul class="dropdown-menu">
                            <?php
                              $query2 = mysqli_query($conn, "SELECT s.`nis`, k.`id` as idkelas, t.`id` as idtahunajaran
                                                        FROM siswa as s 
                                                        left join kelas k on s.idkelas = k.id
                                                        left join tahunajaran t on t.id = k.idtahunajaran
                                                        where nis='$_SESSION[id_user]'");
                              $a2 = mysqli_fetch_assoc($query2);
                             $queryp = mysqli_query($conn,"SELECT * FROM semester where aktif='Aktif'");
                              
                              while($p = mysqli_fetch_assoc($queryp)){
                            ?>
                              <li><a href="med2.php?mod=nilairaport&act=form&idsemester=<?php echo $p['id']?>&idkelas=<?php echo $a2['idkelas']?>&idtahunajaran=<?php echo $a2['idtahunajaran']?>&nis=<?php echo $_SESSION['id_user'] ?>"><?php echo $p['semester'] ?></a></li>
                            <?php
                            }
                            ?>
                          </ul>
                      </li>
                      <?php
                      }
                      ?>                       
                         <?php
                        if ($_SESSION['level']=='siswa' or $_SESSION['level']=='ortu') {
                        ?>                         
                        <li class="dropdown">
                          <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">SPP <b class=" fa fa-angle-down"></b></a>
                              <ul class="dropdown-menu">  
                              <li><a href="med2.php?mod=laporankemaarifan&act=aksi">Laporan SPP MAHAD
                                    <?php
                                    $sqln= mysqli_query($conn,"SELECT b.`nis`, (SELECT COUNT(DISTINCT `bulanke`) FROM `spp`) as bln, COUNT(a.`nis`),((SELECT COUNT(DISTINCT `bulanke`) FROM `spp`) - COUNT(a.`nis`)) as notif
                                      FROM `kemaarifan` as a
                                      RIGHT JOIN `siswa` as b on a.`nis` = b.`nis`
                                      WHERE b.`nis` = '$_SESSION[login_user]'
                                      group by b.`nis` ");
                                    $notif = mysqli_fetch_assoc($sqln);
                                    if($notif['notif']!=='0'){
                                    ?>
                                    <!--<span class="badge bg-important"><i class="fa fa-bell"></i> <?php echo $notif['notif'] ?></span>      -->         
                                    <?php
                                    }                          
                                    ?>
                                    </a> 
                                </li>
                                <li><a href="med2.php?mod=laporan&act=aksi">Laporan SPP MADRASAH
                                    <?php
                                    $sqln= mysqli_query($conn,"SELECT b.`nis`, (SELECT COUNT(DISTINCT `bulanke`) FROM `spp`) as bln, COUNT(a.`nis`),((SELECT COUNT(DISTINCT `bulanke`) FROM `spp`) - COUNT(a.`nis`)) as notif
                                      FROM `spp`as a
                                      RIGHT JOIN `siswa` as b on a.`nis` = b.`nis`
                                      WHERE b.`nis` = '$_SESSION[login_user]'
                                      group by b.`nis` ");
                                    $notif = mysqli_fetch_assoc($sqln);
                                    if($notif['notif']!=='0'){
                                    ?>
                                   <!-- <span class="badge bg-important"><i class="fa fa-bell"></i> <?php echo $notif['notif'] ?></span>     -->          
                                    <?php
                                    }                          
                                    ?>
                                    </a> 
                                  </li>
                                  
                                  
                              </ul>
                          </li> 
                          <?php
                          $query2 = mysqli_query($conn, "SELECT s.`nis`, k.`id` as idkelas, t.`id` as idtahunajaran
                                                FROM siswa as s 
                                                left join kelas k on s.idkelas = k.id
                                                left join tahunajaran t on t.id = k.idtahunajaran
                                                where nis='$_SESSION[id_user]'");
                          $a2 = mysqli_fetch_assoc($query2);
                          ?>
                        <li><a href="med2.php?mod=transaksi&act=form&idtahunajaran=<?php echo $a2['idtahunajaran']?>&nis=<?php echo $_SESSION['id_user'] ?>">Pendaftaran</a></li>

                        <?php         
                        }
                        ?>
                        <?php
                        if ($_SESSION['level']=='keuangan mahad') {
                        ?>
                          <li class="dropdown">
                          <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">SPP MAHAD <b class=" fa fa-angle-down"></b></a>
                              <ul class="dropdown-menu">                                        
                                <li><a href="med2.php?mod=kemaarifan">Pembayaran SPP MAHAD</a></li>
                                <li><a href="med2.php?mod=laporankemaarifan">Laporan SPP MAHAD</a></li>
                              </ul>
                          </li>
                        <?php
                        }
                        ?>
                       <?php
                        if ($_SESSION['level']=='keuangan madrasah' ) {
                        ?>                
                          <!--<li><a href="med2.php?mod=siswa">Pendaftaran Santri</a></li>-->
                          <li class="dropdown">
                          <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">SPP MADRASAH <b class=" fa fa-angle-down"></b></a>
                              <ul class="dropdown-menu">                                        
                                <li><a href="med2.php?mod=spp">Pembayaran SPP MADRASAH</a></li>
                                <li><a href="med2.php?mod=laporan">Laporan SPP MADRASAH</a></li>
                              </ul>
                          </li>
                         <?php         
                        }
                        ?>
                        <?php
                        if ($_SESSION['level']=='keuangan' OR $_SESSION['level']=='keuangan mahad' OR $_SESSION['level']=='keuangan madrasah' OR $_SESSION['level']=='keuangan kemaarifan') {
                        ?>  
                          <li class="dropdown">
                          <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Pembayaran <b class=" fa fa-angle-down"></b></a>
                              <ul class="dropdown-menu">                                       
                                
                                <li><a href="med2.php?mod=jenispembayaran">Jenis Pembayaran</a></li>
                                <li><a href="med2.php?mod=pembayaran">Data Pembayaran</a></li>
                                <li><a href="med2.php?mod=transaksi">Transaksi Pendaftaran</a></li>
                                <li><a href="med2.php?mod=pendaftaran">Data Transaksi</a></li>
                                <li><a href="med2.php?mod=laporanpendaftaran">Laporan Pendaftaran</a></li>
                              </ul>
                          </li>          
                        <?php         
                        }
                        ?>
                        <!--
                        <?php
                        if ($_SESSION['level']=='guru' or $_SESSION['level']=='siswa') {
                        ?>
                        
                        <li class="dropdown">
                          <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">E-learning <b class=" fa fa-angle-down"></b></a>
                          <ul class="dropdown-menu">
                            <li><a href="med2.php?mod=materi">Materi</a></li>                            
                            <li><a href="med2.php?mod=quiz">Quiz</a></li>                            
                          </ul>
                        </li>
                        <?php
                      }
                        ?>
                        <?php
                        if ($_SESSION['level']=='ortu') {
                        ?>   
                        <li><a href="med2.php?mod=kejadian_siswa&act=detail&id=<?php echo $_SESSION['id_user'] ?>">BK</a></li>
                        <?php
                      }
                        ?> -->
                  </ul>

              </div>
              <div class="top-nav hr-top-nav">
                  <ul class="nav pull-right top-menu">
                      <li>
                          <input type="text" class="form-control search" placeholder=" Search">
                      </li>
                      <!-- user login dropdown start-->
                      <li class="dropdown">
                          <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                              <img alt="" src="images/users.png">
                              <span class="username"><?php echo $login_session ?></span>
                              <b class="caret"></b>
                          </a>
                          <?php
                          if ($_SESSION['level']=='keuangan') {
                          ?>                          
                          <ul class="dropdown-menu extended logout">
                              <li><a href="logout.php"><i class="fa fa-sign-out"></i> Log Out</a></li>
                          </ul>
                          <?php
                          }else{
                          ?>
                          <ul class="dropdown-menu extended logout">
                            
                            <li><a href="med2.php?mod=<?php echo $mw ?>&act=detail&id=<?php echo $id ?>"><i class=" fa fa-suitcase"></i>Profile</a></li>
                              <li><a href="med2.php?mod=<?php echo $mw ?>&act=form&id=<?php echo $id ?>"><i class="fa fa-cog"></i> Settings</a></li>
                              <li><a href="logout.php"><i class="fa fa-key"></i> Log Out</a></li>
                          </ul>
                          <?php
                          }
                          ?>  
                      </li>
                      <!-- user login dropdown end -->
                  </ul>
              </div>

          </div>

      </header>
<!--header end-->

<!--sidebar end-->
    <!--main content start-->
            <!-- Main content -->
<section id="main-content">
    <section class="wrapper">
         <?php include"content.php"; ?>
    </section>
</section>
<!-- /.content -->
    <!--main content end-->
<!--right sidebar start-->
<div class="right-sidebar">
<div class="right-stat-bar">
<ul class="right-side-accordion">
<li class="widget-collapsible">
    <a href="#" class="head widget-head red-bg active clearfix">
        <span class="pull-left"><i class="fa fa-gears"></i> Pengaturan</span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="prog-row side-mini-stat clearfix">
                <div class="side-graph-info">
                    <h4>Target sell</h4>
                    <p>
                        25%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="target-sell">
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>
</ul>
</div>
</div>
<!--right sidebar end-->

</section>

<!-- Placed js at the end of the document so the pages load faster -->

<!--Core js-->
<script src="js/jquery-1.8.3.min.js"></script>
<script src="bs3/js/bootstrap.min.js"></script>
<script src="js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
<script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/easypiechart/jquery.easypiechart.js"></script>
<script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>

<script src="js/bootstrap-switch.js"></script>

<script type="text/javascript" src="js/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="js/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="js/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="js/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="js/jquery-multi-select/js/jquery.quicksearch.js"></script>


<script src="js/jquery-tags-input/jquery.tagsinput.js"></script>

<script src="js/select2/select2.js"></script>
<script src="js/select-init.js"></script>


<!--common script init for all pages-->
<script src="js/scripts.js"></script>

<script src="js/toggle-init.js"></script>

<script src="js/advanced-form.js"></script>

<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="js/skycons/skycons.js"></script>
<script src="js/jquery.scrollTo/jquery.scrollTo.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="js/calendar/clndr.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>
<script src="js/calendar/moment-2.2.1.js"></script>
<script src="js/evnt.calendar.init.js"></script>
<script src="js/jvector-map/jquery-jvectormap-1.2.2.min.js"></script>
<script src="js/jvector-map/jquery-jvectormap-us-lcc-en.js"></script>
<script src="js/gauge/gauge.js"></script>
<script src="js/jquery-steps/jquery.steps.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<!--clock init-->
<script src="js/css3clock/js/css3clock.js"></script>
<!--Easy Pie Chart-->
<script src="js/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="js/sparkline/jquery.sparkline.js"></script>
<!--Morris Chart-->
<script src="js/morris-chart/morris.js"></script>
<script src="js/morris-chart/raphael-min.js"></script>
<!--jQuery Flot Chart-->
<script src="js/flot-chart/jquery.flot.js"></script>
<script src="js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="js/flot-chart/jquery.flot.resize.js"></script>
<script src="js/flot-chart/jquery.flot.pie.resize.js"></script>
<script src="js/flot-chart/jquery.flot.animator.min.js"></script>
<script src="js/flot-chart/jquery.flot.growraf.js"></script>
<script src="js/jquery.customSelect.min.js" ></script>
<!-- DataTables -->
<script src="js/datatables/jquery.dataTables.min.js"></script>
<script src="js/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="js/datatables/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="js/datatables/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="js/datatables/buttons.flash.min.js"></script>
<script type="text/javascript" src="js/datatables/jszip.min.js"></script>
<script type="text/javascript" src="js/datatables/pdfmake.min.js"></script>
<script type="text/javascript" src="js/datatables/vfs_fonts.js"></script>
<script type="text/javascript" src="js/datatables/buttons.colVis.min.js"></script>

<script type="text/javascript" src="js/datatables/buttons.html5.min.js"></script>
<script type="text/javascript" src="js/datatables/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>
<script src="assets/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="assets/input-mask/jquery.inputmask.extensions.js"></script>
<script src="js/time.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2()
    });
    
</script>
<script>
    $(function ()
    {
        $("#wizard").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft"
        });

        $("#wizard-vertical").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            stepsOrientation: "vertical"
        });
    });


</script>
<script >
Inputmask.extendAliases({
  pesos: {
            prefix: "",
            groupSeparator: ".",
            alias: "numeric",
            placeholder: "0",
            autoGroup: !0,
            digits: 2,
            digitsOptional: !1,
            clearMaskOnLostFocus: !1
        }
});

$(document).ready(function(){
  
  $(".currency").inputmask({ alias : "currency", prefix: '' });
  $(".currency1").inputmask({ alias : "currency", prefix: '' });
  $(".currency2").inputmask({ alias : "currency", prefix: '' });
  $(".currency3").inputmask({ alias : "currency", prefix: '' });
  $(".currency4").inputmask({ alias : "pesos" });
  $(".time").inputmask("h:s",{ "placeholder": "hh/mm" });
  $(".time1").inputmask("h:s",{ "placeholder": "hh/mm" });

  
});
</script>
<script type="text/javascript">
    $(document).ready(function() {
    $('#exampleres').DataTable( {
        "scrollX": true
    } );
} );
</script>
<script type="text/javascript">
  $(function () {
    $('#examplea').DataTable()
    $('#exampleb').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
    $('#examplec').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
    $('#example1').DataTable( {
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
    $('#example2').DataTable( {
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
    $('#example3').DataTable( {
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
    $('#example4').DataTable( {
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
    $('#example5').DataTable( {
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
    $('#example6').DataTable( {
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
    $('#example7').DataTable( {
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
    $('#examplex').DataTable( {
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
    $('#tblall').DataTable( {
        
        dom: 'Bfrtip',
       'paging'      : false,
       'ordering'    : false,
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
                'colvis',
            {
                extend: 'collection',
                text: 'Export',
                buttons: [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: ':visible'
                    },footer: true
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible'
                    },footer: true
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible'
                    },footer: true
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    },footer: true
                }
                
            ]           
            }
        ]

    } );
    $('#tblex').DataTable( {
        
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
                'pageLength',
                'colvis',
            {
                extend: 'collection',
                text: 'Export',
                buttons: [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: ':visible'
                    },footer: true
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible'
                    },footer: true
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible'
                    },footer: true
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    },footer: true
                }
                
            ]           
            }
        ]

    } );
</script>

<script type="text/javascript">
    $(document).ready(function(){

        // Format mata uang.
        $( '.uang' ).mask('000.000.000', {reverse: true});

    })
</script>
<!--script for this page-->
<script type="text/javascript">
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);
</script>

</body>
</html>
