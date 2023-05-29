<?php
session_start();
require('dbconnect.php');

//GET參數
$message_No = $_GET['No'];
if($message_No == null){
    echo "<script type='text/javascript'>";
    echo "alert('Error!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message'/>";
    exit;
}

//Check：有回覆內容
$SQL = "SELECT 回覆內容, 舍監編號
        FROM 留言
        WHERE No=$message_No";
$result = mysqli_query($link, $SQL);
$row = mysqli_fetch_assoc($result);
if($row["回覆內容"] == null){
    echo "<script type='text/javascript'>";
    echo "alert('Error!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message'/>";
    exit;
}

//Check：回覆者本人、"系統管理員"才可刪除
if(!isset($_SESSION['login_identity']) || ($_SESSION['login_identity'] != "系統管理員") && $row["舍監編號"] != $_SESSION["login_monitor"]){
    echo "<script type='text/javascript'>";
    echo "alert('權限不足，無法修改!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message_content?No=".$message_No."'/>";
    exit;
}

//刪除回覆內容
$SQL = "UPDATE 留言
        SET 回覆內容=NULL, 舍監編號=NULL, 回覆時間=NULL
        WHERE No=$message_No";
$result = mysqli_query($link, $SQL);
if (!$result) {        // || mysqli_affected_rows($link) <= 0
    echo "<script type='text/javascript'>";
    echo "alert('留言刪除失敗!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message_content?No=".$message_No."'/>";
}
else{                                    
    echo "<script type='text/javascript'>";
    echo "alert('留言刪除成功!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message_content?No=".$message_No."'/>";
}

?>
