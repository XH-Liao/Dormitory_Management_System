<?php

//Check："學生"、"舍監"才可使用本頁面
session_start();
if(!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "學生" && $_SESSION['login_identity'] != "舍監"){
    header('Location: login');
    exit();
}

$title = "申請住宿狀態";
require("layout/header.php");
?>

<br>
<h1>申請住宿已成功</h1>
<?php
require('dbconnect.php');
require('time.php');
$uAccount = $_SESSION['login_account'];

//先查詢申請狀態
$SQL = "SELECT 學年度, 學期, 姓名, 入住申請.學號, 核可狀態, 繳費狀態
        FROM 入住申請, 學生
        WHERE 入住申請.學號=學生.學號 AND 入住申請.學號='$uAccount' AND 學年度='$year' AND 學期='$semester'";
$result = mysqli_query($link, $SQL);
$row = mysqli_fetch_assoc($result);

//如果已核可，就查詢房號、需繳費金額
if ($row['核可狀態'] == true) {
    //查詢房間號碼、費用
    $SQL_room = "SELECT 學生.宿舍編號, 房間號碼, 房間住宿費用
                FROM 宿舍大樓, 學生
                WHERE 學生.宿舍編號=宿舍大樓.宿舍編號 AND 學生.學號='$uAccount'";
    $result_room = mysqli_query($link, $SQL_room);
    if ($result)
        $row_room = mysqli_fetch_assoc($result_room);
}

?>



<table class="table caption-top">
    <caption>申請狀態</caption>
    <tr class=" row row-cols-2 row-cols-md-4">
        <!--
        <th class="col-4 col-md-2">學年度：</th>
        <td class="col-8 col-md-4">111</td>    
        -->
        <th class="col">學年度：</th>
        <td class="col"><?php echo $row['學年度'] ?></td>
        <th class="col">學期：</th>
        <td class="col"><?php echo $row['學期'] ?></td>
        <th class="col">姓名：</th>
        <td class="col"><?php echo $row['姓名'] ?></td>
        <th class="col">學號：</th>
        <td class="col"><?php echo $row['學號'] ?></td>
        <th class="col">核可狀態：</th>
        <td class="col">
            <?php
            if ($row['核可狀態'] == true)
                echo "已核可，宿舍房間：{$row_room['宿舍編號']} {$row_room['房間號碼']}";
            else
                echo "尚未核可"
            ?>
        </td>
        <th class="col">繳費狀態：</th>
        <td class="col">
            <!-- Button trigger modal -->
            <?php
            if ($row['繳費狀態'] == true)
                echo "<button type='button' class='btn btn-primary disable'>已繳費</button>";
            else
                echo "<button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#pay_modal'>前往繳費</button>"
            ?>
        </td>
    </tr>
</table>

<!-- Modal -->
<div class="modal fade" id="pay_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">繳費 - 住宿金</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?php
            if ($row['核可狀態'] == false)
                print <<<EOT
                    <div class="modal-body">
                    <p>管理員尚未核可申請，無法繳費！</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                    </div>
EOT;
            else
                print <<<EOT
                    <div class="modal-body">
                    <form action="apply_fee.php" method="POST">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">繳費金額</label>
                        <div class="col-sm-9">
                            <input type="text" name="繳費金額" class="form-control" id="money" required readonly value="{$row_room['房間住宿費用']}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">信用卡號</label>
                        <div class="col-sm-9">
                            <input type="text" name="信用卡號" class="form-control" required placeholder="xxxx xxxx xxxx xxxx">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">三碼檢查碼</label>
                        <div class="col-sm-9">
                            <input type="text" name="三碼檢查碼" class="form-control" id="三碼檢查碼" required placeholder="...">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">信用卡到期</label>
                        <div class="col-sm-9">
                            <input type="month" name="信用卡到期" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3 row" style="text-align: center;">
                        <div class="col-1"></div>
                        <div class="col-10">
                        <button type="button" class="btn btn-secondary col-5" data-bs-dismiss="modal">取消</button>
                        <input type="submit" value="確認支付" class="btn btn-primary col-5">
                        </div>
                        <div class="col-1"></div>
                    </div>
                    </form>
                    </div>
EOT;
            ?>
        </div>
    </div>
</div>

<?php
//繳費執行的結果訊息
if (isset($_SESSION['msg'])) {
    if ($_SESSION['msg'] == "繳費成功！") {
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


<?php
require("layout/footer.php");
?>