<?php
$title = "留言內容";
require('layout/header.php');
require('dbconnect.php');

$message_No = $_GET['No'];
$SQL = "SELECT *
        FROM 留言, 學生
        WHERE 留言.學號=學生.學號 AND No=$message_No";
$result = mysqli_query($link, $SQL);
if (mysqli_num_rows($result) <= 0) {
    echo "<script type='text/javascript'>";
    echo "alert('Error!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message'/>";
    exit;
}
$row = mysqli_fetch_assoc($result);
?>
<!--Message內容-->
<br>
<div class="card border-secondary">
    <div class="card-body bg-secondary  text-light">
        <h5>
            <?php echo $row['標題'];
            //可修改者：留言者本人
            if (isset($_SESSION['login_identity']) && $_SESSION['login_account'] == $row["學號"]) {
                echo "<a class='text-light' id='without_underline' href='message_update?No=" . $message_No . "'>&nbsp;<i class='bi bi-pencil-square'></i>&nbsp;</a>";
            }
            //可刪除者：系統管理員、舍監、留言者本人
            if (isset($_SESSION['login_identity']) && ($_SESSION['login_identity'] == "系統管理員" || $_SESSION['login_identity'] == "舍監" || $_SESSION['login_account'] == $row["學號"])) {

                echo "<a style='float: right;' id='without_underline' href='message_delete_confirm?No=$message_No' onclick='return confirm(\"確認刪除此留言？\")'>&nbsp;<i class='bi bi-trash3 text-light'></i>&nbsp;</a>";
            }
            ?>
        </h5>
    </div>
    <div class="card-body">
        <p class="card-text"><?php echo nl2br($row['內容']); ?></p>

    </div>
    <div class="card-footer">
        <p style="text-align: end;" class="card-text">
            <?php
            echo $row['日期'];
            echo "&nbsp;&nbsp;<i class='bi bi-person-fill'></i> " . $row['學號'] . " " . $row['姓名'];
            ?>
        </p>
    </div>
    <!--回復內容-->
    <?php
    //要顯示：已回覆 || 舍監 
    // => 不顯示：無回覆內容 && 不是舍監 
    if ($row["回覆內容"] == null && (!isset($_SESSION["login_identity"]) || $_SESSION["login_identity"] != "舍監")) {
        echo "</div>";
        exit;
    }

    //查詢回覆舍監姓名
    if ($row["回覆內容"] != null) {
        $SQL = "SELECT *
        FROM 留言, 學生
        WHERE 留言.舍監編號=學生.舍監編號 AND No=$message_No";
        $result = mysqli_query($link, $SQL);
        $row = mysqli_fetch_assoc($result);
    }else{
        echo "<butoon class='btn btn-secondary' style='float: right;' data-bs-toggle='modal' data-bs-target='#message_reply_model'>";
                    echo "<i class='bi bi-chat-dots-fill'></i>&nbsp; 回覆留言";
                    echo "</butoon>";
                    exit;
    }
    ?>
    <div class="card-body bg-secondary  text-light">
        <h5>
            留言回覆
            <?php
            //顯示回覆 新增、修改、刪除 btn
            if (isset($_SESSION['login_identity']) && ($_SESSION['login_identity'] == "系統管理員" || $_SESSION['login_identity'] == "舍監")) {
                if ($row["回覆內容"] == NULL) {     //尚未回覆 => 新增回覆
                    echo "<butoon class='btn btn-secondary' style='float: right;' data-bs-toggle='modal' data-bs-target='#message_reply_model'>";
                    echo "<i class='bi bi-chat-dots-fill'></i>&nbsp; 回覆留言";
                    echo "</butoon>";
                } else {    //已回覆
                    //回覆者本人可修改、刪除
                    if (isset($_SESSION["login_monitor"]) && $row["舍監編號"] == $_SESSION["login_monitor"]) {
                        echo "<a class='text-light' id='without_underline' href='message_reply_update?No=" . $message_No . "'>&nbsp;<i class='bi bi-pencil-square'></i>&nbsp;</a>";
                        echo "<a style='float: right;' id='without_underline' href='message_reply_delete_confirm?No=$message_No' onclick='return confirm(\"確認刪除此回覆？\")'>&nbsp;<i class='bi bi-trash3 text-light'></i>&nbsp;</a>";
                    }
                    //管理員可刪除
                    if ($_SESSION["login_identity"] == "系統管理員") {
                        echo "<a style='float: right;' id='without_underline' href='message_reply_delete_confirm?No=$message_No' onclick='return confirm(\"確認刪除此回覆？\")'>&nbsp;<i class='bi bi-trash3 text-light'></i>&nbsp;</a>";
                    }
                }
            }
            ?>
        </h5>
    </div>
    <div class="card-body">
        <p class="card-text"><?php echo nl2br($row['回覆內容']); ?></p>
    </div>
    <div class="card-footer">
        <p style="text-align: end;" class="card-text">
            <?php
            echo $row['回覆時間'];
            echo "&nbsp;&nbsp;<i class='bi bi-person-fill'></i> " . $row['學號']." ".$row['姓名'];
            ?>
        </p>
    </div>
</div>
<!-- 新增回覆 Modal -->
<div class="modal fade" id="message_reply_model">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">留言回覆</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="message_reply_insert_confirm.php" method="POST">
                    <input type="hidden" name="No" value="<?php echo $message_No; ?>">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">回覆內容</label>
                        <div class="col-sm-9">
                            <textarea type="text" name="回覆內容" class="form-control" rows="18" required></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row" style="text-align: center;">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <button type="button" class="btn btn-secondary col-5" data-bs-dismiss="modal">取消</button>
                            <input type="submit" value="確認回覆" class="btn btn-primary col-5">
                        </div>
                        <div class="col-1"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>