<?php
//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

$title = "班級列表";
require('layout/header.php');
require('dbconnect.php');
?>

<br>
<div class="row">
    <div class="col-6">
        <h1>班級列表</h1>
    </div>
    <div class="col-6">
        <a href="class_insert" class="btn btn-primary" style="float: right;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="currentColor" class="bi bi-journal-plus" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z" />
                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
            </svg>
            新增班級
        </a>
    </div>
</div>

<?php
//列出所有班級 [班級編號, 老師編號、老師姓名]
$SQL = "SELECT 班級編號
        FROM 班級
        ORDER BY 班級編號 ASC";
$result = mysqli_query($link, $SQL);
?>

<div class="table-responsive-md" id="center">
    <table class="table table-hover align-middle align-items-center sortable">
        <thead>
            <th></th>
            <th>班級編號</th>
            <th>班級學生人數</th>
            <th style='text-align: left;'>導師編號-姓名</th>
            <th>Functions</th>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a href='teacher_list' onclick='return confirm(\"提示：請由老師頁面設定班級導師！\")'><i class='bi bi-pencil-square'></i></a> ";
                echo "<a href='class_delete_confirm?班級編號=" . $row['班級編號'] . "' onclick='return confirm(\"Warning: 刪除班級將會連同班級內的所有學生一併刪除\\n確認刪除班級資料？\")'><i class='bi bi-trash3'></i></a></td>";
                echo "<td>" . $row['班級編號'] . "</td>";

                //列出班級人數
                $SQL_amount = "SELECT COUNT(*) as 班級人數 FROM 學生 WHERE 班級編號='{$row['班級編號']}'";
                if($result_amount = mysqli_query($link, $SQL_amount)){
                    $row_amount = mysqli_fetch_assoc($result_amount);
                    echo "<td>".$row_amount["班級人數"]."</td>";
                }
                
                //列出班級的所有導師編號-姓名
                echo "<td style='text-align: left;'>";
                $SQL_teacher = "SELECT 老師編號, 姓名 FROM 老師 WHERE 班級編號='{$row['班級編號']}'";
                $result_teacher = mysqli_query($link, $SQL_teacher);
                if($row_teacher = mysqli_fetch_assoc($result_teacher)){
                    echo $row_teacher['老師編號']."-".$row_teacher['姓名']." ";
                }
                while($row_teacher = mysqli_fetch_assoc($result_teacher)){
                    echo ", ".$row_teacher['老師編號']."-".$row_teacher['姓名'];
                }
                echo "</td>";

                echo "<td><div class='btn-group'>";
                echo "<a href='stu_list?班級編號=" . $row['班級編號'] . "' class='btn btn-outline-secondary'>查看班級學生</a>";
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