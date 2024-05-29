<?php

require "../Model/database.php";

$resid = filter_input(INPUT_GET, 'resid', FILTER_SANITIZE_NUMBER_INT);
$sql = "DELETE FROM reservation WHERE Res_ID = ?";
$sql_prep = $conn->prepare($sql);
$sql_prep->bind_param("i", $resid);
$sql_prep->execute();
header("Location: ../VIew/reservationList.php");
