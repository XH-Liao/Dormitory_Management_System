<?php
session_start();

//Check：不可為null
$uAccount1 = $_POST['學號1'];
$uAccount2 = $_POST['學號2'];

if($uAccount1 == null || $uAccount2 ==null){
    $_SESSION['msg_change'] = "所有欄位皆為必填";
    header('Location: assign_room');
    exit;
}

if($uAccount1 == $uAccount2){
    $_SESSION["msg_change"] = "兩位學號不可相同！";
    echo "<script> history.back(); </script>";
    exit;
}

require('dbconnect.php');
//查詢兩學生的房號
$SQL1="SELECT 宿舍編號, 房間號碼, 性別
        FROM 學生
        WHERE 學號='$uAccount1'";
$result1 = mysqli_query($link, $SQL1);
$SQL2="SELECT 宿舍編號, 房間號碼, 性別
        FROM 學生
        WHERE 學號='$uAccount2'";
$result2 = mysqli_query($link, $SQL2);

//Check：兩位學生皆須有房號才可交換
if(mysqli_num_rows($result1) != 1 || mysqli_num_rows($result2) != 1){
    $_SESSION['msg_change'] = "兩位學生皆須有房號才可交換！";
    echo "<script> history.back(); </script>";
    exit;
}

//Check：兩位房號不可相同！
$row1 = mysqli_fetch_assoc($result1);
$row2 = mysqli_fetch_assoc($result2);
if($row1['宿舍編號'] == $row2['宿舍編號'] && $row1['房間號碼'] == $row2['房間號碼']){
    $_SESSION["msg_change"] = "兩位房號不可相同！";
    echo "<script> history.back(); </script>";
    exit;
}else if($row1['性別'] != $row2['性別']){
    $_SESSION["msg_change"] = "兩位性別必須相同！";
    echo "<script> history.back(); </script>";
    exit;
}

$building_ID1= $row1['宿舍編號'];
$room_number1= $row1['房間號碼'];
$building_ID2= $row2['宿舍編號'];
$room_number2= $row2['房間號碼'];

//開始交換房號
//stu1換
$SQL1 = "UPDATE 學生
        SET 宿舍編號='$building_ID2', 房間號碼='$room_number2'
        WHERE 學號='$uAccount1'";
$result1=mysqli_query($link, $SQL1);

$SQL2 = "UPDATE 學生
        SET 宿舍編號='$building_ID1', 房間號碼='$room_number1'
        WHERE 學號='$uAccount2'";
$result2 = mysqli_query($link, $SQL2);

if(!$result1 || !$result2){
    $_SESSION['msg_change'] = "交換房間失敗！";
    echo "<script> history.back(); </script>";
    exit;
}else{
    $_SESSION['msg_change'] = "交換房間成功！";
    header('Location: assign_room');
}
?>