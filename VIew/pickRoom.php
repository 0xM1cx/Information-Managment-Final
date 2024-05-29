<?php require '../Model/database.php' ?>

<?php
session_start();
$drop_amenities = array("Wifi", "TV", "Aircon", "Desk", "Drinks");

$type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?: '';
$capacity = filter_input(INPUT_POST, 'capacity', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?: '';
$selectedAmenities = isset($_POST['selected_amenities']) ? $_POST['selected_amenities'] : [];
$checkindate = isset($_POST['checkindate']) ? $_POST['checkindate'] : '';
$checkoutdate = isset($_POST['checkoutdate']) ? $_POST['checkoutdate'] : '';
$pricerange = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// $sql = "SELECT Type, Room_Capacity, Price, Amenities, r.CheckInDate AS rooms_CID, r.CheckOutDate AS rooms_COD, Pic_Name, res.CheckInDate AS res_CID, res.CheckOutDate AS res_COD FROM rooms r, reservation res WHERE 1=1 AND r.Room_Id = res.Room_ID";
$sql = "SELECT
            r.Room_Id AS r_Room_Id,
            Type, 
            Room_Capacity, 
            Price, 
            Amenities, 
            r.CheckInDate AS rooms_CID, 
            r.CheckOutDate AS rooms_COD, 
            Pic_Name, 
            res.CheckInDate AS res_CID, 
            res.CheckOutDate AS res_COD 
        FROM 
            rooms r 
        LEFT JOIN 
            reservation res 
        ON 
            r.Room_Id = res.Room_ID 
        WHERE 
            1=1";

if (!empty($type)) {
    $sql .= " AND Type = '$type'";
}

if (!empty($capacity)) {
    $sql .= " AND Room_Capacity = '$capacity'";
}


if (!empty($selectedAmenities)) {
    $amenityConditions = [];
    $selectedAmenities = explode(",", $selectedAmenities);

    foreach ($selectedAmenities as $amenity) {
        $amenityConditions[] = "Amenities LIKE '%$amenity%'";
    }

    $amenityQuery = implode(" AND ", $amenityConditions);

    $sql .= " AND ($amenityQuery)";
}


// if (!empty($checkindate) && !empty($checkoutdate)) {

//     $sql .= " AND (
//              (CheckInDate IS NOT NULL AND CheckOutDate IS NOT NULL AND NOT EXISTS (  -- pag check hin non-null dates and no overlap
//                SELECT * FROM rooms 
//                WHERE (
//                  (CheckInDate <= '$checkindate' AND CheckOutDate >= '$checkindate')
//                  OR (CheckInDate <= '$checkoutdate' AND CheckOutDate >= '$checkoutdate')
//                  OR (CheckInDate >= '$checkindate' AND CheckOutDate <= '$checkoutdate')
//                )
//              ))
//              OR (CheckInDate IS NULL AND CheckOutDate IS NULL) 
//            )";
// }

if (!empty($checkindate) && !empty($checkoutdate)) {
    $sql .= " AND r.Room_Id NOT IN (
                SELECT res.Room_ID 
                FROM reservation res 
                WHERE 
                    ('$checkindate' BETWEEN res.CheckInDate AND res.CheckOutDate)
                    OR ('$checkoutdate' BETWEEN res.CheckInDate AND res.CheckOutDate)
                    OR (res.CheckInDate BETWEEN '$checkindate' AND '$checkoutdate')
                    OR (res.CheckOutDate BETWEEN '$checkindate' AND '$checkoutdate')
              )
              AND r.Room_Id NOT IN (
                SELECT r1.Room_Id 
                FROM rooms r1 
                WHERE 
                    ('$checkindate' BETWEEN r1.CheckInDate AND r1.CheckOutDate)
                    OR ('$checkoutdate' BETWEEN r1.CheckInDate AND r1.CheckOutDate)
                    OR (r1.CheckInDate BETWEEN '$checkindate' AND '$checkoutdate')
                    OR (r1.CheckOutDate BETWEEN '$checkindate' AND '$checkoutdate')
              )";
}

if (!empty($pricerange)) {
    if ($pricerange == 'Lowest to Highest') {
        $sql .= " ORDER BY Price ASC";
    } elseif ($pricerange == 'Highest to Lowest') {
        $sql .= " ORDER BY Price DESC";
    }
}

