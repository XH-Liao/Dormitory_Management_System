<?php
session_start();
require('dbconnect.php');

//GET參數
$No = $_GET['No'];
if($No == null){
    echo "<script type='text/javascript'>";
    echo "alert('Error!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message'/>";
    exit;
}

//Check：留言者本人、"舍監"、"系統管理員"才可刪除
$SQL = "SELECT 學號, 回覆內容
        FROM 留言
        WHERE No=$No";
$result = mysqli_query($link, $SQL);
if(mysqli_num_rows($result) != 1){
    echo "<script type='text/javascript'>";
    echo "alert('Error!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message'/>";
    exit;
}

//Check：留言者本人、"舍監"、"系統管理員"才可刪除
$row = mysqli_fetch_assoc($result);
if(!isset($_SESSION['login_identity']) || ($row["學號"] != $_SESSION["login_account"] && $_SESSION['login_identity'] != "系統管理員" && $_SESSION['login_identity'] != "舍監")){
    echo "<script type='text/javascript'>";
    echo "alert('權限不足，無法修改!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message_content?No=".$message_No."'/>";
    exit;
}

//刪除留言
$SQL = "DELETE FROM 留言
        WHERE No=$No";
$result = mysqli_query($link, $SQL);
if (!$result) {        
    echo "<script type='text/javascript'>";
    echo "alert('留言刪除失敗!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message'/>";
}else{         
    if(mysqli_affected_rows($link) < 1){
        echo "<script type='text/javascript'> alert('留言刪除失敗! (無此留言)'); </script>";
    } else{
        echo "<script type='text/javascript'> alert('留言刪除成功!'); </script>";
    }     
    echo "<meta http-equiv='Refresh'; content='0; url=message'/>";
}
