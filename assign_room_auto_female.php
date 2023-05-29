<?php




//女宿
//查詢所有已申請的學生
$SQL_stu = "SELECT 學生.學號
            FROM 入住申請, 學生
            WHERE 入住申請.學號=學生.學號 AND 宿舍編號 IS NULL AND 房間號碼 IS NULL AND 性別='女'
            ORDER BY 申請日期 ASC";
$result_stu = mysqli_query($link, $SQL_stu);
//查詢所有空房
$SQL_room = "SELECT 宿舍房間.宿舍編號, 房間號碼, 當前入住人數
            FROM 宿舍大樓, 宿舍房間
            WHERE 宿舍大樓.宿舍編號=宿舍房間.宿舍編號 AND 當前入住人數 < 4 AND 性別='女'
            ORDER BY 宿舍房間.宿舍編號 DESC";
$result_room = mysqli_query($link, $SQL_room);

$male_failed_msg = "";
if (isset($_SESSION['msg_failed']))
    $male_failed_msg = $_SESSION['msg_failed'] . "<br>";

if (mysqli_num_rows($result_stu) <= 0) {
    $_SESSION['msg_failed'] = $male_failed_msg . "女宿分配失敗！(目前無女學生提出申請)";
    //header('Location: assign_room');
    //exit();
} else if (mysqli_num_rows($result_room) <= 0) {
    $_SESSION['msg_failed'] = $male_failed_msg . "女宿分配失敗！(已額滿，無空房)";
    //header('Location: assign_room');
    //exit();
} else {
    //第一房
    $row_room = mysqli_fetch_assoc($result_room);

    //當前入住人數
    $current = $row_room['當前入住人數'];

    //分配宿舍給所有學生
    while ($row_stu = mysqli_fetch_assoc($result_stu)) {
        //更新學生的宿舍大樓、房號
        $SQL_assign = "UPDATE 學生
                    SET 宿舍編號='{$row_room['宿舍編號']}', 房間號碼={$row_room['房間號碼']}
                    WHERE 學號='{$row_stu['學號']}'";
        $result = mysqli_query($link, $SQL_assign);
        //更新入住申請 => "已核可"
        $SQL = "UPDATE 入住申請
            SET 核可狀態=true, Account='{$_SESSION['login_account']}'
            WHERE 學號='{$row_stu['學號']}'";
        $result = mysqli_query($link, $SQL);

        //入住人數+1
        $current++;
        //若已人滿(4人)，更新"當前入住人數"為4，並且選定下一房
        if ($current >= 4) {
            $current = 0;
            $SQL = "UPDATE 宿舍房間
                SET 當前入住人數=4
                WHERE 宿舍編號='{$row_room['宿舍編號']}' AND 房間號碼={$row_room['房間號碼']}";
            $result = mysqli_query($link, $SQL);

            //選定下一房
            if (!$row_room = mysqli_fetch_assoc($result_room)) {
                $_SESSION['msg_failed'] = $male_failed_msg . "女宿申請人數大於目前的可容納量！";
                $_SESSION["msg_success"] = "女宿申請部分成功！(申請人數大於目前的可容納量)";
                break;
            }
        }
    }

    //安排完後，更新"當前入住人數"
    if ($current != 0) {
        $SQL = "UPDATE 宿舍房間
                    SET 當前入住人數='$current'
                    WHERE 宿舍編號='{$row_room['宿舍編號']}' AND 房間號碼={$row_room['房間號碼']}";
        $result = mysqli_query($link, $SQL);
    }

    $_SESSION['msg_success'] = "女宿分配成功！";
}
