<?php
session_start();
require('dbconnect.php');

$RoomNum=$_POST['房間編號'];
$DomitoryNum=$_POST['DID'];

/*測試資料是否收到
echo "房間編號：".$RoomNum;
echo "<br>入住人數：".$InPerson;
echo "<br>大樓編號：".$DomitoryNum;
exit();
*/

if($RoomNum == NULL ||  $DomitoryNum == NULL)
{
    $_SESSION['msg']='所有欄位皆為必填';
    header('Location: room?宿舍編號='.$DomitoryNum.'');
    exit;
}

$SQL="SELECT 宿舍編號
      From 宿舍大樓
      WHERE  宿舍編號='$DomitoryNum'";

$result=mysqli_query($link,$SQL);

if(mysqli_num_rows($result)==0)
{
    $_SESSION['msg']='無此大樓';
        header('Location: room?宿舍編號='.$DomitoryNum.'');
        exit;
}
$SQL="SELECT 房間號碼
      from 宿舍房間
      where 房間號碼='$RoomNum' and 宿舍編號='$DomitoryNum'";

$result=mysqli_query($link,$SQL);

if(mysqli_num_rows($result)!=0)
{
    $_SESSION['msg']='已有此房間';
        header('Location: room?宿舍編號='.$DomitoryNum.'');
        exit;
}

$SQL="UPDATE 宿舍大樓
      SET 房間數=房間數+1
      where 宿舍編號='$DomitoryNum' 
      ";

$result=mysqli_query($link,$SQL);

$SQL="INSERT INTO 宿舍房間(房間號碼,當前入住人數,宿舍編號) VALUES('$RoomNum','0','$DomitoryNum')";



if(mysqli_query($link,$SQL))
{
    
    echo "<script type='text/javascript'>";
    echo "alert('新增成功')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=room_list?宿舍編號=$DomitoryNum'>";
        
      
}
else
{
    echo "<script type='text/javascript'>";
        echo "alert('新增失敗')";
        echo "</script>";
        echo "<meta http-equiv='Refresh' content='0; url=room_list?宿舍編號=$DomitoryNum'>";
}



?>