<?php
require "./database.php";
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

        $sql = "INSERT INTO customer (F_Name, L_Name, Address, Phone) VALUES (?, ?, ?, ?)";
        $stmt_customer = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt_customer, "ssss", $fname, $lname, $address, $phone);
        mysqli_stmt_execute($stmt_customer);

        // 2. Retrieve the newly inserted customer ID
        $customer_id = mysqli_stmt_insert_id($stmt_customer);

        // 3. Insert Reservation Data (referencing customer ID, room ID, potentially payment ID)
        $sql_reservation = "INSERT INTO reservation (Customer_ID, Room_ID, CheckInDate, CheckOutDate, Amount, Payment_Date, Card_Number) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_reservation = mysqli_prepare($conn, $sql_reservation);

        mysqli_stmt_bind_param($stmt_reservation, "iiiiiss", $customer_id, $room, $checkindate, $checkoutdate, $amount, $payment_date, $card_number);
        mysqli_stmt_execute($stmt_reservation);

        // Check for errors in reservation insertion
        if (mysqli_stmt_error($stmt_reservation)) {
            echo "Error inserting reservation: " . mysqli_stmt_error($stmt_reservation);
            exit();  // Terminate script on error
        }

        // Close prepared statements
        mysqli_stmt_close($stmt_customer);
        mysqli_stmt_close($stmt_reservation);

        // Success message (optional)
        echo "Reservation successfully created!";
    } else {
        echo "Please fill out all required fields.";
    }
}


// Close connection (assuming it's not closed elsewhere)
mysqli_close($conn);
