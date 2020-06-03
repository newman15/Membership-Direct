<?php
    session_start();

    if(!isset($_SESSION['sessionEmail']))
    {
        header("location: login-page.php");
        die();
    }

    $userEmail = $_SESSION['sessionEmail'];

    $elements = array(
        0,
        $make = $_POST["make"],
        $model= $_POST["model"],
        $year = $_POST["year"],
        $color = $_POST["color"],
        $vin = $_POST["vin"],
        $vehicle_id = $_SESSION["vehicle-choice"][5]
    );

    // Connection to DB        
    require "includes/db-info.php";
    $dbh = new PDO("mysql:host=$serverName; dbname=$dbName", $userName, $password);
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    // Get Member Id based off email
    $getId = $dbh->prepare("SELECT member_id FROM member WHERE email=?");
    $getId->execute([$userEmail]);
    $memberId = $getId->fetchColumn();

    // Replace first name based on member id
    $stmt = $dbh->prepare("UPDATE vehicle SET make = ?, model = ?, year = ?, color = ?, 
        vin = ? WHERE vehicle_id= ?");

    for ($i = 1; $i <= 6; $i++)
        $stmt->bindParam($i, $elements[$i]);

    $stmt->execute();
    header("Location: account.php");
    exit;
?>