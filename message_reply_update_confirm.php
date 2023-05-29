<?php
session_start();
require('dbconnect.php');

//HTTP-POST
$message_No = $_POST['No'];
$reply_content = $_POST['回覆內容'];
if ($message_No == null || $reply_content == null) {
    $_SESSION["msg"] = "所有欄位皆為必填";
    header("Location: message_update?No=$message_No");
    exit;
}

//Check：有此留言、查詢此留言回覆
$SQL = "SELECT 回覆內容, 舍監編號
        FROM 留言
        WHERE No=$message_No";
$result = mysqli_query($link, $SQL);
if(mysqli_num_rows($result) != 1){
    echo "<script type='text/javascript'>";
    echo "alert('Error!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message'/>";
    exit;
}

//Check：必須是回覆者本人才可修改
$row = mysqli_fetch_assoc($result);
if(!isset($_SESSION['login_identity']) || $row["舍監編號"] != $_SESSION["login_monitor"]){
    echo "<script type='text/javascript'>";
    echo "alert('權限不足，無法修改!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message_content?No=".$message_No."'/>";
    exit;
}

//UPDATE 回覆內容
$SQL = "UPDATE 留言
        SET 回覆內容='$reply_content'
        WHERE No='$message_No'";
if (mysqli_query($link, $SQL)) {
    echo "<script type='text/javascript'>";
    echo "alert('回覆內容 修改成功!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message_content?No=$message_No'/>";
} else {
    $_SESSION["msg"] = "回覆內容 修改失敗!";
    header("Location: message_update?No=$message_No");
    exit;
}
