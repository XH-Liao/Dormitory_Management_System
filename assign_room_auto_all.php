<?php
session_start();
require('dbconnect.php');

//透過HTTP-POST取得mode
$mode = $_POST['mode'];

if($mode == 1){                                         //僅分配男宿
    require('assign_room_auto_male.php');
}else if($mode == 2){                                   //僅分配女宿
    require('assign_room_auto_female.php');
}else if($mode == 3){                                   //分配男、女宿
    require('assign_room_auto_male.php');
    require('assign_room_auto_female.php');
    if(!isset($_SESSION['msg_failed']))
        $_SESSION['msg_success'] = "所有宿舍分配成功！";
}
//msg 分兩種：success、failed
header('Location: assign_room');

?>