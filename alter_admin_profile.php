<?php
//Check："系統管理員"才可使用本頁面 
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

$title = "個人資料";
require('layout/header.php');
require("dbconnect.php");

$SQL = "SELECT *
        FROM 系統管理員
        WHERE Account='{$_SESSION['login_account']}'";
$result = mysqli_query($link, $SQL);
$row = mysqli_fetch_assoc($result);
?>

<br>
<div class="row">
    <div class="col-md-2 col-lg-3"></div>
    <div class="col-md-8 col-lg-6">
        <div class="row">
            <div class="col-6">
                <h1>個人資料</h1>
            </div>
            <div class="col-6">
                <a href="alter_password" class="btn btn-primary" style="float: right;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key-fill" viewBox="0 0 16 16">
                        <path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2zM2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                    </svg> 更改密碼
                </a>
            </div>
        </div>
        
        <div class="mb-3 row">
            <label class="col-3 col-form-label">Account</label>
            <div class="col-9">
                <label class="col-form-label"><?php echo $row["Account"]; ?></label>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-3 col-form-label">姓名</label>
            <div class="col-9">
                <label class="col-form-label"><?php echo $row["姓名"]; ?></label>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-3 col-form-label">生日</label>
            <div class="col-9">
                <label class="col-form-label"><?php echo $row["生日"]; ?></label>
            </div>
        </div>
        <br>
    </div>
    <div class="col-md-2 col-lg-3"></div>
</div>

<?php
require('layout/footer.php');
?>

