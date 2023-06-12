<?php
session_start();
require('dbconnect.php');

    //Check："系統管理員"才可使用本頁面
    if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
        header('Location: login');
        exit;
    }

    //HTTP-POST取得form輸入資料
    $identity = $_POST['identity'];
    $uAccount = $_POST['學號'];
    $uName = $_POST['姓名'];
    $uBirthdate = $_POST['生日'];
    if($identity == "學生"){
        $uAccount = $_POST['學號'];
        $uGender = $_POST['性別'];
        $uClass = $_POST['班級'];
    }else if($identity == "老師"){
        $uClass = $_POST['班級編號'];
    }

    //Debug：確認POST接收到的資料
    /*
    echo "身份：".$identity;
    echo "<br>帳號：".$uAccount;
    echo "<br>姓名：".$uName;
    echo "<br>生日：".$uBirthdate;
    if($identity == "學生"){
        echo "<br>學號：".$uAccount;
        echo "<br>性別：".$uGender;
        echo "<br>班級：".$uClass;
    }else if($identity == "老師"){
        echo "<br>指導班級：".$uClass;
    }
    exit();
    */

    //所有欄位皆為必填
    if($identity == "學生"){
        if($uAccount==null || $uName==null || $uGender==null || $uBirthdate==null || $uClass==null){
            $_SESSION['msg']="所有欄位皆為必填";
            header('Location: enroll');
            exit;
        }
    }
    else if($identity == "老師"){
        if($uAccount==null || $uName==null || $uBirthdate==null || $uClass==null){
            $_SESSION['msg']="所有欄位皆為必填";
            header('Location: enroll');
            exit;
        }
    }else{
        die("identity error!");
    }

    //依據生日，給定預設密碼
    $uPwd = 'Nuk'.$uBirthdate;  //e.g. Nuk2022-12-13
    $pwd_hash = password_hash($uPwd, PASSWORD_DEFAULT);
    
    //檢查：註冊時，使用者帳號不得重複
    $amount = 0;
    $SQL = "SELECT 學號 
    FROM 學生
    WHERE 學號='$uAccount'";
    $result = mysqli_query($link, $SQL);
    $amount = mysqli_num_rows($result);
    
    if($amount > 0){
        $_SESSION['msg']="此學號已註冊";
        header('Location: enroll');
        exit;
    }
    //插入使用者資料至資料庫
    //
    //$SQL = "INSERT INTO 使用者 (帳號, 密碼, 姓名, 身份, 生日) 
    //VALUES ('$uAccount', '$pwd_hash', '$uName', '$identity', '$uBirthdate')";
    //mysqli_query($link, $SQL) or die(mysqli_error($link));


    //取得使用者編號
    //$uAccount = mysqli_insert_id($link);
    
    //根據身份插入對應資料表
    if($identity == "學生"){
        $SQL = "INSERT INTO 學生 (學號, 性別, 班級) 
        VALUES ('$uAccount', '$uGender', '$uClass')";
        }
        else if($identity == "老師"){
            $SQL = "INSERT INTO 老師 (老師編號, 班級編號) 
            VALUES ('$uAccount', '$uClass')";
            }
            else if($identity == "系統管理員"){
                //無需插入其他資料表
            }
            mysqli_query($link, $SQL) or die(mysqli_error($link));
            //顯示註冊結果
            $_SESSION['msg']="註冊成功！";
            header('Location: enroll');
            exit;
?>