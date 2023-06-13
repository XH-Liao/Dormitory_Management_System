<?php
require_once("dbconnect.php");

// 從資料庫中獲取第二個下拉式選單的選項
$firstValue = $_POST['value'];

$SQL = "SELECT 房間號碼
            FROM 宿舍房間
            WHERE 宿舍編號='$firstValue'";
$result = mysqli_query($link, $SQL);

// 生成第二個下拉式選單的選項的HTML
$html = "<option selected value=''>請選擇</option>";
while($row = mysqli_fetch_assoc($result)){
    $html .= "<option value='".$row["房間號碼"]."'>".$row["房間號碼"]."</option>";
}

// 返回第二個下拉式選單的選項的HTML
echo $html;
?>
