<?php

    date_default_timezone_set('Asia/Jakarta');
include"../../lib/conn.php";
include"../../lib/fungsi_indotgl.php";
$q = $_GET['q'];
$js = $_GET['js'];
$qkl = "SELECT * FROM kelas";
$sqlkl = mysqli_query($conn,$qkl); 
$dtkl = mysqli_fetch_assoc($sqlkl) ;
if(empty($_GET['js'])){
?>
<div class="alert alert-danger alert-dismissible" id="succsess-alert">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<h4><i class="icon fa fa-ban"></i> Alert!</h4>
Pilih Tanggal</div>

<section class="panel panel-warning">
    <header class="panel-heading">
        Daftar Tanggal Pengembangan Prestasi Kelas <b><?php echo $dtkl['kelas'] ?></b>
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
                    <th class="text-center">Dartar Tanggal Yang Terinput</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $i=1;                    
                    $sql1 = "SELECT c.`id`, c.`kelas`, a.`date` 
                            FROM `pengembangan_prestasi` as a
                            JOIN `siswa` as b ON a.`nis` = b.`nis`
                            JOIN `kelas` as c ON b.`idkelas` = c.`id`
                            WHERE b.`idkelas` = '$q'
                            GROUP BY a.`date`";
                    $hasil1= mysqli_query($conn,$sql1); 
                    while ($data1 = $hasil1->fetch_array()){
                ?>
                <tr class="">
                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
                    <td align="center"><?php echo tglindo($data1['date'])?></td>         
                </tr>
                
                <?php
                         $i++;
                     }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php
}else{
$queryx = "SELECT c.`id`, c.`kelas`, a.`date` 
			FROM `pengembangan_prestasi` as a
			JOIN `siswa` as b ON a.`nis` = b.`nis`
			JOIN `kelas` as c ON b.`idkelas` = c.`id`
			WHERE a.`date`='$js' AND b.`idkelas` = '$q'
			GROUP BY c.`id`";
$sqlx = mysqli_query($conn,$queryx);	
$qkls = mysqli_fetch_assoc($sqlx);
if ($qkls !=0) {
?>
<section class="panel panel-warning">
    <header class="panel-heading">
        Data Pengembangan Prestasi
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
                    <th class="text-center">Nama</th>
					<th class="text-center">Mufrodat</th>
                    <th class="text-center">Nahwu</th>
                    <th class="text-center">Murod</th>
					<th class="text-center">Ket\kendala</th>
				</tr>
                </thead>
                <tbody>
                <?php
					$i=1;                    
                    $sqll = "SELECT a.`id`, a.`nis`, b.`nama`, a.`info1`, a.`info2`, a.`info3`, a.`ket`
                            FROM `pengembangan_prestasi` as a
                            JOIN `siswa` as b ON a.`nis` = b.`nis`
                            JOIN `kelas` as c ON b.`idkelas` = c.`id`
                            WHERE b.`idkelas` = '$q' AND a.`date` = '$js'";
                    $hasill= mysqli_query($conn,$sqll); 
	        		while ($datal = $hasill->fetch_array()){
				?>
                <tr class="">
                    <td align="center"><?php echo $i ?></td>
                    <input type="hidden" name="id[]" value="<?php echo $datal['id'] ?>">
                    <td align="center"><?php echo $datal['nis']?></td>
                    <td><?php echo $datal['nama']?></td>
                    <td align="center">
                    	<input type="hidden" name="nis[]" value="<?php echo $datal['nis'] ?>">
                    	<input type="text" name="info1[]" class="form-control"  value="<?php echo $datal['info1']?>">
                    </td>	
                    <td>
                        <input type="text" name="info2[]" class="form-control"  value="<?php echo $datal['info2']?>">
                    </td>	
                    <td>
                        <input type="text" name="info3[]" class="form-control"  value="<?php echo $datal['info3']?>">
                    </td>  
                    <td>
                        <input type="text" name="ket[]" class="form-control"  value="<?php echo $datal['ket']?>">
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
Tidak Ada Data Yang Terinput</div>

<section class="panel panel-warning">
    <header class="panel-heading">
        Daftar Tanggal Pengembangan Prestasi Kelas <b><?php echo $dtkl['kelas'] ?></b>
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
                    <th class="text-center">Dartar Tanggal Yang Terinput</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $i=1;                    
                    $sql1 = "SELECT c.`id`, c.`kelas`, a.`date` 
                            FROM `pengembangan_prestasi` as a
                            JOIN `siswa` as b ON a.`nis` = b.`nis`
                            JOIN `kelas` as c ON b.`idkelas` = c.`id`
                            WHERE b.`idkelas` = '$q'
                            GROUP BY a.`date`";
                    $hasil1= mysqli_query($conn,$sql1); 
                    while ($data1 = $hasil1->fetch_array()){
                ?>
                <tr class="">
                    <input type="hidden" name="id" value="<?php echo $m['id'] ?>">
                    <td align="center"><?php echo tglindo($data1['date'])?></td>         
                </tr>
                
                <?php
                         $i++;
                     }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php	
}

}
?>


