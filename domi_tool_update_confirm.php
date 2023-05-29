<?php
if(!isset ($_SESSION))
{
session_start();
}
require('dbconnect.php');

//HTTP-Post
$ToolName=$_POST['大樓設備'];

$O_TName=$_POST['ToolName'];
$DID=$_POST['DID'];

    
if($ToolName == NULL )
{
    $_SESSION['msg']='所有欄位皆為必填';
    header('Location: domi_list_update?宿舍編號='.$DID.'&大樓設備='.$O_TName.'');
    exit;
}


$SQL="UPDATE 宿舍大樓_大樓設備
      SET 大樓設備='$ToolName' 
      where 宿舍編號='$DID' and 大樓設備 ='$O_TName' 
      ";


$result=mysqli_query($link,$SQL);



if(mysqli_affected_rows($link)>0)
{
    echo "<script type='text/javascript'>";
    echo "alert('更動成功')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_tool_list?宿舍編號=$DID'>";
}
else if(mysqli_affected_rows($link)==0)
{
    echo "<script type='text/javascript'>";
    echo "alert('無資料更動')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_tool_list?宿舍編號=$DID'>";
}
else{
    echo "<script type='text/javascript'>";
    echo "alert('連線錯誤')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_tool_list?宿舍編號=$DID'>";
}




?>