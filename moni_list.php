<?php
//Check："系統管理員"才可使用本頁面
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

$title = "舍監列表";
require('layout/header.php');
require('dbconnect.php');
?>

<br>
<div class="row">
    <div class="col-6">
        <h1>舍監列表</h1>
    </div>
    <div class="col-6">
        <a href="monitor" class="btn btn-primary" style="float: right;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="currentColor" class="bi bi-flag-fill" viewBox="0 0 16 16">
                <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001" />
            </svg>
            新增舍監
        </a>
    </div>
</div>


<!--<a href="stu_state?學號=a1095525" class="btn btn-primary">Test</a>-->

<?php
//列出所有學生名單 [學號、姓名、Email、連絡電話、性別、房號、btn(查詢入住狀態)、btn(查詢違規)、生日、btn(重設密碼)]
$SQL = "SELECT 學號, 姓名, Email, 連絡電話, 學生.性別 AS 性別, 生日, 學生.舍監編號 AS 舍監編號,宿舍房間.房間號碼 AS 房間號碼,宿舍房間.宿舍編號 AS 宿舍編號
        FROM  學生 ,宿舍房間 where 學生.舍監編號=宿舍房間.舍監編號 and 宿舍房間.舍監編號 IS NOT NULL
        Group by 舍監編號
        ORDER BY 舍監編號  ASC";
$result = mysqli_query($link, $SQL);


?>
<div class="table-responsive-md">
    <table class="table table-hover align-middle align-items-center sortable" id="center">
        <thead>
            <th colspan="2"></th>
            <th>舍監編號</th>
            <th>學號</th>
            <th>姓名</th>
            <th>Email</th>
            <th>連絡電話</th>
            <th>生日</th>
            <th>性別</th>
            <th>管理房號</th>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a href='moni_list_update?學號=" . $row['學號'] . "&編號=" . $row['舍監編號'] . "'><i class='bi bi-pencil-square'></i></a></td>";
                echo "<td><a href='monitor_list_delete?學號=" . $row['學號'] . "&編號=" . $row['舍監編號'] . "' onclick='return confirm(\"確認刪除舍監資料？\")'><i class='bi bi-trash3'></i></a></td>";
                echo "<td>" . $row['舍監編號'] . "</td>";
                echo "<td>" . $row['學號'] . "</td>";
                echo "<td>" . $row['姓名'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['連絡電話'] . "</td>";
                echo "<td>" . $row['生日'] . "</td>";
                echo "<td>" . $row['性別'] . "</td>";
                $SQL = "SELECT 宿舍編號,房間號碼
                      FROM 宿舍房間
                      WHERE 舍監編號=" . $row['舍監編號'];
                $result2 = mysqli_query($link, $SQL);
                echo "<td>";
                $row2 = mysqli_fetch_array($result2);
                do {
                    echo $row2['宿舍編號'] . $row2['房間號碼'];
                    $row2 = mysqli_fetch_array($result2);
                    if ($row2) {
                        echo ",";
                    }
                } while ($row2);

                echo "</td>";
                echo "<td><div class='btn-group'>";
                echo "</div></td>";
                echo "</tr>";
                //$row['房間號碼'] .
            }


            ?>
        </tbody>
    </table>
</div>
<?php
require('layout/footer.php');
?>