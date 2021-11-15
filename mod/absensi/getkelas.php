<?php

    date_default_timezone_set('Asia/Jakarta');
include"../../lib/conn.php";
include"../../lib/fungsi_indotgl.php";
$q = $_GET['q'];
$js = $_GET['js'];
$sqll = "SELECT * 
		FROM `siswa` as a
		JOIN `kelas` as b ON a.`idkelas` = b.`id` 
		WHERE `idkelas` = '$q'";
$hasill= mysqli_query($conn,$sqll);	
$tgl=date("Y-m-d");
if(empty($_GET['js'])){
?>
<div class="alert alert-danger alert-dismissible" id="succsess-alert">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<h4><i class="icon fa fa-ban"></i> Alert!</h4>
Pilih Jenis Absensi</div>
<?php
}else{
$queryx = "SELECT c.`id`, c.`kelas`, a.`id_jenisabsensi` 
			FROM `absensi_siswa` as a
			JOIN `siswa` as b ON a.`nis` = b.`nis`
			JOIN `kelas` as c ON b.`idkelas` = c.`id`
			WHERE a.`date`= CURDATE() AND a.`id_jenisabsensi`='$js' AND b.`idkelas` = '$q'
			GROUP BY c.`id`";
$sqlx = mysqli_query($conn,$queryx);	
$qkls = mysqli_fetch_assoc($sqlx);
if ($qkls ==0) {
?>
<section class="panel panel-warning">
    <header class="panel-heading">
        Data Absensi Santri Tanggal <b><?php echo tglindo($tgl) ?></b>
    </header>
    <div class="panel-body">
    	<div class="adv-table editable-table table-responsive">
            <div class="clearfix">
                <div class="btn-group">
                </div>
                <div class="btn-group pull-right">
                   
                </div>
            </div>
            <div class="space12"></div>
            <table class="table table-striped table-hover table-bordered" id="example">
                <thead>
                <tr>
					<th class="text-center">No</th>
                    <th class="text-center">NIS</th>
					<th class="text-center">Nama Santri</th>
					<th class="text-center">Absen</th>
				</tr>
                </thead>
                <tbody>
                <?php
					$i=1;
	        		while ($datal = $hasill->fetch_array()){
				?>
                <tr class="">
                    <td align="center"><?php echo $i ?></td>
                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
                    <td align="center"><?php echo $datal['nis']?></td>
                    <td><?php echo $datal['nama']?></td>
                    <td align="center">
                    	<input type="hidden" name="nis[]" value="<?php echo $datal['nis'] ?>">
                    	<select name="kehadiran[]" class="form-control">
                          <?php
                                    $sqla = mysqli_query($conn,"SELECT * FROM kehadiran ORDER BY urutan ASC");
                            while($k = mysqli_fetch_assoc($sqla))
                            {
                             
                                echo"<option value='$k[id]'>$k[kehadiran]</option>";  
                              
                            }
                                    ?>
                      </select>
                    </td>					
                </tr>
				
                <?php
						 $i++;
					 }
					?>
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>
</section>
<?php
}else{
?>
<div class="alert alert-danger alert-dismissible" id="succsess-alert">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<h4><i class="icon fa fa-ban"></i> Alert!</h4>
Kelas Sudah Diinput</div>
<?php	
}

}
?>


