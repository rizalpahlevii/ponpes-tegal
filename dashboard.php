<!--mini statistics start-->
<?php
$tahun = date("Y");
$siswa = mysqli_query($conn, "SELECT * FROM siswa");
$jsiswa = mysqli_num_rows($siswa);
$sk = mysqli_query($conn, "SELECT * FROM siswa WHERE `tahunmasuk` = '$tahun'");
$jsk = mysqli_num_rows($sk);
$snon = mysqli_query($conn, "SELECT DISTINCT a.* 
                            FROM `siswa` as a 
                            JOIN `siswa_nonaktif` as b ON a.`nis` = b.`nis`");
$jsnon = mysqli_num_rows($snon);
$sa = mysqli_query($conn, "SELECT a.* 
                            FROM `siswa` as a 
                            LEFT JOIN `siswa_nonaktif` as b ON a.`nis` = b.`nis`
                            WHERE b.`nis` IS NULL");
$jsa = mysqli_num_rows($sa);
$guru = mysqli_query($conn, "SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran, d.`status` 
							FROM `guru` as a
							JOIN `pegawai` as b on a.nip = b.nip
							JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
							JOIN `statusguru` as d on d.`id` = a.`statusguru`");
$jguru = mysqli_num_rows($guru);
$kelas = mysqli_query($conn, "SELECT a.`id`, a.`tingkat`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` and d.alumni='0' ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
												FROM `kelas` as a
												JOIN `pegawai` as b on a.nipwali = b.nip
												JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id`
												WHERE c.aktif = 'Aktif'");
$jkelas = mysqli_num_rows($kelas);
$mk = mysqli_query($conn, "SELECT * FROM pelajaran");
$jmk = mysqli_num_rows($mk);
?>
<?php
if ($_SESSION['level'] == 'superadmin' or $_SESSION['level'] == 'admin') {
?>
    <div class="row">
        <div class="col-md-4">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon tar"><i class="fa fa-user"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $jguru ?></span>
                    Total Guru Pengajar
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon pink"><i class="fa fa-home"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $jkelas ?></span>
                    Total Kelas
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon green"><i class="fa fa-tags"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $jmk ?></span>
                    Total Mata Pelajaran
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon tar"><i class="fa fa-users"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $jsiswa ?></span>
                    Total Santri
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon green"><i class="fa fa-users"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $jsa ?></span>
                    Total Santri Aktif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon orange"><i class="fa fa-users"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $jsnon ?></span>
                    Total Santri Tidak Aktif
                </div>
            </div>
        </div>
    </div>
    <!--mini statistics end-->
<?php
}
?>

<div class="row">
    <div class="col-md-8">
        <div class="event-calendar clearfix">
            <div class="col-lg-7 calendar-block">
                <div class="cal1 ">
                </div>
            </div>
            <div class="col-lg-5 event-list-block">
                <div class="cal-day">
                    <span>Today</span>
                    <?php echo date("l") ?>
                </div>
                <ul class="event-list">


                </ul>
                <input type="text" class="form-control evnt-input" placeholder="NOTES">
            </div>
        </div>
    </div>
    <?php
    if ($_SESSION['level'] == 'superadmin' or $_SESSION['level'] == 'admin') {
    ?>
        <div class="col-md-4">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon pink"><i class="fa fa-users"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $jsk ?></span>
                    Total Santri Baru <?php echo $tahun ?>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="col-md-4">
        <div class="profile-nav alt" align="center">
            <section class="panel">
                <div class="user-heading alt clock-row terques-bg">
                    <h1><?php echo date('d F Y'); ?></h1>
                    <p class="text-left"><?php echo date('Y, l'); ?></p>
                    <!--<p class="text-left">7:53 PM</p>-->
                </div>
                <ul id="clock">
                    <li id="sec"></li>
                    <li id="hour"></li>
                    <li id="min"></li>
                </ul>
                <?php
                require_once("HijriCalendar/HijriCalendar.php");
                $hijri = HijriCalendar::GregorianToHijri(time());
                $querya = "SELECT * FROM jam_absen";
                $sql_a = mysqli_query($conn, $querya);
                $a = mysqli_fetch_assoc($sql_a);
                ?>
                <div>
                    <h1><?php echo $hijri[1] . ' ' . HijriCalendar::monthName($hijri[0]) . ' ' . $hijri[2]; ?></h1>
                    <br>
                </div>
                <!--<ul class="clock-category">
                    <li>
                        <a href="#">
                            <i class="ico-alarm2 "></i>
                            <span>Jam Masuk</span>
                            <span><?php echo $a['jam_masuk'] ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class=" ico-clock2 "></i>
                            <span>Jam Pulang</span>
                            <span><?php echo $a['jam_pulang'] ?></span>
                        </a>
                    </li>
                </ul>-->

            </section>

        </div>
    </div>
</div>