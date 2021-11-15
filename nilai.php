<?php
session_start();
error_reporting(0);


include"lib/conn.php";

$soal = mysqli_query($conn,"SELECT * FROM quiz_pilganda where idquiz='$_POST[id_topik]'");
$pilganda = mysqli_num_rows($soal);
$soal_esay = mysqli_query($conn,"SELECT * FROM quiz_esay WHERE idquiz='$_POST[id_topik]'");
$esay = mysqli_num_rows($soal_esay);
//jika ada pilihan ganda dan ada esay
if (!empty($pilganda) AND !empty($esay)){

//jika ada inputan soal pilganda
if(!empty($_POST['soal_pilganda'])){
    $benar = 0;
    $salah = 0;
    foreach($_POST['soal_pilganda'] as $key => $value){
    $cek = mysqli_query($conn,"SELECT * FROM quiz_pilganda WHERE id=$key");
    while($c = mysqli_fetch_array($cek)){
        $jawaban = $c['kunci'];
    }
    if($value==$jawaban){
        $benar++;
    }else{
        $salah++;
    }
}

$jumlah = $_POST['jumlahsoalpilganda'];
$tidakjawab = $jumlah - $benar - $salah;
$persen = $benar / $jumlah;
$hasil = $persen * 100;

mysqli_query($conn,"INSERT INTO nilai (id_tq, id_siswa, benar, salah, tidak_dikerjakan,persentase)
                           VALUES ('$_POST[id_topik]','$_SESSION[id_user]','$benar','$salah','$tidakjawab','$hasil')");

}
elseif (empty($_POST['soal_pilganda'])){
    $jumlah = $_POST['jumlahsoalpilganda'];
    mysqli_query($conn,"INSERT INTO nilai (id_tq, id_siswa, benar, salah, tidak_dikerjakan,persentase)
                           VALUES ('$_POST[id_topik]','$_SESSION[id_user]','0','0','$jumlah','0')");
}

//jika ada inputan soal esay
if(!empty($_POST['soal_esay'])){
    foreach($_POST['soal_esay'] as $key2 => $value){
    $jawaban = $value;
    $cek = mysqli_query($conn,"SELECT * FROM quiz_esay WHERE id=$key2");
    while($data = mysqli_fetch_array($cek)){
        mysqli_query($conn,"INSERT INTO jawaban(id_tq,id_quiz,id_siswa,jawaban)
                                 VALUES('$_POST[id_topik]','$data[id]','$_SESSION[id_user]','$jawaban')");

    }
    
    }

}
elseif (empty($_POST['soal_esay'])){
    mysqli_query($conn,"INSERT INTO jawaban(id_tq,id_quiz,id_siswa,jawaban)
                                 VALUES('$_POST[id_topik]','$data[id]','$_SESSION[id_user]','')");
}
    header('location:med2.php?mod=quiz&act=show&id='.$_POST[id_topik]);
}

//jika soal hanya esay
if (empty($pilganda) AND !empty($esay)){
    //jika ada inputan soal esay
if(!empty($_POST['soal_esay'])){
    foreach($_POST['soal_esay'] as $key2 => $value){
    $jawaban = $value;
    $cek = mysqli_query($conn,"SELECT * FROM quiz_esay WHERE id=$key2");
    while($data = mysqli_fetch_array($cek)){
        mysqli_query($conn,"INSERT INTO jawaban(id_tq,id_quiz,id_siswa,jawaban)
                                 VALUES('$_POST[id_topik]','$data[id]','$_SESSION[id_user]','$jawaban')");

    }

    }

}
elseif (empty($_POST['soal_esay'])){
    mysqli_query($conn,"INSERT INTO jawaban(id_tq,id_quiz,id_siswa,jawaban)
                                 VALUES('$_POST[id_topik]','$data[id]','$_SESSION[id_user]','')");
}
    header('location:med2.php?mod=quiz&act=show&id='.$_POST[id_topik]);
}

//jika soal hanya pilihan ganda
if (!empty($pilganda) AND empty($esay)){
    //jika ada inputan soal pilganda
if(!empty($_POST['soal_pilganda'])){
    $benar = 0;
    $salah = 0;
    foreach($_POST['soal_pilganda'] as $key => $value){
    $cek = mysqli_query($conn,"SELECT * FROM quiz_pilganda WHERE id=$key");
    while($c = mysqli_fetch_array($cek)){
        $jawaban = $c['kunci'];
    }
    if($value==$jawaban){
        $benar++;
    }else{
        $salah++;
    }
}

$jumlah = $_POST['jumlahsoalpilganda'];
$tidakjawab = $jumlah - $benar - $salah;
$persen = $benar / $jumlah;
$hasil = $persen * 100;

mysqli_query($conn,"INSERT INTO nilai (id_tq, id_siswa, benar, salah, tidak_dikerjakan,persentase)
                           VALUES ('$_POST[id_topik]','$_SESSION[id_user]','$benar','$salah','$tidakjawab','$hasil')");

}
elseif (empty($_POST['soal_pilganda'])){
    $jumlah = $_POST['jumlahsoalpilganda'];
    mysqli_query($conn,"INSERT INTO nilai (id_tq, id_siswa, benar, salah, tidak_dikerjakan,persentase)
                           VALUES ('$_POST[id_topik]','$_SESSION[id_user]','0','0','$jumlah','0')");
}
    header('location:med2.php?mod=quiz&act=show&id='.$_POST[id_topik]);
}

?>
