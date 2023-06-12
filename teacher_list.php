<?php
//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

$title = "老師列表";
require('layout/header.php');
require('dbconnect.php');
?>

<br>
<div class="row">
    <div class="col-6">
        <h1>老師列表</h1>
    </div>
    <div class="col-6">
        <a href="enroll" class="btn btn-primary" style="float: right;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
            </svg>
            老師註冊
        </a>
    </div>
</div>

<?php
//列出所有老師名單 [老師編號、姓名、指導班級、生日、btn(重設密碼)]
$SQL = "SELECT 老師編號, 班級編號, 姓名, 生日
        FROM 老師
        ORDER BY 老師編號 ASC";
$result = mysqli_query($link, $SQL);
?>

<div class="table-responsive-md" id="center">
    <table class="table table-hover align-middle align-items-center sortable">
        <thead>
            <th></th>
            <th>老師編號</th>
            <th>指導班級</th>
            <th>姓名</th>
            <th>生日</th>
            <th>Functions</th>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a href='teacher_update?老師編號=" . $row['老師編號'] . "'><i class='bi bi-pencil-square'></i></a> ";
                echo "<a href='teacher_delete_confirm?老師編號=" . $row['老師編號'] . "' onclick='return confirm(\"確認刪除老師資料？\")'><i class='bi bi-trash3'></i></a></td>";
                echo "<td>" . $row['老師編號'] . "</td>";
                echo "<td>" . $row['班級編號'] . "</td>";
                echo "<td>" . $row['姓名'] . "</td>";
                echo "<td>" . $row['生日'] . "</td>";
                echo "<td><div class='btn-group'>";
                echo "<a href='teacher_reset_password?老師編號=" . $row['老師編號'] . "' class='btn btn-outline-secondary' onclick='return confirm(\"確認重設密碼？\")'>密碼重設</a>";
                echo "</div></td>";
                echo "</tr>";
            }


            ?>
        </tbody>
    </table>
</div>
<?php
require('layout/footer.php');
?>