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

<body onload="init(),noBack();" onpageshow="if (event.persisted) noBack();" onunload="keluar()">
<?php
        if(isset($_GET['id']))
            {
                $sqltrans = mysqli_query($conn,"SELECT q.`id`, q.`judul`, q.`idkelas`, k.`kelas`, q.`idjenis`, j.`jenisujian`, q.`idsemester`, s.`semester`, q.`iddasarpenilaian`,dp.`keterangan` as dasarpenilaian, q.`idrpp`, r.`rpp`, q.`tgl_buat`, q.`waktu_pengerjaan`, q.`info`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
                                FROM `topik_quiz` as q
                                JOIN `pegawai` as b on b.nip = q.pembuat
                                JOIN `pelajaran` as c on q.`idpelajaran` = c.`id`
                                JOIN `guru` as a on a.`nip` = b.`nip`
                                JOIN `kelas` as k on q.`idkelas` = k.`id`
                                JOIN `jenisujian` as j on j.`id` = q.`idjenis`
                                JOIN `semester` as s on s.`id` = q.`idsemester`
                                JOIN `dasarpenilaian` as dp on q.`iddasarpenilaian` = dp.`id`
                                JOIN `rpp` as r on q.`idrpp` = r.`id`
                                JOIN `statusguru` as d on d.`id` = a.`statusguru` WHERE q.`id` = '$_GET[id]'") or die(mysqli_error());
                $tra = mysqli_fetch_assoc($sqltrans);

        ?>
        
        <form action="nilai.php" method=post id=formulir>
        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body profile-information">
                       <div align="center" class="col-md-12">
                            <div class="tab-pane ">                
                                <div class="prf-contacts sttng">
                                    <h2>DATA QUIZ</h2>
                                </div>      
                            </div>
                       </div>
                       <div class="col-md-2">
                               <div align="center" >
                                <img src="images/ect/nilai.png" width="90%" alt=""/>
                            </div>
                       </div>
                       <div class="col-md-5">
                           <div class="profile-desk">
                                <table class="table table-striped">                                     
                                    <tr>
                                        <td>Judul</td>
                                        <td>:</td>
                                        <td><?php echo $tra['judul'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kelas</td>
                                        <td>:</td>
                                        <td><?php echo $tra['kelas'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Semester</td>
                                        <td>:</td>
                                        <td><?php echo $tra['semester'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Pelajaran</td>
                                        <td>:</td>
                                        <td><?php echo $tra['pelajaran'] ?></td>
                                    </tr>
                                </table>
                           </div>
                       </div>
                       <div class="col-md-5">
                           <div class="profile-desk">
                                <table class="table table-striped">                                     
                                    <tr>
                                        <td>Jenis Pengujian</td>
                                        <td>:</td>
                                        <td><?php echo $tra['dasarpenilaian'] ?> - <?php echo $tra['jenisujian'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kelas</td>
                                        <td>:</td>
                                        <td><?php echo $tra['dasarpenilaian'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>quiz Pembelajaran</td>
                                        <td>:</td>
                                        <td><?php echo $tra['rpp'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Durasi</td>
                                        <td>:</td>
                                        <td><div id=divwaktu></div></td>
                                    </tr>
                                </table>
                           </div>
                       </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <section class="panel panel-warning">
                                    <?php
                                        $cek_siswa = mysqli_query($conn,"SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq='$_GET[id]' AND id_siswa='$_SESSION[id_user]'");
                                        $info_siswa = mysqli_fetch_array($cek_siswa);
                                        if ($info_siswa['hits']<= 0){
                                            mysqli_query($conn,"INSERT INTO siswa_sudah_mengerjakan (id_tq,id_siswa,hits)
                                                                                VALUES ('$_GET[id]','$_SESSION[id_user]',hits+1)");
                                        }
                                        elseif ($info_siswa['hits'] > 0){
                                        }

                                        $soal = mysqli_query($conn,"SELECT * FROM quiz_pilganda where idquiz='$_GET[id]' ORDER BY rand()");
                                        $pilganda = mysqli_num_rows($soal);
                                        $soal_esay = mysqli_query($conn,"SELECT * FROM quiz_esay WHERE idquiz='$_GET[id]'");
                                        $esay = mysqli_num_rows($soal_esay);
                                        if (!empty($pilganda) AND !empty($esay)){
                                    ?>
                                    <header class="panel-heading ">
                                        Daftar Soal Pilihan Ganda  
                                        <input type="hidden" name="id_topik" value="<?php echo $_GET['id'] ?>">                                     
                                    </header>
                                    <div class="panel-body">
                                        <?php
                                        $no = 1;
                                        while($s = mysqli_fetch_array($soal)){
                                            if ($s['gambar']!=''){
                                            ?>
                                            <table class="table">
                                                <tr>
                                                    <th rowspan="2" width="5%"><?php echo $no ?>.</th>
                                                    <td rowspan="2" width="30%">
                                                        <img width="70%" src="images/elearning/<?php echo $s['gambar'] ?>">
                                                    </td>
                                                    <th><?php echo $s['pertanyaan'] ?></th>

                                                   
                                                </tr>
                                                <tr>
                                                     <td>
                                                        <input type="radio" value="A" name="soal_pilganda[<?php echo $s['id'] ?>]">A. <?php echo $s['pil_a'] ?>
                                                        <br>
                                                        <input type="radio" value="B" name="soal_pilganda[<?php echo $s['id'] ?>]">B. <?php echo $s['pil_b'] ?>
                                                        <br>
                                                        <input type="radio" value="C" name="soal_pilganda[<?php echo $s['id'] ?>]">C. <?php echo $s['pil_c'] ?>
                                                        <br>
                                                        <input type="radio" value="D" name="soal_pilganda[<?php echo $s['id'] ?>]">D. <?php echo $s['pil_d'] ?>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php
                                            }else{
                                            ?>
                                            <table class="table">
                                                <tr>
                                                    <th rowspan="2" width="5%"><?php echo $no ?>.</th>
                                                    <th  rowspan="2" width="30%"><?php echo $s['pertanyaan'] ?></th>

                                                   
                                                </tr>
                                                <tr>
                                                     <td>
                                                        <input type="radio" value="A" name="soal_pilganda[<?php echo $s['id'] ?>]">A. <?php echo $s['pil_a'] ?>
                                                        <br>
                                                        <input type="radio" value="B" name="soal_pilganda[<?php echo $s['id'] ?>]">B. <?php echo $s['pil_b'] ?>
                                                        <br>
                                                        <input type="radio" value="C" name="soal_pilganda[<?php echo $s['id'] ?>]">C. <?php echo $s['pil_c'] ?>
                                                        <br>
                                                        <input type="radio" value="D" name="soal_pilganda[<?php echo $s['id'] ?>]">D. <?php echo $s['pil_d'] ?>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php                                                
                                            }
                                            $no++;
                                        }
                                        ?>
                                    </div>
                                    <header class="panel-heading ">
                                        Daftar Soal Essay                                
                                    </header>
                                    <div class="panel-body">
                                        <?php
                                        $no2=1;
                                       while($e=mysqli_fetch_array($soal_esay)){
                                            if (!empty($e['gambar'])){
                                            ?>
                                            <table class="table">
                                                <tr>
                                                    <th rowspan="2" width="5%"><?php echo $no2 ?>.</th>                                                    
                                                    <td rowspan="2" width="30%">
                                                        <img width="70%" src="images/elearning/<?php echo $e['gambar'] ?>">
                                                    </td>
                                                    <th><?php echo $e['pertanyaan'] ?></th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4>Jawaban :</h4>
                                                        <br>
                                                        <textarea class="wysihtml5 form-control" name="soal_esay[<?php echo $e['id'] ?>]" cols="90" rows="5"></textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php
                                            }else{
                                            ?>
                                            <table class="table">
                                                <tr>
                                                    <th rowspan="2" width="5%"><?php echo $no2 ?>.</th>     
                                                    <th rowspan="2" width="30%"><?php echo $e['pertanyaan'] ?></th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4>Jawaban :</h4>
                                                        <br>
                                                        <textarea class="wysihtml5 form-control" name="soal_esay[<?php echo $e['id'] ?>]" cols="90" rows="5"></textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php                                                
                                            }
                                            $no2++;
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    $jumlahsoal = $no - 1;
                                    ?>
                                    <input type="hidden" name="jumlahsoalpilganda" value="<?php echo $jumlahsoal ?>">
                                    <?php
                                    }elseif (empty($pilganda) AND !empty($esay)){
                                    ?>
                                    <header class="panel-heading ">
                                        Daftar Soal Essay
                                        <input type="hidden" name="id_topik" value="<?php echo $_POST['id'] ?>">                                     
                                    </header>
                                    <div class="panel-body">
                                        <?php
                                        $no2=1;
                                       while($e=mysqli_fetch_array($soal_esay)){
                                            if (!empty($e['gambar'])){
                                            ?>
                                            <table class="table">
                                                <tr>
                                                    <th rowspan="2" width="3%"><?php echo $no2 ?>.</th>                                                    
                                                    <td rowspan="2" width="30%">
                                                        <img width="70%" src="images/elearning/<?php echo $e['gambar'] ?>">
                                                    </td>
                                                    <th><?php echo $e['pertanyaan'] ?></th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4>Jawaban :</h4>
                                                        <br>
                                                        <textarea class="wysihtml5 form-control" name="soal_esay[<?php echo $e['id'] ?>]" cols="90" rows="5"></textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php
                                            }else{
                                            ?>
                                            <table class="table">
                                                <tr>
                                                    <th rowspan="2" width="3%"><?php echo $no2 ?>.</th>     
                                                    <th rowspan="2" width="30%"><?php echo $e['pertanyaan'] ?></th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4>Jawaban :</h4>
                                                        <br>
                                                        <textarea class="wysihtml5 form-control" name="soal_esay[<?php echo $e['id'] ?>]" cols="90" rows="5"></textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php                                                
                                            }
                                            $no2++;
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    }
                                    elseif (empty($pilganda) AND empty($esay)){
                                    flash('example_message', 'Maaf belum ada soal di Topik Ini.' );

                                    echo"<script>
                                        window.history.go(-1);
                                    </script>";
                                    }
                                    ?>
                                    <header class="panel-heading ">
                                        SELESAI                                  
                                    </header>
                                    <div class="panel-body">
                                        <h3>Apakah anda sudah yakin dengan jawaban anda dan ingin menyimpannya?  <button type=button onclick="tombol()">Ya</button></h3>
                                    <h3 id="tombol"></h3>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        </form>
                     <?php
                     }?>

<section id="container" >

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
<script>
var waktunya;
waktunya = <?php echo "$tra[waktu_pengerjaan]"; ?>;
var waktu;
var jalan = 0;
var habis = 0;
function init(){
    checkCookie()
    mulai();
}
function keluar(){
    if(habis==0){
        setCookie('waktux',waktu,365);
    }else{
        setCookie('waktux',0,-1);
    }
}
function mulai(){
    jam = Math.floor(waktu/3600);
    sisa = waktu%3600;
    menit = Math.floor(sisa/60);
    sisa2 = sisa%60
    detik = sisa2%60;
    if(detik<10){
        detikx = "0"+detik;
    }else{
        detikx = detik;
    }
    if(menit<10){
        menitx = "0"+menit;
    }else{
        menitx = menit;
    }
    if(jam<10){
        jamx = "0"+jam;
    }else{
        jamx = jam;
    }
    document.getElementById("divwaktu").innerHTML = jamx+" H : "+menitx+" M : "+detikx +" S";
    waktu --;
    if(waktu>0){
        t = setTimeout("mulai()",1000);
        jalan = 1;
    }else{
        if(jalan==1){
            clearTimeout(t);
        }
        habis = 1;
        document.getElementById("formulir").submit();
    }
}
function selesai(){    
    if(jalan==1){
            clearTimeout(t);
        }
        habis = 1;
    document.getElementById("formulir").submit();
}
function getCookie(c_name){
    if (document.cookie.length>0){
        c_start=document.cookie.indexOf(c_name + "=");
        if (c_start!=-1){
            c_start=c_start + c_name.length+1;
            c_end=document.cookie.indexOf(";",c_start);
            if (c_end==-1) c_end=document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end));
        }
    }
    return "";
}

function setCookie(c_name,value,expiredays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}

function checkCookie(){
    waktuy=getCookie('waktux');
    if (waktuy!=null && waktuy!=""){
        waktu = waktuy;
    }else{
        waktu = waktunya;
        setCookie('waktux',waktunya,7);
    }
}

</script>
<script type="text/javascript">
    window.history.forward();
    function noBack(){ window.history.forward(); }
</script>
<script type="text/javascript">
function tombol()
{
document.getElementById("tombol").innerHTML= "<input type=button value=Simpan onclick=selesai()>";
}
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
