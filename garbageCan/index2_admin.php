<?php
if(!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員")
    header('Location: ./');
?>

<p>系統管理員登入後才可見的內容...</p>
<?php
    echo "<P>Hello~".$_SESSION['姓名']."</p>"
?>
<a href="logout.php">登出</a>