<?php
date_default_timezone_set('Asia/Jakarta');
    include"session.php";
    
    include"lib/fungsi_indotgl.php";
    include"lib/all_function.php";
    include"lib/fungsi_terbilang.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">

    <title>Modal</title>

    <!--Core CSS -->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />

    <link rel="stylesheet" href="css/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datetimepicker/css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-multi-select/css/multi-select.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery-tags-input/jquery.tagsinput.css" />

    <link rel="stylesheet" type="text/css" href="js/select2/select2.css" />

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />


    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<section id="container" >
<?php
    //link buat paging
    $linkaksi = 'modal.php';

    if(isset($_GET['act']))
    {
        $act = $_GET['act'];
        $linkaksi .= '&act='.$act;
    }
    else
    {
        $act = '';
    }

    $aksi = 'act_modal.php';
    switch ($act) {
    case 'tambahpenilaian':
            if(!empty($_GET['id']))
                {
                    $act = "$aksi?act=edit";
                    $query = mysqli_query($conn,"SELECT * FROM ujian WHERE id = '$_GET[id]'");
                    $temukan = mysqli_num_rows($query);
                    if($temukan > 0)
                    {
                        $c = mysqli_fetch_assoc($query);
                    }
                    else
                    {
                        header("location:modal.php");
                    }

                }
            else
                {
                    $act = "$aksi?act=simpan";
                }
                $idkelas=$_GET['idkelas'];
                $idsemester=$_GET['idsemester'];
                $idpel=$_GET['idpel'];

                $sqla = "SELECT a.`id`, a.`kode`, a.`nama`, a.`kkm`, a.`tingkat`, a.`sifat`, b.`kode` as kelompok, b.`keterangan` 
                        FROM `pelajaran` as a
                        JOIN `aspekkelompok` as b ON a.`sifat` = b.`id`
                        WHERE a.`id` = '$idpel'";
                $ka = mysqli_query($conn, $sqla);
                $atr = mysqli_fetch_assoc($ka);
                $qk = "SELECT * FROM `kelas` WHERE `id` = '$idkelas'";
                $sqlk = mysqli_query($conn,$qk);                 
                $k = mysqli_fetch_assoc($sqlk);
                $qs = "SELECT * FROM `semester` WHERE `id` = '$idsemester'";
                $sqls = mysqli_query($conn,$qs);                 
                $s = mysqli_fetch_assoc($sqls);

        ?>
        <section class="panel">
            <div class="panel-body profile-information">
               <div class="col-md-12">
                   <div class="profile-desk">
                    <div class="tab-pane ">                
                        <div class="prf-contacts sttng">
                            <h2>DATA NILAI</h2>
                        </div>      
                    </div>
                    <table class="table table-borderless" >
                        <tr>
                            <td>Kelas</td>
                            <td>:</td>
                            <td><?php echo $k['kelas']?></td>
                        </tr>
                        <tr>
                            <td>Pelajaran</td>
                            <td>:</td>
                            <td><?php echo $atr['nama']?></td>
                        </tr>                        
                        <tr>                        
                            <td>Semester</td>
                            <td>:</td>
                            <td><?php echo $s['semester']?></td>
                        </tr>
                    </table>                   
                   </div>
               </div>
            </div>
            <div class="row">

           <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>' enctype="multipart/form-data">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Data Bulan
                        </header>
                        <div class="panel-body">
                            <div class="position-center">
                                    <input type="hidden" name="id" value="<?php echo isset($c['id']) ? $c['id'] : '' ;?>">
                                    <input type="hidden" name="idkelas" value="<?php echo $idkelas;?>">
                                    <input type="hidden" name="idsemester" value="<?php echo $idsemester ;?>">
                                    <input type="hidden" name="idpel" value="<?php echo $idpel ;?>">
                                    <div class="form-group">
                                        <label class="control-label col-lg-2 col-sm-2">Tanggal</label>
                                        <div class="col-lg-10 col-sm-8">
                                            <input name="tanggal" class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" value="<?php echo isset($c['tanggal']) ? $c['tanggal'] : '' ;?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label">Bulan</label>
                                        <div class="col-lg-10 col-sm-8">
                                              <select name="bulan" class="form-control" style="width: 100%">
                                                    <option value="<?php echo isset($c['deskripsi']) ? $c['deskripsi'] : 'Pilih Bulan' ;?>"><?php echo isset($c['deskripsi']) ? getBulanHijriah($c['deskripsi']) : 'Pilih Bulan' ;?></option>
                                                    <?php
                                                    $bln=array(1=>'Muharram','Safar','Rabi’ul Awal','Rabi’ul Akhir','Jumadil Awal','Jumadil Akhir','Rajab','Sya’ban','Ramadhan','Syawal','Dzulka’dah','Dzulhijah');
                                                    for($bulan=1; $bulan<=12; $bulan++){
                                                    if($bulan<=9) { echo "<option value='0$bulan'>$bln[$bulan]</option>"; }
                                                    else { echo "<option value='$bulan'>$bln[$bulan]</option>"; }
                                                    }
                                                    ?>
                                              </select>
                                          </div>
                                    </div>
                                                             
                                    <div align="center" class="form-group">
                                        <div class="col-lg-12">
                                            <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
                                            <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </section>

                </div>

            </form>    
            </div>
        <?php
    break;
    }
?>
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
<!--Core js-->
<script src="js/jquery.js"></script>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="bs3/js/bootstrap.min.js"></script>
<script src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/easypiechart/jquery.easypiechart.js"></script>
<script src="js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>
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

<script type="text/javascript" src="js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

<script src="js/jquery-tags-input/jquery.tagsinput.js"></script>

<script src="js/select2/select2.js"></script>
<script src="js/select-init.js"></script>


<!--common script init for all pages-->
<script src="js/scripts.js"></script>

<script src="js/toggle-init.js"></script>

<script src="js/advanced-form.js"></script>
<!--Easy Pie Chart-->
<script src="js/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="js/sparkline/jquery.sparkline.js"></script>
<!--jQuery Flot Chart-->
<script src="js/flot-chart/jquery.flot.js"></script>
<script src="js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="js/flot-chart/jquery.flot.resize.js"></script>
<script src="js/flot-chart/jquery.flot.pie.resize.js"></script>

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
