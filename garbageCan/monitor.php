<?php
$title = "舍監";
require("layout/header.php");
/*
if(!isset($_SESSION['login']) || $_SESSION['login'] != "系統管理員"){
    header('Location: ./');
    exit();
*/
?>

<div class="row">
    <div class="col-md-2 col-lg-3"></div>
    <div class="col-md-8 col-lg-6">
        <br>

        <h1 style="color: #5275e0;">舍監管理</h1>
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <?php
            if (!isset($_SESSION['msg']) || $_SESSION['msg'] != "此學號已經是舍監了" || $_SESSION['msg'] != "所有欄位皆為必填") {
                print <<<EOT
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#新增舍監">新增舍監</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#刪除舍監">刪除舍監</a>
                </li>
EOT;
            } else {
                print <<<EOT
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#新增舍監">新增舍監</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#刪除舍監">刪除舍監</a>
                </li>
EOT;
            }
            ?>
        </ul>
        <br>


        <div class="tab-content">
            <?php
            if (!isset($_SESSION['msg']) || $_SESSION['msg'] != "此學號已經是舍監了" || $_SESSION['msg'] != "所有欄位皆為必填")
                echo "<div id='新增舍監' class='container tab-pane active'>";
            else
                echo "<div id='新增舍監' class='container tab-pane fade'>";
            ?>
            <form action="monitor_add_confirm.php" method="POST">
                <input type="hidden" name="identity" value="新增舍監">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">舍監學號</label>
                    <div class="col-sm-10">
                        <input type="text" name="學號" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">舍監編號</label>
                    <div class="col-sm-10">
                        <input type="text" name="編號" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">管理房號</label>
                    <div class="col-sm-10">
                        <input type="text" name="房號" class="form-control" required>
                    </div>
                </div>
                <input type="submit" value="新增" class="form-control btn btn-primary">
            </form>
        </div>
        <?php
        if (!isset($_SESSION['msg']) || $_SESSION['msg'] != "此學號已經是舍監了" || $_SESSION['msg'] != "所有欄位皆為必填")
            echo "<div id='刪除舍監' class='container tab-pane'>";
        else
            echo "<div id='刪除舍監' class='container tab-pane active'>";
        ?>
        <form action="monitor_del_confirm.php" method="POST">
            <input type="hidden" name="identity" value="刪除舍監">
            <!--<h1 style="color: #5275e0;">刪除舍監</h1>-->
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">舍監學號</label>
                <div class="col-sm-10">
                    <input type="text" name="學號" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">舍監編號</label>
                <div class="col-sm-10">
                    <input type="text" name="編號" class="form-control" required>
                </div>
            </div>
            <input type="submit" value="刪除" class="form-control btn btn-primary">
        </form>
    </div>
</div>
<div class="col-md-2 col-lg-3"></div>
</div>


<?php
if (isset($_SESSION['msg'])) {
    echo "<p style='color: red;'> {$_SESSION['msg']} </p>";
}

session_destroy();
?>
<?php
require("layout/footer.php");
?>