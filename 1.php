<?php
include"lib/conn.php";

//buat query untuk menampilkan berita
$query = mysqli_query($conn,"SELECT * FROM SISWA ORDER BY NAMA");

?>
<style>
 table{
  border:silver 1px solid;
 }
 table td{
  border-bottom:silver 1px solid;
  border-right:silver 1px solid;
  padding:0 0 0 5px;
 }
</style>
<table cellpadding="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif">
  <!--DWLayoutTable-->
  <tr>
    <td height="25" colspan="7" align="center"><strong>DAFTAR MAHASISWA</strong></td>
  </tr>
  <tr>
    <td height="25" align="center" style="background-color:#CCC"><strong>NO</strong></td>
    <td width="100" align="center" style="background-color:#CCC"><strong>NIS</strong></td>
    <td width="250" align="center" style="background-color:#CCC"><strong>NAMA</strong></td>
    <td width="150" align="center" style="background-color:#CCC"><strong>ALAMAT</strong></td>
    <td width="150" align="center" style="background-color:#CCC"><strong>TGL LAHIR</strong></td>
    <td width="150" align="center" style="background-color:#CCC"><strong>TELEPON</strong></td>
     <td width="100" align="center" style="background-color:#CCC"><strong>ANGKATAN</strong></td>
  </tr>
<?php
$nomor = 1;
while($data = mysqli_fetch_assoc($query)){
$kode = $data['is']; // ambil nis siswa (unik)
?>
  <tr>
    <td width="38" height="25" valign="middle"><?php echo $nomor; ?></td>
    <td valign="middle"><?php echo $data['nis']; ?></td>
    <td valign="middle"><?php echo $data['nama']; ?></td>
    <td valign="middle"><?php echo $data['alamatsiswa']; ?></td>
    <td valign="middle"><?php echo $data['tgllahir']; ?></td>
    <td valign="middle"><?php echo $data['hpsiswa']; ?></td>
    <td valign="middle"><?php echo $data['tahunmasuk']; ?></td>
    <td valign="middle">
 <!-- BUAT LINK POP UP KE HALAMAN PDF KONVERTER SEPERTI PADA CONTOH BERIKUT -->
 <a href="javascript:void(0);"
    onclick="window.open('2.php?kode=<?php echo $kode; ?>','nama_window_pop_up','size=800,height=800,scrollbars=yes,resizeable=no')">PDF</a>
 </td>
   </tr>
<?php
$nomor++;
}
?>
</table>