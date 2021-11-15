<?php
  if(!isset($_SESSION['login_user'])){
    header('location: ../../login.php'); // Mengarahkan ke Home Page
  }

  if(isset($_SESSION['modul']) AND $_SESSION['modul'] <> 'TRUE')
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
  $linkaksi = 'med.php?mod=modul';

  if(isset($_GET['act']))
  {
    $act = $_GET['act'];
    $linkaksi .= '&act='.$act;
  }
  else
  {
    $act = '';
  }

  $aksi = 'mod/modul/act_modul.php';

  ?>
  <?php
  switch ($act) {
    case 'form':
      if(!empty($_GET['id']))
      {
        $act = "$aksi?mod=modul&act=edit";
        $query = mysqli_query($conn,"SELECT * FROM modul WHERE id_modul = '$_GET[id]'");
        $temukan = mysqli_num_rows($query);
        if($temukan > 0)
        {
          $c = mysqli_fetch_assoc($query);
        }
        else
        {
          header("location:med.php?mod=modul");
        }

      }
      else
      {
        $act = "$aksi?mod=modul&act=simpan";
      }

      ?>
              <!-- page start-->
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Data Modul
                            </header>
                            <div class="panel-body">
                                <div class="position-center">
                                    <form class="form-horizontal" role="form" method='POST' action='<?php echo $act ?>'>
                                      <input type="hidden" name="id" value="<?php echo isset($c['id_modul']) ? $c['id_modul'] : '' ;?>">
                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Nama Modul</label>
                                        <div class="col-lg-10">
                                            <input type="text" name="nama_modul" class="form-control round-input" value="<?php echo isset($c['nama_modul']) ? $c['nama_modul'] : '' ;?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Posisi</label>
                                        <div class="col-lg-10">
                                            <input type="number" name="posisi" class="form-control round-input" value="<?php echo isset($c['posisi']) ? $c['posisi'] : '' ;?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Icon Modul</label>

                                        <div class="col-lg-10">                                         
                                            <div class="input-group m-bot15">
                                          <input type="text" name="icon_menu" class="form-control round-input"  value="<?php echo isset($c['icon_menu']) ? $c['icon_menu'] : '' ;?>">
                                                  <span class="input-group-btn">
                                                    <a target="_black" href="https://fontawesome.com/v4.7.0/icons/" data-toggle="modal" class="btn btn-info">
                                                <i class="fa fa-search"></i> View
                                            </a>
                                                  </span>
                                        </div>                                        
                                                <p class="help-block"><font color="red">Icon menggunakan fontawesome V 4.0</font></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Link Modul</label>
                                        <div class="col-lg-10">
                                            <input type="text" name="link_menu" class="form-control round-input" value="<?php echo isset($c['link_menu']) ? $c['link_menu'] : '' ;?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-lg-2 col-sm-2 control-label">Kategori Menu</label>
                                      <div class="col-lg-6">
                                          <select id="e1" name="id_menu" class="populate " style="width: 550px">
                                              <?php
                                                        $sql_kategori = mysqli_query($conn,"SELECT * FROM menu");
                                                while($k = mysqli_fetch_assoc($sql_kategori))
                                                {
                                                  if(isset($c['id_menu']) && $k['id_menu'] == $c['id_menu'])
                                                  {
                                                    echo"<option value='$k[id_menu]' selected>$k[nama_menu]</option>";  
                                                  }
                                                  else
                                                  {
                                                    echo"<option value='$k[id_menu]'>$k[nama_menu]</option>";
                                                  }
                                                  
                                                }
                                                        ?>
                                          </select>
                                      </div>
                                  </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                  <button type="submit" name="submit" value="simpan" class="btn btn-primary"><i class='fa fa-save'></i> Simpan</button>
                                  <button type="button" name="submit" onclick="history.back()" class="btn btn-danger"><i class='fa fa-rotate-left'></i> Kembali</button>
                                        </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </section>

                    </div>
                </div>

      <?php
    break;

    default :
    flash('example_message');
      ?>
            <!-- page start-->

            <div class="row">

                <div class="clearfix">
      
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php if($_SESSION['level']=='admin'){?>
                              <a href="med.php?mod=modul&act=form">
                              <button class="btn btn-primary">
                                Tambah <i class="fa fa-plus"></i>
                              </button>
                              </a>
                            <?php }?>
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
                                <table class="table table-striped table-hover table-bordered" id="example">
                                    <thead>
                                    <tr>
                                      <th class="text-center">No</th>
                                      <th class="text-center">Nama Modul</th>
                                      <th class="text-center">Kategori Menu</th>
                                      <th class="text-center">Posisi</th>
                                      <th class="text-center">Icon Modul</th>
                                      <th class="text-center">Link Modul</th>
                                      <?php if($_SESSION['level']=='admin' ){?>
                                        <th class="text-center">Aksi</th>
                                      <?php }?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                      $query = "SELECT a.`id_modul`, a.`id_menu`, a.`nama_modul`,b.`nama_menu`, a.`link_menu`, a.`posisi`, a.`icon_menu`, a.`akses_sekolah` 
                                        FROM `modul` as a
                                        JOIN `menu` as b on a.`id_menu` = b.`id_menu` ";
                                      $sql_kul = mysqli_query($conn,$query);  
                                      $i=1;
                                      while ($m = mysqli_fetch_assoc($sql_kul)) {
                                    ?>
                                    <tr class="">
                                        <td align="center"><?php echo $i ?></td>
                                        <input type="hidden" name="id" value="<?php echo $m['id_modul'] ?>">
                                        <td align="center"><?php echo $m['nama_modul']?></td>
                                        <td align="center"><?php echo $m['nama_menu']?></td>
                                        <td align="center"><?php echo $m['posisi']?></td>
                                        <td><i class="<?php echo $m['icon_menu']?>"></i> <?php echo $m['icon_menu']?></td>
                                        <td align="center"><?php echo $m['link_menu']?></td>
                                        <td align="center">
                                           <!-- <a href="guru_data.php?hal=guru_tampil&id=<?php echo $data['0']?>"><button class="btn btn-success btn-sm"> <i class="fa fa-search"></i></button></a>              
                                       --> <?php if($_SESSION['level']=='admin' ){?>
                                            <a href="med.php?mod=modul&act=form&id=<?php echo $m['id_modul'] ?>" ><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button> </a>
                                            <a href="<?php echo $aksi ?>?mod=modul&act=hapus&id=<?php echo $m['id_modul'] ?>" onclick="return myFunction();"><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button> </a>

                                            
                                          </td>
                                           <?php }?>
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
                </div>
            </div>

                <!-- page end-->
      <?php
    break;
  }

  }
?>
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

