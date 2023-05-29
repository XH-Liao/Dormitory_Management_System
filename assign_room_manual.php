<?php
/* //設定步驟
1. 檢查"學號"必填
2. "宿舍編號"和"房號"必須 [都填(設定房號)] or [都不填 (退宿)] 
3. 檢查是否有此學生 (無 => Error)、查詢"性別"
4. 確認學生有提出入住申請
A. 退宿
    1. 檢查學生原本是否有房號 (無 => Error)
    2. 有 => UPDATE房號 設為NULL、"當前入住人數" -1、UPDATE "入住申請"table的"Account"、"核可狀態"
B. 設定房號
    1. 檢查有此房號
    2. 確認性別相符
    3. 檢查將要設定房號的當前入住人數 (已額滿 => Error)
    4. 檢查學生原本是否有房號 (無 => "核可狀態"改true，有 => 原房間"當前入住人數" -1)
    5. UPDATE 學生的房號、"當前入住人數" +1、UPDATE "入住申請"table的"Account"
*/

session_start();
//Check："系統管理員"才可使用
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit();
}

require('dbconnect.php');

//接收POST參數
$stu_ID = $_POST['學號'];
$building_ID = $_POST['宿舍編號'];
$room_number = $_POST['房間號碼'];
//1. 檢查"學號"必填
if ($stu_ID == null) {
    echo "<script type='text/javascript'>";
    echo "alert('學號為必填！');";
    echo "history.back();";
    echo '</script>';
    //$_SESSION['msg_manual'] = "學號為必填！";
    //header('Location: assign_room');
    exit();
}
//2. "宿舍編號"和"房號"必須 [都填(設定房號)] or [都不填 (退宿)] 
if ($building_ID == null xor $room_number == null) {
    echo "<script type='text/javascript'>";
    echo "alert('房號兩欄位請皆填寫或皆為空白！');";
    echo "history.back();";
    echo '</script>';
    //$_SESSION['msg_manual'] = "房號兩欄位請皆填寫或皆為空白！";
    //header('Location: assign_room');
    exit();
}

//3. 檢查申請名單是否有此學生 (無 => Error)、查詢"性別"
$SQL = "SELECT 性別
        FROM 入住申請, 學生
        WHERE 入住申請.學號=學生.學號 AND 入住申請.學號='$stu_ID'";
$result = mysqli_query($link, $SQL);
if (mysqli_num_rows($result) <= 0) {
    echo "<script type='text/javascript'>";
    echo "alert('申請名單中查無此學號!');";
    echo "history.back();";
    echo '</script>';
    //$_SESSION['msg_manual'] = "請輸入正確學號";
    //header('Location: assign_room');
    exit();
}
$row = mysqli_fetch_assoc($result);
$stu_gender = $row["性別"];


