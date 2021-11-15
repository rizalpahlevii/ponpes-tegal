<?php
require('fpdf.php');


include "../../../../globals/koneksi.php";
$id = $_GET['id'];


$hasil1 = mysql_query("SELECT a.no_induk, a.nama_siswa, b.nama_orang_tua
FROM siswa a
INNER JOIN orang_tua b ON a.id_orang_tua = b.id_orang_tua
WHERE a.no_induk ='$id' ");
if($hasil1 === FALSE) {
die(mysql_error()); // TODO: better error handling
}



$hasil2 = mysql_query("select a.id_daftar_kejadian,b.nama_kejadian,a.tanggal_kejadian,b.tipe_kejadian,b.poin_kejadian from kejadian_siswa a inner join daftar_kejadian b on a.id_daftar_kejadian=b.id_daftar_kejadian where a.no_induk='$id' ");
if($hasil2 === FALSE) {
die(mysql_error()); // TODO: better error handling
}


$row1 = mysql_fetch_array($hasil1);


//tanggal bulan tahun
 /* script menentukan hari */  
 $array_hr= array(1=>"Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu");
 $hr = $array_hr[date('N')];

/* script menentukan tanggal */   
$tgl= date('j');
/* script menentukan bulan */
  $array_bln = array(1=>"Januari","Februari","Maret", "April", "Mei","Juni","Juli","Agustus","September","Oktober", "November","Desember");
  $bln = $array_bln[date('n')];
/* script menentukan tahun */ 
$thn = date('Y');

// penyaring pengaturan bk
$result = mysql_query("select * from pengaturan_bk ");
								if($result === FALSE) {
								die(mysql_error()); // TODO: better error handling
								}
								while ($hasilpengaturan=  mysql_fetch_array($result))
								{
									$arrpengaturan[]=$hasilpengaturan;
									}
									
									

class PDFmod extends FPDF
{
// Page header
function Header()
{
    // Logo
    //$this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    //$this->Cell(100);
    // Title
	
    $this->Cell(0,5,'LEMBAGA PENDIDIKAN AL FALAH DARUSSALAM TROPODO',0,1,'C');
	$this->Cell(0,5,'Sekolah Dasar Al Falah Darussalam',0,1,'C');
	$this->SetFont('Arial','',8);
	$this->Cell(0,5,'Jl Nusa Indah Blok D No. 01 Wisma Tropodo Waru - Sidoarjo Telp. (031)8672828, 8664323 Fax. (031)8673235',0,1,'C');
		$this->Cell(0,5,'Website : www.alfalahdarussalam.sch.id     e-mail : alfalah.darussalam@yahoo.com',0,1,'C');
		$this->Cell(0,5,'',0,1,'C');
    // Line break
	$this->SetFont('Arial','',11);
	$this->Line(5, 32, 210-5, 32);
	$this->Cell(0,5,'Lampiran    : 1(satu) lembar',0,1,'L');
	$this->Cell(0,5,'Hal              : Pemberitahuan Ke Orang Tua',0,1,'L');
	$this->Cell(0,5,'',0,1,'L');
	$this->Cell(0,5,'Kepada Yth.',0,1,'L');
	$this->Cell(0,5,'Bapak',0,1,'L');
	$this->Cell(0,5,'Di Tempat ',0,1,'L');
    $this->Ln(15);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-20);
    // Arial italic 8
    $this->SetFont('Arial','',8);
	$this->Cell(0,5,'Islamic International School of Al Falah Darussalam',0,1,'C');
		$this->Cell(0,5,'Al Falah Darussalam Primary School',0,1,'C');
		$this->SetFont('Arial','I',8);
		$this->Cell(0,5,'Let\'s go to be Better for Excellent Future',0,1,'C');
		$this->SetFont('Arial','',8);
    // Page number
   // $this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,1,'C');
	 
}
}

// Instanciation of inherited class
$pdf = new FPDF( 'P', 'mm', 'A4' );
$pdf->AliasNbPages();
$pdf->AddPage();

