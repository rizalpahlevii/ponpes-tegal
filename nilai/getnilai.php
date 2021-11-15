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
Pilih Semester</div>
<?php
}else{
$sqla = "SELECT * FROM `kelas` WHERE `id` = '$q'";
$qakt = mysqli_query($conn, $sqla);
$akt = mysqli_fetch_assoc($qakt);
$queryx = "SELECT a.*, c.`kelas`, d.`semester`
            FROM `data_ujian` as a
            JOIN `kelas` as c ON a.`idkelas` = c.`id`
            JOIN `semester` as d ON a.`idsemester` = d.`id`
            WHERE a.`idsemester`='$js' AND a.`idkelas` = '$q'
            GROUP BY a.`idkelas`";
$sqlx = mysqli_query($conn,$queryx);
$temukan = mysqli_num_rows($sqlx);	
$qkls = mysqli_fetch_assoc($sqlx);
if ($temukan ==0) {
?>
<section class="panel panel-warning">
    <header class="panel-heading">
        Data Nilai Kelas <b><?php echo $akt['kelas'] ?></b>
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
                    <?php
                    $qk = "SELECT * FROM pelajaran WHERE tingkat = '$akt[tingkat]' order by id asc";
                    $sqlk = mysqli_query($conn,$qk);
                    while ($kh = mysqli_fetch_assoc($sqlk)) {
                    ?>
                    <th class="text-center"><?php echo $kh['nama']?></th>
                    <?php
                    }
                    ?>
				</tr>
                </thead>
                <tbody>
                <?php
                    $i=1;
					$x=0;
	        		while ($datal = $hasill->fetch_array()){
				?>
                <tr class="">
                    <td align="center"><?php echo $i ?></td>
                    <input type="hidden" name="id" value="<?php echo $datal['id'] ?>">
                    <td align="center"><?php echo $datal['nis']?></td>
                    <td><?php echo $datal['nama']?></td>
                    <input type="hidden" name="nis[]" value="<?php echo $datal['nis'] ?>">
                    <?php
                    $qk = "SELECT * FROM pelajaran WHERE tingkat = '$akt[tingkat]' order by id asc";
                    $sqlk = mysqli_query($conn,$qk);
                    while ($kh = mysqli_fetch_assoc($sqlk)) {
                    ?>
                    <td align="center">
                        <input type="hidden" name="pel<?php echo $x ?>[]" value="<?php echo $kh['id'] ?>">
                        <input type="text" name="nilai<?php echo $x ?>[]" class="form-control">
                    </td>
                    <?php
                    }
                    ?>
                    
                </tr>
				
                <?php
                         $i++;
						 $x++;
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


