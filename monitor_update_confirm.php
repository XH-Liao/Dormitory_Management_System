<?php
if (!isset($_SESSION)) {
    session_start();
}
require('dbconnect.php');

//HTTP-Post
$StuID = $_POST['SID'];
$MonitorID = $_POST['舍監編號'];


$O_MID = $_POST['MID'];



if ($MonitorID == NULL) {
    $_SESSION['msg'] = '所有欄位皆為必填';
    header('Location: moni_list_update?學號=' . $StuID . '&編號=' . $O_MID);
    exit;
}


if ($MonitorID != $O_MID) {
    $SQL = "SELECT 舍監編號
      from 舍監
      where 舍監編號='$MonitorID'
      ";
    $result = mysqli_query($link, $SQL);

    if (mysqli_num_rows($result) != 0) {
        $_SESSION['msg'] = '已有此編號';
        header('Location: moni_list_update?學號=' . $StuID . '&編號=' . $O_MID);
        exit;
    }
}
if($MonitorID == $O_MID)
{
    
    $_SESSION['msg'] = '已經是此編號了';
    header('Location: moni_list_update?學號=' . $StuID . '&編號=' . $O_MID);
    exit;
    
}

$SQL = "UPDATE 舍監
        SET 舍監編號='$MonitorID'
        WHERE 舍監編號='$O_MID'";
$result = mysqli_query($link, $SQL);


/*
$SQL = "INSERT INTO 舍監 (舍監編號) VALUES ('$MonitorID')";
$result = mysqli_query($link, $SQL);

$SQL = "UPDATE 宿舍房間 
      SET 舍監編號='$MonitorID'
      WHERE 舍監編號='$O_MID'";

$result = mysqli_query($link, $SQL);

$SQL = "UPDATE 學生 SET 舍監編號='$MonitorID'  WHERE 學號='$StuID'";

$result = mysqli_query($link, $SQL);

$SQL = "UPDATE 學生 
      SET 舍監編號='$MonitorID' 
      where 學號='$StuID'";

$result = mysqli_query($link, $SQL);

$SQL = "DELETE From 舍監
      where 舍監編號='$O_MID'";

$result = mysqli_query($link, $SQL);
*/


if (mysqli_affected_rows($link) > 0) {
    echo "<script type='text/javascript'>";
    echo "alert('更動成功')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=moni_list'>";
} else if (mysqli_affected_rows($link) == 0) {
    echo "<script type='text/javascript'>";
    echo "alert('無資料更動')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=moni_list'>";
} else {
    echo "<script type='text/javascript'>";
    echo "alert('連線錯誤')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=moni_list'>";
}
