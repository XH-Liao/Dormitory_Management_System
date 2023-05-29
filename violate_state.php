
<?php

//Check：有"GET"參數
if(!isset($_GET['學號'])){
    header('Location: index');
    exit;
}
$uAccount = $_GET['學號'];

//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || ($_SESSION['login_account'] != $uAccount && $_SESSION['login_identity'] != "系統管理員" && $_SESSION['login_identity'] != "舍監")) {
    header('Location: login');
    exit;
}

//載入header
$title = "學生入住申請資料";
require('layout/header.php');
require('dbconnect.php');
echo "<br>";

//顯示學生 學號、姓名

$SQL = "SELECT 姓名
        FROM 學生
        WHERE 學號='$uAccount'";
$result = mysqli_query($link, $SQL);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0)
echo "<h2>學生 ".$uAccount." ".$row['姓名']." 違規列表</h2>";

//查詢"違規列表"
$SQL = "SELECT 日期, 違規事項
        FROM 違規紀錄
        WHERE 學號='$uAccount'";
$result = mysqli_query($link, $SQL);


?>

<!--列出學生申請資料-->
<div class="table-responsive-md">
<table class="table table-hover align-middle align-items-center ">
    <thead>
        <th></th>
        <th>日期</th>
        <th>違規事項</th>
    </thead>
    <tbody>
        <?php
        if(mysqli_num_rows($result) <= 0){
            echo "<tr id='h1_center'><td colspan='7'>查無違規資料</td></tr>";
            exit;
        }
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr><td>";
            if($_SESSION["login_identity"] == "舍監"){
                echo "<a href='violate_update?學號=".$uAccount."&違規日期=".$row['日期']."&違規事項=".$row['違規事項']."'><i class='bi bi-pencil-square'></i></a> &nbsp;&nbsp;";
            }
            if($_SESSION["login_identity"] == "舍監" || $_SESSION["login_identity"] == "系統管理員")
                echo "<a href='violate_delete_confirm?學號=".$uAccount."&違規日期=".$row['日期']."&違規事項=".$row['違規事項']."' onclick='return confirm(\"確認刪除違規資料？\")'><i class='bi bi-trash3'></i></a></td>";
            echo "<td>".$row['日期']."</td>";
            echo "<td>".$row['違規事項']."</td>";
            echo "</tr>";
        }
        

        ?>
    </tbody>
</table>
</div>