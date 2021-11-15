<?php
$id=$_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">

    <title>Login</title>

    <!--Core CSS -->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-body">

    <div class="container">
       <?php
      include"login_check.php";

      if(isset($_SESSION['login_user'])){
        header("location: index.php");
      }
    if(!empty($error)) :
    ?>
    <div class="alert alert-danger" role="alert"">
        <button data-dismiss="alert" class="close close-sm" type="button">
            <i class="fa fa-times"></i>
        </button>
        <strong>GAGAL!!!</strong> <?php echo $error; ?>
    </div>
    <?php endif; ?>
      <form class="form-signin" id="form-login" name="login" method="POST">
        <h2 class="form-signin-heading"><font style="font-family: fantasy, cursive, serif; font-size: 1.3em;"> <?php echo $_SESSION['login'] ?></font> </h2>
        <div class="login-wrap">
            <div class="user-login-info">
                <input type="text" class="form-control" name="username" placeholder="Username" autofocus required>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <input type="hidden" name="id" class="form-control" value="<?php echo $_SESSION['id'] ?>" required>
            </div>
            <button class="btn btn-lg btn-login btn-block" value="submit" name="submit" type="submit">Sign in</button>

            
            <div class="registration">                
                <a class="" href="logout.php">
                    <i class=" fa fa-chevron-circle-left" ></i> BACK
                </a>
            </div>
            <div align="left">
                <a class="" href="shortcut.php?id=<?php echo $id ?>">
                    <i class=" fa fa-chevron-circle-left" ></i> Create Shortcut desktop
                </a>
            </div>
        </div>


      </form>

    </div>



    <!-- Placed js at the end of the document so the pages load faster -->

    <!--Core js-->
    <script src="js/jquery.js"></script>
    <script src="bs3/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    window.setTimeout(function() {
    $(".alert").fadeTo(300, 0).slideUp(300, function(){
        $(this).remove(); 
    });
}, 4000);
</script>
  </body>
</html>
