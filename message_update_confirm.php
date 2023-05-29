<?php
session_start();
require('dbconnect.php');

//HTTP-POST
$message_No = $_POST['No'];
$messag_title = $_POST['留言標題'];
$messag_content = $_POST['留言事項'];
if ($message_No == null || $messag_title == null || $messag_content == null) {
    $_SESSION["msg"] = "所有欄位皆為必填";
    header("Location: message_update?No=$message_No");
    exit;
}

$SQL = "SELECT 學號, 回覆內容
        FROM 留言
        WHERE No=$message_No";
$result = mysqli_query($link, $SQL);
$row = mysqli_fetch_assoc($result);

//Check：必須是留言者本人才可修改
if(!isset($_SESSION['login_identity']) || $row["學號"] != $_SESSION["login_account"]){
    echo "<script type='text/javascript'>";
    echo "alert('權限不足，無法修改!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message_content?No=".$message_No."'/>";
    exit;
}
//Check：訊息已被回覆後無法修改
if($row["回覆內容"] != NULL){
    echo "<script type='text/javascript'>";
    echo "alert('此訊息已被回覆，無法修改!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message_content?No=".$message_No."'/>";
    exit;
}

//UPDATE
$SQL = "UPDATE 留言
        SET 標題='$messag_title', 內容='$messag_content'
        WHERE No='$message_No'";
if (mysqli_query($link, $SQL)) {
    echo "<script type='text/javascript'>";
    echo "alert('留言訊息 修改成功!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message_content?No=$message_No'/>";
} else {
    $_SESSION["msg"] = "留言訊息 修改失敗!";
    header("Location: message_update?No=$message_No");
    exit;
}
