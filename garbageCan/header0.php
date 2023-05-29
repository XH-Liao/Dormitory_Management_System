<?php
    session_start();
?>
<!--
    color: #5275e0、#049595、#8b46b9、#1f8aad
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php 
            if(isset($title))
                echo $title;
        ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/6ca71a439b.js" crossorigin="anonymous"></script>
    <style>/*
  	    .nav-link {color: #99ff99;}
        .nav-link:hover {background-color: #ffff4d;}*/
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar1">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a href="/DB_FinalProject" class="nav-link active">學生宿舍管理系統</a>
            <div class="collapse navbar-collapse order-3 order-md-2" id="navbar1">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#" class="nav-link">申請住宿</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">留言板</a>
                    </li>
                </ul>
            </div>
            <ul class="navbar-nav order-2 order-md-3">
                <?php
                    if(!isset($_SESSION['is_login']) || $_SESSION['is_login'] == FALSE){
                        print <<<EOT
                            <li class="nav-item">
                                <a href="enroll" class="nav-link">
                                    <i class="fa-solid fa-user-plus"></i>註冊
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="login" class="nav-link">
                                    <i class="fa-solid fa-right-to-bracket"></i>登入
                                </a>
                            </li>
                        EOT;
                    }else{
                        print <<<EOT
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-user"> &nbsp</i>{$_SESSION['姓名']}
                                </a>
                                <ul class="dropdown-menu "> <!-- dropdown-menu-right -->
                                    <li><a href="#" class="dropdown-item">Link1</a></li>
                                    <li><a href="#" class="dropdown-item">Link2</a></li>
                                    <li><a href="logout.php" class="dropdown-item">登出</a></li>
                                </ul>
                            </li>
                        EOT;
                    }
                ?>
            </ul>
        </div>
    </nav>
    <div class="container">