<?php
require('layout/header.php');
?>


<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <br>
        <h1 style="color: #5275e0;">註冊</h1>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#學生">學生</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#系統管理員">系統管理員</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div id="學生" class="container tab-pane active"><br>
                <form action="enroll_confirm_stu.php" method="POST">
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">學號</label>
                        <div class="col-sm-10">
                            <input type="text" name="學號" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">姓名</label>
                        <div class="col-sm-10">
                            <input type="text" name="姓名" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">性別</label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="性別" value="男" required>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    男
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="性別" value="女">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    女
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">生日</label>
                        <div class="col-sm-10">
                            <input type="date" name="生日" class="form-control" required>
                        </div>
                    </div>
                    <input type="submit" value="註冊" class="form-control btn btn-primary">
                </form>
            </div>
            <div id="系統管理員" class="container tab-pane fade"><br>
            <form action="enroll_confirm_adm.php" method="POST">
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">學號</label>
                        <div class="col-sm-10">
                            <input type="text" name="學號" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">姓名</label>
                        <div class="col-sm-10">
                            <input type="text" name="姓名" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">生日</label>
                        <div class="col-sm-10">
                            <input type="date" name="生日" class="form-control" required>
                        </div>
                    </div>
                    <input type="submit" value="註冊" class="form-control btn btn-primary">
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>


<?php
require('layout/footer.php');
?>