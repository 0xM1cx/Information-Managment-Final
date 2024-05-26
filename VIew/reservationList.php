<?php
session_start();
require '../Model/database.php';
if (isset($_GET['status']) && $_GET['status'] == "Activated" && isset($_GET['toDel'])) {
    $_sql = "DELETE FROM reservation WHERE Res_Id = ?";
    $_sql_Prep = $conn->prepare($_sql);
    $_sql_Prep->bind_param("i", $_GET['toDel']);
    $_sql_Prep->execute();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation List</title>
    <link href="https://unpkg.com/@tailwindcss/custom-forms/dist/custom-forms.min.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/daisyui@2.4.0/dist/daisyui.min.js"></script>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="leading-normal tracking-normal text-indigo-400 m-6 mx-40 bg-cover p-6 bg-fixed" style="background-image: url('../VIew/assets/header.png');">


    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Customer
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Room ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Payment
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Check in Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Check out Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Action</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT Res_Id, F_Name, L_Name, ro.Room_ID AS Room_Number, Price, r.CheckInDate AS resCheckInDate, r.CheckOutDate as resCheckOutDate FROM reservation r, customer c, rooms ro WHERE r.Customer_ID = c.Customer_ID AND r.Room_ID = ro.Room_ID;";

                $res = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <?php echo $row["F_Name"] . " " . $row['L_Name']; ?>
                        </th>
                        <td class="px-6 py-4">
                            <input disabled name="roomid" id="roomid" type="text" placeholder="<?php echo $row['Room_Number']; ?>" value="<?php echo $row['Room_Number']; ?>">
                        </td>
                        <td class="px-6 py-4">
                            <?php echo $row['Price']; ?>
                        </td>
                        <td class="px-6 py-4">
                            <input disabled type="text" name="checkindate" id="checkindate" placeholder="<?php echo $row['resCheckInDate']; ?>" value="<?php echo $row['resCheckInDate']; ?>">
                        </td>
                        <td class="px-6 py-4">
                            <input disabled type="text" name="checkoutdate" id="checkoutdate" placeholder="<?php echo $row['resCheckOutDate']; ?>" value="<?php echo $row['resCheckOutDate']; ?>">

                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="../Model/activateRes.php?room=<?php echo $row['Room_Number']; ?>&cid=<?php echo $row['resCheckInDate']; ?>&cod=<?php echo $row['resCheckOutDate']; ?>&resid=<?php echo $row['Res_Id']; ?>" class="font-medium text-green-600 dark:text-green-500 hover:underline">Activate</a>
                            <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

</html>