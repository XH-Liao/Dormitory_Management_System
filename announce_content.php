<?php
$title = "公告內容";
require('layout/header.php');
require('dbconnect.php');

$announce_No = $_GET['No'];
$SQL = "SELECT 標題, 內容, 日期, Account, 舍監編號
        FROM 系統消息
        WHERE No=$announce_No";
$result = mysqli_query($link, $SQL);
if(mysqli_num_rows($result) <= 0){
    echo "<script type='text/javascript'>";
    echo "alert('Error!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=./'/>";
    exit;
}
$row = mysqli_fetch_assoc($result);
?>

<br>

<div class="card border-secondary">
    <div class="card-body bg-secondary  text-light">
        <h5>
            <?php echo $row['標題'];
            if (isset($_SESSION['login_identity']) && ($_SESSION['login_identity'] == "系統管理員" || $_SESSION['login_identity'] == "舍監")) {
                echo "<a class='text-light' id='without_underline' href='announce_update?No=" . $announce_No . "'>&nbsp;<i class='bi bi-pencil-square'></i>&nbsp;</a>";
                echo "<a style='float: right;' id='without_underline' href='announce_delete?No=$announce_No' onclick='return confirm(\"確認刪除公告資料？\")'>&nbsp;<i class='bi bi-trash3 text-light'></i>&nbsp;</a>";
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
            if (isset($_SESSION['login_identity']) && ($_SESSION['login_identity'] == "系統管理員" || $_SESSION['login_identity'] == "舍監")) {
                echo "&nbsp;&nbsp;<i class='bi bi-person-fill'></i> " . $row['Account'] . $row['舍監編號'];
            }
            ?>
        </p>
    </div>
</div>