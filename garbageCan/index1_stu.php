<?php
if(!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "學生")
    header('Location: ./');
?>

<p>學生登入後才可見的內容...</p>
<?php
    echo "<P>Hello~".$_SESSION['姓名']."</p>"
?>
<a href="logout.php">登出</a>