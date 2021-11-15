<?php
	if(!isset($_SESSION['login_user'])){
		header('location: ../../login.php'); // Mengarahkan ke Home Page
	}

	if(isset($_SESSION['level']) AND $_SESSION['level'] <> 'admin')
	{
		?>
		  <div class="alert alert-danger alert-dismissible" id="succsess-alert">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	        Dilarang mengakses file ini.
	      </div>
		<?php
	}

	//link buat paging
	$linkaksi = "med.php?mod=user";

	if(isset($_GET['act']))
	{
		$act = $_GET['act'];
		$linkaksi .= "&act=".$act;
	}
	else
	{
		$act = "";
	}
	switch ($act) {
	    default :
		flash('example_message');
			?>
		        <!-- page start-->

		        <div class="row">

		            <div class="clearfix">
			
		            <div class="col-sm-12">
		                <section class="panel">
		                    <header class="panel-heading">
		                    	
		                        <span class="tools pull-right">
		                            <a href="javascript:;" class="fa fa-chevron-down"></a>
		                            <a href="javascript:;" class="fa fa-cog"></a>
		                            <a href="javascript:;" class="fa fa-times"></a>
		                         </span>
		                    </header>
							
							
		                    <div class="panel-body">
							
		                        <div class="adv-table editable-table ">
		                            <div class="clearfix">
		                                <div class="btn-group">
		                                </div>
		                                <div class="btn-group pull-right">
		                                   
		                                </div>
		                            </div>
		                            <div class="space12"></div>
		                            <div class="table-responsive">
		                            <table class="table table-striped table-hover table-bordered" id="example">
		                                <thead>
		                                <tr>

											<th class="text-center">No</th>
											<th class="text-center">Petugas</th>
											<th class="text-center">Keterangan</th>
											<th class="text-center">Tanggal</th>
											<th class="text-center">Info Device</th>
										</tr>
		                                </thead>
		                                <tbody>
		                                <?php
											$query = "SELECT * FROM `tb_log` ORDER BY `timestmp` DESC";
											$sql_kul = mysqli_query($conn,$query);	
											$i=1;
											while ($m = mysqli_fetch_assoc($sql_kul)) {
											
											$date = date_create($m['timestmp']);
																													

												
										?>
		                                <tr class="">
		                                    <td align="center"><?php echo $i ?></td>
		                                    <td align="center"><?php echo nama_petugas($m['petugas'])?></td>
		                                    <td align="center"><?php echo $m['deskripsi'] ?></td>
		                                    <td align="center"><?php echo tglindo($m['timestmp'])?> <?php echo date_format($date,"H:i:s"); ?></td>
		                                    <td><?php echo $m['info'] ?></td>
		                                    
		                                </tr>
										
		                                <?php
		 									 $i++;
		 								 }
		 								?>
		                                </tbody>
		                            </table>
		                        	</div>
		                        </div>
		                    </div>
		                </section>
		            </div>
		        </div>

		            <!-- page end-->
			<?php
		break;
	}

	
?>