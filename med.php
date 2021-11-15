<?php
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

<body>

<?php date_default_timezone_set('Asia/Jakarta'); ?>
<section id="container" >
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">

    <a href="med.php?mod=home" class="logo">
        <img class="img-responsive" src="images/logo.png" alt="">
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->

<!--<div class="nav notify-row" id="top_menu">
    
    <ul class="nav top-menu">
       
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-tasks"></i>
                <span class="badge bg-success">8</span>
            </a>
            <ul class="dropdown-menu extended tasks-bar">
                <li>
                    <p class="">You have 8 pending tasks</p>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Target Sell</h5>
                                <p>25% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="45">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Product Delivery</h5>
                                <p>45% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="78">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Payment collection</h5>
                                <p>87% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="60">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Target Sell</h5>
                                <p>33% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="90">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>

                <li class="external">
                    <a href="#">See All Tasks</a>
                </li>
            </ul>
        </li>
        
        <li id="header_inbox_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-envelope-o"></i>
                <span class="badge bg-important">4</span>
            </a>
            <ul class="dropdown-menu extended inbox">
                <li>
                    <p class="red">You have 4 Mails</p>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="images/avatar-mini.jpg"></span>
                                <span class="subject">
                                <span class="from">Jonathan Smith</span>
                                <span class="time">Just now</span>
                                </span>
                                <span class="message">
                                    Hello, this is an example msg.
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="images/avatar-mini-2.jpg"></span>
                                <span class="subject">
                                <span class="from">Jane Doe</span>
                                <span class="time">2 min ago</span>
                                </span>
                                <span class="message">
                                    Nice admin template
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="images/avatar-mini-3.jpg"></span>
                                <span class="subject">
                                <span class="from">Tasi sam</span>
                                <span class="time">2 days ago</span>
                                </span>
                                <span class="message">
                                    This is an example msg.
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="images/avatar-mini.jpg"></span>
                                <span class="subject">
                                <span class="from">Mr. Perfect</span>
                                <span class="time">2 hour ago</span>
                                </span>
                                <span class="message">
                                    Hi there, its a test
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">See all messages</a>
                </li>
            </ul>
        </li>
        
        <li id="header_notification_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                <i class="fa fa-bell-o"></i>
                <span class="badge bg-warning">3</span>
            </a>
            <ul class="dropdown-menu extended notification">
                <li>
                    <p>Notifications</p>
                </li>
                <li>
                    <div class="alert alert-info clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #1 overloaded.</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="alert alert-danger clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #2 overloaded.</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="alert alert-success clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #3 overloaded.</a>
                        </div>
                    </div>
                </li>

            </ul>
        </li>
        
    </ul>
