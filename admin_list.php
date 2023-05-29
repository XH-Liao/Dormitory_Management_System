<?php
//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_account'] != "admin") {
    header('Location: login');
    exit;
}

$title = "管理員列表";
require('layout/header.php');
require('dbconnect.php');
?>

<br>
<div class="row">
    <div class="col-6">
        <h1>管理員列表</h1>
    </div>
    <div class="col-6">
        <a href="enroll" class="btn btn-primary" style="float: right;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
            </svg>
            管理員註冊
        </a>
    </div>
</div>

<?php
//列出所有管理員名單 [Account、姓名、生日、btn(重設密碼)]
$SQL = "SELECT Account, 姓名, 生日
FROM 系統管理員
WHERE  Account!='admin'
ORDER BY Account ASC";
$result = mysqli_query($link, $SQL);
?>

<div class="table-responsive-md" id="center">
    <table class="table table-hover align-middle align-items-center sortable">
        <thead>
            <th></th>
            <th>Account</th>
            <th>姓名</th>
            <th>生日</th>
            <th>Functions</th>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a href='admin_update?Account=" . $row['Account'] . "'><i class='bi bi-pencil-square'></i></a> ";
                echo "<a href='admin_delete_confirm?Account=" . $row['Account'] . "' onclick='return confirm(\"確認刪除管理員資料？\")'><i class='bi bi-trash3'></i></a></td>";
                echo "<td>" . $row['Account'] . "</td>";
                echo "<td>" . $row['姓名'] . "</td>";
                echo "<td>" . $row['生日'] . "</td>";
                echo "<td><div class='btn-group'>";
                echo "<a href='admin_reset_password?Account=" . $row['Account'] . "' class='btn btn-outline-secondary' onclick='return confirm(\"確認重設密碼？\")'>密碼重設</a>";
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