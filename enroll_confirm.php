<?php
session_start();
require('dbconnect.php');

//Check："系統管理員"才可使用本頁面
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

//HTTP-POST取得form輸入資料
$identity = $_POST['identity'];     //註冊的身分
$uAccount = $_POST['帳號'];
$uName = $_POST['姓名'];
$uBirthdate = $_POST['生日'];
if(isset($_POST['班級'])){
    $class_No = $_POST['班級'];
}
if (isset($_POST['性別'])) {
    $uGender = $_POST['性別'];
}

//Debug：確認POST接收到的資料
/*
    echo "學號：".$uAccount;
    echo "<br>姓名：".$uName;
    echo "<br>性別：".$gender;
    echo "<br>生日：".$birthdate;
    exit();
    */

//所有欄位皆為必填
if ($identity == "學生") {
    if ($uAccount == null || $uName == null || $class_No == null || $uGender == null || $uBirthdate == null) {
        $_SESSION['msg'] = "所有欄位皆為必填";
        header('Location: enroll');
        exit;
    }
} else if ($identity == "系統管理員") {
    if ($uAccount == null || $uName == null || $uBirthdate == null) {
        $_SESSION['msg'] = "所有欄位皆為必填";
        header('Location: enroll');
        exit;
    }
} else if ($identity == "老師") {
    if ($uAccount == null || $uName == null || $uBirthdate == null) {
        $_SESSION['msg'] = "除了欄位\"指導班級\"，所有欄位皆為必填";
        header('Location: enroll');
        exit;
    }
} else {
    die("identity error!");
}

// 確認班級存在
if (isset($class_No)) {
    $SQL = "SELECT * FROM 班級 WHERE 班級編號='$class_No'";
    $result = mysqli_query($link, $SQL);
    if (mysqli_num_rows($result) <= 0) {
        echo "<script type='text/javascript'> alert('Error：班級不存在！\\n提示：請輸入正確的班級編號！'); history.back(); </script>";
        exit;
    }
}

//依據生日，給定預設密碼
$uPwd = 'Nuk' . $uBirthdate;  //e.g. Nuk2022-12-13
$pwd_hash = password_hash($uPwd, PASSWORD_DEFAULT);

//檢查：註冊時，使用者帳號不得重複
$amount = 0;
$SQL = "SELECT 學號 
            FROM 學生
            WHERE 學號='$uAccount'";
$result = mysqli_query($link, $SQL);
$amount += mysqli_num_rows($result);

$SQL = "SELECT Account 
            FROM 系統管理員
            WHERE Account='$uAccount'";
$result = mysqli_query($link, $SQL);
$amount += mysqli_num_rows($result);

$SQL = "SELECT 老師編號 
            FROM 老師
            WHERE 老師編號='$uAccount'";
$result = mysqli_query($link, $SQL);
$amount += mysqli_num_rows($result);

if ($amount != 0) {
    if ($identity == "學生")
        $_SESSION['msg'] = '請勿重複註冊，此學生已存在！';
    else if ($identity == "系統管理員")
        $_SESSION['msg'] = '請勿重複註冊，此管理員已存在！';
    else if ($identity == "老師")
        $_SESSION['msg'] = '請勿重複註冊，此老師已存在！';

    echo "<script type='text/javascript'> history.back(); </script>";
    exit;
}

//加入資料表中
if ($identity == "學生")
    $SQL = "INSERT INTO 學生 (學號, 姓名, 性別, 密碼, 生日, 班級編號) VALUES ('$uAccount', '$uName', '$uGender', '$pwd_hash', '$uBirthdate', '$class_No')";
else if ($identity == "系統管理員")
    $SQL = "INSERT INTO 系統管理員 (Account, 姓名, 密碼, 生日) VALUES ('$uAccount', '$uName', '$pwd_hash', '$uBirthdate')";
else if ($identity == "老師") {
    if ($class_No != NULL)
        $SQL = "INSERT INTO 老師 (老師編號, 姓名, 密碼, 生日, 班級編號) VALUES ('$uAccount', '$uName', '$pwd_hash', '$uBirthdate', '$class_No')";
    else
        $SQL = "INSERT INTO 老師 (老師編號, 姓名, 密碼, 生日) VALUES ('$uAccount', '$uName', '$pwd_hash', '$uBirthdate')";
}


if (mysqli_query($link, $SQL)) {
    echo "<script type='text/javascript'> alert('註冊成功'); </script>";
    if ($identity == "學生")
        echo "<meta http-equiv='Refresh' content='0; url=stu_list'>";
    else if ($identity == "系統管理員")
        echo "<meta http-equiv='Refresh' content='0; url=admin_list'>";
    else if ($identity == "老師")
        echo "<meta http-equiv='Refresh' content='0; url=teacher_list'>";
} else {
    echo "<script type='text/javascript'> alert('註冊失敗'); history.back(); </script>";
}
