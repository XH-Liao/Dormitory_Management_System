<?php
//Check："系統管理員"、"舍監"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || ($_SESSION['login_identity'] != "系統管理員" && $_SESSION['login_identity'] != "舍監")) {
    header('Location: login');
    exit;
}

$title = "違規列表";
require('layout/header.php');
require("dbconnect.php")
?>

<!-- 學號 姓名 違規內容(違規事項, 日期) Update按鈕 Delete按鈕-->
<br>
<div class="row">
    <div class="col-md-6 col-5">
        <h1>違規列表</h1>
    </div>
    <div class="col-md-6 col-7">
        <div class="btn-group" style="float: right;">
            <button href="enroll" class="btn btn-primary" style="float: right;" data-bs-toggle='modal' data-bs-target='#violate_search_modal'>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg> 查詢
            </button>
            <?php
            if ($_SESSION["login_identity"] == "舍監") {
            ?>
                <button href="enroll" class="btn btn-primary" style="float: right;" data-bs-toggle='modal' data-bs-target='#violate_modal'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </svg> 新增違規
                </button>
            <?php
            }
            ?>

        </div>
    </div>
</div>

<?php

$SQL = "SELECT *
        FROM 違規紀錄, 學生
        WHERE 違規紀錄.學號=學生.學號
        ORDER BY 日期 DESC";
$result = mysqli_query($link, $SQL);

?>
<div class="table-responsive-md">
    <table class="table table-hover align-middle align-items-center sortable">
        <thead>
            <th></th>
            <th>日期</th>
            <th>學號</th>
            <th>姓名</th>
            <th class="col-8">違規事項</th>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) <= 0) {
                echo "<tr id='h1_center'><td colspan='12'>查無違規資料</td></tr>";
            }
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td id='center'>";
                if($_SESSION["login_identity"] == "舍監"){
                    echo "<a href='violate_update?學號=" . $row['學號'] . "&違規日期=" . $row['日期'] . "&違規事項=" . $row['違規事項'] . "'><i class='bi bi-pencil-square'></i></a> ";
                }
                echo "<a href='violate_delete_confirm?學號=" . $row['學號'] . "&違規日期=" . $row['日期'] . "&違規事項=" . $row['違規事項'] . "' onclick='return confirm(\"確認刪除違規資料？\")'><i class='bi bi-trash3'></i></a></td>";
                echo "<td>" . $row['日期'] . "</td>";
                echo "<td>" . $row['學號'] . "</td>";
                echo "<td>" . $row['姓名'] . "</td>";
                echo "<td>" . $row['違規事項'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<!-- 查詢違規 Modal -->
<div class="modal fade" id="violate_search_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">查詢違規紀錄</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="violate_state.php" method="GET">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">學號</label>
                        <div class="col-sm-9">
                            <input type="text" name="學號" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3 row" style="text-align: center;">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <button type="button" class="btn btn-secondary col-5" data-bs-dismiss="modal">取消</button>
                            <input type="submit" value="確認查詢" class="btn btn-primary col-5">
                        </div>
                        <div class="col-1"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 新增違規 Modal -->
<div class="modal fade" id="violate_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">新增違規紀錄</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="violate_confirm.php" method="POST">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">學號</label>
                        <div class="col-sm-9">
                            <input type="text" name="學號" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">違規事項</label>
                        <div class="col-sm-9">
                            <input type="text" name="違規事項" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">違規日期</label>
                        <div class="col-sm-9">
                            <input type="date" name="違規日期" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3 row" style="text-align: center;">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <button type="button" class="btn btn-secondary col-5" data-bs-dismiss="modal">取消</button>
                            <input type="submit" value="確認新增" class="btn btn-primary col-5">
                        </div>
                        <div class="col-1"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require('layout/footer.php');
?>