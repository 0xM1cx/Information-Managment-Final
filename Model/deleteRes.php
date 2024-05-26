<?php

require "./Model/database.php";
$resid = $_GET['resid'];
$sql = "DELETE FROM reservation WHERE Res_ID = ?";
$sql_prep = $conn->prepare($sql);
$sql_prep->bind_param("i", $resid);
$sql_prep->execute();
