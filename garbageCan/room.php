<?php
$title = "房間管理";
require("layout/header.php");
?>

<div class="row">
    <div class="col-md-2 col-lg-3"></div>
    <div class="col-md-8 col-lg-6">
        <br>

        <h1 style="color: #5275e0;">房間管理</h1>
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <?php
            if (!isset($_SESSION['msg']) || $_SESSION['msg'] != "無此大樓") {
                print <<<EOT
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#新增房間">新增房間</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#刪除房間">刪除房間</a>
                </li>
EOT;
            } else {
                print <<<EOT
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#新增房間">新增房間</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#刪除房間">刪除房間</a>
                </li>
EOT;
            }
            ?>
        </ul>
        <br>

        <div class="tab-content">
            <?php
            if (!isset($_SESSION['msg']) || $_SESSION['msg'] != "無此大樓")
                echo "<div id='新增房間' class='container tab-pane active'>";
            else
                echo "<div id='新增房間' class='container tab-pane fade'>";
            ?>
            <form action="room_confirm.php" method="POST">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">房間編號</label>
                    <div class="col-sm-10">
                        <input type="text" name="房間編號" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">入住人數</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="入住人數" aria-label="Default select example">
                            <option selected disabled>0-4人</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
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
        if (!isset($_SESSION['msg']) || $_SESSION['msg'] != "無此大樓")
            echo "<div id='刪除房間' class='container tab-pane'>";
        else
            echo "<div id='刪除房間' class='container tab-pane active'>";
        ?>
        <form action="room_confirm.php" method="POST">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">房間編號</label>
                <div class="col-sm-10">
                    <input type="text" name="房間編號" class="form-control" required>
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
<?php
if (isset($_SESSION['msg'])) {
    echo "<p style='color: red;'> {$_SESSION['msg']} </p>";
}

session_destroy();
?>
<?php
require("layout/footer.php");
?>