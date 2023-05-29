<?php
if(!isset ($_SESSION))
{
session_start();
}
require('dbconnect.php');

//HTTP-Post
$RoomID=$_POST['房間號碼'];

$O_RoomID=$_POST['RID'];
$DID=$_POST['DID'];

    
if($RoomID == NULL )
{
    $_SESSION['msg']='所有欄位皆為必填';
    header('Location: room_list_update?宿舍編號='.$DID.'&房間號碼='.$O_RoomID.'');
    exit;
}
$SQL="SELECT 房間號碼
      from 宿舍房間
      where 房間號碼='$RoomID' and 宿舍編號='$DID'";

$result=mysqli_query($link,$SQL);

if(mysqli_num_rows($result)!=0)
{
    $_SESSION['msg']='已有此房間';
    header('Location: room_list_update?宿舍編號='.$DID.'&房間號碼='.$O_RoomID.'');
    exit;
}

$SQL="UPDATE 宿舍房間
      SET 房間號碼='$RoomID' 
      where 宿舍編號='$DID' and 房間號碼 ='$O_RoomID' 
      ";


$result=mysqli_query($link,$SQL);



if(mysqli_affected_rows($link)>0)
{
    echo "<script type='text/javascript'>";
    echo "alert('更動成功')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=room_list?宿舍編號=$DID'>";
}
else if(mysqli_affected_rows($link)==0)
{
    echo "<script type='text/javascript'>";
    echo "alert('無資料更動')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=room_list?宿舍編號=$DID'>";
}
else{
    echo "<script type='text/javascript'>";
    echo "alert('連線錯誤')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=room_list?宿舍編號=$DID'>";
}
