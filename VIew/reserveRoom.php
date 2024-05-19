<?php
$currentTime = date('l, F jS Y h:i:s A');
?>

<section class="bg-transparent py-8 antialiased dark:bg-gray-900 md:py-16">
    <h1 class="text-4xl">Reserve a Room</h1>
    <br>
    <br>
    <br>
    <form action="../Model/processReservation.php" method="POST" class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12 xl:gap-16">
            <div class="min-w-0 flex-1 space-y-8">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="mt-3">
                            <a href="../VIew/pickRoom.php" class="focus:ring transform transition hover:scale-105 duration-300 ease-in-out font-bold py-2 px-4 bg-gradient-to-r from-purple-800 to-green-500 hover:from-pink-500 hover:to-green-500 mb-3 text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Pick a Room</a>
                        </div>
                        <div></div>
                        <div>
                            <label for="f_name" class="mb-2 block text-sm font-medium text-[#07074D]"> First Name* </label>
                            <input name="f_name" type="text" id="f_name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="Shawn Michael" required />
                        </div>

                        <div>
                            <label for="l_name" class="mb-2 block text-sm font-medium text-[#07074D]"> Last Name* </label>
                            <input name="l_name" type="text" id="l_name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="Sudaria" required />
                        </div>

                        <div>
                            <div>
                                <label for="address" class="mb-2 block text-sm font-medium text-[#07074D]"> Address* </label>
                                <input class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" type="text" name="address" id="address" placeholder="Sta. Crus St, Brgy 44, Tacloban City, Philippines" required>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="phone" class="mb-2 block text-sm font-medium text-[#07074D]"> Contact Number* </label>
                                <input pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" type="tel" name="phone" id="phone" placeholder="123-456-7890" required>
                            </div>
                        </div>
                        <div>
                            <div>
                                <?php
                                if (!empty($_GET['room'])) {
                                    $room_id = $_GET['room'];
                                    $sql = "SELECT Type, Room_Capacity, Price FROM rooms WHERE Room_Id = ?";
                                    $ready = mysqli_prepare($conn, $sql);
                                    mysqli_stmt_bind_param($ready, 'i', $room_id);
                                    mysqli_stmt_execute($ready);
                                    $result = mysqli_stmt_get_result($ready);
                                    $row = $result->fetch_assoc();
                                    $Roomtype = $row['Type'] . " of ";
                                    $Roomcapacity = $row['Room_Capacity'];
                                    $Roomprice = $row['Price'];
                                } else {
                                    $Roomtype = "No room picked yet";
                                    $Roomcapacity = "";
                                    $Roomprice = 0.00;
                                    $room_id = "";
                                }
                                ?>
                                <label for="room" class="mb-2 block text-sm font-medium text-[#07074D]"> Room Picked </label>
                                <input class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm placeholder-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" type="text" name="fake" id="fake" placeholder="<?php echo $Roomtype . $Roomcapacity ?>" readonly required>
                                <input type="hidden" name="room" id="room" value="<?php echo $room_id ?>">
                            </div>
                        </div>
                        <div>
                            <div class="flex flex-col">
                                <label for="checkindate" class="text-stone-600 text-sm font-medium">Check In Date</label>
                                <input type="date" name="checkindate" id="checkindate" class="mt-2 block w-full rounded-md border border-gray-200 px-2 py-2 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                            </div>
                            <div class="flex flex-col">
                                <label for="checkoutdate" class="text-stone-600 text-sm font-medium">Check Out Date</label>
                                <input type="date" name="checkoutdate" id="checkoutdate" class="mt-2 block w-full rounded-md border border-gray-200 px-2 py-2 shadow-sm outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                            </div>

                        </div>

                    </div>
                </div>
                <div class="space-y-4">
                    <h3 class="text-xl font-semibold text-[#07074D]">Payment</h3>
                </div>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="rounded-lg bg-transparent p-4 ps-4">
                            <div>
                                <label for="amount" class="mb-2 block text-sm font-medium text-[#07074D]"> Amount to pay* </label>
                                <input class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" type="text" name="amount" id="amount" placeholder="₱ <?php echo $Roomprice ?>" value="<?php echo $Roomprice ?>" required readonly>
                            </div>
                        </div>
                        <div class="rounded-lg bg-transparent p-4 ps-4">
                            <div>
                                <label for="payment_date" class="mb-2 block text-sm font-medium text-[#07074D]"> Payment Date* </label>
                                <input class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" type="text" name="payment_date" id="payment_date" placeholder="<?php echo $currentTime ?>" value="<?php echo $currentTime ?>" required readonly>
                            </div>
                        </div>
                        <div class="rounded-lg bg-transparent p-4 ps-4">
                            <div>
                                <label for="card_number" class="mb-2 block text-sm font-medium text-[#07074D]"> Card Number* </label>
                                <input class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" type="text" name="card_number" id="card_number" placeholder="1234 xxxx xxxx xxxx" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-6 w-full space-y-6 sm:mt-8 lg:mt-0 lg:max-w-xs xl:max-w-md">
                <div class="flow-root">
                    <div class="-my-3 divide-y divide-gray-200 dark:divide-gray-800">
                        <dl class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-base font-bold text-[#07074D]">Total</dt>
                            <dd class="text-base font-bold text-green-500">₱ <?php echo $Roomprice ?></dd>
                        </dl>
                    </div>
                </div>
                <div class="space-y-3">
                    <button type="submit" class="focus:ring transform transition hover:scale-105 duration-300 ease-in-out font-bold py-2 px-4 bg-gradient-to-r from-purple-800 to-green-500 hover:from-pink-500 hover:to-green-500 flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4  focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Proceed to Payment</button>
                </div>
            </div>
        </div>
    </form>
</section>