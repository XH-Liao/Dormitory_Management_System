<?php
session_start();
require('dbconnect.php');

//Check："系統管理員"才可使用本頁面
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

//HTTP-POST取得form輸入資料
$original_uAccount = $_POST['原學號'];
$uAccount = $_POST['學號'];
$uName = $_POST['姓名'];
$class_Number = $_POST["班級"];
$uGender = $_POST['性別'];
$uBirthdate = $_POST['生日'];

//所有欄位皆為必填
if ($original_uAccount == null || $uAccount == null || $uName == null || $class_Number == null 
    || $uGender == null || $uBirthdate == null) {
    $_SESSION['msg'] = "所有欄位皆為必填";
    header("Location: stu_list_update?學號=$original_uAccount");
    exit;
}

//學號不同 => 代表要修改學號 => 確認新學號尚無被註冊
if($original_uAccount != $uAccount){
    $SQL = "SELECT 學號
            FROM 學生
            WHERE 學號='$uAccount'";
    $result = mysqli_query($link, $SQL);
    if(mysqli_num_rows($result) > 0){
        $_SESSION['msg'] = "修改失敗！此學號已存在";
        header("Location: stu_list_update?學號=$original_uAccount");
        exit;
    }
}

//修改學生資料
$SQL = "UPDATE 學生
        SET 學號='$uAccount', 姓名='$uName', 班級編號='$class_Number', 性別='$uGender', 生日='$uBirthdate'
        WHERE 學號='$original_uAccount'";
if(!mysqli_query($link, $SQL)){
    $_SESSION['msg'] = "學生資料修改失敗";
    header("Location: stu_list_update?學號=$original_uAccount");
}else{
    echo "<script type='text/javascript'>";
    echo "alert('學生資料修改成功!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=stu_list'/>";
}
