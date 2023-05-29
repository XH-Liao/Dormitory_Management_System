<?php
session_start();
require('dbconnect.php');

//Check："系統管理員"才可使用本頁面
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

//HTTP-POST
$announce_title = $_POST['公告標題'];
$announce_content = $_POST['公告內容'];
if($announce_title == null || $announce_content == null){
    echo "<script type='text/javascript'>";
    echo "alert('所有欄位皆為必填!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=./'/>";
}

//新增至DB
if($_SESSION['login_identity'] == "系統管理員"){
    $SQL = "INSERT INTO 系統消息 (標題, 內容, Account) VALUES ('$announce_title', '$announce_content', '{$_SESSION['login_account']}')";
}else{
    $SQL = "INSERT INTO 系統消息 (標題, 內容, 舍監編號) VALUES ('$announce_title', '$announce_content', '{$_SESSION['login_account']}')";
}
if(mysqli_query($link, $SQL)){
    echo "<script type='text/javascript'>";
    echo "alert('公告成功!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=./'/>";
}else{
    echo "<script type='text/javascript'>";
    echo "alert('公告失敗!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=./'/>";
}

?>