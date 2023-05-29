<?php

//Check："學生"才可使用
session_start();
if($_SESSION['login_identity'] != "學生"){
    header('Location: login');
    exit();
}
$uAccount = $_SESSION['login_account'];

//確認是否已申請過
require('dbconnect.php');
require('time.php');
$SQL = "SELECT 學號
        FROM 入住申請
        WHERE 學號='$uAccount' AND 學年度='$year' AND 學期='$semester' AND 核可狀態=true AND 繳費狀態=false";
$result = mysqli_query($link, $SQL);
if(mysqli_num_rows($result) <= 0){
    header('Location: applied');
    exit();
}

//POST參數
$pay_fee = $_POST['繳費金額'];
$card_number = $_POST['信用卡號'];
$check_three_number = $_POST['三碼檢查碼'];
$closing_date = $_POST['信用卡到期'];

//不為null
if($pay_fee==null || $card_number== null || $check_three_number==null || $closing_date==null){
    $_SESSION['msg'] = "所有欄位皆為必填！";
    header('Location: applied');
    exit;
}

//確認參數值合法
$SQL = "SELECT 房間住宿費用
        FROM 宿舍大樓, 學生
        WHERE 學生.宿舍編號=宿舍大樓.宿舍編號 AND 學號='$uAccount'";
$result = mysqli_query($link, $SQL);
$row = mysqli_fetch_assoc($result);
if($pay_fee != $row['房間住宿費用'] || strlen($card_number)!=12 || strlen($check_three_number)!=3){
    $_SESSION['msg'] = "繳費資料錯誤！";
    header('Location: applied');
    exit;
}

//UPDATE 繳費狀態
$SQL = "UPDATE 入住申請
        SET 繳費狀態=true
        WHERE 學號='$uAccount'";
$result = mysqli_query($link, $SQL);

if(!$result){
    $_SESSION['msg'] = "繳費失敗！";
}else{
    $_SESSION['msg'] = "繳費成功！";
}
header('Location: applied');
?>