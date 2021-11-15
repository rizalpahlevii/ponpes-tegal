<?php
  include"../session_popup.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>FIRDAUS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../images/favicon.ico">

    <link rel="stylesheet" href="../assets/print/css/w3.css">
    <link rel="stylesheet" href="../assets/print/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/print/js/jquery-ui/jquery-ui.css">
    
    <style>
    .w3-theme {color:#fff !important;background-color:#4CAF50 !important;}
    .w3-btn {background-color:#4CAF50 ;margin-bottom:4px;}
    .w3-code{border-left:4px solid #4CAF50}
    @media only screen and (max-width: 601px) {.w3-top{position:static;} #main{margin-top:0px !important}}


    .tbl th.header { 
        background-image: url(..assets/print/js/table.sorter/themes/blue/bg.gif);
        cursor: pointer; 
        font-weight: bold; 
        background-repeat: no-repeat; 
        background-position: center left; 
        padding-left: 20px; 
        margin-left: -1px; 
    }

    .tbl th.headerSortUp { 
      background-image: url(..assets/print/js/table.sorter/themes/blue/asc.gif);
      cursor: pointer; 
        font-weight: bold; 
        background-repeat: no-repeat; 
        background-position: center left; 
        padding-left: 20px; 
        margin-left: -1px; 

    } 
    .tbl th.headerSortDown { 
      background-image: url(..assets/print/js/table.sorter/themes/blue/desc.gif);
      cursor: pointer; 
        font-weight: bold; 
        background-repeat: no-repeat; 
        background-position: center left; 
        padding-left: 20px; 
        margin-left: -1px; 
    } 
    .ui-datepicker {
        font-family: "Trebuchet MS", "Helvetica", "Arial",  "Verdana", "sans-serif";
        font-size: 80.5%;
    }
    .ui-tooltip-content {
        font-size: 80.5%;
    }
    </style>
    <script src="..assets/print/js/jquery-1.12.2.min.js"></script>
    <script src="..assets/print/js/jquery-ui/jquery-ui.js"></script>
    <script src="..assets/print/js/jquery.maskedinput.min.js"></script>
    <script src="..assets/print/js/jquery.number.js"></script>
    <script src="..assets/print/js/infusion-jquery/jquery.webcam.js"></script>
    <script src="..assets/print/js/w3codecolors.js"></script>
    <script src="..assets/print/js/jquery.freezeheader.js"></script>


    <script language="javascript" type="text/javascript">
        $(document).ready(function () {
            $("#table1").freezeHeader();
            /*$("#table1").freezeHeader({ 'height': '300px' });
            $("#table2").freezeHeader();
                
            $("#tbex1").freezeHeader();
            $("#tbex2").freezeHeader();
            $("#tbex3").freezeHeader();
            $("#tbex4").freezeHeader();*/
                
        });
    </script>
</head>
<body>
    <div class="w3-container">
    <?php
        include"../lib/fungsi_indotgl.php";
        include"../lib/fungsi_terbilang.php";
        include"../lib/all_function.php";
        
        if ($_GET['mod'] == "cetakkwitansi") {
            include"cetak_kwitansi.php";
        }elseif($_GET['mod'] == "spp"){
            include"spp.php";
        }elseif($_GET['mod'] == "mahad"){
            include"mahad.php";
        }elseif($_GET['mod'] == "raport_siswa"){
            include"raport_siswa_pdf.php";
        }elseif($_GET['mod'] == "nilai_kelas"){
            include"nilai_kelas_print.php";
        }elseif($_GET['mod'] == "raport_kelas"){
            include"raport_kelas_print.php";
        }

    ?>
    </div>
    
    <script>
        window.print();
    </script>
</body>
</html>