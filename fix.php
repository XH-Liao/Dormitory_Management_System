<?php
$title = "報修申請";

require("layout/header.php");
require('dbconnect.php');


?>

<div class="row">
    <div class="col-md-2 col-lg-3"></div>
    <div class="col-md-8 col-lg-6">
        <br>
        <?php
        if (isset($_SESSION['msg'])) {
            print <<<EOT
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                    {$_SESSION['msg']}
                </div>
                </div>
            EOT;
            unset($_SESSION['msg']);
        }
        ?>
        <h1 style="color: #5275e0;">報修申請</h1>
        <form action="fix_confirm.php" method="POST">
            <input type="hidden" name="identity" value="報修申請">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">大樓編號</label>
                <div class="col-sm-10">
                <select class="form-select" name="宿舍編號" aria-label="Default select example">
                    <option selected disabled>選擇大樓編號</option>
                    <?php
                        $SQL = "SELECT 宿舍編號
                        FROM  宿舍大樓
                        ";
                        $result = mysqli_query($link, $SQL);
                        
                        while($row = mysqli_fetch_assoc($result))
                        {
                            
                            echo "<option value=".$row['宿舍編號'].">".$row['宿舍編號']."</option>";
                            
                        }
                    ?>
                </select>
                
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">房間房號</label>
                <div class="col-sm-10">
                <select class="form-select" name="房間號碼" aria-label="Default select example">
                    <option selected disabled>選擇房間號碼</option>
                    <?php
                        $SQL = "SELECT 房間號碼,宿舍編號
                        FROM 宿舍房間
                        ORDER BY 宿舍編號 ASC
                        ";
                        $result = mysqli_query($link, $SQL);
                        
                        while($row = mysqli_fetch_assoc($result))
                        {
                            
                            echo "<option value=".$row['房間號碼'].">".$row['宿舍編號']."-".$row['房間號碼']."</option>";
                            
                        }
                    ?>
                </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">設備名稱</label>
                <div class="col-sm-10">
                    <select class="form-select" name="設備名稱" aria-label="Default select example">
                    <option selected disabled>選擇設備名稱</option>
                    <?php
                        $SQL = "SELECT 大樓設備 FROM 宿舍大樓_大樓設備
                                UNION
                                SELECT 設備 AS 大樓設備 FROM 宿舍房間_設備
                        ";
                        $result = mysqli_query($link, $SQL);
                        
                        while($row = mysqli_fetch_assoc($result))
                        {
                            
                            echo "<option value=".$row['大樓設備'].">".$row['大樓設備']."</option>";
                            
                        }
                    ?>
                </select>
                </div>
            </div>
            <input type="submit" value="報修" class="form-control btn btn-primary">
        </form>
    </div>
</div>
<div class="col-md-2 col-lg-3"></div>
</div>



<?php
require("layout/footer.php");
?>