<?php
session_start();
require('dbconnect.php');

$DomitoryName=$_POST['大樓名稱'];
$Price=$_POST['費用'];
$RoomNum=$_POST['房間數'];
$DomitoryNum=$_POST['大樓編號'];

/*測試資料是否收到
echo "大樓名稱：".$DomitoryName;
echo "<br>費用：".$Price;
echo "<br>房間數：".$RoomNum;
echo "<br>大樓編號：".$DomitoryNum;
exit();
*/

if($DomitoryName == NULL || $Price == NULL || $RoomNum == NULL || $DomitoryNum == NULL)
{
    $_SESSION['msg']='所有欄位皆為必填';
    header('Location: domitory');
    exit;
}

if(strlen($DomitoryNum)>2)
{
    $_SESSION['msg']='大樓編碼過長';
        header('Location: domitory');
        exit;
}

$SQL="SELECT 宿舍編號
      From 宿舍大樓
      WHERE  宿舍編號='$DomitoryNum'";

$result=mysqli_query($link,$SQL);

if(mysqli_num_rows($result)>0)
{
    $_SESSION['msg']='已有此大樓編號';
        header('Location: domitory');
        exit;
}

$SQL="INSERT INTO 宿舍大樓 (大樓名稱,房間住宿費用,房間數,宿舍編號) VALUES ('$DomitoryName','$Price','$RoomNum','$DomitoryNum')";


if(mysqli_query($link,$SQL))
{
    echo "<script type='text/javascript'>";
    echo "alert('新增成功')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=index'>";
}
else
{
    echo "<script type='text/javascript'>";
    echo "alert('新增失敗')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=index'>";
}

?>