//header awal

    $pdf->SetFont('Arial','B',15);
    // Move to the right
    //$this->Cell(100);
    // Title
	
    $pdf->Cell(0,5,''.$arrpengaturan[3][2],0,1,'C');
	$pdf->Cell(0,5,''.$arrpengaturan[4][2],0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,''.$arrpengaturan[5][2],0,1,'C');
		$pdf->Cell(0,5,''.$arrpengaturan[6][2],0,1,'C');
		$pdf->Cell(0,5,'',0,1,'C');
    // Line break
	$pdf->SetFont('Arial','',11);
	$pdf->Line(5, 32, 210-5, 32);
	$pdf->Cell(0,5,'Lampiran    : 1(satu) lembar',0,1,'L');
	$pdf->Cell(0,5,'Hal              : Pemberitahuan Ke Orang Tua',0,1,'L');
	$pdf->Cell(0,5,'',0,1,'L');
	$pdf->Cell(0,5,'Kepada Yth.',0,1,'L');
	$pdf->Cell(0,5,'Bapak '.$row1['nama_orang_tua'],0,1,'L');
	$pdf->Cell(0,5,'Di Tempat ',0,1,'L');
    $pdf->Ln(15);
//header akhir

$pdf->SetFont('Times','I',11);
$pdf->Cell(0,5,'Bismillaahirrohmaanirrohiim',0,1,'C');
$pdf->Cell(0,5,'',0,1,'C');
$pdf->Cell(0,5,'Assalamu\'alaikum Wr.Wb',0,1,'L');
$pdf->Cell(0,5,'',0,1,'C');
$pdf->SetFont('Times','',11);
$reportSubtitle = "            Alhamdulillah, segala puji hanya milik Allah S.W.T, sholawat serta salam semoga tetap tercurah kepada Rasulullah Muhammad SAW beserta keluarga, sahabat dan segenap pengikutnya sehingga kita tergolong pengikut beliau yang setia. Amin.";
$reportSubtitle2 = "            Sehubungan dengan pelanggaran yang kerap dilakukan oleh siswa Bapak / Ibu atas nama : ";
$namasiswa = "            ".$row1['nama_siswa']."                       No Induk : ".$row1['no_induk'];
$reportSubtitle3 = "Maka kami memberitahukan hal ini kepada Bapak/ Ibu agar dapat diberi perhatian khusus kepada putra / putrinya";
$reportSubtitle4 = "            Demikian surat pemberitahuan ini. Semoga Allah SWT meridhoi segala upaya kita. Amin.";
$reportSubtitle5 = "Wassalamu'alaikum Wr.Wb";
$tandatgn1="Sidoarjo, ".$tgl." ".$bln." ".$thn;
$tandatgn2="Kepala Sekolah";
$tandatgn3="";
$tandatgn4="--------------------";
$pdf->MultiCell( 0, 5, $reportSubtitle, 0,1);
$pdf->MultiCell( 0, 5, $reportSubtitle2, 0,1);
$pdf->MultiCell( 0, 5, '', 0,1);
$pdf->SetFont('Times','B',11);
$pdf->MultiCell( 0, 5, $namasiswa, 0,1);
$pdf->MultiCell( 0, 5, '', 0,1);
$pdf->SetFont('Times','',11);
$pdf->MultiCell( 0, 5, $reportSubtitle3, 0,1);
$pdf->MultiCell( 0, 5, $reportSubtitle4, 0,1);
$pdf->MultiCell( 0, 5, $reportSubtitle5, 0,1);
$pdf->MultiCell( 0, 5, '', 0,1);
$pdf->MultiCell( 0, 5, '', 0,1);
$pdf->MultiCell( 0, 5, '', 0,1);
$pdf->cell(129);
$pdf->MultiCell( 0, 5, $tandatgn1, 0);
$pdf->cell(129);
$pdf->MultiCell( 0, 5, $tandatgn2, 0);
$pdf->cell(129);
$pdf->MultiCell( 0, 5, $tandatgn3, 0);
$pdf->MultiCell( 0, 5, '', 0,1);
$pdf->MultiCell( 0, 5, '', 0,1);
$pdf->MultiCell( 0, 5, '', 0,1);
$pdf->MultiCell( 0, 5, '', 0,1);
$pdf->MultiCell( 0, 5, '', 0,1);
$pdf->SetFont('Times','BU',11);
$pdf->cell(129);
$pdf->MultiCell( 0, 5, $tandatgn4, 0);

