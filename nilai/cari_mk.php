<?php
	include"../../lib/conn.php";
   
    $sql_guru = mysqli_query($conn,"SELECT a.`id`, a.`kode`, a.`nama`, a.`kkm`, a.`tingkat`, a.`sifat`, b.`kode` as kelompok, b.`keterangan` 
	FROM `pelajaran` as a
	JOIN `aspekkelompok` as b ON a.`sifat` = b.`id` ORDER BY tingkat");
    while($mk = mysqli_fetch_assoc($sql_guru)){
   
    ?>
        <option value="<?php echo $data_prov["id_kota"] ?>"><?php echo $data_prov["nm_kota"] ?></option><br>
   
    <?php
    }
    ?>