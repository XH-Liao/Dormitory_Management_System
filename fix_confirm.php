<?php
if(!isset ($_SESSION))
{
session_start();
}
require('dbconnect.php');

$DomiID=$_POST['宿舍編號'];
if(isset($_POST['房間號碼']))
{
    $RoomID=$_POST['房間號碼'];
}
else
{
    $RoomID=NULL;
}
$ToolName=$_POST['設備名稱'];

if($DomiID == NULL || $ToolName == NULL)
{
     
    $_SESSION['msg']='大樓和設備名稱為必填';
    header('Location: fix');
    exit;
}
if($RoomID == NULL)
{
    $SQL = "SELECT 宿舍編號,大樓設備,維修狀態
            FROM 宿舍大樓_大樓設備
            WHERE 宿舍編號='$DomiID' AND 大樓設備='$ToolName'";
    $result = mysqli_query($link, $SQL);
    if (mysqli_num_rows($result) == 0) {
        $_SESSION['msg']='資料有誤';
        header('Location: fix');
        exit;
    }
    $row = mysqli_fetch_assoc($result);
    if ($row['維修狀態'] == 1)
    {
        $_SESSION['msg']='已經申請';
        header('Location: fix');
        exit;
    }
    else
    {
        
        $SQL="UPDATE 宿舍大樓_大樓設備
        SET 維修狀態 = 1
        where 宿舍編號='$DomiID' and 大樓設備 ='$ToolName' 
        ";


        $result=mysqli_query($link,$SQL);


        
        if(mysqli_affected_rows($link)>0)
        {
            echo "<script type='text/javascript'>";
            echo "alert('更動成功')";
            echo "</script>";
            echo "<meta http-equiv='Refresh' content='0; url=/SE_FinalProject' > ";
        }
        else if(mysqli_affected_rows($link)==0)
        {
            echo "<script type='text/javascript'>";
            echo "alert('無資料更動')";
            echo "</script>";
            echo "<meta http-equiv='Refresh' content='0; url=/SE_FinalProject'>";
        }
        else{
            echo "<script type='text/javascript'>";
            echo "alert('連線錯誤')";
            echo "</script>";
            echo "<meta http-equiv='Refresh' content='0; url=/SE_FinalProject'>";
        }

    }
}
else
{
    $SQL = "SELECT 宿舍編號,房間號碼,設備,維修狀態
            FROM 宿舍房間_設備
            WHERE 宿舍編號='$DomiID' AND 房間號碼='$RoomID' AND 設備='$ToolName'";
    $result = mysqli_query($link, $SQL);
    if (mysqli_num_rows($result) == 0) {
        $_SESSION['msg']='資料有誤';
        header('Location: fix');
        exit;
    }
    $row = mysqli_fetch_assoc($result);
    if($row['維修狀態'] == 1)
    {
        $_SESSION['msg']='已經申請';
        header('Location: fix');
        exit;
    }
    else
    {
        $SQL="UPDATE 宿舍房間_設備
        SET 維修狀態 = 1
        where 宿舍編號='$DomiID' and 設備 ='$ToolName' and 房間號碼 = '$RoomID' 
        ";


        $result=mysqli_query($link,$SQL);



        if(mysqli_affected_rows($link)>0)
        {
            echo "<script type='text/javascript'>";
            echo "alert('更動成功')";
            echo "</script>";
            echo "<meta http-equiv='Refresh' content='0; url=/SE_FinalProject'>";
        }
        else if(mysqli_affected_rows($link)==0)
        {
            echo "<script type='text/javascript'>";
            echo "alert('無資料更動')";
            echo "</script>";
            echo "<meta http-equiv='Refresh' content='0; url=/SE_FinalProject'>";
        }
        else{
            echo "<script type='text/javascript'>";
            echo "alert('連線錯誤')";
            echo "</script>";
            echo "<meta http-equiv='Refresh' content='0; url=/SE_FinalProject'>";
        }
    }
}


?>