$res = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pick A Room</title>
    <link href="https://unpkg.com/@tailwindcss/custom-forms/dist/custom-forms.min.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/daisyui@2.4.0/dist/daisyui.min.js"></script>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="leading-normal tracking-normal text-indigo-400 m-6 mx-40 bg-cover p-6 bg-fixed" style="background-image: url('../VIew/assets/header.png');">
    <h1 class="text-4xl">Pick a Room</h1>
    <a href="../Controller/index.php" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Go Back</a>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <div class="m-2">
            <div class="rounded-xl bg-transparent">
                <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <div class="flex flex-col">
                        <label for="type" class="text-stone-600 text-sm font-medium">Type</label>
                        <select id="type" name="type" class="mt-2 block w-full rounded-md border border-gray-200 px-2 py-2 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="" selected></option>
                            <option>Standard Room</option>
                            <option>Deluxe</option>
                            <option>Suite</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label for="capacity" class="text-stone-600 text-sm font-medium">Capacity</label>
                        <input type="text" name="capacity" id="capacity" placeholder="" class="mt-2 rounded-md border border-gray-200 px-2 py-2 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                    </div>

                    <div class="relative">
                        <label for="selected-amenities" class="text-stone-600 text-sm font-medium">Amenities</label>
                        <div class="mt-1">
                            <input id="multi-selector-input" class="px-2 py-2 border border-gray-300 rounded cursor-pointer" placeholder="Select your amenities" />
                            <ul id="multi-selector-list" class="absolute top-full left-0 z-10 hidden mt-1 w-full border border-gray-300 bg-white rounded-md shadow-sm">
                                <?php foreach ($drop_amenities as $amenity) : ?>
                                    <li class="px-4 py-2 cursor-pointer hover:bg-gray-100" data-value="<?php echo $amenity; ?>"><?php echo $amenity; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <input type="hidden" id="selected-amenities" name="selected_amenities" class="mt-1 rounded-md border border-gray-200 px-2 py-2 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <div class="flex flex-col">
                        <label for="checkindate" class="text-stone-600 text-sm font-medium">Check In Date</label>
                        <input type="date" name="checkindate" id="checkindate" class="mt-2 block w-full rounded-md border border-gray-200 px-2 py-2 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                    </div>
                    <div class="flex flex-col">
                        <label for="checkoutdate" class="text-stone-600 text-sm font-medium">Check Out Date</label>
                        <input type="date" name="checkoutdate" id="checkoutdate" class="mt-2 block w-full rounded-md border border-gray-200 px-2 py-2 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                    </div>
                    <div class="flex flex-col">
                        <label for="price" class="text-stone-600 text-sm font-medium">Price</label>
                        <select id="price" name="price" class="mt-2 block w-full rounded-md border border-gray-200 px-2 py-2 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="" selected disabled></option>
                            <option>Highest to Lowest</option>
                            <option>Lowest to Highest</option>
                        </select>
                    </div>

                </div>
                <div class="mt-6 grid w-full grid-cols-2 justify-end space-x-4 md:flex">
                    <button class="active:scale-95 rounded-lg bg-gray-200 px-8 py-2 font-medium text-gray-600 outline-none focus:ring hover:opacity-90">Reset</button>
                    <button class="active:scale-95 rounded-lg bg-blue-600 px-8 py-2 font-medium text-white outline-none focus:ring hover:opacity-90">Search</button>
                </div>
            </div>
        </div>
    </form>
    <br>
    <!-- ##### Table that shows the rooms ##### -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="table-auto w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-16 py-3">
                        <span class="sr-only">Image</span>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Capacity
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Amenities
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Book
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                // $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="p-4">
                            <img src="<?php echo $row['Pic_Name']; ?>" class="w-16 md:w-32 max-w-full max-h-full" alt="Apple Watch">
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            <input type="text" name="type" placeholder="<?php echo $row['Type']; ?>">
                        </td>
                        <td>
                            <input name="capacity" type="text" placeholder="<?php echo $row['Room_Capacity']; ?>">
                        </td>
                        <td>
                            <input name="Amenities" type="text" placeholder="<?php echo $row['Amenities']; ?>">
                        </td>
                        <td>
                            <input name="price" type="text" disabled placeholder="<?php echo $row['Price']; ?>">
                        </td>
                        <td>
                            <button class="text-white bg-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                <a href="../Controller/index.php?room=<?php echo $row['r_Room_Id']; ?>&cid=<?= $checkindate ?>&cod=<?= $checkoutdate ?>">book</a>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php $conn->close(); ?>




    <script>
        const input = document.getElementById("multi-selector-input");
        const list = document.getElementById("multi-selector-list");
        const hiddenInput = document.getElementById("selected-amenities");

        let selectedAmenities = [];


        input.addEventListener("click", function() {
            list.classList.toggle("hidden");
        });


        list.addEventListener("click", function(e) {
            if (e.target.tagName === "LI") {
                const value = e.target.dataset.value;
                if (!selectedAmenities.includes(value)) {
                    selectedAmenities.push(value);
                } else {
                    selectedAmenities = selectedAmenities.filter(item => item !== value);
                }
                input.value = selectedAmenities.join(", ");
                hiddenInput.value = selectedAmenities.join(",");
            }
        });


        input.addEventListener("input", function() {
            selectedAmenities = input.value.split(",").map(item => item.trim());
            hiddenInput.value = selectedAmenities.join(",");
        });
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


</body>

</html>