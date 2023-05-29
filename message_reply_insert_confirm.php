<?php
session_start();
require('dbconnect.php');

//HTTP-POST
$message_No = $_POST['No'];
$reply_content = $_POST['回覆內容'];
if ($message_No == null){
    echo "<script type='text/javascript'>";
    echo "alert('Error!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message'/>";
    exit;
}else if ($reply_content == null) {
    echo "<script type='text/javascript'>";
    echo "alert('所有欄位皆為必填!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message_content?No=".$message_No."'/>";
    exit;
}

//Check：必須是"舍監"
if(!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "舍監"){
    echo "<script type='text/javascript'>";
    echo "alert('權限不足，無法回覆!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message_content?No=".$message_No."'/>";
    exit;
}

//新增回覆留言
$SQL = "UPDATE 留言
        SET 回覆內容='$reply_content', 舍監編號='{$_SESSION["login_monitor"]}'
        WHERE No=$message_No";
if(mysqli_query($link, $SQL)){
    header("Location: message_content?No=$message_No");
}else{
    echo "<script type='text/javascript'>";
    echo "alert('回覆留言失敗!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='10; url=message_content?No=".$message_No."'/>";
    exit;
}