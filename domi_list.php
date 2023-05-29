<?php
//Check："系統管理員"才可使用本頁面
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

$title = "大樓列表";
require('layout/header.php');
require('dbconnect.php');
?>

<br>
<div class="row">
    <div class="col-6">
        <h1>大樓列表</h1>
    </div>
    <div class="col-6">
        <a href="domitory" class="btn btn-primary" style="float: right;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building-fill-add" viewBox="0 0 16 16">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Z" />
                <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v7.256A4.493 4.493 0 0 0 12.5 8a4.493 4.493 0 0 0-3.59 1.787A.498.498 0 0 0 9 9.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .39-.187A4.476 4.476 0 0 0 8.027 12H6.5a.5.5 0 0 0-.5.5V16H3a1 1 0 0 1-1-1V1Zm2 1.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5Zm3 0v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1ZM4 5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5ZM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5ZM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z" />
            </svg>
            新增大樓
        </a>
    </div>
</div>


<!--<a href="stu_state?學號=a1095525" class="btn btn-primary">Test</a>-->

<?php
//列出所有學生名單 [學號、姓名、Email、連絡電話、性別、房號、btn(查詢入住狀態)、btn(查詢違規)、生日、btn(重設密碼)]
$SQL = "SELECT 大樓名稱, 房間住宿費用,房間數,宿舍編號	
        FROM 宿舍大樓 
        ORDER BY 大樓名稱 ASC";
$result = mysqli_query($link, $SQL);

?>
<div class="table-responsive-md">
    <table class="table table-hover align-middle align-items-center sortable" id="center">
        <thead>
            <th colspan="2"></th>
            <th>大樓名稱</th>
            <th>房間住宿費用</th>
            <th>房間數</th>
            <th>宿舍編號</th>
            <th>Functions</th>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a href='domi_list_update?宿舍編號=" . $row['宿舍編號'] . "'><i class='bi bi-pencil-square'></i></a></td>";
                echo "<td><a href='domi_delete?宿舍編號=" . $row['宿舍編號'] . "' onclick='return confirm(\"確認刪除大樓資料？\")'><i class='bi bi-trash3'></i></a></td>";
                echo "<td>" . $row['大樓名稱'] . "</td>";
                echo "<td>" . $row['房間住宿費用'] . "</td>";
                echo "<td>" . $row['房間數'] . "</td>";
                echo "<td>" . $row['宿舍編號'] . "</td>";
                echo "<td><div class='btn-group'>";
                echo "<a href='domi_tool_list?宿舍編號=" . $row['宿舍編號'] . "' class='btn btn-outline-secondary'>大樓設備</a>";
                echo "<a href='room_list?宿舍編號=" . $row['宿舍編號'] . "' class='btn btn-outline-secondary'>宿舍房間</a>";
                echo "<a href='stu_list?宿舍編號=" . $row['宿舍編號'] . "' class='btn btn-outline-secondary'>學生列表</a>";
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