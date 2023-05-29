<?php
if(!isset ($_SESSION))
{
session_start();
}
require('dbconnect.php');

//HTTP-Post
$DName=$_POST['大樓名稱'];
$Price=$_POST['費用'];
//$RoomNum=$_POST['房間數'];

$O_DName=$_POST['DName'];
$O_Price=$_POST['Price'];
$O_RoomNum=$_POST['RoomNum'];
$DID=$_POST['DID'];

    
if($Price == NULL || $DName == NULL /*|| $RoomNum == NULL*/)
{
    $_SESSION['msg']='所有欄位皆為必填';
    header('Location: domi_list_update?宿舍編號='.$DID);
    exit;
}


$SQL="UPDATE 宿舍大樓
      SET 大樓名稱='$DName',房間住宿費用='$Price'
      where 宿舍編號='$DID' 
      ";


$result=mysqli_query($link,$SQL);

/*if($RoomNum > $O_RoomNum)
{

   for($count=$O_RoomNum+1;$count<=$RoomNum;$count++)
{
    $SQL="INSERT INTO 宿舍房間(房間號碼,當前入住人數,宿舍編號) VALUES('$count','0','$DID')";
    $result=mysqli_query($link,$SQL);
    if(!$result)
    {
        echo "<script type='text/javascript'>";
        echo "alert('新增失敗')";
        echo "</script>";
        echo "<meta http-equiv='Refresh' content='0; url=index'>";
    }
}
}
else if ($RoomNum < $O_RoomNum)
{
    $SQL="DELETE from 宿舍房間
          where 宿舍編號='$DID' and 房間號碼 > '$RoomNum'
          ";
    $result=mysqli_query($link,$SQL);
}
*/


if(mysqli_affected_rows($link)>0)
{
    echo "<script type='text/javascript'>";
    echo "alert('更動成功')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_list'>";
}
else if(mysqli_affected_rows($link)==0)
{
    echo "<script type='text/javascript'>";
    echo "alert('無資料更動')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_list'>";
}
else{
    echo "<script type='text/javascript'>";
    echo "alert('連線錯誤')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_list'>";
}




?>