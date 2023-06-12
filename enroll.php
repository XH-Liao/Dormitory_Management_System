<?php
//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

$title = "註冊";
require('layout/header.php');
?>


<div class="row">
    <div class="col-md-2 col-lg-3"></div>
    <div class="col-md-8 col-lg-6">
        <br>
        <!-- 警告內容：成功、失敗 -->
        <?php
        if (isset($_SESSION['msg'])) {
            print <<<EOT
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>
                        {$_SESSION['msg']}
                    </div>
                </div>
EOT;
        }
        ?>
        <h1>註冊</h1>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <?php
            //根據不同錯誤訊息，顯示對應身分的註冊介面
            if (!isset($_SESSION['msg']) || $_SESSION['msg'] == "請勿重複註冊，此學生已存在！") {
                print <<<EOT
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#學生">學生</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#系統管理員">系統管理員</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#老師">老師</a>
                </li>
EOT;
            } else if ($_SESSION['msg'] == "請勿重複註冊，此管理員已存在！") {
                print <<<EOT
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#學生">學生</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#系統管理員">系統管理員</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#老師">老師</a>
                </li>
EOT;
            } else if ($_SESSION['msg'] == "請勿重複註冊，此老師已存在！") {
                print <<<EOT
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#學生">學生</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#系統管理員">系統管理員</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#老師">老師</a>
                </li>
EOT;
            }
            ?>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <?php
            // 根據不同的錯誤訊息，顯示對應的註冊內容
            if (!isset($_SESSION['msg']) || $_SESSION['msg'] == "請勿重複註冊，此學生已存在！") {
                echo "<div id='學生' class='container tab-pane active'><br>";
            } else {
                echo "<div id='學生' class='container tab-pane fade'><br>";
            }
            ?>
            <!-- 註冊表單：學生 -->
            <form action="enroll_confirm.php" method="POST">
                <input type="hidden" name="identity" value="學生">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">學號</label>
                    <div class="col-sm-10">
                        <input type="text" name="帳號" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">姓名</label>
                    <div class="col-sm-10">
                        <input type="text" name="姓名" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">班級</label>
                    <div class="col-sm-10">
                        <input type="text" name="班級" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">性別</label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="性別" value="男" required>
                            <label class="form-check-label" for="flexRadioDefault1">
                                男
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="性別" value="女">
                            <label class="form-check-label" for="flexRadioDefault1">
                                女
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">生日</label>
                    <div class="col-sm-10">
                        <input type="date" name="生日" class="form-control" required>
                    </div>
                </div>
                <input type="submit" value="註冊" class="form-control btn btn-primary">
            </form>
        </div>
        <!-- 註冊表單：管理員 -->
        <?php
        if (isset($_SESSION['msg']) && $_SESSION['msg'] == "請勿重複註冊，此管理員已存在！") {
            echo "<div id='系統管理員' class='container tab-pane active'><br>";
        } else {
            echo "<div id='系統管理員' class='container tab-pane fade'><br>";
        }
        ?>
        <form action="enroll_confirm.php" method="POST">
            <input type="hidden" name="identity" value="系統管理員">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">帳號</label>
                <div class="col-sm-10">
                    <input type="text" name="帳號" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">姓名</label>
                <div class="col-sm-10">
                    <input type="text" name="姓名" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">生日</label>
                <div class="col-sm-10">
                    <input type="date" name="生日" class="form-control" required>
                </div>
            </div>
            <input type="submit" value="註冊" class="form-control btn btn-primary">
        </form>
    </div>
    <!-- 註冊表單：老師 -->
    <?php
    if (isset($_SESSION['msg']) && $_SESSION['msg'] == "請勿重複註冊，此老師已存在！") {
        echo "<div id='老師' class='container tab-pane active'><br>";
    } else {
        echo "<div id='老師' class='container tab-pane fade'><br>";
    }
    ?>
    <form action="enroll_confirm.php" method="POST">
        <input type="hidden" name="identity" value="老師">
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">帳號</label>
            <div class="col-sm-10">
                <input type="text" name="帳號" class="form-control" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">姓名</label>
            <div class="col-sm-10">
                <input type="text" name="姓名" class="form-control" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">指導班級</label>
            <div class="col-sm-10">
                <input type="text" name="班級" class="form-control">
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">生日</label>
            <div class="col-sm-10">
                <input type="date" name="生日" class="form-control" required>
            </div>
        </div>
        <input type="submit" value="註冊" class="form-control btn btn-primary">
    </form>
</div>
</div>
</div>
<div class="col-md-2 col-lg-3"></div>
</div>


<?php
unset($_SESSION['msg']);
require('layout/footer.php');
?>