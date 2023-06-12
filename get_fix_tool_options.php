<?php
require_once("dbconnect.php");

// 從資料庫中獲取第二個下拉式選單的選項
$firstValue = $_POST['value'];
if(isset($_POST['value2']))
{
    $secondValue=$_POST['value2'];
}
else
{
    $secondValue=NULL;
}
if($secondValue == NULL)
{
    $SQL = "SELECT 大樓設備
            FROM 宿舍大樓_大樓設備
            WHERE 宿舍編號='$firstValue'";
    $result = mysqli_query($link, $SQL);

    // 生成第二個下拉式選單的選項的HTML
    $html = "<option selected disabled>請選擇</option>";
    while($row = mysqli_fetch_assoc($result)){
        $html .= "<option value='".$row["大樓設備"]."'>".$row["大樓設備"]."</option>";
    }

    // 返回第二個下拉式選單的選項的HTML
    echo $html;
}
else
{
    $SQL = "SELECT 設備
    FROM 宿舍房間_設備
    WHERE 宿舍編號 ='$firstValue' AND 房間號碼 = '$secondValue'";
    $result = mysqli_query($link, $SQL);

    // 生成第二個下拉式選單的選項的HTML
    $html = "<option selected disabled>請選擇</option>";
    while($row = mysqli_fetch_assoc($result)){
    $html .= "<option value='".$row["設備"]."'>".$row["設備"]."</option>";
    }

    // 返回第二個下拉式選單的選項的HTML
    echo $html;
}
?>
