<?php
session_start();
require('dbconnect.php');

//檢測是否登入
if ($_SESSION['login_account'] == null || $_SESSION['login_identity'] != "學生") {
    header('Location: login');
    exit();
}

// 檢測是否填寫Email
$uAccount = $_SESSION['login_account'];
$SQL = "SELECT Email
            FROM 學生
            WHERE 學號='$uAccount'";
$result = mysqli_query($link, $SQL);
$row = mysqli_fetch_assoc($result);
if ($row["Email"] == NULL) {
    echo "<script type='text/javascript'>alert('提示：請先填寫Email！ \n以便後續發送宿舍通知！')</script>";
    echo "<meta http-equiv='Refresh'; content='0; url=alter_profile'/>";
} else {
    //將申請資料，新增至資料表
    $uAccount = $_SESSION['login_account'];
    require('time.php');
    $SQL = "INSERT INTO 入住申請(核可狀態, 繳費狀態, 學年度, 學期, 學號) VALUES (false, false, '$year', '$semester', '$uAccount')";
    $result = mysqli_query($link, $SQL);
    if ($result) {
        header('Location: applied');
    } else {
        $_SESSION['msg'] = "申請失敗！";
        header('Location: apply');
    }
}
?>