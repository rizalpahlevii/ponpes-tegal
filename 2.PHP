<?php
include"lib/conn.php"; //buat koneksi ke database
include"lib/fungsi_indotgl.php";
$kode   = $_GET['kode']; //kode berita yang akan dikonvert
$query  = mysqli_query($conn,"SELECT * FROM SISWA WHERE NIS='".$kode."'");
$siswa = mysqli_fetch_assoc($query);
    $querykl = mysqli_query($conn,"SELECT a.`id`, a.`kelas`, c.`tahunajaran` ,a.`idtahunajaran`, a.`kapasitas`,(SELECT COUNT(*) FROM `siswa` as d where d.`idkelas` = a.`id` ) AS tersisa, a.`nipwali`,b.`nama`, a.`keterangan` 
                        FROM `kelas` as a
                        JOIN `pegawai` as b on a.nipwali = b.nip
                        JOIN `tahunajaran` as c on a.`idtahunajaran` = c.`id` WHERE a.id = '$siswa[idkelas]'");
    $kls = mysqli_fetch_assoc($querykl);
  $date=date('Y-m-d');
  $tgl=tglindo($date);
?>
<html xmlns="http://www.w3.org/1999/xhtml"> <!-- Bagian halaman HTML yang akan konvert -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
</head>
<body>
<?php
echo'<div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body invoice">
                      <div style="border: 3px #1780dd solid; padding: 10px;background-color:#ffffff;">
              <table class="table" width="100%">
                <tr>
                  <td width="25%" align="center"><img src="images/logokop.png" width="50%"></td>
                  <td width="75%" align="center">
                    <b><font size="2">PEMERINTAH PROVINSI JAWA TIMUR</font></b>
                    <br>
                    <b><font size="2">DINAS PENDIDIKAN</font></b>
                    <br>
                    <b><font size="3">SMA NEGERI 2 SIDOARJO</font></b>
                    <br>
                    <font size="1">Jalan Lingkar Barat Gading Fajar 2 Sidoarjo</font>
                    <br>
                    <font size="1">E-mail : smanda_sda@yahoo.com, Website : www.sman2sidaorjo.sch.id</font>
                  </td>
                </tr>
              </table>
                <div style="border: 1px #000 solid; padding: 1px;background-color:#ffffff;"></div>
              <table width="100%">
                <tr>
                  <td align="center">
                    <b><font size="2">RAPORT KATAGORI</font></b>
                    <br>
                    <b><font size="2">SEMESTER</font></b>
                    <br>
                    <b><font size="2">TAHUN AJARAN '.$kls["tahunajaran"].'</font></b>
                  </td>
                </tr>
              </table>
              <br>
              <table width="100%">
                <tr>
                  <td width="25%">Nama Peserta Didik</td>
                  <td align="center" width="2%" >:</td>
                  <td >'.$siswa["nama"].'</td>
                </tr>
                <tr>
                  <td>Nomor Induk</td>
                  <td align="center">:</td>
                  <td>'.$siswa["nis"].'</td>
                </tr>
                <tr>
                  <td>NIPDN</td>
                  <td align="center">:</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Kelas</td>
                  <td align="center">:</td>
                  <td>'.$kls["kelas"].'</td>
                </tr>
              </table>
              <table border="1" width="100%">   
                    <tr>
                      <th width="10" style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center"><font size="1">No</font></th>
                      <th width="40" style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center"><font size="1">Mata Pelajaran</font></th>
                      <th colspan="3" class="text-center"><font size="1">Pengetahuan</font></th>
                      <th colspan="3" class="text-center"><font size="1">Keterampilan</font></th>
                      <th style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center"><font size="1">Rata -Rata Nilai</font></th>
                      <th style="vertical-align : middle;text-align:center;" rowspan="2" class="text-center"><font size="1">Kelas Katagori</font></th>
                    </tr>
                    <tr>
                      <th class="text-center"><font size="1">UH1</font></th>
                      <th class="text-center"><font size="1">UH2</font></th>
                      <th class="text-center"><font size="1">UH3</font></th>
                      
                      <th class="text-center"><font size="1">UH1</font></th>
                      <th class="text-center"><font size="1">UH2</font></th>
                      <th class="text-center"><font size="1">UH3</font></th>
                      
                    </tr>';
                      $querys = mysqli_query($conn,"SELECT * FROM dasarpenilaian order by posisi");
                      $is=1;
                      while($k = mysqli_fetch_assoc($querys)){
    echo'<tr>
                      
                      <th colspan="10">'.$k["keterangan"].'</th>
                   </tr>';
                      $queryp = mysqli_query($conn,"SELECT * FROM pelajaran where sifat='$k[id]'");
                      $ip=1;
                      while($p = mysqli_fetch_assoc($queryp)){
              echo'<tr>
                      <th class="text-center"><font size="1">'.$ip.'</font></th>
                      <td width="20%"><font size="1">'.$p["nama"].'</font></td>
                      <td colspan="7"></td>';
                      
                        $queryk = mysqli_query($conn,"SELECT * FROM `rpp` WHERE `idpelajaran` = '$p[id]'");
                        $queryk1 = mysqli_query($conn,"SELECT * FROM `rpp` WHERE `idpelajaran` = '$p[id]'");
                        
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
                    $qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$siswa[nis]' and `idpelajaran` = '$p[id]'");
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

                    echo'<td style="vertical-align : middle;text-align:center;" rowspan="'.$hs.'">'.$kelas.'</td>
                    </tr>';
                        $ik=1;
                        while($kd = mysqli_fetch_assoc($queryk)){

                     echo'<tr>
                      <td><font size="1">KD'.$ik.'</font></td>
                        <td><font size="1">'.$kd["rpp"].'</font></td>';
                        $no=1;
                        for ($x=0; $x < 3; $x++) { 
                          $q = mysqli_query($conn,"SELECT * FROM `raport_katagori` WHERE `nis`='$siswa[nis]' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]' and `jenisujian` ='Pengetahuan' and `uhke` ='$no'");
                      $te = mysqli_num_rows($q);
                      if($te > 0)
                      {
                        $t = mysqli_fetch_assoc($q);
                        $nilai = $t['nilai'];
                        $jnp[""] = $t['nilai']; 
                      }else{
                        $nilai = '-';
                      }
                        
                 echo'<td align="center" ><font size="1">'.$nilai.'</font></td>';
                        $no++;
                      }
                        ?>
                        <?php
                        $no=1;
                        for ($x=0; $x < 3; $x++) { 
                          $q = mysqli_query($conn,"SELECT * FROM `raport_katagori` WHERE `nis`='$siswa[nis]' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]' and `jenisujian` ='Keterampilan' and `uhke` ='$no'");
                      $te = mysqli_num_rows($q);
                      if($te > 0)
                      {
                        $t = mysqli_fetch_assoc($q);
                        $nilai = $t['nilai'];
                        $jnp[""] = $t['nilai']; 
                      }else{
                        $nilai = '-';
                      }
                        
                     echo'<td align="center" ><font size="1">'.$nilai.'</font></td>';

                        
                        $no++;
                      }
                       
                        
                        $qtp = mysqli_query($conn,"SELECT  max(`uhke`) as totp FROM `raport_katagori` WHERE `nis`='$siswa[nis]' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]' and `jenisujian` ='Pengetahuan' ");
                        $tp = mysqli_fetch_assoc($qtp);
                        $qtk = mysqli_query($conn,"SELECT  max(`uhke`) as totk FROM `raport_katagori`  WHERE `nis`='$siswa[nis]' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]' and `jenisujian` ='Keterampilan' ");
                        $tk = mysqli_fetch_assoc($qtk);
                        
                        $qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$siswa[nis]' and `idpelajaran` = '$p[id]' and `idrpp` ='$kd[id]'");
                        $tps = mysqli_fetch_assoc($qtps);
                        $jrt = $tps['totp'];
                        $kodeb = $tp['totp'] + $tk['totk'];
                        if ($kodeb <= 0) $kodeb = 1;
                        $trt = ($jrt!=0)?($jrt/$kodeb):0;
                        
                        
                        echo'<td align="center"><font size="1">'.round($trt,1).'</font></td>
                       
                      </tr>';
                      
                      $ik++;
                      }
                      $ip++;
                      }
                      $is++;
                      }
                      
                    echo'</table> <br>';   
             
                $querys = mysqli_query($conn,"SELECT * FROM dasarpenilaian WHERE keterangan LIKE '%Peminatan%'");
              $sqlp = mysqli_fetch_assoc($querys);
              $q= mysqli_query($conn,"SELECT * FROM pelajaran WHERE sifat = '$sqlp[id]'");
              $jmqmk = mysqli_num_rows($q); 
              $jrtp = 0;
              while($kd = mysqli_fetch_assoc($q)){
                $qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$siswa[nis]' and `idpelajaran` = '$kd[id]'");
                $tps = mysqli_fetch_assoc($qtps);
                $jrtp += $tps['totp'];
              }     
              $rtnp = $jrtp/$jmqmk;    
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
                
                echo'<table width="100%">
                  <td width="5%"></td>
                  <td width="40%" style="border: 2px #000 solid; padding: 10px;background-color:#ffffff;"><b>Rata - Rata Nilai Perminatan : '.round($rtnp,1).'</b></td>
                  <td width="10%"></td>
                  <td width="40%" style="border: 2px #000 solid; padding: 10px;background-color:#ffffff;"><b>Kelas Katagori : '.$kelas.'</b></td>
                  <td width="5%"></td>
                  
                </table>
                <br>
                <table width="100%">
                  <tr>
                    <td width="30%" align="center">Mengetahui, <br> Wali Kelas,</td>
                    <td width="40%" align="center"><br> Orang Tua/ Wali,</td>
                    <td width="30%" align="center">Sidoarjo, '.$tgl.' <br> Wali Kelas,</td>
                  </tr>
                  <tr height="50px">
                  </tr>
                  <tr>
                    <td width="30%" align="center"><u>'.$kls["nama"].'</u></td>
                    <td width="40%" align="center">_______________</td>
                    <td width="30%" align="center"><u>'.$kls["nama"].'</u></td>
                  </tr>
                </table>
                
            </div>
                    </div>
                </section>
            </div>
        </div>';
?>
</body>
</html><!-- Akhir halaman HTML yang akan di konvert -->
<?php
$filename="mhs-".$kode.".pdf"; //ubah untuk menentukan nama file pdf yang dihasilkan nantinya
//==========================================================================================================
//Copy dan paste langsung script dibawah ini,untuk mengetahui lebih jelas tentang fungsinya silahkan baca-baca tutorial tentang HTML2PDF
//==========================================================================================================
$content = ob_get_clean();
$content = '<page style="font-family: freeserif">'.nl2br($content).'</page>';
 require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
 try
 {
  $html2pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15',array(30, 0, 20, 0));
  $html2pdf->setDefaultFont('Arial');
  $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
  $html2pdf->Output($filename);
 }
 catch(HTML2PDF_exception $e) { echo $e; }
?>