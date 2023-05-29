<?php

//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

$title = "分配房間";
require('layout/header.php');
require("dbconnect.php");
?>

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

<br>


<div class="row">
    <div class="col-md-6">
        <h1>自動分配房間</h1>
        <br>
        <table class="table caption-top" style="text-align: center;">
            <div class="row mb-3"></div>
            <tr class="row row-cols-2">
                <td class="col">宿舍類別</td>
                <td class="col">快速分配</td>
                <th class="col">男宿</th>
                <td class="col">
                    <form action="assign_room_auto_all.php" method="POST">
                        <input type="hidden" name="mode" value="1">
                        <input type="submit" value="自動分配男宿" class="btn btn-outline-primary" onclick="return confirm('確認分配男宿？')">
                    </form>
                </td>
                <th class="col">女宿</th>
                <td class="col">
                    <form action="assign_room_auto_all.php" method="POST">
                        <input type="hidden" name="mode" value="2">
                        <input type="submit" value="自動分配女宿" class="btn btn-outline-danger" onclick="return confirm('確認分配女宿？')">
                    </form>
                </td>
                <th class="col">所有宿舍</th>
                <td class="col">
                    <form action="assign_room_auto_all.php" method="POST">
                        <input type="hidden" name="mode" value="3">
                        <input type="submit" value="自動分配宿舍" class="btn btn-outline-success" onclick="return confirm('確認分配所有宿舍？')">
                    </form>
                </td>
            </tr>
        </table>
        <!-- 警告內容：成功、失敗 -->
        <?php
        if (isset($_SESSION['msg_success'])) {
            print <<<EOT
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>
                    {$_SESSION['msg_success']}
                </div>
            </div>
EOT;
            unset($_SESSION['msg_success']);
        }
        if (isset($_SESSION['msg_failed'])) {
            print <<<EOT
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                    {$_SESSION['msg_failed']}
                </div>
                </div>
EOT;
            unset($_SESSION['msg_failed']);
        }
        ?>
        <br>&nbsp;
    </div>
    <div class="col-md-6">
        <h1>手動分配房間</h1>
        <br>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <?php

            if (!isset($_SESSION['msg_change'])) {      //當前操作"設定房號"
                print <<<EOT
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#設定房號">設定房號</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#交換寢室">交換寢室</a>
                </li>
EOT;
            } else {                                    //當前操作"交換寢室"
                print <<<EOT
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#設定房號">設定房號</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#交換寢室">交換寢室</a>
                </li>
EOT;
            }
            ?>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <?php
            if (!isset($_SESSION['msg_change']))
                echo "<div id='設定房號' class='container tab-pane active'><br>";
            else
                echo "<div id='設定房號' class='container tab-pane fade'><br>";
            ?>
            <form action="assign_room_manual.php" method="POST">
                <input type="hidden" name="identity" value="學生">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">學號</label>
                    <div class="col-sm-10">
                        <input type="text" name="學號" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">宿舍編號</label>
                    <div class="col-sm-10">
                        <input type="text" name="宿舍編號" class="form-control">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">房間號碼</label>
                    <div class="col-sm-10">
                        <input type="text" name="房間號碼" class="form-control">
                    </div>
                </div>
                <input type="submit" value="確認設定寢室" class="form-control btn btn-primary">
            </form>
        </div>
        <?php
        if (!isset($_SESSION['msg_change']))
            echo "<div id='交換寢室' class='container tab-pane '><br>";
        else
            echo "<div id='交換寢室' class='container tab-pane active'><br>";
        ?>
        <form action="assign_room_change.php" method="POST">
            <input type="hidden" name="identity" value="系統管理員">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">學號1</label>
                <div class="col-sm-10">
                    <input type="text" name="學號1" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">學號2</label>
                <div class="col-sm-10">
                    <input type="text" name="學號2" class="form-control" required>
                </div>
            </div>
            <input type="submit" value="確認交換寢室" class="form-control btn btn-primary">
        </form>
    </div>
    <br>
    <!-- 警告內容：成功、失敗 -->
    <?php
    //設定房號的結果訊息
    if (isset($_SESSION['msg_manual'])) {
        if ($_SESSION['msg_manual'] == "設定房號成功！" || $_SESSION['msg_manual'] == "退宿成功！") {
            print <<<EOT
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                    <div>
                        {$_SESSION['msg_manual']}
                    </div>
                </div>
EOT;
        } else {
            print <<<EOT
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>
                        {$_SESSION['msg_manual']}
                    </div>
                    </div>
EOT;
        }
        unset($_SESSION['msg_manual']);
    }

    //交換房號的結果訊息
    if (isset($_SESSION['msg_change'])) {
        if ($_SESSION['msg_change'] == "交換房間成功！") {
            print <<<EOT
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                    <div>
                        {$_SESSION['msg_change']}
                    </div>
                </div>
EOT;
        } else {
            print <<<EOT
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>
                        {$_SESSION['msg_change']}
                    </div>
                    </div>
EOT;
        }
        unset($_SESSION['msg_change']);
    }
    ?>
    <br>&nbsp;
</div>
</div>
<br>&nbsp;
</div>


</div>

<?php
require('layout/footer.php');
?>