<?php

$email = $password = $f_name = $l_name = $company = $phone = "";
$passError = null;

if (isset($_POST['submit'])) {
    $f_name = filter_input(INPUT_POST, 'floating_first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $l_name = filter_input(INPUT_POST, 'floating_last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'floating_email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'floating_phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $company = filter_input(INPUT_POST, 'floating_company', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $repeat_pass = filter_input(INPUT_POST, 'floating_repeat_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $_password = filter_input(INPUT_POST, 'floating_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $sql = "INSERT INTO customers (f_name, l_name, email, pass, phone, company) VALUES ('$f_name', '$l_name', '$email', '$_password', '$phone', '$company');";

    if ($password === $repeat_pass) {
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
        } else {
            echo "ERROR: Did not insert into database" . mysqli_error($conn);
        }
    } else {
        $passError = "Password does not match";
    }
}

?>

<style>
    input {
        color: white;
    }
</style>

<div class="container">
    <!-- ### Form to reserve a room ### -->
    <div class="columns-1">
        <h1 class="text-4xl">Reserve a Room</h1>
        <br>
        <br>
        <br>
        <div class="flex items-center justify-center p-12">
            <div class="mx-auto w-full max-w-[550px]">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                    <div class="-mx-3 flex flex-wrap">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="fName" class="mb-3 block text-base font-medium text-[#07074D]">
                                    First Name
                                </label>
                                <input type="text" name="fName" id="fName" placeholder="First Name" class="shadow appearance-none border rounded leading-tight focus:ring transform transition hover:scale-105 duration-300 ease-in-out w-full rounded-md border border-[#e0e0e0] bg-transparent py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="lName" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Last Name
                                </label>
                                <input type="text" name="lName" id="lName" placeholder="Last Name" class="shadow appearance-none border rounded leading-tight focus:ring transform transition hover:scale-105 duration-300 ease-in-out w-full rounded-md border border-[#e0e0e0] bg-transparent py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                    </div>
                    <!-- <div class="mb-5">
                        <label for="guest" class="mb-3 block text-base font-medium text-[#07074D]">
                            How many guest are you bringing?
                        </label>
                        <input type="number" name="guest" id="guest" placeholder="5" min="0" class="w-full appearance-none rounded-md border border-[#e0e0e0] bg-transparent py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div> -->
                    <div class="-mx-3 flex flex-wrap">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="address" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Address
                                </label>
                                <input placeholder="Address" type="text" name="address" id="address" class="shadow appearance-none border rounded leading-tight focus:ring transform transition hover:scale-105 duration-300 ease-in-out w-full rounded-md border border-[#e0e0e0] bg-transparent py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="phone" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Phone Number
                                </label>
                                <input placeholder="Phone Number" type="tel" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" id="phone" class="shadow appearance-none border rounded leading-tight focus:ring transform transition hover:scale-105 duration-300 ease-in-out w-full rounded-md border border-[#e0e0e0] bg-transparent py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                    </div>

                    <br><br>
                    <h5 class="text-2xl">Reserve a Room</h5>
                    <br>
                    <div class="-mx-3 flex flex-wrap">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="CheckInDate" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Check In Date
                                </label>
                                <input type="date" name="CheckInDate" id="CheckInDate" class="shadow appearance-none border rounded leading-tight focus:ring transform transition hover:scale-105 duration-300 ease-in-out w-full rounded-md border border-[#e0e0e0] bg-transparent py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="CheckOutDate" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Check Out Date
                                </label>
                                <input type="date" name="CheckOutDate" id="CheckOutDate" class="shadow appearance-none border rounded leading-tight focus:ring transform transition hover:scale-105 duration-300 ease-in-out w-full rounded-md border border-[#e0e0e0] bg-transparent py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="Room" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Room
                                </label>
                                <input disabled type="text" name="room" id="room" class="shadow appearance-none border rounded leading-tight focus:ring transform transition hover:scale-105 duration-300 ease-in-out w-full rounded-md border border-[#e0e0e0] bg-transparent py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label style="color:transparent;" for="" class=" mb-3 block text-base font-medium">
                                    Room
                                </label>
                                <a class="bg-gradient-to-r from-purple-800 to-green-500 hover:from-pink-500 hover:to-green-500 text-white font-bold py-2 px-4 rounded focus:ring transform transition hover:scale-105 duration-300 ease-in-out" href="../VIew/pickRoom.php">
                                    Pick a Room
                                </a>
                            </div>
                        </div>
                    </div>

                    <br><br>
                    <h5 class="text-2xl">Payment Details</h5>
                    <br>
                    <div class="-mx-3 flex flex-wrap">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="amount" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Amount
                                </label>
                                <input disabled type="text" name="amount" id="amount" class="shadow appearance-none border rounded leading-tight focus:ring transform transition hover:scale-105 duration-300 ease-in-out w-full rounded-md border border-[#e0e0e0] bg-transparent py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="date" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Payment Date
                                </label>
                                <input type="date" name="date" id="date" class="shadow appearance-none border rounded leading-tight focus:ring transform transition hover:scale-105 duration-300 ease-in-out w-full rounded-md border border-[#e0e0e0] bg-transparent py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="CardNumber" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Card Number
                                </label>
                                <input type="text" name="cardNumber" id="cardNumber" class="shadow appearance-none border rounded leading-tight focus:ring transform transition hover:scale-105 duration-300 ease-in-out w-full rounded-md border border-[#e0e0e0] bg-transparent py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <div>
                            <button class="bg-gradient-to-r from-purple-800 to-green-500 hover:from-pink-500 hover:to-green-500 text-white font-bold py-2 px-4 rounded focus:ring transform transition hover:scale-105 duration-300 ease-in-out" type="button">
                                Sign Up
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("date").value = today;
    });
</script>