</div>-->
<div class="top-nav clearfix">
    <!--search & user info start-->
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
            <ul class="dropdown-menu extended logout">
                <!--<li><a href="#"><i class=" fa fa-user"></i>Profile</a></li>
                <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>-->
                <li><a href="logout.php"><i class="fa fa-key"></i> Log Out</a></li>
            </ul>
        </li>
        <!--<li>
            <div class="toggle-right-box">
                <div class="fa fa-bars"></div>
            </div>
        </li>-->
        <!-- user login dropdown end -->
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<aside class="position-fixed">
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->            <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a href="index.php">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <?php
                if ($_SESSION['level']=='perpustakaan') {
                ?>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-folder"></i>
                        <span>Perpustakaan</span>
                    </a>
                    <ul class="sub">
                        <li><a href="med.php?mod=kategori_buku">Kategori Buku</a></li>
                        <li><a href="med.php?mod=sumber_buku">Sumber Buku</a></li>
                        <li><a href="med.php?mod=rak_buku">Rak Buku</a></li>
                        <li><a href="med.php?mod=buku">Buku</a></li>
                        <li><a href="med.php?mod=peminjaman">Data Peminjaman</a></li>
                        <li><a href="med.php?mod=pengembalian">Data Pengembalian</a></li>
                        <li><a href="med.php?mod=kas">Kas</a></li>
                    </ul>
                </li>
                <?php
                }elseif($_SESSION['level']=='admin' OR $_SESSION['level']=='superadmin'){
                ?>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-cog"></i>
                        <span>Reverensi</span>
                    </a>
                    <ul class="sub">
                        <li><a href="med.php?mod=pekerjaan">Pekerjaan</a></li>
                        <li><a href="med.php?mod=pendidikan">Pendidikan</a></li>
                        <li><a href="med.php?mod=statusiswa">Status Santri</a></li>
                        <li><a href="med.php?mod=statusguru">Status Pengajar</a></li>
                        <li><a href="med.php?mod=kondisisiswa">Kondisi Santri</a></li>
                        <li><a href="med.php?mod=pegawai">Data Pegawai</a></li>
                        <li><a href="med.php?mod=semester">Semester</a></li>
                        <li><a href="med.php?mod=kehadiran">Kehadiran</a></li>
                        <li><a href="med.php?mod=absensi">Jenis Absensi</a></li>
                        <li><a href="med.php?mod=jenisabsensi">Sub Jenis Absensi</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-bookmark"></i>
                        <span>Data Master</span>
                    </a>
                    <ul class="sub">
                        <li><a href="med.php?mod=tahunajaran">Tahun Ajaran</a></li>
                        <li><a href="med.php?mod=guru">Data Pengajar</a></li>
                        <li><a href="med.php?mod=kelas">Data Kelas</a></li>
                        <li><a href="med.php?mod=siswa">Data Santri</a></li>
                        <li><a href="med.php?mod=user">Data User</a></li>
                        <li><a href="med.php?mod=libur">Periode Libur</a></li>
                        <li><a href="med.php?mod=naikkelas">Pindah Kelas</a></li>
                        <li><a href="med.php?mod=naikkelas2">Naik Kelas</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-clock-o"></i>
                        <span>Absensi</span>
                    </a>
                    <ul class="sub">
                        <li><a href="med.php?mod=absensisiswa">Santri</a></li>
                        <li><a href="med.php?mod=absensiguru">Pengajar</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-list-alt"></i>
                        <span>Nilai</span>
                    </a>
                    <ul class="sub">
                        <!--<li><a href="med.php?mod=kelompok">Aspek Kelompok</a></li>
                        <li><a href="med.php?mod=aspekpenilaian">Aspek Penilaian</a></li>
                    
                        <li><a href="med.php?mod=nilairaportb">Nilai Raport</a></li>
                        <li><a href="med.php?mod=jenispengujian">Jenis Pengujian</a></li>
                        <li><a href="med.php?mod=perhitungan_nilai">Perhitungan Nilai</a></li>
                        <li><a href="med.php?mod=pengembangan_prestasi">Nilai Bulanan</a></li>
                        <li><a href="med.php?mod=standart">Nilai Standar Naik Kelas</a></li>
                        <li><a href="med.php?mod=pembagiannama">Pembagian Nama</a></li>
                        <li><a href="med.php?mod=program">Program Pembelajaran</a></li>
                        -->
                        <li><a href="med.php?mod=kelompok">Aspek Kelompok</a></li>
                        <li><a href="med.php?mod=pelajaran">Mata Pelajaran</a></li>
                        <li><a href="med.php?mod=nilaitamrin">Input Nilai</a></li>
                        <li><a href="med.php?mod=nilairaport">Nilai Raport</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-folder"></i>
                        <span>Perpustakaan</span>
                    </a>
                    <ul class="sub">
                        <li><a href="med.php?mod=kategori_buku">Kategori Buku</a></li>
                        <li><a href="med.php?mod=sumber_buku">Sumber Buku</a></li>
                        <li><a href="med.php?mod=rak_buku">Rak Buku</a></li>
                        <li><a href="med.php?mod=buku">Buku</a></li>
                        <li><a href="med.php?mod=peminjaman">Data Peminjaman</a></li>
                        <li><a href="med.php?mod=pengembalian">Data Pengembalian</a></li>
                        <li><a href="med.php?mod=kas">Kas</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-money"></i>
                        <span>Keuangan</span>
                    </a>
                    <ul class="sub">
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-circle"></i>
                                <span>SPP MADRASAH</span>
                            </a>
                            <ul class="sub">
                                <li><a href="med.php?mod=spp">Pembayaran SPP MADRASAH</a></li>
                                <li><a href="med.php?mod=laporan">Laporan SPP MADRASAH</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-circle"></i>
                                <span>SPP MAHAD</span>
                            </a>
                            <ul class="sub">
                                <li><a href="med.php?mod=kemaarifan">Pembayaran SPP MAHAD</a></li>
                                <li><a href="med.php?mod=laporankemaarifan">Laporan SPP MAHAD</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-circle"></i>
                                <span>Pendaftaran</span>
                            </a>
                            <ul class="sub">
                                <li><a href="med.php?mod=jenispembayaran">Jenis Pembayaran</a></li>
                                <li><a href="med.php?mod=pembayaran">Data Pembayaran</a></li>
                                <li><a href="med.php?mod=transaksi">Transaksi Pendaftaran</a></li>
                                <li><a href="med.php?mod=pendaftaran">Data Transaksi</a></li>
                                <li><a href="med.php?mod=laporanpendaftaran">Laporan Pendaftaran</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-clock-o"></i>
                        <span>Histori</span>
                    </a>
                    <ul class="sub">
                        <li><a href="med.php?mod=historinilairaport">Nilai Raport</a></li>
                        <li><a href="med.php?mod=historipembayaran">Data Pembayaran</a></li>
                    </ul>
                </li>
                <li>
                    <a href="med.php?mod=laporan_user">
                        <i class="fa fa-list-alt"></i>
                        <span>Laporan User</span>
                    </a>
                </li>
                <li>
                    <a href="med.php?mod=userakun&act=admin">
                    <i class="fa fa-user"></i>
                        <span>Setting Akun</span>
                    </a>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>        
<!-- sidebar menu end-->
    </div>
</aside>
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
      $("#month").datepicker( {
        format: "mm-yyyy",
        startView: "months", 
        minViewMode: "months"
    });
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
    $('#examplea').DataTable();
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
} );
</script>
<script type="text/javascript">
    $(document).ready(function(){

        // Format mata uang.
        $( '.uang' ).mask('000.000.000', {reverse: true});

    });
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
