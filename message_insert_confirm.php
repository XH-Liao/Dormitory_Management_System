<?php
session_start();
require('dbconnect.php');

//Check："學生"才可使用本頁面
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "學生") {
    header('Location: login');
    exit;
}

//HTTP-POST
$message_title = $_POST['留言標題'];
$message_content = $_POST['留言內容'];
if($message_title == null || $message_content == null){
    echo "<script type='text/javascript'>";
    echo "alert('所有欄位皆為必填!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message'/>";
}

//新增至DB
$SQL = "INSERT INTO 留言 (標題, 內容, 學號) VALUES ('$message_title', '$message_content', '{$_SESSION['login_account']}')";

if(mysqli_query($link, $SQL)){
    echo "<script type='text/javascript'>";
    echo "alert('留言成功!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message'/>";
}else{
    echo "<script type='text/javascript'>";
    echo "alert('留言失敗!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message'/>";
}

?>