<?php
session_start();
require("dbconnect.php");

//確認有登入
if(!isset($_SESSION["login_account"])){
    echo "<script type='text/javascript'>";
    echo "alert('請先登入!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=login'/>";
    exit;
}

//POST參數
$original_password = $_POST["原密碼"];
$new_password = $_POST["新密碼"];
$check_password = $_POST["確認密碼"];
if($original_password == null || $new_password == null || $check_password == null){
    $_SESSION["msg"] = "所有欄位皆為必填";
    header("Location: alter_password");
    exit;
}

//Check：新密碼長度
if(strlen($new_password) < 8){
    $_SESSION["msg"] = "新密碼長度不足！";
    header("Location: alter_password");
    exit;
}

//Check：新舊密碼不相同
if($new_password == $original_password){
    $_SESSION["msg"] = "新舊密碼不可相同！";
    header("Location: alter_password");
    exit;
}

//確認驗證密碼相同
if($new_password != $check_password){
    $_SESSION["msg"] = "確認密碼錯誤！";
    header("Location: alter_password");
    exit;
}

//確認原密碼正確、不是預設密碼
if($_SESSION["login_identity"] == "系統管理員"){                //查詢系統管理員密碼
    $SQL = "SELECT 密碼, 生日
            FROM 系統管理員
            WHERE Account='{$_SESSION["login_account"]}'";
}else if($_SESSION["login_identity"] == "學生"){                //查詢學生、舍監密碼
    $SQL = "SELECT 密碼, 生日
            FROM 學生
            WHERE 學號='{$_SESSION["login_account"]}'";
}else if($_SESSION["login_identity"] == "老師"){                //查詢老師密碼
    $SQL = "SELECT 密碼, 生日
            FROM 老師
            WHERE 老師編號='{$_SESSION["login_account"]}'";
}
$result = mysqli_query($link, $SQL);
$row = mysqli_fetch_assoc($result);
//Check：密碼正確
if (!password_verify($original_password, $row["密碼"])) {
    $_SESSION['msg'] = "原密碼錯誤！";
    header("Location: alter_password");
    exit;
}
//Check：不是預設密碼
if($new_password == "Nuk".$row["生日"]){
    $_SESSION["msg"] = "不可修改為預設密碼";
    header("Location: alter_password");
    exit;
}

//UPDATE 新密碼
$pwd_hash = password_hash($new_password, PASSWORD_DEFAULT);
if($_SESSION["login_identity"] == "系統管理員"){
    $SQL = "UPDATE 系統管理員
            SET 密碼='$pwd_hash'
            WHERE Account='{$_SESSION["login_account"]}'";
}else if($_SESSION["login_identity"] == "學生"){
    $SQL = "UPDATE 學生
            SET 密碼='$pwd_hash'
            WHERE 學號='{$_SESSION["login_account"]}'";
}else if($_SESSION["login_identity"] == "老師"){
    $SQL = "UPDATE 老師
            SET 密碼='$pwd_hash'
            WHERE 老師編號='{$_SESSION["login_account"]}'";
}

if(!mysqli_query($link, $SQL)){
    $_SESSION["msg"] = "密碼修改失敗！";
    header("Location: alter_password");
}else{
    $_SESSION["changed_password"] = true;
    echo "<script type='text/javascript'>";
    echo "alert('密碼修改成功!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=index'/>";
}
?>