<?php
session_start();
require('dbconnect.php');

//HTTP-Post
$StuID=$_POST['學號'];
$MonitorID=$_POST['編號'];

/*測試資料是否收到
echo "學號：".$StuID;
echo "<br>舍監編號：".$MonitorID;
exit();
*/

//判斷收到的資料是否有空值，舍監填入的資料不可以有空值
if($StuID == NULL || $MonitorID == NULL)
{
    $_SESSION['msg']='所有欄位皆為必填';
    header('Location: monitor_del');
    exit;
}

$SQL="SELECT 學號
      FROM 學生
      WHERE 學號 ='$StuID'";

$result=mysqli_query($link,$SQL);

if($result)
{
    if(mysqli_num_rows($result)==0)
    {
        $_SESSION['msg']='無此學號';
        header('Location: monitor_del');
        exit;
    }
}


$SQL="SELECT 學號,舍監編號
      FROM 學生
      WHERE  學號='$StuID' AND 舍監編號 IS NULL";

$result=mysqli_query($link,$SQL);

if($result)
{
    if(mysqli_num_rows($result)>0)
    {
        $_SESSION['msg']='此學生不是舍監';
        header('Location: monitor_del');
        exit;
    }
}

$SQL="SELECT 學號,舍監編號
      FROM 學生
      WHERE  學號='$StuID' AND 舍監編號='$MonitorID'";

$result=mysqli_query($link,$SQL);

if($result)
{
    if(mysqli_num_rows($result)==0)
    {
        $_SESSION['msg']='舍監編號錯誤';
        header('Location: monitor_del');
        exit;
    }
}

$SQL="DELETE 
      FROM 舍監_管理房號
      WHERE 舍監編號='$MonitorID'";

$result=mysqli_query($link,$SQL);

$SQL="UPDATE 學生 SET 舍監編號=NULL  WHERE 學號='$StuID'";

$result=mysqli_query($link,$SQL);

$SQL="DELETE 
      FROM 舍監
      WHERE 舍監編號='$MonitorID'";

$result=mysqli_query($link,$SQL);


if(mysqli_affected_rows($link)>0)
{
    echo "<script type='text/javascript'>";
    echo "alert('刪除成功')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=moni_list'>";
}
else if(mysqli_affected_rows($link)==0)
{
    echo "<script type='text/javascript'>";
    echo "alert('無資料更動')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=moni_list'>";
}
else{
    echo "<script type='text/javascript'>";
    echo "alert('連線錯誤')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=moni_list'>";
}

?>