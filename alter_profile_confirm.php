<?php
session_start();
require("dbconnect.php");

//Check："學生"、"舍監"才可使用本頁面 
if (!isset($_SESSION['login_identity']) || ($_SESSION['login_identity'] != "學生" && $_SESSION['login_identity'] != "舍監")) {
    header('Location: login');
    exit;
}

//POST
$email = $_POST["Email"];
$phone_number = $_POST["聯絡電話"];

$SQL = "UPDATE 學生
        SET Email='$email', 連絡電話='$phone_number'
        WHERE 學號='{$_SESSION['login_account']}'";
if(!mysqli_query($link, $SQL)){
    $_SESSION["msg"] = "個人資料修改失敗！";
    echo "<script>history.back();</script>";
}else{
    $_SESSION["msg"] = "個人資料修改成功！";
    header("location: alter_profile");
}
?>