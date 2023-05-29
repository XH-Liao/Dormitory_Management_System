<?php
$title = "學生宿舍管理系統";
require("layout/header.php");
require('dbconnect.php');
?>

<br>
<div class="row">
    <div class="col-6">
        <h1>宿舍公告</h1>
    </div>
    <div class="col-6">
        <?php
        if (isset($_SESSION['login_identity']) && ($_SESSION['login_identity'] == "系統管理員" || $_SESSION['login_identity'] == "舍監")) {
            echo "<butoon class='btn btn-primary' style='float: right;' data-bs-toggle='modal' data-bs-target='#announce_model'>";
            echo "<i class='bi bi-megaphone-fill'></i>&nbsp; 新增公告";
            echo "</butoon>";
        }
        ?>
    </div>
</div>
<!-- 新增公告 Modal -->
<div class="modal fade" id="announce_model">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">新增公告</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="announce_insert_confirm.php" method="POST">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">公告標題</label>
                        <div class="col-sm-9">
                            <input type="text" name="公告標題" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">公告內容</label>
                        <div class="col-sm-9">
                            <textarea type="text" name="公告內容" class="form-control" rows="18" required></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row" style="text-align: center;">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <button type="button" class="btn btn-secondary col-5" data-bs-dismiss="modal">取消</button>
                            <input type="submit" value="發布公告" class="btn btn-primary col-5">
                        </div>
                        <div class="col-1"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--公告列表-->
<?php
$SQL = "SELECT 日期, 標題, No
        FROM 系統消息
        ORDER BY No DESC";
$result = mysqli_query($link, $SQL);
?>

<div class="table-responsive-md">
    <table class="table table-hover align-middle align-items-center sortable">
        <thead>
            <?php
            if (isset($_SESSION['login_identity']) && ($_SESSION['login_identity'] == "系統管理員" || $_SESSION['login_identity'] == "舍監")) {
                echo "<th colspan='2'></th>";
            }
            ?>
            <th>公告日期</th>
            <th class="col-10">公告標題</th>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                if (isset($_SESSION['login_identity']) && ($_SESSION['login_identity'] == "系統管理員" || $_SESSION['login_identity'] == "舍監")) {
                    echo "<td id='center'><a id='without_underline' href='announce_update?No=" . $row['No'] . "'><i class='bi bi-pencil-square'></i></a></td>";
                    echo "<td id='center'><a id='without_underline' href='announce_delete?No=" . $row['No'] . "' onclick='return confirm(\"確認刪除此公告資料？\")'><i class='bi bi-trash3'></i></a></td>";
                }
                echo "<td>" . $row['日期'] . "</td>";
                echo "<td><a href='announce_content?No={$row['No']}' id='without_underline'>" . $row['標題'] . "</a></td>";
                echo "</tr>";
            }


            ?>
        </tbody>
    </table>
</div>

<?php
require("layout/footer.php");
?>

<!--
    <br>
    <h1>學生宿舍管理系統</h1>
    <?php
    /*
        if(!isset($_SESSION['login_identity'])){
            require('index0.php');
        }else if($_SESSION['login_identity'] == "學生"){
            require('index1_stu.php');
        }else if($_SESSION['login_identity'] == "系統管理員"){
            require('index2_admin.php');
        }
        */
    ?>
-->