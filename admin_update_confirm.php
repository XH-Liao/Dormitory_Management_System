<?php
session_start();
require("dbconnect.php");

//Check："Admin"才可使用本頁面 
if (!isset($_SESSION['login_identity']) || $_SESSION['login_account'] != "admin") {
    header('Location: login');
    exit;
}

//POST
$Account = $_POST["Account"];
$name = $_POST["姓名"];
$birth_date = $_POST["生日"];
if($Account=="admin"){
    echo "<script> alert('Admin資料不允許修改！'); </script>";
    echo '<meta http-equiv="refresh" content="0; url=admin_list">';
    exit;
}
if($name == null || $birth_date == null){
    $_SESSION["msg"] = "所有欄位皆為必填";
    echo "<script>history.back();</script>";
    exit;
}

//update 姓名、生日
$SQL = "UPDATE 系統管理員
        SET 姓名='$name', 生日='$birth_date'
        WHERE Account='$Account'";
if(!mysqli_query($link, $SQL)){
    $_SESSION["msg"] = "資料修改失敗！";
    echo "<script>history.back();</script>";
}else{
    echo "<script> alert('資料修改成功！'); </script>";
    echo '<meta http-equiv="refresh" content="0; url=admin_list">';
}

?>