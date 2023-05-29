<?php
$title = "留言板";
require("layout/header.php");
require('dbconnect.php');
?>

<br>
<div class="row">
    <div class="col-6">
        <h1>留言板</h1>
    </div>
    <div class="col-6">
        <?php
        if (isset($_SESSION['login_identity']) && ($_SESSION['login_identity'] == "學生")) {
            echo "<butoon class='btn btn-primary' style='float: right;' data-bs-toggle='modal' data-bs-target='#announce_model'>";
            echo "<i class='bi bi-chat-dots-fill'></i>&nbsp; 新增留言";
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
                <h3 class="modal-title" id="exampleModalLabel">新增留言</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="message_insert_confirm.php" method="POST">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">留言標題</label>
                        <div class="col-sm-9">
                            <input type="text" name="留言標題" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">留言內容</label>
                        <div class="col-sm-9">
                            <textarea type="text" name="留言內容" class="form-control" rows="18" required></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row" style="text-align: center;">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <button type="button" class="btn btn-secondary col-5" data-bs-dismiss="modal">取消</button>
                            <input type="submit" value="發布留言" class="btn btn-primary col-5">
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
$SQL = "SELECT 日期, 標題, No, 留言.學號, 姓名
        FROM 留言, 學生
        WHERE 留言.學號=學生.學號
        ORDER BY No DESC";
$result = mysqli_query($link, $SQL);
?>

<div class="table-responsive-md">
    <table class="table table-hover align-middle align-items-center sortable">
        <thead>
            <th class="col-md-2">留言時間</th>
            <th class="col-md-8" id='main_td'>留言標題</th>
            <th class="col-md-2">留言者</th>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['日期'] . "</td>";
                echo "<td><a href='message_content?No={$row['No']}' id='without_underline'  id='main_td'>" . $row['標題'] . "</a></td>";
                echo "<td>" . $row['學號'] . " " . $row['姓名'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
require("layout/footer.php");
?>