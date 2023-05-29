<?php
$title = "大樓管理";
require("layout/header.php");
?>

<div class="row">
    <div class="col-md-2 col-lg-3"></div>
    <div class="col-md-8 col-lg-6">
        <br>

        <h1 style="color: #5275e0;">大樓管理</h1>
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <?php
            if (!isset($_SESSION['msg']) || $_SESSION['msg'] != "已有此大樓編號") {
                print <<<EOT
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#新增大樓">新增大樓</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#刪除大樓">刪除大樓</a>
                </li>
EOT;
            } else {
                print <<<EOT
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#新增大樓">新增大樓</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#刪除大樓">刪除大樓</a>
                </li>
EOT;
            }
            ?>
        </ul>
        <br>

        <div class="tab-content">
            <?php
            if (!isset($_SESSION['msg']) || $_SESSION['msg'] != "已有此大樓編號")
                echo "<div id='新增大樓' class='container tab-pane active'>";
            else
                echo "<div id='新增大樓' class='container tab-pane fade'>";
            ?>
            <form action="domitory_confirm.php" method="POST">
                <input type="hidden" name="identity" value="新增大樓">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">大樓名稱</label>
                    <div class="col-sm-10">
                        <input type="text" name="大樓名稱" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">房間住宿費用</label>
                    <div class="col-sm-10">
                        <input type="text" name="費用" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">房間數</label>
                    <div class="col-sm-10">
                        <input type="text" name="房間數" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">大樓編號</label>
                    <div class="col-sm-10">
                        <input type="text" name="大樓編號" class="form-control" required>
                    </div>
                </div>
                <input type="submit" value="新增" class="form-control btn btn-primary">
            </form>
        </div>
        <?php
        if (!isset($_SESSION['msg']) || $_SESSION['msg'] != "已有此大樓編號")
            echo "<div id='刪除大樓' class='container tab-pane'>";
        else
            echo "<div id='刪除大樓' class='container tab-pane active'>";
        ?>
        <form action="domitory_confirm.php" method="POST">
            <input type="hidden" name="identity" value="刪除大樓">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">大樓名稱</label>
                <div class="col-sm-10">
                    <input type="text" name="大樓名稱" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">大樓編號</label>
                <div class="col-sm-10">
                    <input type="text" name="大樓編號" class="form-control" required>
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