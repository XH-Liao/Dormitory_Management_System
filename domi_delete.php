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
    exit();
}
require('dbconnect.php');
$DomiNum = $_GET['宿舍編號'];
$SQL = "SELECT 宿舍編號
      From 宿舍大樓
      WHERE  宿舍編號='$DomiNum'";

$result = mysqli_query($link, $SQL);

if (mysqli_num_rows($result) == 0) {
    echo "<script type='text/javascript'>";
    echo "alert('資料錯誤')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_list'>";
    exit;
}

$SQL="DELETE from 宿舍房間_設備 
      where 宿舍編號='$DomiNum'
      ";
$result=mysqli_query($link,$SQL);
if(!$result)
    {
        echo "<script type='text/javascript'>";
        echo "alert('刪除失敗')";
        echo "</script>";
        echo "<meta http-equiv='Refresh' content='0; url=domi_list'>";
    }
$SQL="DELETE from 宿舍房間
      where 宿舍編號='$DomiNum'
      ";
$result=mysqli_query($link,$SQL);
if(!$result)
{
    echo "<script type='text/javascript'>";
    echo "alert('刪除失敗')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_list'>";
}
$SQL="DELETE from 宿舍大樓_大樓設備
      where 宿舍編號='$DomiNum'
      ";
$result=mysqli_query($link,$SQL);
if(!$result)
{
    echo "<script type='text/javascript'>";
    echo "alert('刪除失敗')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_list'>";
}

$SQL="DELETE from 宿舍大樓
      where 宿舍編號='$DomiNum'
      ";
$result=mysqli_query($link,$SQL);
if($result)
{
    echo "<script type='text/javascript'>";
    echo "alert('刪除成功')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_list'>";
}
else
{
    echo "<script type='text/javascript'>";
    echo "alert('刪除失敗')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_list'>";
}














?>