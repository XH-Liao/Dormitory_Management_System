<?php
//Check："系統管理員"才可使用本頁面、Check：有GET參數
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員" || !isset($_GET['學號'])) {
    header('Location: login');
    exit;
}

$uAccount = $_GET['學號'];

$title = "修改學生資料";
require('layout/header.php');

require('dbconnect.php');
//查詢學生原資料
$SQL = "SELECT 姓名, 班級編號, 性別, 生日
        FROM 學生
        WHERE 學號='$uAccount'";
$result = mysqli_query($link, $SQL);
if (mysqli_num_rows($result) <= 0) {
    echo "<br><h3 id='h1_center'>Error</h3>";
    exit;
}
$row = mysqli_fetch_assoc($result);
?>


<div class="row">
    <div class="col-md-2 col-lg-3"></div>
    <div class="col-md-8 col-lg-6">
        <br>
        <h1>修改學生資訊</h1>
        <form action="stu_list_update_confirm.php" method="POST">
            <input type="hidden" name="原學號" value="<?php echo $uAccount; ?>">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">學號</label>
                <div class="col-sm-10">
                    <input type="text" name="學號" class="form-control" required value="<?php echo $uAccount; ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">姓名</label>
                <div class="col-sm-10">
                    <input type="text" name="姓名" class="form-control" required value="<?php echo $row['姓名'] ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">班級</label>
                <div class="col-sm-10">
                    <input type="text" name="班級" class="form-control" required value="<?php echo $row['班級編號'] ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">性別</label>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="性別" value="男" required <?php if ($row['性別'] == '男') echo "checked";  ?>>
                        <label class="form-check-label" for="flexRadioDefault1">
                            男
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="性別" value="女" <?php if ($row['性別'] == '女') echo "checked";  ?>>
                        <label class="form-check-label" for="flexRadioDefault1">
                            女
                        </label>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">生日</label>
                <div class="col-sm-10">
                    <input type="date" name="生日" class="form-control" required value="<?php echo $row['生日'] ?>">
                </div>
            </div>
            <input type="submit" value="確認修改" class="form-control btn btn-primary">
        </form>
        <br>
        <!-- 警告內容：成功、失敗 -->
        <?php
        if (isset($_SESSION['msg'])) {
            if ($_SESSION['msg'] == "違規登記成功！") {
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
        <br>&nbsp;
    </div>
    <div class="col-md-2 col-lg-3"></div>
</div>


<?php
require('layout/footer.php');
?>