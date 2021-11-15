<?php
include"../../lib/conn.php";
$jj = $_POST['jenis'];
if($jj=="guru"){
$pelajaran_id = $_POST['pelajaran_id'];

$sqlm = mysqli_query($conn,"SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran
							FROM `guru` as a
							JOIN `pegawai` as b on a.nip = b.nip
							JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
							WHERE a.`idpelajaran` = '$pelajaran_id'");
while($m = mysqli_fetch_assoc($sqlm))
{
  if(isset($c['idguru']) && $m['id'] == $c['idguru'])
  {
    echo"<option value='$m[id]' selected>$m[nip] - $m[guru]</option>";  
  }
  else
  {
    echo"<option value='$m[id]'>$m[nip] - $m[guru]</option>";
  }
}  
}elseif($jj=="pelajaran"){
    $kelas_id = $_POST['kelas_id'];
    $sy = "SELECT * FROM `kelas` WHERE `id` = '$kelas_id'";
    		$sqsy = mysqli_query($conn,$sy);	
    		$y = mysqli_fetch_assoc($sqsy);
    		$tingkat = $y['tingkat'];
    $sqlm = mysqli_query($conn,"SELECT * FROM pelajaran
    							WHERE `tingkat` = '$tingkat'");
    while($k = mysqli_fetch_assoc($sqlm))
    {
      if(isset($c['idpelajaran']) && $k['id'] == $c['idpelajaran'])
      {
        echo"<option value='$k[id]' selected>$k[nama] </option>";  
      }
      else
      {
        echo"<option value='$k[id]'>$k[nama] </option>";
      }
      
    } 
}

?>