<?php
session_start();
require("dbconnect.php");

//Check："系統管理員"才可使用本頁面 
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

//POST
$Account = $_GET["老師編號"];
if($Account == null){
    echo "<script> alert('Error!'); </script>";
    echo '<meta http-equiv="refresh" content="0; url=teacher_list">';
    exit;
}

//delete
$SQL = "DELETE FROM 老師
        WHERE 老師編號='$Account'";
if(!mysqli_query($link, $SQL)){
    echo "<script> alert('Error！'); </script>";
}else{
    if(mysqli_affected_rows($link) < 1){
        echo "<script> alert('資料刪除失敗！'); </script>";
    }else{
        echo "<script> alert('資料刪除成功！'); </script>";
    }
}
echo '<meta http-equiv="refresh" content="0; url=teacher_list">';
?>