<?php
if(!isset ($_SESSION))
{
session_start();
}


if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}
if(!isset($_GET['學號']) || !isset($_GET['編號']))
{
    header('Location: moni_list');
    exit;
}
require('dbconnect.php');
$StuID = $_GET['學號'];
$MonitorID = $_GET['編號'];

/*
$SQL = "SELECT 學號,舍監編號
      From 學生
      WHERE  學號='$StuID' and 舍監編號='$MonitorID'";

$result = mysqli_query($link, $SQL);

if (mysqli_num_rows($result) == 0) {
    echo "<script type='text/javascript'>";
    echo "alert('資料錯誤')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=moni_list'>";
    exit;
}

if ($StuID == NULL || $MonitorID == NULL) {
    $_SESSION['msg'] = '所有欄位皆為必填';
    header('Location: Moni_list');
    exit;
}

$SQL = "SELECT 宿舍大樓.宿舍編號
      FROM 宿舍大樓,學生
      WHERE 宿舍大樓.宿舍編號='$DomiID' and 學號='$StuID' and 宿舍大樓.性別=學生.性別";

$result = mysqli_query($link, $SQL);

if ($result) {
    if (mysqli_num_rows($result) == 0) {
        $_SESSION['msg'] = '性別錯誤';
        header('Location: moni_list');
        exit;
    }
}

$SQL = "UPDATE 宿舍房間 
      SET 舍監編號=NULL
      WHERE 舍監編號='$MonitorID' and 宿舍編號='$DomiID'";

$result = mysqli_query($link, $SQL);

$SQL = "UPDATE 學生 SET 舍監編號=NULL  WHERE 學號='$StuID'";

$result = mysqli_query($link, $SQL);
*/


//DELETE
$SQL = "DELETE 
      FROM 舍監
      WHERE 舍監編號='$MonitorID'";

$result = mysqli_query($link, $SQL);


if (mysqli_affected_rows($link) > 0) {
    echo "<script type='text/javascript'>";
    echo "alert('刪除成功')";
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