//footer awal

    $pdf->SetY(-38);

    $pdf->SetFont('Arial','',8);
//	$pdf->Cell(0,5,'Islamic International School of Al Falah Darussalam',0,1,'C');
//		$pdf->Cell(0,5,'Al Falah Darussalam Primary School',0,1,'C');
//		$pdf->SetFont('Arial','I',8);
//		$pdf->Cell(0,5,'Let\'s go to be Better for Excellent Future',0,1,'C');
//		$pdf->SetFont('Arial','',8);

//footer akhir


$pdf->AddPage();
$lamp1="LAMPIRAN";
$lamp2="No Induk: ".$row1['no_induk'];
$lamp3="NAMA: ".$row1['nama_siswa'];
$pdf->MultiCell( 0, 5, '', 0);
$pdf->Cell( 18, 5, $lamp1,1,1);
$pdf->MultiCell( 0, 5, '', 0);
$pdf->SetFont('Times','B',11);
$pdf->MultiCell( 0, 5, $lamp2, 0);
$pdf->MultiCell( 0, 5, $lamp3, 0);
$pdf->MultiCell( 0, 5, '', 0);
$pdf->MultiCell( 0, 5, '', 0);

$pdf->SetFont('Arial','',12);
$pdf->SetY(38);
$pdf->SetX(10);
$pdf->MultiCell(50,6,'Nama Kejadian',1);
$pdf->SetY(38);
$pdf->SetX(60);
$pdf->MultiCell(80,6,'Tanggal Kejadian',1);
$pdf->SetY(38);
$pdf->SetX(140);
$pdf->MultiCell(30,6,'Tipe Kejadian',1,'R');
$pdf->SetY(38);
$pdf->SetX(170);
$pdf->MultiCell(30,6,'Poin ',1,'R');


$pertama = mysql_query("select nilai_pengaturan from pengaturan_bk where id_pengaturan_bk=1 ");
if($pertama === FALSE) {
die(mysql_error()); // TODO: better error handling
}


