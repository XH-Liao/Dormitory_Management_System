<?php
//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

$title = "學生列表";
require('layout/header.php');
require('dbconnect.php');
?>

<br>
<div class="row">
    <div class="col-6">
        <h1><?php if (isset($_GET['宿舍編號']) && isset($_GET['房間號碼'])) {
                echo $_GET['宿舍編號'] . $_GET['房間號碼'];
            } else if (isset($_GET['宿舍編號'])) {
                echo $_GET['宿舍編號'];
            } ?>學生列表</h1>
        <!--讓使用者知道是甚麼樣的學生列表-->
    </div>
    <?php if (isset($_GET['宿舍編號']) && isset($_GET['房間號碼'])) {
        print <<< EOT
            <div class="col-6">
                <butoon class='btn btn-primary' style='float: right;' data-bs-toggle='modal' data-bs-target='#announce_model'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                    </svg>
                    新增房間學生
                </butoon>
EOT;
    } else if (!isset($_GET['宿舍編號']) && !isset($_GET['房間號碼'])) {
        print <<< EOT
            <div class="col-6">
                <a href="enroll" class="btn btn-primary" style="float: right;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                    </svg>
                    新生註冊
                </a>
            </div>
EOT;
    } ?>
</div>

<div class="modal fade" id="announce_model">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">新增房間學生</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                            <label class="col-sm-3 col-form-label">學號</label>
                            <div class="col-sm-9">
                                <input type="text" name="學號" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">宿舍編號</label>
                            <div class="col-sm-9">
                                <input type="text" name="宿舍編號" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">房間號碼</label>
                            <div class="col-sm-9">
                                <input type="text" name="房間號碼" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 row" style="text-align: center;">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <button type="button" class="btn btn-secondary col-5" data-bs-dismiss="modal">取消</button>
                                <input type="submit" value="確認設定寢室" class="btn btn-primary col-5">
                            </div>
                            <div class="col-1"></div>
                        </div>
                    </form>
                </div>
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
                ?>
                <br>&nbsp;
            </div>
        </div>
    </div>
</div>
</div>
<!--<a href="stu_state?學號=a1095525" class="btn btn-primary">Test</a>-->

<?php
//列出所有學生名單 [學號、姓名、Email、連絡電話、性別、房號、btn(查詢入住狀態)、btn(查詢違規)、生日、btn(重設密碼)]

if (isset($_GET['宿舍編號']) && isset($_GET['房間號碼'])) //判斷是否來源於Room_list是就輸出住那間房間的學生
{
    $DomiID = $_GET['宿舍編號'];
    $RoomID = $_GET['房間號碼'];
    $SQL = "SELECT 學號, 姓名, Email, 連絡電話, 性別,  生日,宿舍編號,房間號碼
        FROM 學生 where 宿舍編號='$DomiID' and 房間號碼='$RoomID'
        ORDER BY 學號 ASC";
    $result = mysqli_query($link, $SQL);
} else if (isset($_GET['宿舍編號'])) //判斷是否來源於domi_list是就輸出住那棟樓的學生
{
    $DomiID = $_GET['宿舍編號'];
    $SQL = "SELECT 學號, 姓名, Email, 連絡電話, 性別,  生日,宿舍編號,房間號碼
        FROM 學生 where 宿舍編號='$DomiID'
        ORDER BY 學號 ASC";
    $result = mysqli_query($link, $SQL);
} else {
    $SQL = "SELECT 學號, 姓名, Email, 連絡電話, 性別,  生日,宿舍編號,房間號碼
        FROM 學生 
        ORDER BY 學號 ASC";
    $result = mysqli_query($link, $SQL);
}
?>
<div class="table-responsive-md" id="center">
    <table class="table table-hover align-middle align-items-center sortable">
        <thead>
            <th colspan="2"></th>
            <th>學號</th>
            <th>姓名</th>
            <th>Email</th>
            <th>連絡電話</th>
            <th>生日</th>
            <th>性別</th>
            <th>房號</th>
            <th>Functions</th>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a href='stu_list_update?學號=" . $row['學號'] . "'><i class='bi bi-pencil-square'></i></a></td>";
                echo "<td><a href='stu_list_delete?學號=" . $row['學號'] . "' onclick='return confirm(\"確認刪除學生資料？\")'><i class='bi bi-trash3'></i></a></td>";
                echo "<td>" . $row['學號'] . "</td>";
                echo "<td>" . $row['姓名'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['連絡電話'] . "</td>";
                echo "<td>" . $row['生日'] . "</td>";
                echo "<td>" . $row['性別'] . "</td>";
                echo "<td>" . $row['宿舍編號'] . $row['房間號碼'] . "</td>";
                echo "<td><div class='btn-group'>";
                echo "<a href='stu_list_apply_state?學號=" . $row['學號'] . "' class='btn btn-outline-secondary'>申請狀態</a>";
                echo "<a href='violate_state?學號=" . $row['學號'] . "' class='btn btn-outline-secondary'>違規列表</a>";
                echo "<a href='stu_list_reset_password?學號=" . $row['學號'] . "' class='btn btn-outline-secondary' onclick='return confirm(\"確認重設密碼？\")'>密碼重設</a>";
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