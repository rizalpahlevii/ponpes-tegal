<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['pengembangan_prestasi']) AND $_SESSION['pengembangan_prestasi'] <> 'TRUE')
	{
		?>
		  <div class="alert alert-danger alert-dismissible" id="succsess-alert">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	        Dilarang mengakses file ini.
	      </div>
		<?php
	}
	else{

	//link buat paging
	if ($_SESSION['level']=="admin") {
		$linkaksi = 'med.php?mod=pengembangan_prestasi';
	}else{		
		$linkaksi = 'med2.php?mod=pengembangan_prestasi';
	}

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= '&act='.$act;
	}
	else
	{
		$act = '';
	}

	$aksi = 'mod/nilai/act_pengembangan_prestasi.php';

	?>
	<?php
	switch ($act) {
		case 'form':
				$act = "$aksi?mod=pengembangan_prestasi&act=simpan";

			?>
			        <!-- page start-->
				        <div class="row">
				            <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data Pengembangan Prestasi
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <div class="form-group">
				                                <label class="control-label col-lg-2 col-sm-2">Tanggal</label>
				                                <div class="col-lg-10">
				                                    <input name="date" id="js" class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" placeholder="Klik Tanggal" />
				                                </div>
				                            </div>
				                            <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
		                                      <div class="col-lg-10">
		                                          <select name="idkelas" class="form-control" onchange="showUser(this.value)">
		                                          		<option>Kelas</option>
		                                              <?php
		                                                        $sql_kelas = mysqli_query($conn,"SELECT a.* 
																	FROM `kelas` as a 
																	JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
																	WHERE b.`aktif` = 'Aktif'");
		                                                while($k = mysqli_fetch_assoc($sql_kelas))
		                                                {
		                                                 
		                                                    echo"<option value='$k[id]'>$k[kelas]</option>";  
		                                                  
		                                                }
		                                                        ?>
		                                          </select>
		                                      	</div>
		                                  	</div>
				                        </div>
				                    </div>
				                </section>
				                <div id="txtHint" align="center"><b>Info will be listed here...</b></div>
				            </div>
				        </form>
				        </div>

			<?php
		break;

		default :
		flash('example_message');
			?>
		        <!-- page start-->

                <?php if($_SESSION['level']=='admin' or $_SESSION['level']=='guru'){?>
                	<a href="<?php echo $linkaksi ?>&act=form">
					<button class="btn btn-primary">
						Tambah <i class="fa fa-plus"></i>
					</button>
					</a>
				<?php }?>
				<br>
				<br>
		        <div class="row">
				            <form class="form-horizontal" role="form" method='POST' action='<?php echo $aksi ?>?mod=pengembangan_prestasi&act=edit'>
				            <div class="col-lg-12">
				                <section class="panel">
				                    <header class="panel-heading">
				                        Data Pengembangan Prestasi
				                    </header>
				                    <div class="panel-body">
				                        <div class="position-center">
				                            <div class="form-group">
				                                <label class="control-label col-lg-2 col-sm-2">Tanggal</label>
				                                <div class="col-lg-10">
				                                    <input name="date" id="dt" class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" placeholder="Klik Tanggal" />
				                                </div>
				                            </div>
				                            <div class="form-group">
		                                      <label class="col-lg-2 col-sm-2 control-label">Kelas</label>
		                                      <div class="col-lg-10">
		                                          <select name="idkelas" class="form-control" onchange="showData(this.value)">
		                                          		<option>Kelas</option>
		                                              <?php
		                                                        $sql_kelas = mysqli_query($conn,"SELECT a.* 
																	FROM `kelas` as a 
																	JOIN `tahunajaran` as b ON a.`idtahunajaran` = b.`id`
																	WHERE b.`aktif` = 'Aktif'");
		                                                while($k = mysqli_fetch_assoc($sql_kelas))
		                                                {
		                                                 
		                                                    echo"<option value='$k[id]'>$k[kelas]</option>";  
		                                                  
		                                                }
		                                                        ?>
		                                          </select>
		                                      	</div>
		                                  	</div>
				                        </div>
				                    </div>
				                </section>
				                <div id="txtHint2" align="center"><b>View Data Pengembangan Prestasi</b></div>
				            </div>
				        </form>
				        </div>

		            <!-- page end-->
			<?php
		break;
		case 'detail':
			# code...
		break;
	}

	}
?>
<script>
function showUser(str) {
  var xhttp;    
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("txtHint").innerHTML = this.responseText;
    }
  };
  var district = document.getElementById('js');
    var js = district.value;
  xhttp.open("GET", "mod/nilai/getkelas.php?q="+str+"&js="+js, true);
  xhttp.send();
}
</script>

<script>
function showData(str) {
  var xhttp;    
  if (str == "") {
    document.getElementById("txtHint2").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("txtHint2").innerHTML = this.responseText;
    }
  };
  var district = document.getElementById('dt');
    var js = district.value;
  xhttp.open("GET", "mod/nilai/getdata.php?q="+str+"&js="+js, true);
  xhttp.send();
}
</script>
<script>
													
function myFunction() {
  var msg;
	msg= "Apakah Anda Yakin Akan Menghapus Data ? " ;
	var agree=confirm(msg);
	if (agree)
	return true ;
	else
	return false ;
}
</script>

