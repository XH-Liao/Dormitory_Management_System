<?php
session_start();
require('dbconnect.php');

//Check："系統管理員"才可使用本頁面
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "舍監") {
    header('Location: login');
    exit;
}

//取得POST參數
$original_uAccount = $_POST['原學號'];
$original_violate_rule = $_POST['原違規事項'];
$original_violate_date = $_POST['原違規日期'];

$new_uAccount = $_POST['學號'];
$new_violate_rule = $_POST['違規事項'];
$new_violate_date = $_POST['違規日期'];

//Check：所有欄位皆為必填
if(!isset($original_uAccount) || !isset($original_violate_rule) || !isset($original_violate_date) || 
    !isset($new_uAccount) || !isset($new_violate_rule) || !isset($new_violate_date)){
    $_SESSION['msg'] = "所有欄位皆為必填";
    header("Location: violate_update?學號=".$new_uAccount."&違規事項=".$new_violate_rule."&違規日期=".$new_violate_date);
    exit;
}

//查詢是否有該筆資料可update
$SQL = "SELECT *
        FROM 違規紀錄
        WHERE 學號='$original_uAccount' AND 違規事項='$original_violate_rule' AND 日期='$original_violate_date'";
$result = mysqli_query($link, $SQL);
if(mysqli_num_rows($result) != 1){
    $_SESSION['msg'] = "Error! (without original data)";
    header("Location: violate_update?學號=".$new_uAccount."&違規事項=".$new_violate_rule."&違規日期=".$new_violate_date);
    exit;
}


$SQL = "UPDATE 違規紀錄
        SET 學號='$new_uAccount', 違規事項='$new_violate_rule', 日期='$new_violate_date'
        WHERE 學號='$original_uAccount' AND 違規事項='$original_violate_rule' AND 日期='$original_violate_date'";
if(!mysqli_query($link, $SQL)){
    $_SESSION['msg'] = "違規資料更新失敗";
    header("Location: violate_update?學號=".$new_uAccount."&違規事項=".$new_violate_rule."&違規日期=".$new_violate_date);
    exit;
}else{
    echo "<script type='text/javascript'>";
    echo "alert('違規資料更新成功！')";
    echo '</script>';
    echo "<meta http-equiv='Refresh' content='0; url=violate_state?學號=".$new_uAccount."'/>";
}
?>