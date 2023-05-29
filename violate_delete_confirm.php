<?php
session_start();
require('dbconnect.php');

//Check："系統管理員"才可使用本頁面、有GET參數
if (!isset($_SESSION['login_identity']) || ($_SESSION['login_identity'] != "系統管理員" && $_SESSION['login_identity'] != "舍監")) {
    header('Location: login');
    exit;
}

if(!isset($_GET['學號']) || !isset($_GET['違規事項']) || !isset($_GET['違規日期'])){
    echo "<script type='text/javascript'>";
    echo "alert('Error!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=violate_state?學號=".$_GET['學號']."'/>";
    exit;
}
$uAccount = $_GET['學號'];
$violate_rule = $_GET['違規事項'];
$violate_date = $_GET['違規日期'];

//刪除違規紀錄
$SQL = "DELETE FROM 違規紀錄
        WHERE 學號='$uAccount' AND 違規事項='$violate_rule' AND 日期='$violate_date'";
$result = mysqli_query($link, $SQL);
if (!$result) {        
    echo "<script type='text/javascript'>";
    echo "alert('違規紀錄 刪除失敗!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=violate_state?學號=".$uAccount."'/>";
}else{
    if(mysqli_affected_rows($link) < 1){
        echo "<script type='text/javascript'> alert('違規紀錄 刪除失敗! (無此違規紀錄)'); </script>";
    }else{
        echo "<script type='text/javascript'> alert('違規紀錄 刪除成功!'); </script>";
    }      
    echo "<meta http-equiv='Refresh'; content='0; url=violate_state?學號=".$uAccount."'/>";
}

?>
