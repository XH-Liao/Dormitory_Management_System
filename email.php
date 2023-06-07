<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require_once("dbconnect.php");

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                                                   //Enable verbose debug output
    $mail->isSMTP();                                                        //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                                   //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                               //Enable SMTP authentication
    $mail->Username   = 'PHPmailNUK@gmail.com';                             //SMTP username
    $mail->Password   = 'hdaxadveqccfilxf';                                 //SMTP password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                      //Enable implicit TLS encryption
    $mail->Port       = 465;
    $mail->SMTPSecure = "ssl";                                              //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->CharSet = 'utf-8';

    //Recipients
    $mail->setFrom('PHPmailNUK@gmail.com', 'DMS_Manager 宿舍管理員');       // 設定寄件者資料

    // 設定信件模板內容
    $content = "同學：<br>" .
        " 同學您好，目前尚未收到您的宿舍費用，請在<font color='red'>7日內</font>繳納費用！<br>" .
        " 若未在規定期限內繳費，將依宿舍規定第5條規範，予以<font color='red'>退宿</font>！<br><br><br>" .
        "-----------------------------------------------------------------------<br>" .
        "宿舍管理員 DMS manager<br>" .
        "國立高雄大學 | National University of Kaohsiung<br>" .
        "高雄市楠梓區高雄大學路700號<br>" .
        "Tel：(07)5919000<br>" .
        "Fax：(07)5919083<br>" .
        "Email：sec@nuk.edu.tw".
        "<br><br><br><br><br><font color='orange'>此信件僅為測試訊息！</font>";

    // SQL 查詢所有未繳費的名單 (姓名、Email)
    $SQL = "SELECT 姓名, Email
            FROM 入住申請, 學生
            WHERE 入住申請.學號=學生.學號 AND 繳費狀態=FALSE";
    $result = mysqli_query($link, $SQL);
    while ($row = mysqli_fetch_assoc($result)) {
        $uName = $row["姓名"];
        $email = $row["Email"];

        $mail->addAddress($email, $uName);                      // 設定收件人

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = '宿舍費用催繳通知';
        $message = $uName . $content;
        $mail->Body    = $message;

        $mail->send();
        $mail->clearAddresses();
    }

    echo "<script type='text/javascript'>alert('提示：催繳Email寄送成功!')</script>";
    echo "<meta http-equiv='Refresh'; content='0; url=assign_room_apply_list'/>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
