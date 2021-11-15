<?php
include "../../../lib/conn.php";

require '../../../PHPMailer/PHPMailerAutoload.php';

$idsemester = $_GET['idsemester'];
$idkelas = $_GET['idkelas'];
$querys = mysqli_query($conn,"SELECT * FROM siswa");
$i=1;
while($k = mysqli_fetch_assoc($querys)){
	 $query = mysqli_query($conn,"SELECT * FROM dasarpenilaian WHERE keterangan LIKE '%Peminatan%'");
$sqlp = mysqli_fetch_assoc($query);
$q= mysqli_query($conn,"SELECT * FROM pelajaran WHERE sifat = '$sqlp[id]'");
$jmqmk = mysqli_num_rows($q);	
$jrtp = 0;
while($kd = mysqli_fetch_assoc($q)){
	$qtps = mysqli_query($conn,"SELECT  sum(`nilai`) as totp FROM `raport_katagori` WHERE `nis`='$k[nis]' and `idpelajaran` = '$kd[id]'");
	$tps = mysqli_fetch_assoc($qtps);
	$jrtp += $tps['totp'];
}		  
$rtnp = $jrtp/$jmqmk;    
if ($rtnp >= 95) {
	$kelas = "A";
}elseif ($rtnp >= 90) {
	$kelas = "B";
}elseif ($rtnp >= 85) {
	$kelas = "C";
}elseif ($rtnp >= 80) {
	$kelas = "D";
}elseif ($rtnp <= 80) {
	$kelas = "E";
}	

$id = $k['id'];
$nis = $k['nis'];
$nama = $k['nama'];
$rata = round($rtnp,1);
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Asia/Jakarta');

$message = file_get_contents('email.html'); 
$message = str_replace('%nama%', $nama, $message); 
$message = str_replace('%nis%', $nis, $message);
$message = str_replace('%rata%', $rata, $message); 
$message = str_replace('%kelas%', $kelas, $message); 
$message = str_replace('%id%', $id, $message); 
$message = str_replace('%idsemester%', $idsemester, $message); 
//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
$mail->Host = 'srv29.niagahoster.com';
$mail->SMTPAuth = true;
$mail->Username = 'smart@easytech.co.id';
$mail->Password = 'papercraft';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

//Set who the message is to be sent from
$mail->setFrom('smart@easytech.co.id', 'Raport Katagori '.$nama);

//Set an alternative reply-to address
//$mail->addReplyTo('Ilaaa.tuwe@gmail.com', 'First Last');

//Set who the message is to be sent to
$mail->addAddress($k['emailsiswa'], $k['nama']);

//Set the subject line
$mail->Subject = 'Raport Siswa '.$nama;

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML($message);
$mail->isHTML(true);
$mail->Body = $message;

//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
	echo "<meta http-equiv='refresh' content='0;url=../../../med.php?mod=raport' />";

}
$i++;
}

//send the message, check for errors
?>
