<?php
session_start();
require("dbconnect.php");

//Check："admin"才可使用本頁面 
if (!isset($_SESSION['login_identity']) || $_SESSION['login_account'] != "admin") {
    header('Location: login');
    exit;
}

//GET
$Account = $_GET["Account"];
if($Account == null){
    echo "<script> alert('Error!'); </script>";
    echo '<meta http-equiv="refresh" content="0; url=admin_list">';
    exit;
}

if($Account=="admin"){
    echo "<script> alert('Admin資料不允許修改！'); </script>";
    echo '<meta http-equiv="refresh" content="0; url=admin_list">';
    exit;
}

//查詢生日
$SQL = "SELECT 生日
        FROM 系統管理員
        WHERE Account='$Account'";
$result = mysqli_query($link, $SQL);
$row = mysqli_fetch_assoc($result);
$birth_date = $row['生日'];
$pwd_hash = password_hash("Nuk".$birth_date, PASSWORD_DEFAULT);

//update 姓名、生日
$SQL = "UPDATE 系統管理員
        SET 密碼='$pwd_hash'
        WHERE Account='$Account'";
if(!mysqli_query($link, $SQL)){
    echo "<script> alert('密碼重設失敗！'); </script>";
}else{
    echo "<script> alert('密碼重設成功！'); </script>";
}
echo '<meta http-equiv="refresh" content="0; url=admin_list">';
?>