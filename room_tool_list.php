<?php
//Check："系統管理員"才可使用本頁面
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}
if(!isset($_GET['宿舍編號']))
{
    header('Location: domi_list');
    exit;
}
$DomiID = $_GET['宿舍編號'];
if(!isset($_GET['房間號碼']))
{
    header('Location: room_list?宿舍編號='.$DomiID);
    exit;
}
$RoomID = $_GET['房間號碼'];
$title = "房間設備列表";
require('layout/header.php');
require('dbconnect.php');
$SQL = "SELECT 宿舍編號
      From 宿舍大樓
      WHERE  宿舍編號='$DomiID'";

$result = mysqli_query($link, $SQL);

if (mysqli_num_rows($result) == 0) {
    echo "<br><h3 id='h1_center'>Error</h3>";
    exit;
}

$SQL = "SELECT 房間號碼,宿舍編號
      From 宿舍房間
      WHERE  房間號碼='$RoomID' AND 宿舍編號='$DomiID'";

$result = mysqli_query($link, $SQL);

if (mysqli_num_rows($result) == 0) {
    echo "<br><h3 id='h1_center'>Error</h3>";
    exit;
}
?>

<br>
<div class="row">
    <div class="col-6">
        <h1><?php echo $DomiID . $RoomID ?>房間設備列表</h1>
    </div>
    <div class="col-6">
        <a href="room_tool?宿舍編號=<?php echo $DomiID ?>&房間號碼=<?php echo $RoomID ?>" class="btn btn-primary" style="float: right;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16">
                <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0Zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708ZM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11Z" />
            </svg>
            新增房間設備
        </a>
    </div>
</div>


<!--<a href="stu_state?學號=a1095525" class="btn btn-primary">Test</a>-->

<?php
//列出所有學生名單 [學號、姓名、Email、連絡電話、性別、房號、btn(查詢入住狀態)、btn(查詢違規)、生日、btn(重設密碼)]
$SQL = "SELECT 設備,房間號碼,宿舍編號 	
        FROM 宿舍房間_設備 where 宿舍編號='$DomiID' and 房間號碼='$RoomID'";
$result = mysqli_query($link, $SQL);

?>
<div class="table-responsive-md">
    <table class="table table-hover align-middle align-items-center sortable">
        <thead>
            <th colspan="2"></th>
            <th>設備</th>
            <th>房間號碼</th>
            <th>宿舍編號</th>
            <!--<th>Functions</th>-->
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a href='room_tool_update?宿舍編號=" . $row['宿舍編號'] . "&房間號碼=" . $row['房間號碼'] . "&房間設備=" . $row['設備'] . "'><i class='bi bi-pencil-square'></i></a></td>";
                echo "<td><a href='room_tool_delete?宿舍編號=" . $row['宿舍編號'] . "&房間號碼=" . $row['房間號碼'] . "&房間設備=" . $row['設備'] . "' onclick='return confirm(\"確認刪除房間設備資料？\")'><i class='bi bi-trash3'></i></a></td>";
                echo "<td>" . $row['設備'] . "</td>";
                echo "<td>" . $row['房間號碼'] . "</td>";
                echo "<td>" . $row['宿舍編號'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php
require('layout/footer.php');
?>