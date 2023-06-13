<?php
session_start();

if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "老師") {
    header('Location: login');
    exit;
}

$title = "班級列表";
require('layout/header.php');
require('dbconnect.php');
?>

<?php
$TeacherID=$_SESSION['login_account'];
$SQL = "SELECT 班級編號
        FROM 老師 
        where 老師編號= '$TeacherID'
        ";
    $result = mysqli_query($link, $SQL);
    $row=mysqli_fetch_assoc($result);
    $ClassNum=$row["班級編號"];
$SQL = "SELECT 班級編號,學號,姓名,Email,連絡電話,生日,宿舍編號,房間號碼,性別
        FROM 學生 
        where 班級編號 = '$ClassNum'
        ";
        $result = mysqli_query($link, $SQL);
?>

<br>
<div class="row">
    <div class="col-6">
        <h1>班級<?php echo $ClassNum; ?> 學生列表</h1>
    </div>
</div>
<?php


?>
<div class="table-responsive-md" id="center">
    <table class="table table-hover align-middle align-items-center sortable">
        <thead>
            <th>班級</th>
            <th>學號</th>
            <th>姓名</th>
            <th>Email</th>
            <th>連絡電話</th>
            <th>生日</th>
            <th>性別</th>
            <th>房號</th>
        </thead>
        <tbody>
            <?php
            if(mysqli_num_rows($result) == 0){
                echo "<tr><td colspan='8'>暫無指導班級</td></tr>";
            }
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['班級編號'] . "</td>";
                echo "<td>" . $row['學號'] . "</td>";
                echo "<td>" . $row['姓名'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['連絡電話'] . "</td>";
                echo "<td>" . $row['生日'] . "</td>";
                echo "<td>" . $row['性別'] . "</td>";
                echo "<td>" . $row['宿舍編號'] . $row['房間號碼'] . "</td>";
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