<?php
$title = "報修申請";

require("layout/header.php");
require('dbconnect.php');


?>
<script>
    $(document).ready(function() {
        
        // 綁定第一個下拉式選單的change事件
        $('#firstSelect').change(function() {
            var firstValue = $(this).val(); // 取得所選擇的值

            // 根據選擇的值動態調整第二個下拉式選單的選項
            if (firstValue === '') {
                $('#secondSelect').html('<option value="">請先選擇大樓編號</option>'); 
                $('#thirdSelect').html('<option value="">請先選擇其他項目</option>'); 
            } else {
                // 使用AJAX向PHP發送請求，獲取第二個下拉式選單的選項內容
                $.ajax({
                    url: "get_fix_room_options.php",
                    method: "POST",
                    data: {
                        value: firstValue
                    },
                    success: function(response) {
                        var secondSelect = document.getElementById("secondSelect");
                        secondSelect.innerHTML = response;
                    }
                });
                $.ajax({
                    url: "get_fix_tool_options.php",
                    method: "POST",
                    data: {
                        value: firstValue
                        
                    },
                    success: function(response) {
                        var thirdSelect = document.getElementById("thirdSelect");
                        thirdSelect.innerHTML = response;
                    }
                });
            }
        });
        $('#secondSelect').change(function() {
            var firstValue = $('#firstSelect').val();
            var secondValue = $(this).val();
            if (secondValue === '') {
                if(firstValue === '')
                {
                $('#thirdSelect').html('<option value="">請先選擇其他項目</option>'); 
                }
                else
                {
                    $.ajax({
                    url: "get_fix_tool_options.php",
                    method: "POST",
                    data: {
                        value: firstValue
                        
                    },
                    success: function(response) {
                        var thirdSelect = document.getElementById("thirdSelect");
                        thirdSelect.innerHTML = response;
                    }
                });
                }
            }
            else 
            {
                // 使用AJAX向PHP發送請求，獲取第二個下拉式選單的選項內容
                
                $.ajax({
                    url: "get_fix_tool_options.php",
                    method: "POST",
                    data: {
                        value: firstValue,
                        value2: secondValue
                    },
                    success: function(response) {
                        var thirdSelect = document.getElementById("thirdSelect");
                        thirdSelect.innerHTML = response;
                    }
                });
            }
        });
    });
   
</script>


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
                <select id="firstSelect" class="form-select"  name="宿舍編號" aria-label="Default select example">
                    <option value="">選擇大樓編號</option>
                    
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
                <select id="secondSelect" class="form-select"  name="房間號碼" aria-label="Default select example">
                <option value="">請先選擇大樓編號</option>
                   
                    
                </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">設備名稱</label>
                <div class="col-sm-10">
                    <select id="thirdSelect" class="form-select"   name="設備名稱" aria-label="Default select example">
                    <option value="">請先選擇其他項目</option>
                    
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">報修人</label>
                <div class="col-sm-10">
                    <input type="text" name="報修人" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">聯絡方式</label>
                <div class="col-sm-10">
                    <input type="text" name="聯絡方式" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">損毀情況</label>
                <div class="col-sm-10">
                    <textarea type="text" name="損毀情況" rows="15" class="form-control" required></textarea>
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