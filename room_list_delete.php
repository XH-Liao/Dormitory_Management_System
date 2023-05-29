<?php
if(!isset ($_SESSION))
{
session_start();
}
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}
if(!isset($_GET['宿舍編號']))
{
    header('Location: domi_list');
    exit;
}
require('dbconnect.php');
$DomiID = $_GET['宿舍編號'];
$SQL="SELECT 宿舍編號
      FROM 宿舍大樓
      WHERE 宿舍編號='$DomiID'
      ";
$result=mysqli_query($link,$SQL);
if (mysqli_num_rows($result) == 0) {
    echo "<script type='text/javascript'>";
    echo "alert('資料錯誤')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_list'>";
    exit;
}   
if(!isset($_GET['房間號碼']))
{
    header('Location: room_list?宿舍編號='.$DomiID);
    exit;
}
$RoomID = $_GET['房間號碼'];
$SQL="SELECT 房間號碼
      FROM 宿舍房間
      WHERE 宿舍編號='$DomiID' and 房間號碼='$RoomID'
      ";
$result=mysqli_query($link,$SQL);
if (mysqli_num_rows($result) == 0) {
    echo "<script type='text/javascript'>";
    echo "alert('資料錯誤')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=room_list?宿舍編號=".$DomiID."'>";
    exit;
}



$SQL="UPDATE 宿舍大樓
      SET 房間數=房間數-1
      where 宿舍編號='$DomiID' 
      ";


$result=mysqli_query($link,$SQL);

$SQL="DELETE from 宿舍房間_設備 
      where 宿舍編號='$DomiID' and 房間號碼='$RoomID'
      ";
$result=mysqli_query($link,$SQL);
if(!$result)
    {
        echo "<script type='text/javascript'>";
        echo "alert('刪除失敗')";
        echo "</script>";
        echo "<meta http-equiv='Refresh' content='0; url=index'>";
    }
$SQL="DELETE from 宿舍房間
      where 宿舍編號='$DomiID' and 房間號碼='$RoomID'
      ";
$result=mysqli_query($link,$SQL);

if($result)
{
    echo "<script type='text/javascript'>";
    echo "alert('刪除成功')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=room_list?宿舍編號=$DomiID'>";
}
else
{
    echo "<script type='text/javascript'>";
    echo "alert('刪除失敗')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=room_list?宿舍編號=$DomiID'>";
}














?>