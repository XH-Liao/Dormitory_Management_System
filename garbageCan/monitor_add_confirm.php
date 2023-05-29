<?php
session_start();
require('dbconnect.php');
//HTTP-Psot
$StuID=$_POST['學號'];
$MonitorID=$_POST['編號'];
$RoomID=$_POST['房號'];


/* 測試資料是否收到
echo "學號：".$StuID;
echo "<br>舍監編號：".$MonitorID;
echo "<br>房號：".$RoomID;
exit();
*/

//判斷收到的資料是否有空值，舍監填入的資料不可以有空值
if($StuID == NULL || $MonitorID == NULL || $RoomID == NULL)
{
    $_SESSION['msg']='所有欄位皆為必填';
    header('Location: monitor_add');
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
        $_SESSION['msg']='查無此學生';
        header('Location: monitor');    //bug: monitor_add
        exit;
    }
}

$SQL="SELECT 學號,舍監編號
      FROM 學生
      WHERE 學號 ='$StuID' AND 舍監編號 IS NOT NULL";


$result=mysqli_query($link,$SQL);

if($result)
{
    if(mysqli_num_rows($result)!=0)
    {
        $_SESSION['msg']='此學號已經是舍監了';
        header('Location: monitor_add');
        exit;
    }
}


$SQL="SELECT 舍監編號
      FROM 舍監
      WHERE 舍監編號 ='$MonitorID'";

$result=mysqli_query($link,$SQL);

if($result)
{
    if(mysqli_num_rows($result)!=0)
    {
        $_SESSION['msg']='已經有此編號了';
        header('Location: monitor_add');
        exit;   
    }
}
$SQL="INSERT INTO 舍監 (舍監編號) VALUES ('$MonitorID')";
$SQL2="INSERT INTO 舍監_管理房號(管理房號,舍監編號) VALUES ('$RoomID','$MonitorID')";
$SQL3="UPDATE 學生 SET 舍監編號='$MonitorID' WHERE 學號='$StuID'";
if(mysqli_query($link,$SQL))
{
    if(mysqli_query($link,$SQL2))
    {
        $result=mysqli_query($link,$SQL3);
        if(mysqli_affected_rows($link)>0)
        {
        echo "<script type='text/javascript'>";
        echo "alert('新增成功')";
        echo "</script>";
        echo "<meta http-equiv='Refresh' content='0; url=index'>";
        }
        else
        {
            echo "<script type='text/javascript'>";
        echo "alert('新增學生_舍監編號失敗')";
        echo "</script>";
        echo "<meta http-equiv='Refresh' content='0; url=enroll'>";
        }
    }
    else
    {
        echo "<script type='text/javascript'>";
        echo "alert('新增舍監_管理失敗')";
        echo "</script>";
        echo "<meta http-equiv='Refresh' content='0; url=enroll'>";
    }
}
else
{
    echo "<script type='text/javascript'>";
        echo "alert('新增舍監失敗')";
        echo "</script>";
        echo "<meta http-equiv='Refresh' content='0; url=enroll'>";
}

?>