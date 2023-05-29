<?php

//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

//Check：有"GET"參數
if (!isset($_GET['學號'])) {
    header('Location: stu_list');
    exit;
}
$uAccount = $_GET['學號'];


require('dbconnect.php');
//查詢"學生生日"
$SQL = "SELECT 生日
        FROM 學生
        WHERE 學號='$uAccount'";
$result = mysqli_query($link, $SQL);
$row = mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) <= 0) {        //查無此學生
    echo "<script type='text/javascript'>";
    echo "alert('Error! (無此學生)')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=stu_list'/>";
}else{                                      //有此學生，密碼重設
    $birth_date = $row['生日'];             //取得生日
    $pwd_hash = password_hash("Nuk".$birth_date, PASSWORD_DEFAULT);
    $SQL = "UPDATE 學生
            SET 密碼='$pwd_hash'
            WHERE 學號='$uAccount'";
    if(mysqli_query($link, $SQL)){
        echo "<script type='text/javascript'>";
        echo "alert('密碼重設成功！')";
        echo '</script>';
        echo "<meta http-equiv='Refresh' content='0; url=stu_list'/>";
    }else{
        echo "<script type='text/javascript'>";
        echo "alert('密碼重設失敗！')";
        echo '</script>';
        echo "<meta http-equiv='Refresh' content='0; url=stu_list'/>";
    }
}



?>
