<?php

//Check："系統管理員"才可使用本頁面
if(!isset ($_SESSION))
{
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
require('dbconnect.php');
$DomiID = $_GET['宿舍編號'];
$SQL="SELECT 宿舍編號
      FROM 宿舍大樓
      WHERE 宿舍編號='$DomiID'
      ";
$result=mysqli_query($link,$SQL);
if (mysqli_num_rows($result) == 0) {
    echo "<script type='text/javascript'>";
    echo "alert('資料錯誤')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_list'>";
    exit;
}  
$title = "房間列表";
require('layout/header.php');
$SQL = "SELECT 宿舍編號
      From 宿舍大樓
      WHERE  宿舍編號='$DomiID'";

$result = mysqli_query($link, $SQL);

if (mysqli_num_rows($result) == 0) {
    echo "<br><h3 id='h1_center'>Error</h3>";
    exit;
}







$SQL = "SELECT 宿舍編號,大樓名稱 	
    FROM 宿舍大樓
    where 宿舍編號='$DomiID' 
    ";

$result = mysqli_query($link, $SQL);
$row = mysqli_fetch_assoc($result);
?>

<br>
<div class="row">
    <div class="col-6">
        <h1><?php echo $row['大樓名稱'] ?>房間列表</h1>
    </div>
    <div class="col-6"><a href="room?宿舍編號=<?php echo $DomiID ?>" class="btn btn-primary" style="float: right;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
                <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15H1.5zM11 2h.5a.5.5 0 0 1 .5.5V15h-1V2zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z" />
            </svg>
            新增房間
        </a>
    </div>
</div>



<?php




$SQL = "SELECT 房間號碼,宿舍編號,當前入住人數,舍監編號
    FROM 宿舍房間 where 宿舍編號='$DomiID'
    ORDER BY 房間號碼 ASC";

$result = mysqli_query($link, $SQL);

?>
<div class="table-responsive-md">
    <table class="table table-hover align-middle align-items-center sortable" id="center">
        <thead>
            <th colspan="2"></th>
            <th>房間號碼</th>
            <th>宿舍編號</th>
            <th>當前入住人數</th>
            <th>舍監編號</th>
            <th>Functions</th>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a href='room_list_update?宿舍編號=" . $row['宿舍編號'] . "&房間號碼=" . $row['房間號碼'] . "'><i class='bi bi-pencil-square'></i></a></td>";
                echo "<td><a href='room_list_delete?宿舍編號=" . $row['宿舍編號'] . "&房間號碼=" . $row['房間號碼'] . "' onclick='return confirm(\"確認刪除房間資料？\")'><i class='bi bi-trash3'></i></a></td>";
                echo "<td>" . $row['房間號碼'] . "</td>";
                echo "<td>" . $row['宿舍編號'] . "</td>";
                echo "<td>" . $row['當前入住人數'] . "</td>";
                echo "<td>" . $row['舍監編號'] . "</td>";
                echo "<td><div class='btn-group'>";
                echo "<a href='room_edit_moni?宿舍編號=" . $row['宿舍編號'] . "&房間號碼=" . $row['房間號碼'] . "' class='btn btn-outline-secondary'>設定舍監</a>";
                echo "<a href='room_tool_list?宿舍編號=" . $row['宿舍編號'] . "&房間號碼=" . $row['房間號碼'] . "' class='btn btn-outline-secondary'>房間設備</a>";
                echo "<a href='stu_list?宿舍編號=" . $row['宿舍編號'] . "&房間號碼=" . $row['房間號碼'] . "' class='btn btn-outline-secondary'>學生列表</a>";
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