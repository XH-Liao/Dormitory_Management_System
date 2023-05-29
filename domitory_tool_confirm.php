<?php
if(!isset ($_SESSION))
{
session_start();
}
require('dbconnect.php');

//HTTP-Psot
$DomitoryNum=$_POST['DID'];
$DomitoryTool=$_POST['大樓設備'];

/*測試資料是否收到
echo "大樓編號：".$DomitoryNum;
echo "<br>大樓設備：".$DomitoryTool;
exit();
*/

if($DomitoryTool == NULL || $DomitoryNum == NULL)
{
    $_SESSION['msg']='所有欄位皆為必填';
    header('Location: domitory_tool');
    exit;
}

$SQL="SELECT 宿舍編號
      From 宿舍大樓
      WHERE  宿舍編號='$DomitoryNum'";

$result=mysqli_query($link,$SQL);

if(mysqli_num_rows($result)==0)
{
    $_SESSION['msg']='無此大樓';
        header('Location: domitory_tool?宿舍編號='.$DomitoryNum);
        exit;
}

$SQL="SELECT 大樓設備,宿舍編號
      From 宿舍大樓_大樓設備
      WHERE  大樓設備='$DomitoryTool' AND 宿舍編號='$DomitoryNum'";

$result=mysqli_query($link,$SQL);

if(mysqli_num_rows($result)>0)
{
    $_SESSION['msg']='大樓已有此設備';
        header('Location: domitory_tool?宿舍編號='.$DomitoryNum);
        exit;
}

$SQL="INSERT INTO 宿舍大樓_大樓設備 (大樓設備,宿舍編號) VALUES ('$DomitoryTool','$DomitoryNum')";

if(mysqli_query($link,$SQL))
{
    echo "<script type='text/javascript'>";
    echo "alert('新增成功')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_tool_list?宿舍編號=$DomitoryNum'>";
}
else
{
    echo "<script type='text/javascript'>";
    echo "alert('新增失敗')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_tool_list?宿舍編號=$DomitoryNum'>";
}

?>