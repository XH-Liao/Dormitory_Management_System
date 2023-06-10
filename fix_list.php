<?php
//Check："系統管理員"才可使用本頁面
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

$title = "報修列表";
require('layout/header.php');
require('dbconnect.php');
?>

<br>
<div class="row">
    <div class="col-6">
        <h1>報修列表</h1>
    </div>
</div>




<?php

$SQL = "SELECT 大樓設備,宿舍編號,維修狀態
        FROM 宿舍大樓_大樓設備
        WHERE 維修狀態 = 1
        ORDER BY 宿舍編號 ASC";
$result = mysqli_query($link, $SQL);

?>
<div class="table-responsive-md">
    <table class="table table-hover align-middle align-items-center sortable" id="center">
        <thead>
            <th colspan="1"></th>
            <th>大樓編號</th>
            <th>房間號碼</th>
            <th>設備名稱</th>
            <th>維修狀態</th>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a href='fix_list_update?宿舍編號=".$row['宿舍編號']."&設備名稱=".$row['大樓設備']."' onclick='return confirm(\"確認維修完成？\")'><i class='bi bi-check-square'></i></a></td>";
                echo "<td>" . $row['宿舍編號'] . "</td>";
                echo "<td></td>";
                echo "<td>" . $row['大樓設備'] . "</td>";
                echo "<td>維修中</td>";
                echo "</tr>";
            }
            $SQL = "SELECT 設備,宿舍編號,房間號碼,維修狀態
            FROM 宿舍房間_設備
            WHERE 維修狀態 = 1
            ORDER BY 宿舍編號 ASC";
            $result = mysqli_query($link, $SQL);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a href='fix_list_update?宿舍編號=".$row['宿舍編號']."&設備名稱=".$row['設備']."&房間號碼=".$row['房間號碼']."' onclick='return confirm(\"確認維修完成？\")'><i class='bi bi-check-square'></i></a></td>";
                echo "<td>" . $row['宿舍編號'] . "</td>";
                echo "<td>" . $row['房間號碼'] . "</td>";
                echo "<td>" . $row['設備'] . "</td>";
                echo "<td>維修中</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php
require('layout/footer.php');
?>