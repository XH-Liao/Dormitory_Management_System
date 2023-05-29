<?php

//Check："系統管理員"才可使用本頁面、有GET參數
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}
$uAccount = $_GET['學號'];

//查詢是否有此

//刪除學生
require('dbconnect.php');
$SQL = "DELETE FROM 學生
        WHERE 學號='$uAccount'";
$result = mysqli_query($link, $SQL);
if (!$result) {
    echo "<script type='text/javascript'>";
    echo "alert('刪除失敗!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=stu_list'/>";
} else {
    if (mysqli_affected_rows($link) < 1) {
        echo "<script type='text/javascript'>";
        echo "alert('刪除失敗! (無此資料)')";
        echo '</script>';
        echo "<meta http-equiv='Refresh'; content='0; url=stu_list'/>";
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('刪除成功!')";
        echo '</script>';
        echo "<meta http-equiv='Refresh'; content='0; url=stu_list'/>";
    }
}
?>