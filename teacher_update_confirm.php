<?php
session_start();
require("dbconnect.php");

//Check："系統管理員"才可使用本頁面 
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

//POST
$Account = $_POST["Account"];
$name = $_POST["姓名"];
$birth_date = $_POST["生日"];
$class_No = $_POST["班級"];
if($class_No != NULL){
    $SQL = "SELECT * FROM 班級 WHERE 班級編號='$class_No'";
    $result = mysqli_query($link, $SQL);
    if (mysqli_num_rows($result) <= 0) {
        echo "<script type='text/javascript'> alert('Error：班級不存在！\\n提示：請輸入正確的班級編號！'); history.back(); </script>";
        exit;
    }
}

if($name == null || $birth_date == null){
    $_SESSION["msg"] = "姓名與生日為必填";
    echo "<script>history.back();</script>";
    exit;
}

//update 姓名、生日
if($class_No != NULL){
    $SQL = "UPDATE 老師
            SET 班級編號='$class_No', 姓名='$name', 生日='$birth_date'
            WHERE 老師編號='$Account'";
}else{
    $SQL = "UPDATE 老師
            SET 班級編號=NULL, 姓名='$name', 生日='$birth_date'
            WHERE 老師編號='$Account'";
}

if(!mysqli_query($link, $SQL)){
    $_SESSION["msg"] = "資料修改失敗！";
    echo "<script>history.back();</script>";
}else{
    echo "<script> alert('資料修改成功！'); </script>";
    echo '<meta http-equiv="refresh" content="0; url=teacher_list">';
}

?>