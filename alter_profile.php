<?php
//Check："學生"、"舍監"才可使用本頁面 
session_start();
if (!isset($_SESSION['login_identity']) || ($_SESSION['login_identity'] != "學生" && $_SESSION['login_identity'] != "舍監")) {
    header('Location: login');
    exit;
}

$title = "個人資料";
require('layout/header.php');
require("dbconnect.php");

$SQL = "SELECT *
        FROM 學生
        WHERE 學號='{$_SESSION['login_account']}'";
$result = mysqli_query($link, $SQL);
$row = mysqli_fetch_assoc($result);

$monitor = "";
if ($row["房間號碼"] != null) {
    $SQL_monitor = "SELECT 學號, 姓名
            FROM 宿舍房間, 學生
            WHERE 宿舍房間.舍監編號=學生.舍監編號 AND 宿舍房間.宿舍編號='{$row['宿舍編號']}' AND 宿舍房間.房間號碼='{$row['房間號碼']}'";
    $result_monitor = mysqli_query($link, $SQL);
    $row_monitor = mysqli_fetch_assoc($result_monitor);
    $monitor = $row_monitor["學號"] . " " . $row_monitor["姓名"];
}
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
        <?php
        if (isset($_SESSION['msg'])) {
            if ($_SESSION['msg'] == "個人資料修改成功！") {
                print <<<EOT
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                    <div>
                        {$_SESSION['msg']}
                    </div>
                </div>
    EOT;
            } else {
                print <<<EOT
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>
                        {$_SESSION['msg']}
                    </div>
                    </div>
    EOT;
            }
            unset($_SESSION['msg']);
        }
        ?>
        <div class="mb-3 row">
            <label class="col-3 col-form-label">學號</label>
            <div class="col-9">
                <label class="col-form-label"><?php echo $row["學號"]; ?></label>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-3 col-form-label">姓名</label>
            <div class="col-9">
                <label class="col-form-label"><?php echo $row["姓名"]; ?></label>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-3 col-form-label">性別</label>
            <div class="col-9">
                <label class="col-form-label"><?php echo $row["性別"]; ?></label>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-3 col-form-label">生日</label>
            <div class="col-9">
                <label class="col-form-label"><?php echo $row["生日"]; ?></label>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-3 col-form-label">宿舍房號</label>
            <div class="col-9">
                <label class="col-form-label"><?php echo $row["宿舍編號"] . " " . $row["房間號碼"]; ?></label>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-3 col-form-label">舍監</label>
            <div class="col-9">
                <label class="col-form-label"><?php echo $monitor; ?></label>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-9">
                <label class="col-form-label"><?php echo $row["Email"]; ?></label>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">聯絡電話</label>
            <div class="col-sm-9">
                <label class="col-form-label"><?php echo $row["連絡電話"]; ?></label>
            </div>
        </div>
        <div class="row">
            <div class="btn-group">
                <a href="violate_state?學號=<?php echo $_SESSION['login_account']; ?>" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </svg> 查看違規資料
                </a>
                <button class="btn btn-primary" data-bs-toggle='modal' data-bs-target='#edit_profile_modal'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                    </svg> 修改資料
                </button>
            </div>

        </div>
        <br>
    </div>
    <div class="col-md-2 col-lg-3"></div>
</div>

<?php
require('layout/footer.php');
?>

<!-- 修改資料 Modal -->
<div class="modal fade" id="edit_profile_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">修改資料</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="alter_profile_confirm.php" method="POST">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" name="Email" class="form-control" value="<?php echo $row["Email"]; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">聯絡電話</label>
                        <div class="col-sm-9">
                            <input type="text" name="聯絡電話" class="form-control" value="<?php echo $row["連絡電話"]; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row" style="text-align: center;">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <button type="button" class="btn btn-secondary col-5" data-bs-dismiss="modal">取消</button>
                            <input type="submit" value="確認修改" class="btn btn-primary col-5">
                        </div>
                        <div class="col-1"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--
<form action="alter_profile_confirm.php" method="POST">
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-9">
            <input type="text" name="Email" class="form-control" value="<?php echo $row["Email"]; ?>">
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label">聯絡電話</label>
        <div class="col-sm-9">
            <input type="text" name="聯絡電話" class="form-control" value="<?php echo $row["連絡電話"]; ?>">
        </div>
    </div>
    <input type="submit" value="確認修改資料" class="form-control btn btn-primary">
</form>
    -->