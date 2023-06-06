<?php

//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

//載入header
$title = "學生入住申請資料";
require('layout/header.php');
require('dbconnect.php');
echo "<br>";

//查詢"申請狀態"
$SQL = "SELECT 申請編號, 學年度, 學期, 學生.學號, 姓名, 申請日期, 核可狀態, 繳費狀態, Account
        FROM 入住申請, 學生
        WHERE 入住申請.學號=學生.學號";
$result = mysqli_query($link, $SQL);
?>
<div class="row">
    <div class="col-6">
        <h1>住宿申請名單</h1>
    </div>
    <div class="col-6">
        <div class="btn-group" style="float: right;">
            <button class="btn btn-danger" data-bs-toggle='modal' data-bs-target='#email_modal'>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                    <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
                </svg>
                催繳費用
            </button>
            <a href="assign_room" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
                    <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15H1.5zM11 2h.5a.5.5 0 0 1 .5.5V15h-1V2zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z" />
                </svg>
                分配房間
            </a>
        </div>
    </div>
</div>
<!--列出學生申請資料-->
<div class="table-responsive-md" id="center">
    <table class="table table-hover align-middle align-items-center sortable">
        <thead>
            <th>學年度</th>
            <th>學期</th>
            <th>申請日期</th>
            <th>學號</th>
            <th>姓名</th>
            <th>繳費狀態</th>
            <th>核可狀態</th>
            <th>核可人員</th>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) <= 0) {
                echo "<tr id='h1_center'><td colspan='8'>查無申請資料</td></tr>";
                exit;
            }
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['學年度'] . "</td>";
                echo "<td>" . $row['學期'] . "</td>";
                echo "<td>" . $row['申請日期'] . "</td>";
                echo "<td>" . $row['學號'] . "</td>";
                echo "<td>" . $row['姓名'] . "</td>";
                echo "<td>" . ($row['繳費狀態'] == 1 ? '是' : '否') . "</td>";
                echo "<td>" . ($row['核可狀態'] == 1 ? '是' : '否') . "</td>";
                echo "<td>" . $row['Account'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- 確認發送Email Modal -->
<div class="modal fade" id="email_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">催繳通知</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                確認發送催繳通知Email？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" data-bs-toggle='modal' data-bs-target='#wait_modal' onclick="location.href='email.php';">確認</button>
            </div>
        </div>
    </div>
</div>

<!-- 確認發送Email Modal -->
<div class="modal fade" id="wait_modal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Email寄送中</h5>
            </div>
            <div class="modal-body">
                <br>
                <div class="container">
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="loader col-3"></div>
                        <div class="col-8" style="text-align: center;"><br>請稍後...正在發送催繳通知</div>
                    </div>
                </div>
                <br><br>
            </div>
        </div>
    </div>
</div>