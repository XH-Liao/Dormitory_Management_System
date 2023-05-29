<?php
session_start();
require("dbconnect.php");

//Check："系統管理員"才可使用本頁面 
if (!isset($_SESSION['login_identity']) || $_SESSION['login_account'] != "admin") {
    header('Location: login');
    exit;
}

//POST
$Account = $_GET["Account"];
if($Account == null){
    echo "<script> alert('Error!'); </script>";
    echo '<meta http-equiv="refresh" content="0; url=admin_list">';
    exit;
}

if($Account=="admin"){
    echo "<script> alert('Admin資料不允許刪除！'); </script>";
    echo '<meta http-equiv="refresh" content="0; url=admin_list">';
    exit;
}

//delete
$SQL = "DELETE FROM 系統管理員
        WHERE Account='$Account'";
if(!mysqli_query($link, $SQL)){
    echo "<script> alert('資料刪除失敗！(請檢察是否有尚未交接的資料，例如：入住申請核可員)'); </script>";
}else{
    if(mysqli_affected_rows($link) < 1){
        echo "<script> alert('資料刪除失敗！ (無此資料)'); </script>";
    }else{
        echo "<script> alert('資料刪除成功！'); </script>";
    }
}
echo '<meta http-equiv="refresh" content="0; url=admin_list">';
?>