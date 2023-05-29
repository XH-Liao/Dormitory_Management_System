<?php
session_start();
require('dbconnect.php');

//Check："系統管理員"、"舍監" 才可使用
if (!isset($_SESSION['login_identity']) || ($_SESSION['login_identity'] != "系統管理員" && $_SESSION['login_identity'] != "舍監")) {
    header('Location: login');
    exit;
}

if($_GET['No'] == null){
    echo "<script type='text/javascript'>";
    echo "alert('Error!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=./'/>";
}else{
//刪除公告
$SQL = "DELETE FROM 系統消息
        WHERE No='{$_GET['No']}'";
$result = mysqli_query($link, $SQL);
if (!$result) {        
    echo "<script type='text/javascript'>";
    echo "alert('刪除失敗!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=./'/>";
}else{
    if(mysqli_affected_rows($link) < 1){
        echo "<script type='text/javascript'> alert('刪除失敗! (無此公告)'); </script>";
    }else{
        echo "<script type='text/javascript'> alert('刪除成功!'); </script>";
    }      
    echo "<meta http-equiv='Refresh'; content='0; url=./'/>";
}
}



?>
