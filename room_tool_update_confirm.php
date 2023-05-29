<?php
if(!isset ($_SESSION))
{
session_start();
}
require('dbconnect.php');

//HTTP-Post
$ToolName=$_POST['房間設備'];

$O_TName=$_POST['ToolName'];
$DID=$_POST['DID'];
$RID=$_POST['RID'];

    
if($ToolName == NULL )
{
    $_SESSION['msg']='所有欄位皆為必填';
    header('Location: room_tool_update?宿舍編號='.$DID.'&房間號碼='.$RID.'&房間設備='.$O_TName.'');
    exit;
}


$SQL="UPDATE 宿舍房間_設備
      SET 設備='$ToolName' 
      where 宿舍編號='$DID' and 房間號碼 ='$RID' and 設備='$O_TName'
      ";


$result=mysqli_query($link,$SQL);



if(mysqli_affected_rows($link)>0)
{
    echo "<script type='text/javascript'>";
    echo "alert('更動成功')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=room_tool_list?宿舍編號=$DID&房間號碼=$RID'>";
}
else if(mysqli_affected_rows($link)==0)
{
    echo "<script type='text/javascript'>";
    echo "alert('無資料更動')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=room_tool_list?宿舍編號=$DID&房間號碼=$RID'>";
}
else{
    echo "<script type='text/javascript'>";
    echo "alert('連線錯誤')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=room_tool_list?宿舍編號=$DID&房間號碼=$RID'>";
}




?>