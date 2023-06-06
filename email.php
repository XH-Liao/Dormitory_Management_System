<?php
//POST的資料
$email = "a1095527@mail.nuk.edu.tw";
$uName = "廖習驊";
//$message = $_POST["message"];
//$message = nl2br($message);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'PHPmailNUK@gmail.com';                     //SMTP username
    $mail->Password   = 'mcjhjavtikmpefjd';                               //SMTP password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;
    $mail->SMTPSecure = "ssl";                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->CharSet = 'utf-8';

    //Recipients
    $mail->setFrom('PHPmailNUK@gmail.com', 'DMS_Manager 宿舍管理員');
    $mail->addAddress($email, $uName);

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = '宿舍費用催繳通知';
    $message = $uName . "同學：<br> 同學您好，目前尚未收到您的宿舍費用，請在<font color='red'>7日內</font>繳納費用！<br>" .
        " 若未在規定期限內繳費，將依宿舍規定第5條規範，予以<font color='red'>退宿</font><br><br><br><br><br>" .
        "<font color='blue'>此信件為測試訊息，請勿當真！</font>";
    $mail->Body    = $message;

    $mail->send();
    echo '<h1>訊息已傳送！</h1>';
    echo "<script type='text/javascript'>alert('提示：催繳Email寄送成功!')</script>";
    echo "<meta http-equiv='Refresh'; content='0; url=assign_room_apply_list'/>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
