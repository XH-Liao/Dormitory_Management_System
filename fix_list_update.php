<?php
if(!isset ($_SESSION))
{
session_start();
}
if(!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員"){
    header('Location: login');
    exit();
}
if(!isset($_GET['宿舍編號']))
{
    header('Location: fix_list');
    exit();
}
$title = "維修更新";
require("layout/header.php");
require('dbconnect.php');
$DomiID=$_GET['宿舍編號'];
if(!isset($_GET['房間號碼']))
{
    $RoomID=NULL;
}
else
{
    $RoomID=$_GET['房間號碼'];
}
if(!isset($_GET['設備名稱']))
{
    $ToolName=NULL;
}
else
{
    $ToolName=$_GET['設備名稱'];
}


if($RoomID == NULL)
{
    $SQL = "SELECT 宿舍編號,大樓設備,維修狀態
            FROM 宿舍大樓_大樓設備
            WHERE 宿舍編號='$DomiID' AND 大樓設備='$ToolName'";
    $result = mysqli_query($link, $SQL);
    if (mysqli_num_rows($result) == 0) {
        echo "<script type='text/javascript'>";
        echo "alert('資料有誤')";
        echo "</script>";
        echo "<meta http-equiv='Refresh' content='0; url=fix_list' > ";
        exit;
    }
    $row = mysqli_fetch_assoc($result);
    if ($row['維修狀態'] != 1)
    {
        echo "<script type='text/javascript'>";
        echo "alert('並無維修需求')";
        echo "</script>";
        echo "<meta http-equiv='Refresh' content='0; url=fix_list' > ";
        exit;
    }
    else
    {
        
        $SQL="UPDATE 宿舍大樓_大樓設備
        SET 維修狀態 = 0,報修人 = NULL,聯絡方式 = NULL ,損毀情況 = NULL
        where 宿舍編號='$DomiID' and 大樓設備 ='$ToolName' 
        ";


        $result=mysqli_query($link,$SQL);


        
        if(mysqli_affected_rows($link)>0)
        {
            echo "<script type='text/javascript'>";
            echo "alert('更動成功')";
            echo "</script>";
            echo "<meta http-equiv='Refresh' content='0; url=fix_list' > ";
        }
        else if(mysqli_affected_rows($link)==0)
        {
            echo "<script type='text/javascript'>";
            echo "alert('無資料更動')";
            echo "</script>";
            echo "<meta http-equiv='Refresh' content='0; url=fix_list'>";
        }
        else
        {
            echo "<script type='text/javascript'>";
            echo "alert('連線錯誤')";
            echo "</script>";
            echo "<meta http-equiv='Refresh' content='0; url=fix_list'>";
        }

    }
}
else
{
    $SQL = "SELECT 宿舍編號,房間號碼,設備,維修狀態
    FROM 宿舍房間_設備
    WHERE 宿舍編號='$DomiID' AND 房間號碼='$RoomID' AND 設備='$ToolName'";
    $result = mysqli_query($link, $SQL);
    if (mysqli_num_rows($result) == 0) 
    {
        echo "<script type='text/javascript'>";
        echo "alert('資料有誤')";
        echo "</script>";
        echo "<meta http-equiv='Refresh' content='0; url=fix_list' > ";
        exit;
    }
    $row = mysqli_fetch_assoc($result);
    if($row['維修狀態'] != 1)
    {
        echo "<script type='text/javascript'>";
        echo "alert('並無維修需求')";
        echo "</script>";
        echo "<meta http-equiv='Refresh' content='0; url=fix_list' > ";
        exit;
    }
    else
    {
        $SQL="UPDATE 宿舍房間_設備
        SET 維修狀態 = 0,報修人 = NULL,聯絡方式 = NULL ,損毀情況 = NULL
        where 宿舍編號='$DomiID' and 設備 ='$ToolName' and 房間號碼 = '$RoomID' 
        ";


        $result=mysqli_query($link,$SQL);



        if(mysqli_affected_rows($link)>0)
        {
            echo "<script type='text/javascript'>";
            echo "alert('更動成功')";
            echo "</script>";
            echo "<meta http-equiv='Refresh' content='0; url=fix_list'>";
        }
        else if(mysqli_affected_rows($link)==0)
        {
            echo "<script type='text/javascript'>";
            echo "alert('無資料更動')";
            echo "</script>";
            echo "<meta http-equiv='Refresh' content='0; url=fix_list'>";
        }
        else
        {
            echo "<script type='text/javascript'>";
            echo "alert('連線錯誤')";
            echo "</script>";
            echo "<meta http-equiv='Refresh' content='0; url=fix_list'>";
        }
    }
}

?>

