<?php
//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit();
}

require('dbconnect.php');

//HTTP-POST
$class_Number = $_POST['班級'];
$teacher_ID1 = $_POST['老師1'];
$teacher_ID2 = $_POST['老師2'];

//必填：班級
if ($class_Number == NULL) {
    $_SESSION['msg'] = 'Error: 班級編號為必填';
    header('Location: class_insert');
    exit;
}

//查詢老師是否存在、老師是否已經有指導班級
if ($teacher_ID1 != NULL) {
    $SQL = "SELECT * FROM 老師 WHERE 老師編號='$teacher_ID1'";
    $result = mysqli_query($link, $SQL);
    if (mysqli_num_rows($result) <= 0) {
        $_SESSION['msg'] = 'Error: 老師編號1錯誤';
        header('Location: class_insert');
        exit;
    }
    
    $row = mysqli_fetch_assoc($result);
    if ($row["班級編號"] != NULL) {
        $_SESSION['msg'] = 'Error: 老師1已經有指導班級';
        header('Location: class_insert');
        exit;
    }
}
if ($teacher_ID2 != NULL) {
    $SQL = "SELECT * FROM 老師 WHERE 老師編號='$teacher_ID2'";
    $result = mysqli_query($link, $SQL);
    if (mysqli_num_rows($result) <= 0) {
        $_SESSION['msg'] = 'Error: 老師編號2錯誤';
        header('Location: class_insert');
        exit;
    }
    
    $row = mysqli_fetch_assoc($result);
    if ($row["班級編號"] != NULL) {
        $_SESSION['msg'] = 'Error: 老師2已經有指導班級';
        header('Location: class_insert');
        exit;
    }
}


//新增班級
$SQL = "INSERT INTO 班級(班級編號) VALUES ('$class_Number')";
if ($result = mysqli_query($link, $SQL)) {                        //新增班級成功
    // 更新老師1的指導班級
    if ($teacher_ID1 != null) {
        $SQL = "UPDATE 老師
                SET 班級編號='$class_Number'
                WHERE 老師編號='$teacher_ID1'";
        if (!$result = mysqli_query($link, $SQL)) {
            $_SESSION['msg'] = "Success: 新增班級成功。\nError: 設定班級導師1失敗！";
            echo "<script type='text/javascript'> history.back(); </script>";
            exit;
        }
    }

    // 更新老師2的指導班級
    if ($teacher_ID2 != null) {
        $SQL = "UPDATE 老師
                SET 班級編號='$class_Number'
                WHERE 老師編號='$teacher_ID2'";
        if (!$result = mysqli_query($link, $SQL)) {
            $_SESSION['msg'] = "Success: 新增班級成功。\nError: 設定班級導師2失敗！";
            echo "<script type='text/javascript'> history.back(); </script>";
            exit;
        }
    }

    echo "<script type='text/javascript'> alert('Success: 新增班級成功！'); </script>";
    echo "<meta http-equiv='Refresh' content='0; url=class_list'>";
} else {                                                          //新增班級失敗
    $_SESSION['msg'] = "Error: 新增班級失敗！";
    echo "<script type='text/javascript'> history.back(); </script>";
    exit;
}
