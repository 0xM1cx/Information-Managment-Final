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
        <!-- <form class="max-w-md mx-auto w-full" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
            
        </form> -->

        <div class="flex items-center justify-center p-12">
            <div class="mx-auto w-full max-w-[550px]">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                    <div class="-mx-3 flex flex-wrap">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="fName" class="mb-3 block text-base font-medium text-[#07074D]">
                                    First Name
                                </label>
                                <input type="text" name="fName" id="fName" placeholder="First Name" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="lName" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Last Name
                                </label>
                                <input type="text" name="lName" id="lName" placeholder="Last Name" class="w-full rounded-md border border-[#e0e0e0] bg-transparent py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="guest" class="mb-3 block text-base font-medium text-[#07074D]">
                            How many guest are you bringing?
                        </label>
                        <input type="number" name="guest" id="guest" placeholder="5" min="0" class="w-full appearance-none rounded-md border border-[#e0e0e0] bg-transparent py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>

                    <div class="-mx-3 flex flex-wrap">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="date" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Date
                                </label>
                                <input type="date" name="date" id="date" class="w-full rounded-md border border-[#e0e0e0] bg-transparent py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label for="phone" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Phone Number
                                </label>
                                <input type="tel" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" id="phone" class="w-full rounded-md border border-[#e0e0e0] bg-transparent py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="mb-3 block text-base font-medium text-[#07074D]">
                            Are you coming to the event?
                        </label>
                        <div class="flex items-center space-x-6">
                            <div class="flex items-center">
                                <input type="radio" name="radio1" id="radioButton1" class="h-5 w-5" />
                                <label for="radioButton1" class="pl-3 text-base font-medium text-[#07074D]">
                                    Yes
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="radio1" id="radioButton2" class="h-5 w-5" />
                                <label for="radioButton2" class="pl-3 text-base font-medium text-[#07074D]">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <button class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base font-semibold text-white outline-none">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>