if ($building_ID == null && $room_number == null) {       //A. 退宿
    //1. 檢查學生原本是否有房號 (無 => Error)
    $SQL = "SELECT 宿舍編號, 房間號碼
            FROM 學生
            WHERE 學號='$stu_ID' AND 宿舍編號 IS NOT NULL AND 房間號碼 IS NOT NULL";
    $result = mysqli_query($link, $SQL);
    if (mysqli_num_rows($result) <= 0) {
        echo "<script type='text/javascript'>";
        echo "alert('此學生無房號，退宿失敗！');";
        echo "history.back();";
        echo '</script>';
        //$_SESSION['msg_manual'] = "此學生無房號，退宿失敗！";
        //header("Location: assign_room");
        exit;
    }
    $row = mysqli_fetch_assoc($result);
    //2. 有 => UPDATE房號 設為NULL、"當前入住人數" -1、UPDATE "入住申請"table的"Account"、"核可狀態"
    //UPDATE房號 設為NULL
    $SQL_room = "UPDATE 學生
                 SET 宿舍編號=NULL, 房間號碼=NULL
                 WHERE 學號='$stu_ID'";
    if (!mysqli_query($link, $SQL_room)) {
        echo "<script type='text/javascript'>";
        echo "alert('退宿失敗！(Error: when set NULL)');";
        echo "history.back();";
        echo '</script>';
        //$_SESSION['msg_manual'] = "退宿失敗！(Error: when set NULL)";
        //header('Location: assign_room');
        exit;
    }
    //"當前入住人數" -1
    $SQL_amount = "UPDATE 宿舍房間
                        SET 當前入住人數=當前入住人數-1
                        WHERE 宿舍編號='{$row['宿舍編號']}' AND 房間號碼='{$row['房間號碼']}'";
    if (!mysqli_query($link, $SQL_amount)) {
        echo "<script type='text/javascript'>";
        echo "alert('退宿失敗！(Error: when人數-1)');";
        echo "history.back();";
        echo '</script>';
        //$_SESSION['msg_manual'] = "退宿失敗！(Error: when人數-1)";
        //header('Location: assign_room');
        exit;
    }
    //UPDATE "入住申請"table的"Account"、"核可狀態"
    $SQL = "UPDATE 入住申請
                    SET Account=NULL, 核可狀態=false
                    WHERE 學號='$stu_ID'";
    if (!mysqli_query($link, $SQL)) {
        echo "<script type='text/javascript'>";
        echo "alert('退宿失敗！ (Error: when set 核可員Account)');";
        echo "history.back();";
        echo '</script>';
        $_SESSION['msg_manual'] = "退宿失敗！ (Error: when set 核可員Account)";
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('退宿成功！');";
        echo '</script>';
        echo "<meta http-equiv='Refresh' content='0; url=stu_list?宿舍編號=" . $building_ID . "&房間號碼=" . $room_number . "'/>";
        //$_SESSION['msg_manual'] = "退宿成功！";
    }
    //header('Location: assign_room');
    exit;
} else {                                                //B. 設定房號
    //1. 檢查有此房號、查詢此棟"性別"
    $SQL_room = "SELECT *
            FROM 宿舍房間, 宿舍大樓
            WHERE 宿舍房間.宿舍編號=宿舍大樓.宿舍編號 AND 宿舍大樓.宿舍編號='$building_ID' AND 房間號碼='$room_number'";
    $result_room = mysqli_query($link, $SQL_room);
    if (mysqli_num_rows($result_room) <= 0) {
        echo "<script type='text/javascript'>";
        echo "alert('請輸入正確的宿舍編號與房號!');";
        echo "history.back();";
        echo '</script>';
        //$_SESSION["msg_manual"] = "請輸入正確的宿舍編號與房號";
        //header("Location: assign_room");
        exit;
    }
    $row_room = mysqli_fetch_assoc($result_room);
    //2. 確認性別相符
    if ($stu_gender != $row_room["性別"]) {
        echo "<script type='text/javascript'>";
        echo "alert('男女不可混宿！');";
        echo "history.back();";
        echo '</script>';
        //$_SESSION["msg_manual"] = "男女不可混宿！";
        //header("Location: assign_room");
        exit;
    }
    //3. 檢查將要設定房號的當前入住人數 (已額滿 => Error)
    $SQL = "SELECT 當前入住人數
            FROM 宿舍房間
            WHERE 宿舍編號='$building_ID' AND 房間號碼='$room_number'";
    $result = mysqli_query($link, $SQL);
    $row = mysqli_fetch_assoc($result);
    $room_amount = $row['當前入住人數'];
    if ($room_amount >= 4) {
        echo "<script type='text/javascript'>";
        echo "alert('此房間入住人數已額滿！');";
        echo "history.back();";
        echo '</script>';
        //$_SESSION['msg_manual'] = "此房間入住人數已額滿！";
        //header('Location: assign_room');
        exit();
    }
    //4. 檢查學生原本是否有房號 (無 => "核可狀態"改true，有 => 原房間"當前入住人數" -1)
    $SQL = "SELECT 宿舍編號, 房間號碼
            FROM 學生
            WHERE 學號='$stu_ID'";
    $result = mysqli_query($link, $SQL);
    $row = mysqli_fetch_assoc($result);
    if ($row["宿舍編號"] == null) {
        $SQL = "UPDATE 入住申請
                SET 核可狀態=true
                WHERE 學號='$stu_ID'";
        if (!mysqli_query($link, $SQL)) {
            echo "<script type='text/javascript'>";
            echo "alert('設定房號失敗！ (Error: update apply's apply state)');";
            echo "history.back();";
            echo '</script>';
            //$_SESSION['msg_manual'] = "設定房號失敗！ (Error: update apply's apply state)";
            //header('Location: assign_room');
            exit;
        }
    } else if ($row["宿舍編號"] == $building_ID && $row["房間號碼"] == $room_number) {
        echo "<script type='text/javascript'>";
        echo "alert('此學生已入住此宿舍房間！');";
        echo "history.back();";
        echo '</script>';
        exit;
    } else {
        $SQL_amount = "UPDATE 宿舍房間
                    SET 當前入住人數=當前入住人數-1
                    WHERE 宿舍編號='{$row['宿舍編號']}' AND 房間號碼='{$row['房間號碼']}'";
        if (!mysqli_query($link, $SQL_amount)) {
            echo "<script type='text/javascript'>";
            echo "alert('設定房號失敗！ (Error: when set amount-1)');";
            echo "history.back();";
            echo '</script>';
            //$_SESSION["msg"] = "設定房號失敗！ (Error: when set amount-1)";
            //header("Location: assign_room");
            exit;
        }
    }
    //5. UPDATE 學生的房號、"當前入住人數" +1、UPDATE "入住申請"table的"Account"
    //UPDATE 學生的房號
    $SQL_stu = "UPDATE 學生
                SET 宿舍編號='$building_ID', 房間號碼='$room_number'
                WHERE 學號='$stu_ID'";
    if (!mysqli_query($link, $SQL_stu)) {
        echo "<script type='text/javascript'>";
        echo "alert('設定房號失敗！ (Error: update stu's room number)');";
        echo "history.back();";
        echo '</script>';
        //$_SESSION['msg_manual'] = "設定房號失敗！ (Error: update stu's room number)";
        //header('Location: assign_room');
        exit;
    }
    //"當前入住人數" +1
    $SQL_amount = "UPDATE 宿舍房間
    SET 當前入住人數=當前入住人數+1
    WHERE 宿舍編號='$building_ID' AND 房間號碼='$room_number'";
    if (!mysqli_query($link, $SQL_amount)) {
        echo "<script type='text/javascript'>";
        echo "alert('設定房號失敗！ (Error: when set amount+1)');";
        echo "history.back();";
        echo '</script>';
        //$_SESSION['msg_manual'] = "設定房號失敗！ (Error: when set amount+1)";
        //header('Location: assign_room');
        exit;
    }
    //UPDATE "入住申請"table的"Account"
    $SQL = "UPDATE 入住申請
            SET Account='{$_SESSION['login_account']}'
            WHERE 學號='$stu_ID'";
    if (!mysqli_query($link, $SQL)) {
        //失敗 => 回到上一頁
        echo "<script type='text/javascript'>";
        echo "alert('設定房號失敗！ (Error: when set 核可員Account)');";
        echo "history.back();";
        echo '</script>';
        //$_SESSION['msg_manual'] = "設定房號失敗！ (Error: when set 核可員Account)";
    } else {
        //成功 => 前往宿舍房間成員頁面
        echo "<script type='text/javascript'>";
        echo "alert('設定房號成功！');";
        echo '</script>';
        echo "<meta http-equiv='Refresh' content='0; url=stu_list?宿舍編號=" . $building_ID . "&房間號碼=" . $room_number . "'/>";
    }

    //失敗 => 回到上一頁
    /*
    echo "<script type='text/javascript'>";
    echo "alert('Error!');";
    echo "history.back();";
    echo '</script>';
    */
}
