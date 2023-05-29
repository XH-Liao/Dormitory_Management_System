<?php
session_start();
require('dbconnect.php');

$RoomNum=$_POST['房間編號'];
$InPerson=$_POST['入住人數'];
$DomitoryNum=$_POST['大樓編號'];

/*測試資料是否收到
echo "房間編號：".$RoomNum;
echo "<br>入住人數：".$InPerson;
echo "<br>大樓編號：".$DomitoryNum;
exit();
*/

if($RoomNum == NULL || $InPerson == NULL || $DomitoryNum == NULL)
{
    $_SESSION['msg']='所有欄位皆為必填';
    header('Location: room');
    exit;
}

$SQL="SELECT 宿舍編號
      From 宿舍大樓
      WHERE  宿舍編號='$DomitoryNum'";

$result=mysqli_query($link,$SQL);

if(mysqli_num_rows($result)==0)
{
    $_SESSION['msg']='無此大樓';
        header('Location: room');
        exit;
}


header('Location: room');
exit;
/*我覺得宿舍房間table需要修改，不太確定該怎麼寫入 */

?>