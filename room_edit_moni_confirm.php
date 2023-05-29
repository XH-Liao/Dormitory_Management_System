<?php
if(!isset ($_SESSION))
{
session_start();
}
require('dbconnect.php');

//HTTP-Post
$O_RoomID=$_POST['RID'];
$DID=$_POST['DID'];

$MoniID=$_POST['舍監編號'];
    
if($MoniID == NULL )
{
    $_SESSION['msg']='所有欄位皆為必填';
    header('Location: room_edit_moni?宿舍編號='.$DID.'&房間號碼='.$O_RoomID);
    exit;
}
if($MoniID == "清空")
{
    $SQL="UPDATE 宿舍房間
    SET 舍監編號=NULL 
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
    exit;
}
$SQL="SELECT 舍監編號
      FROM 宿舍房間
      WHERE 房間號碼='$O_RoomID' and 宿舍編號='$DID'
      ";
$result=mysqli_query($link,$SQL);
$row=mysqli_fetch_assoc($result);
$Room_moni=$row['舍監編號'];
if($Room_moni == $MoniID)
{
    $_SESSION['msg']='已經為此房間舍監';
    header('Location: room_edit_moni?宿舍編號='.$DID.'&房間號碼='.$O_RoomID);
    exit;
}
$SQL="SELECT *
      from 宿舍房間
      where 舍監編號='$Room_moni'";

$result=mysqli_query($link,$SQL);
if(mysqli_num_rows($result)==1)
{
    $_SESSION['msg']='無法更動，此房間原舍監僅剩一間房';
    header('Location: room_edit_moni?宿舍編號='.$DID.'&房間號碼='.$O_RoomID);
    exit;
}

$SQL="UPDATE 宿舍房間
      SET 舍監編號='$MoniID' 
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




?>