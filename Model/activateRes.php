<?php
require "./database.php";
function insertDateToRoom($conn, $checkindate, $checkoutdate, $roomid, $res_id)
{
    $sql = "UPDATE rooms SET CheckInDate = ?, CheckOutDate = ? WHERE Room_Id = ?;";
    $stmt_DTR = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt_DTR, "ssi", $checkindate, $checkoutdate, $roomid);
    $DTR_result = mysqli_stmt_execute($stmt_DTR);

    if ($DTR_result) {
        $DTR_id = mysqli_stmt_insert_id($stmt_DTR);
        header("LOCATION: ../VIew/reservationList.php?status=Activated&toDel={$res_id}");
    } else {
        echo "<h1>Error in inserting date to the room table</h1>";
    }

    return $DTR_id;
}


insertDateToRoom($conn, $_GET['cid'], $_GET['cod'], $_GET['room'], $_GET['resid']);
