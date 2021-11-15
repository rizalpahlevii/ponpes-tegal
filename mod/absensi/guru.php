<?php
include"../../lib/conn.php";

$pelajaran_id = $_POST['pelajaran_id'];

$sqlm = mysqli_query($conn,"SELECT a.`id`, a.`nip`, a.`idpelajaran`, a.`statusguru`, a.`keterangan`, b.`nama` as guru, c.`nama` as pelajaran
							FROM `guru` as a
							JOIN `pegawai` as b on a.nip = b.nip
							JOIN `pelajaran` as c on a.`idpelajaran` = c.`id`
							WHERE a.`idpelajaran` = '$pelajaran_id'");
while($m = mysqli_fetch_assoc($sqlm))
{
  if(isset($c['idmateri']) && $m['id'] == $c['idmateri'])
  {
    echo"<option value='$m[id]' selected>$m[nip] - $m[guru]</option>";  
  }
  else
  {
    echo"<option value='$m[id]'>$m[nip] - $m[guru]</option>";
  }
}
?>