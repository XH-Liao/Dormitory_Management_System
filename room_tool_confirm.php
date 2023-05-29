<?php
if(!isset ($_SESSION))
{
session_start();
}
require('dbconnect.php');

//HTTP-Psot
$RoomTool=$_POST['房間設備'];

$DomitoryNum=$_POST['DID'];
$RoomNum=$_POST['RID'];

$SQL="SELECT 宿舍編號
      From 宿舍大樓
      WHERE  宿舍編號='$DomitoryNum'";

$result=mysqli_query($link,$SQL);

if(mysqli_num_rows($result)==0)
{
    $_SESSION['msg']='無此大樓';
     header('Location: room_tool?宿舍編號='.$DomitoryNum.'&房間號碼='.$RoomNum.'');
        exit;
}

$SQL="SELECT 房間號碼,宿舍編號
      From 宿舍房間
      WHERE  房間號碼='$RoomNum' AND 宿舍編號='$DomitoryNum'";

$result=mysqli_query($link,$SQL);

if(mysqli_num_rows($result)==0)
{
    $_SESSION['msg']='大樓無此房號';
        header('Location: room_tool?宿舍編號='.$DomitoryNum.'&房間號碼='.$RoomNum.'');
        exit;
}

$SQL="SELECT 設備,房間號碼,宿舍編號
      From 宿舍房間_設備
      WHERE  設備='$RoomTool' AND 房間號碼='$RoomNum' AND 宿舍編號='$DomitoryNum'";

$result=mysqli_query($link,$SQL);

if(mysqli_num_rows($result)>0)
{
    $_SESSION['msg']='房間已有此設備';
        header('Location: domitory_tool?宿舍編號='.$DomitoryNum.'&房間號碼='.$RoomNum.'');
        exit;
}

$SQL="INSERT INTO 宿舍房間_設備(設備,房間號碼,宿舍編號) VALUES ('$RoomTool','$RoomNum','$DomitoryNum') ";

if(mysqli_query($link,$SQL))
{
    echo "<script type='text/javascript'>";
    echo "alert('新增成功')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=room_tool_list?宿舍編號=$DomitoryNum&房間號碼=$RoomNum'>";
}
else
{
    echo "<script type='text/javascript'>";
    echo "alert('新增失敗')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=room_tool_list?宿舍編號=$DomitoryNum&房間號碼=$RoomNum'>";
}

?>