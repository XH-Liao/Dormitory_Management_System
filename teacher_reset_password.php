<?php
session_start();
require("dbconnect.php");

//Check："系統管理員"才可使用本頁面 
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

//GET
$Account = $_GET["老師編號"];
if($Account == null){
    echo "<script> alert('Error!'); </script>";
    echo '<meta http-equiv="refresh" content="0; url=teacher_list">';
    exit;
}

//查詢生日
$SQL = "SELECT 生日
        FROM 老師
        WHERE 老師編號='$Account'";
$result = mysqli_query($link, $SQL);
$row = mysqli_fetch_assoc($result);
$birth_date = $row['生日'];
$pwd_hash = password_hash("Nuk".$birth_date, PASSWORD_DEFAULT);

//update 姓名、生日
$SQL = "UPDATE 老師
        SET 密碼='$pwd_hash'
        WHERE 老師編號='$Account'";
if(!mysqli_query($link, $SQL)){
    echo "<script> alert('密碼重設失敗！'); </script>";
}else{
    echo "<script> alert('密碼重設成功！'); </script>";
}
echo '<meta http-equiv="refresh" content="0; url=teacher_list">';
?>