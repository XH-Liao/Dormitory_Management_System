<?php
//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "舍監") {
    header('Location: login');
    exit;
}

//Check：取得GET參數 (!= null)
if(!isset($_GET['學號']) || !isset($_GET['違規事項']) || !isset($_GET['違規日期'])){
    echo "<br><h3>Error</h3>";
    exit;
}
$stu_id = $_GET['學號'];
$violate_rule = $_GET['違規事項'];
$violate_date = $_GET['違規日期'];


$title = "違規登記";
require('layout/header.php');
?>

<br>
<div class="row">
    <div class="col-md-2 col-lg-3"></div>
    <div class="col-md-8 col-lg-6">
        <h1>違規資料修改</h1>
        <form action="violate_update_confirm.php" method="POST">
            <input type="hidden" name="原學號" value="<?php echo $_GET['學號']; ?>">
            <input type="hidden" name="原違規事項" value="<?php echo $_GET['違規事項']; ?>">
            <input type="hidden" name="原違規日期" value="<?php echo $_GET['違規日期']; ?>">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">學號</label>
                <div class="col-sm-10">
                    <input type="text" name="學號" class="form-control" required value="<?php echo $_GET['學號']; ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">違規事項</label>
                <div class="col-sm-10">
                    <input type="text" name="違規事項" class="form-control" required value="<?php echo $_GET['違規事項']; ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">違規日期</label>
                <div class="col-sm-10">
                    <input type="date" name="違規日期" class="form-control" required value="<?php echo $_GET['違規日期']; ?>">
                </div>
            </div>
            <input type="submit" value="確認修改" class="form-control btn btn-primary">
        </form>
        <br>
        <!-- 警告圖示 -->
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </symbol>
            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
            </symbol>
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
            </symbol>
        </svg>
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