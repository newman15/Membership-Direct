<?php
    session_start();

    if(!isset($_SESSION['sessionEmail']))
    {
        header("location: login-page.html");
        die();
    }

    $userEmail = $_SESSION['sessionEmail'];

    $formElements = array(
        0,
        $firstName = $_POST["first-name"],
        $lastName= $_POST["last-name"],
        $phone_number = $_POST["phone-number"],
        $address = $_POST["address"],
        $state = $_POST["state"],
        $zipCode = $_POST["zip-code"]
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
    $stmt = $dbh->prepare("UPDATE member SET first_name = ?, last_name = ?, phone_number = ?, address = ?, 
        state = ?, zip_code = ? WHERE member_id= ?");


    for ($i = 1; $i <= 6; $i++)
        $stmt->bindParam($i, $formElements[$i]);

    $stmt->bindParam(7, $memberId);

    $stmt->execute();
    header("Location: account.php");
    exit;
?>