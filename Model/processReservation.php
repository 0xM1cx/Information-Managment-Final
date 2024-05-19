<?php
require "./database.php";
$fname = $lname = $address = $phone = $room = $checkindate = $checkoutdate = $amount = $payment_date = $card_number = "";

// echo "<h2> {$_POST['f_name']} </h2>";
// echo "<h2> {$_POST['l_name']} </h2>";
// echo "<h2> {$_POST['address']} </h2>";
// echo "<h2> {$_POST['phone']} </h2>";
// echo "<h2> {$_POST['room']} </h2>";
// echo "<h2> {$_POST['checkindate']} </h2>";
// echo "<h2> {$_POST['checkoutdate']} </h2>";
// echo "<h2> {$_POST['amount']} </h2>";
// echo "<h2> {$_POST['payment_date']} </h2>";
// echo "<h2> {$_POST['card_number']} </h2>";

function insertCustomer()
{
}

function insertPayment()
{
}


function insertDate()
{
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
            echo "<h1>Error inserting reservation: " . mysqli_stmt_error($stmt_reservation) . "</h1>";
            exit();  // Terminate script on error
        }

        // Close prepared statements
        mysqli_stmt_close($stmt_customer);
        mysqli_stmt_close($stmt_reservation);

        // Success message (optional)
        echo "<h1>Reservation successfully created!</h1>";
    } else {
        echo "<h1>Please fill out all required fields.</h1>";
    }



    $sql = "SELECT res.Room_Id, res.Reservation_ID
        FROM reservation res
        WHERE res.room_id IS NULL OR res.Reservation_ID IS NULL";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Loop through entities with empty room_id and res_Id
        while ($row = mysqli_fetch_assoc($result)) {
            $room_id = $row['Room_Id'];
            $reservation_id = $row['Reservation_ID'];

            // Randomly select a room (assuming no specific criteria)
            $random_room_sql = "SELECT Room_Id FROM rooms ORDER BY RAND() LIMIT 1";
            $random_room_result = mysqli_query($conn, $random_room_sql);

            if (mysqli_num_rows($random_room_result) == 1) {
                $random_room_row = mysqli_fetch_assoc($random_room_result);
                $room_id = $random_room_row['Room_Id'];

                // Randomly select a reservation (assuming no specific criteria)
                $random_reservation_sql = "SELECT Reservation_ID FROM reservation ORDER BY RAND() LIMIT 1";
                $random_reservation_result = mysqli_query($conn, $random_reservation_sql);

                if (mysqli_num_rows($random_reservation_result) == 1) {
                    $random_reservation_row = mysqli_fetch_assoc($random_reservation_result);
                    $reservation_id = $random_reservation_row['Reservation_ID'];

                    // Update entity table with room_id and res_Id
                    $update_sql = "UPDATE entity SET room_id = ?, res_Id = ? WHERE id = ?";
                    $stmt = mysqli_prepare($conn, $update_sql);

                    mysqli_stmt_bind_param($stmt, "iii", $room_id, $reservation_id, $entity_id);
                    mysqli_stmt_execute($stmt);

                    // Check for update errors
                    if (mysqli_stmt_error($stmt)) {
                        echo "<h1> Error updating entity: " . mysqli_stmt_error($stmt) . "</h1>";
                    } else {
                        echo "<h1>Entity " . $reservation_id . " assigned room " . $room_id . " and reservation " . $reservation_id . "<br></h1>";
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    echo "<h1>No reservations found for entity " . $entity_id . "<br></h1>";
                }
            } else {
                echo "<h1>No rooms found for entity " . $entity_id . "<br></h1>";
            }

            mysqli_free_result($random_room_result);  // Free memory from random room query
        }
    } else {
        echo "<h1>No entities found with empty room_id and res_Id</h1>";
    }
}




// Close connection (assuming it's not closed elsewhere)
mysqli_close($conn);
