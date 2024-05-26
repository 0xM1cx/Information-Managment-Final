<?php
require "./database.php";
$currentDateTime = date('Y-m-d H:i:s');
$fname = $lname = $address = $phone = $room = $checkindate = $checkoutdate = $amount = $payment_date = $card_number = "";




function insertCustomer($conn, $fname, $lname, $address, $phone)
{
    $sql = "INSERT INTO customer (F_Name, L_Name, Address, Phone) VALUES (?, ?, ?, ?);";
    $stmt_cust = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt_cust, 'ssss', $fname, $lname, $address, $phone);
    $cust_result = mysqli_stmt_execute($stmt_cust);

    if ($cust_result) {
        $cust_id = mysqli_stmt_insert_id($stmt_cust); // get the newly created customer id, gamition ko later ha reservation table
    } else {
        echo "<h1>Error ha pag insert hin customer inforamation</h1>";
    }

    return $cust_id;
}

function insertPayment($conn, $amount, $payment_date, $card_number)
{
    $sql = "INSERT INTO payment (Amount, Payment_Date, Card_Number) VALUES (?, ?, ?);";
    $stmt_pay = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt_pay, 'iss', $amount, $payment_date, $card_number);
    $pay_result = mysqli_stmt_execute($stmt_pay);

    if ($pay_result) {
        $pay_id = mysqli_stmt_insert_id($stmt_pay);
    } else {
        echo "<h1>Error in the inserting to payment table</h1>";
    }

    return $pay_id;
}


// function insertDateToRoom($conn, $checkindate, $checkoutdate, $roomid)
// {
//     $sql = "UPDATE rooms SET CheckInDate = ?, CheckOutDate = ? WHERE Room_Id = ?;";
//     $stmt_DTR = mysqli_prepare($conn, $sql);
//     mysqli_stmt_bind_param($stmt_DTR, "ssi", $checkindate, $checkoutdate, $roomid);
//     $DTR_result = mysqli_stmt_execute($stmt_DTR);

//     if ($DTR_result) {
//         $DTR_id = mysqli_stmt_insert_id($stmt_DTR);
//     } else {
//         echo "<h1>Error in inserting date to the room table</h1>";
//     }

//     return $DTR_id;
// }

function insertReservation($conn, $custid, $roomid, $payid, $checkindate, $checkoutdate)
{
    $sql = "INSERT INTO reservation (Customer_ID, Room_ID, Payment_ID, CheckInDate, CheckOutDate) VALUES (?, ?, ?, ?, ?);";
    $stmt_res = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt_res, "iiiss", $custid, $roomid, $payid, $checkindate, $checkoutdate);
    $resvervation_result = mysqli_stmt_execute($stmt_res);

    if ($resvervation_result) {
        $res_id = mysqli_stmt_insert_id($stmt_res);
    } else {
        echo "<h1>Error trying to insert to Reservation table</h1>";
    }
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!empty($_POST['f_name']) && !empty($_POST['l_name']) && !empty($_POST['address']) && !empty($_POST['phone']) && !empty($_POST['room']) && !empty($_POST['checkindate']) && !empty($_POST['checkoutdate']) && !empty($_POST['amount']) && !empty($_POST['payment_date']) && !empty($_POST['card_number'])) {
        $lname = filter_input(INPUT_POST, 'l_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fname = filter_input(INPUT_POST, 'f_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $room = filter_input(INPUT_POST, 'room', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $checkindate = filter_input(INPUT_POST, 'checkindate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $checkoutdate = filter_input(INPUT_POST, 'checkoutdate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $payment_date = filter_input(INPUT_POST, 'payment_date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $card_number = filter_input(INPUT_POST, 'card_number', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        // Insert into the customer table
        $new_cust_id = insertCustomer($conn, $fname, $lname, $address, $phone);
        $new_payment_id = insertPayment($conn, $amount, $currentDateTime, $card_number);
        // insertDateToRoom($conn, $checkindate, $checkoutdate, $room);
        $new_res_id = insertReservation($conn, $new_cust_id, $room, $new_payment_id, $checkindate, $checkoutdate);
        header("Location: ../Controller/index.php");
    } else {
        echo "<h1>Error: there are variables with no values</h1>";
    }
}


mysqli_close($conn);
