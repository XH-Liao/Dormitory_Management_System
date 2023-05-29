<?php
session_start();
require('dbconnect.php');

//Check："系統管理員"、"舍監" 才可使用
if (!isset($_SESSION['login_identity']) || ($_SESSION['login_identity'] != "系統管理員" && $_SESSION['login_identity'] != "舍監")) {
    header('Location: login');
    exit;
}
$uAccount = $_SESSION['login_account'];

//HTTP-POST
$announce_No = $_POST['No'];
$announce_title = $_POST['公告標題'];
$announce_content = $_POST['公告事項'];
if($announce_No == null || $announce_title == null || $announce_content == null){
    $_SESSION["msg"] = "所有欄位皆為必填";
    header("Location: announce_update?No=$announce_No");
    exit;
}

//UPDATE
if($_SESSION['login_identity'] == "系統管理員"){
    $SQL = "UPDATE 系統消息
            SET 標題='$announce_title', 內容='$announce_content', Account='$uAccount', 舍監編號=NULL
            WHERE No='$announce_No'";
}else if($_SESSION['login_identity'] == "舍監"){
    $SQL = "UPDATE 系統消息
            SET 標題='$announce_title', 內容='$announce_content', Account=NULL, 舍監編號='$uAccount'
            WHERE No='$announce_No'";
}

if(mysqli_query($link, $SQL)){
    echo "<script type='text/javascript'>";
    echo "alert('公告事項 修改成功!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=announce_content?No=$announce_No'/>";
}else{
    $_SESSION["msg"] = "公告事項 修改失敗!";
    header("Location: announce_update?No=$announce_No");
    exit;
}

?>