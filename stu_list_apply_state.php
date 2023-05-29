<?php

//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

//Check：有"GET"參數
if (!isset($_GET['學號'])) {
    header('Location: stu_list');
    exit;
}
$uAccount = $_GET['學號'];

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
if (mysqli_num_rows($result) > 0)
    echo "<h2>學生 " . $uAccount . " " . $row['姓名'] . " 申請資料</h2>";

//查詢"申請狀態"
$SQL = "SELECT 申請編號, 學年度, 學期, 申請日期, 核可狀態, 繳費狀態, Account
        FROM 入住申請
        WHERE 學號='$uAccount'";
$result = mysqli_query($link, $SQL);


?>

<!--列出學生申請資料-->
<div class="table-responsive-md" id="center">
    <table class="table table-hover align-middle align-items-center ">
        <thead>
            <th>學年度</th>
            <th>學期</th>
            <th>申請日期</th>
            <th>繳費狀態</th>
            <th>核可狀態</th>
            <th>核可人員</th>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) <= 0) {
                echo "<tr id='h1_center'><td colspan='7'>查無申請資料</td></tr>";
                exit;
            }
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['學年度'] . "</td>";
                echo "<td>" . $row['學期'] . "</td>";
                echo "<td>" . $row['申請日期'] . "</td>";
                echo "<td>" . ($row['繳費狀態']==1?'是':'否') . "</td>";
                echo "<td>" . ($row['核可狀態']==1?'是':'否') . "</td>";
                echo "<td>" . $row['Account'] . "</td>";
                echo "</tr>";
            }


            ?>
        </tbody>
    </table>
</div>