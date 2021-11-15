<?php
include"../../lib/conn.php";

$pelajaran_id = $_POST['pelajaran_id'];

$sqlm = mysqli_query($conn,"SELECT * FROM `rpp` WHERE `idpelajaran` = '$pelajaran_id'");
while($m = mysqli_fetch_assoc($sqlm))
{
  if(isset($c['idmateri']) && $m['id'] == $c['idmateri'])
  {
    echo"<option value='$m[id]' selected>$m[rpp]</option>";  
  }
  else
  {
    echo"<option value='$m[id]'>$m[rpp]</option>";
  }
}
?>