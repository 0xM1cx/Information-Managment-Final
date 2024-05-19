<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Customer Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Room ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Check In Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Check Out Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Lease
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            require '../Model/database.php';
            $sql = "SELECT * FROM reservation";
            $q_res = mysqli_query($conn, $sql);

            $room_id = $lname = $fname = "";

            if ($q_res) {
                if ($row = mysqli_fetch_assoc($q_res)) {
                    $res_id = $row['Res_Id'];
                    $cust_id = $row['Customer_ID'];
                    $room_id = $row['Room_ID'];
                    $pay_id = $row['Payment_ID'];
                    $checkindate = $row['CheckInDate'];
                    $checkoutdate = $row['CheckOutDate'];

                    $_sql = "SELECT * FROM customer WHERE Customer_ID = ?";
                    $stmt = mysqli_prepare($conn, $_sql);
                    mysqli_stmt_bind_param($stmt, 'i', $cust_id);

                    if ($cust_res = mysqli_stmt_execute($stmt)) {
                        $cust_res = mysqli_stmt_get_result($stmt);
                        while ($_row = mysqli_fetch_assoc($cust_res)) {
                            $fname = $_row['F_Name'];
                            $lname = $_row['L_Name'];
                        }
                    } else {
                        echo "<h1>Error in getting customer information</h1>";
                    }
                }
            }

            ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Apple MacBook Pro 17"
                </th>
                <td class="px-6 py-4">
                    Silver
                </td>
                <td class="px-6 py-4">
                    Laptop
                </td>
                <td class="px-6 py-4">
                    $2999
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>