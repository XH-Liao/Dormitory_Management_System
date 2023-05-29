<?php

//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "舍監") {
    header('Location: login');
    exit;
}

//Check：所有欄位皆為必填
$uAccount = $_POST['學號'];
$violate_rule = $_POST['違規事項'];
$violate_date = $_POST['違規日期'];
if($uAccount  == null || $violate_rule == null || $violate_date == null){
    echo "<script type='text/javascript'>";
    echo "alert('所有欄位皆為必填！')";
    echo '</script>';
    echo "<meta http-equiv='Refresh' content='0; url=violate_list'/>";
    exit;
}

//登記違規
require('dbconnect.php');
$SQL = "INSERT INTO 違規紀錄 (學號, 違規事項, 日期) VALUES ('$uAccount', '$violate_rule', '$violate_date')";
$result = mysqli_query($link, $SQL);
if(!$result){
    echo "<script type='text/javascript'>";
    echo "alert('新增違規資料失敗！')";
    echo '</script>';
    echo "<meta http-equiv='Refresh' content='0; url=violate_list'/>";
}else{
    echo "<script type='text/javascript'>";
    echo "alert('新增違規資料成功！')";
    echo '</script>';
    echo "<meta http-equiv='Refresh' content='0; url=violate_list'/>";
}
?>