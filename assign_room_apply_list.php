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
                <button type="button" class="btn btn-primary" data-bs-toggle='modal' data-bs-target='#wait_modal'>
                    <a href="email.php" style="text-decoration: none; color:white;">確認</a>
                </button>

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
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                    <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                </svg>
                請稍後...正在發送催繳通知
                <br><br><br>
            </div>
        </div>
    </div>
</div>