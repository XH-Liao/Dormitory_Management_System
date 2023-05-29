<?php
session_start();
require('dbconnect.php');

$uAccount = $_POST['帳號'];
$uPwd = $_POST['密碼'];

if ($uAccount == null || $uPwd == null) {
    $_SESSION['msg'] = "帳號密碼皆為必填";
    header('Location: login.php');
    exit;
}

//檢查帳號是否在"學生"table
$SQL = "SELECT 密碼, 姓名, 舍監編號, 生日
        FROM 學生
        WHERE 學號='$uAccount'";
$result = mysqli_query($link, $SQL);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    //Check：密碼正確
    if (!password_verify($uPwd, $row["密碼"])) {
        $_SESSION['msg'] = "帳號或密碼錯誤！";
        header('Location: login');
        exit();
    }
    //設定登入身分、姓名
    if ($row["舍監編號"] != NULL) {
        $_SESSION['login_identity'] = "舍監";
        $_SESSION["login_monitor"] = $row["舍監編號"];
    } else {
        $_SESSION['login_identity'] = "學生";
    }
    $_SESSION['login_account'] = $uAccount;
    $_SESSION['姓名'] = $row['姓名'];
    //Check：是否有修改預設密碼
    if ($uPwd != "Nuk" . $row["生日"]) {
        $_SESSION["changed_password"] = true;
        header('Location: ./');
    } else {
        $_SESSION["changed_password"] = false;
        header('Location: alter_password');
    }
} else {                    //檢查帳號是否在"系統管理員"table
    $SQL = "SELECT 密碼, 姓名, 生日
            FROM 系統管理員
            WHERE Account='$uAccount'";
    $result = mysqli_query($link, $SQL);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        //Check：密碼正確
        if (!password_verify($uPwd, $row["密碼"])) {
            $_SESSION['msg'] = "帳號或密碼錯誤！";
            header('Location: login');
            exit();
        }
        //設定登入身分、姓名
        $_SESSION['login_identity'] = "系統管理員";
        $_SESSION['login_account'] = $uAccount;
        $_SESSION['姓名'] = $row['姓名'];
        //Check：是否有修改預設密碼
        if ($uPwd != "Nuk" . $row["生日"]) {
            $_SESSION["changed_password"] = true;
            header('Location: ./');
        } else {
            $_SESSION["changed_password"] = false;
            header('Location: alter_password');
        }
    } else {            //"此帳號不存在"
        $_SESSION['msg'] = "此帳號不存在！";
        header('Location: login');
        exit();
    }
}
      
//for Debug：輸出查詢到資料庫的uName、uPwd
/*
echo "DB query result：<br>";
echo "使用者名稱：".$row['uName']."<br>";
echo "密碼：".$row['uPwd']."<br>";
*/

//檢測登入錯誤情況
/*
if(mysqli_num_rows($result)<1){
    $_SESSION['msg'] = "此帳號不存在";
    header('Location: login.php');
}
else if(mysqli_num_rows($result)>1){
    $_SESSION['msg'] = "此學號異常！";  //(DB存在兩個以上相同的學號)
    header('Location: login.php');
}
else if($row['密碼'] != $uPwd){
    $_SESSION['is_login'] = FALSE;
    $_SESSION['msg'] = "密碼錯誤！";
    header('Location: login.php');
}else{
    $_SESSION['is_login'] = TRUE;
    $_SESSION['姓名'] = $row['姓名'];
    header('Location: index.php');
}
mysqli_close($link);
*/
