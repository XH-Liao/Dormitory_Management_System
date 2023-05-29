<?php
    session_start();
    require('dbconnect.php');

    //檢測是否登入
    if($_SESSION['login_account'] == null || $_SESSION['login_identity'] != "學生"){
        header('Location: login');
        exit();
    }
    
    //將申請資料，新增至資料表
    $uAccount = $_SESSION['login_account'];
    require('time.php');
    $SQL = "INSERT INTO 入住申請(核可狀態, 繳費狀態, 學年度, 學期, 學號) VALUES (false, false, '$year', '$semester', '$uAccount')";
    $result = mysqli_query($link, $SQL);
    if($result){
        header('Location: applied');
    }else{
        $_SESSION['msg'] = "申請失敗！";
        header('Location: apply');
    }