$h_pertama = mysql_fetch_array($pertama);


								
									
									
							if ($arrpengaturan[1][3] == '1' and $arrpengaturan[2][2] == 'tambah') {
								
$c_nama = "";
$c_tanggal = "";
$c_tipe = "";
$c_poin = "";
$awal = $h_pertama['nilai_pengaturan'];
$total=0;

//For each row, add the field to the corresponding column
while($row2 = mysql_fetch_array($hasil2))
{ 
   $nama =$row2['nama_kejadian'];
   $tanggal = $row2['tanggal_kejadian'];
   $tipe = $row2['tipe_kejadian'];
   $poin =$row2['poin_kejadian'];

 $c_nama = $c_nama.$nama."\n";
 $c_tanggal = $c_tanggal.$tanggal."\n";
 $c_tipe = $c_tipe.$tipe."\n";
 if ($tipe=='reward'){
	 $c_poin = $c_poin.'-'.$poin."\n";
	 $total = $total-($poin);
	 } else 
	 {
		$c_poin = $c_poin.'+'.$poin."\n";
		$total = $total+($poin);
	 }
 

}
$hasilakhir = $awal+$total;

$pdf->SetY(44);
$pdf->SetX(10);
$pdf->MultiCell(50,6,'Poin Awal',1);
$pdf->SetY(44);
$pdf->SetX(60);
$pdf->MultiCell(80,6,'-',1);
$pdf->SetY(44);
$pdf->SetX(140);
$pdf->MultiCell(30,6,'-',1,'R');
$pdf->SetY(44);
$pdf->SetX(170);
$pdf->MultiCell(30,6,''.$awal.'',1,'R');




$pdf->SetY(50);
$pdf->SetX(10);
$pdf->MultiCell(50,6,$c_nama,1);
$pdf->SetY(50);
$pdf->SetX(60);
$pdf->MultiCell(80,6,$c_tanggal,1);
$pdf->SetY(50);
$pdf->SetX(140);
$pdf->MultiCell(30,6,$c_tipe,1,'R');
$pdf->SetY(50);
$pdf->SetX(170);
$pdf->MultiCell(30,6,$c_poin,1,'R');
$pdf->MultiCell( 0, 5, '', 0,1);
$pdf->MultiCell(30,6,'TOTAL : '.$hasilakhir,0,'R');
	
$pdf->Output();								
								
								

							}elseif ($arrpengaturan[1][3] == '1' and $arrpengaturan[2][2] == 'kurang'){
								
								
$c_nama = "";
$c_tanggal = "";
$c_tipe = "";
$c_poin = "";
$awal = $h_pertama['nilai_pengaturan'];
$total=0;

//For each row, add the field to the corresponding column
while($row2 = mysql_fetch_array($hasil2))
{ 
   $nama =$row2['nama_kejadian'];
   $tanggal = $row2['tanggal_kejadian'];
   $tipe = $row2['tipe_kejadian'];
   $poin =$row2['poin_kejadian'];

 $c_nama = $c_nama.$nama."\n";
 $c_tanggal = $c_tanggal.$tanggal."\n";
 $c_tipe = $c_tipe.$tipe."\n";
 if ($tipe=='reward'){
	 $c_poin = $c_poin.'+'.$poin."\n";
	 $total = $total+($poin);
	 } else 
	 {
		$c_poin = $c_poin.'-'.$poin."\n";
		$total = $total-($poin);
	 }
 

}
$hasilakhir = $awal+$total;

$pdf->SetY(44);
$pdf->SetX(10);
$pdf->MultiCell(50,6,'Poin Awal',1);
$pdf->SetY(44);
$pdf->SetX(60);
$pdf->MultiCell(80,6,'-',1);
$pdf->SetY(44);
$pdf->SetX(140);
$pdf->MultiCell(30,6,'-',1,'R');
$pdf->SetY(44);
$pdf->SetX(170);
$pdf->MultiCell(30,6,''.$awal.'',1,'R');




$pdf->SetY(50);
$pdf->SetX(10);
$pdf->MultiCell(50,6,$c_nama,1);
$pdf->SetY(50);
$pdf->SetX(60);
$pdf->MultiCell(80,6,$c_tanggal,1);
$pdf->SetY(50);
$pdf->SetX(140);
$pdf->MultiCell(30,6,$c_tipe,1,'R');
$pdf->SetY(50);
$pdf->SetX(170);
$pdf->MultiCell(30,6,$c_poin,1,'R');
$pdf->MultiCell( 0, 5, '', 0,1);
$pdf->MultiCell(30,6,'TOTAL : '.$hasilakhir,0,'R');
	
$pdf->Output();

							}elseif ($arrpengaturan[1][3] == '0' and $arrpengaturan[2][2] == 'tambah'){
								
$c_nama = "";
$c_tanggal = "";
$c_tipe = "";
$c_poin = "";
$awal = $h_pertama['nilai_pengaturan'];
$total=0;

//For each row, add the field to the corresponding column
while($row2 = mysql_fetch_array($hasil2))
{ 
   $nama =$row2['nama_kejadian'];
   $tanggal = $row2['tanggal_kejadian'];
   $tipe = $row2['tipe_kejadian'];
   $poin =$row2['poin_kejadian'];



 if ($tipe=='pelanggaran'){
	  $c_nama = $c_nama.$nama."\n";
 $c_tanggal = $c_tanggal.$tanggal."\n";
	  $c_tipe = $c_tipe.$tipe."\n";
		$c_poin = $c_poin.'+'.$poin."\n";
		$total = $total+($poin);
	 }
 

}
$hasilakhir = $awal+$total;

$pdf->SetY(44);
$pdf->SetX(10);
$pdf->MultiCell(50,6,'Poin Awal',1);
$pdf->SetY(44);
$pdf->SetX(60);
$pdf->MultiCell(80,6,'-',1);
$pdf->SetY(44);
$pdf->SetX(140);
$pdf->MultiCell(30,6,'-',1,'R');
$pdf->SetY(44);
$pdf->SetX(170);
$pdf->MultiCell(30,6,''.$awal.'',1,'R');




$pdf->SetY(50);
$pdf->SetX(10);
$pdf->MultiCell(50,6,$c_nama,1);
$pdf->SetY(50);
$pdf->SetX(60);
$pdf->MultiCell(80,6,$c_tanggal,1);
$pdf->SetY(50);
$pdf->SetX(140);
$pdf->MultiCell(30,6,$c_tipe,1,'R');
$pdf->SetY(50);
$pdf->SetX(170);
$pdf->MultiCell(30,6,$c_poin,1,'R');
$pdf->MultiCell( 0, 5, '', 0,1);
$pdf->MultiCell(30,6,'TOTAL : '.$hasilakhir,0,'R');
	
$pdf->Output();			
								
								

							}elseif ($arrpengaturan[1][3] == '0' and $arrpengaturan[2][2] == 'kurang'){
								
$c_nama = "";
$c_tanggal = "";
$c_tipe = "";
$c_poin = "";
$awal = $h_pertama['nilai_pengaturan'];
$total=0;

//For each row, add the field to the corresponding column
while($row2 = mysql_fetch_array($hasil2))
{ 
   $nama =$row2['nama_kejadian'];
   $tanggal = $row2['tanggal_kejadian'];
   $tipe = $row2['tipe_kejadian'];
   $poin =$row2['poin_kejadian'];


 if ($tipe=='pelanggaran'){
	  $c_nama = $c_nama.$nama."\n";
 $c_tanggal = $c_tanggal.$tanggal."\n";
 $c_tipe = $c_tipe.$tipe."\n";
		$c_poin = $c_poin.'-'.$poin."\n";
		$total = $total-($poin);
	 }
 

}
$hasilakhir = $awal+$total;

$pdf->SetY(44);
$pdf->SetX(10);
$pdf->MultiCell(50,6,'Poin Awal',1);
$pdf->SetY(44);
$pdf->SetX(60);
$pdf->MultiCell(80,6,'-',1);
$pdf->SetY(44);
$pdf->SetX(140);
$pdf->MultiCell(30,6,'-',1,'R');
$pdf->SetY(44);
$pdf->SetX(170);
$pdf->MultiCell(30,6,''.$awal.'',1,'R');




$pdf->SetY(50);
$pdf->SetX(10);
$pdf->MultiCell(50,6,$c_nama,1);
$pdf->SetY(50);
$pdf->SetX(60);
$pdf->MultiCell(80,6,$c_tanggal,1);
$pdf->SetY(50);
$pdf->SetX(140);
$pdf->MultiCell(30,6,$c_tipe,1,'R');
$pdf->SetY(50);
$pdf->SetX(170);
$pdf->MultiCell(30,6,$c_poin,1,'R');
$pdf->MultiCell( 0, 5, '', 0,1);
$pdf->MultiCell(30,6,'TOTAL : '.$hasilakhir,0,'R');
	
$pdf->Output('Laporan BK '.$row1['nama_siswa'].'('.$row1['no_induk'].')'.'.pdf', 'D');							
								
								

							}else { echo'kesalahan sistem';
												
												 }
								  ; 		


exit();

?>