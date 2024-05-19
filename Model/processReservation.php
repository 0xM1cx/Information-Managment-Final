<?php
$fname = $lname = $address = $phone = $room = $checkindate = $checkoutdate = $amount = $payment_date = $card_number = "";

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
    }
}
