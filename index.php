<?php
    include"login_check.php";
    if(isset($_SESSION['login_user'])){
        header($_SESSION['link']);
      }else{
          header("location:login.php"); // Langsung mengarah ke Home index.php
      }
?>