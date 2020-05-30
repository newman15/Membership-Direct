<?php
    session_start();

    if(!isset($_SESSION['sessionEmail']))
    {
        header("location: index.html");
        die();
    }
    
    $userEmail = $_SESSION['sessionEmail'];

    // Connection to DB        
    require "includes/db-info.php";
    $dbh = new PDO("mysql:host=$serverName; dbname=$dbName", $userName, $password);
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    // Get Member Id based off email
    $getId = $dbh->prepare("SELECT member_id FROM member WHERE email=?");
    $getId->execute([$userEmail]);

    $elements = array(
        0,
        $member_id = $getId->fetchColumn(),
        $make = $_POST["make"],
        $model = $_POST["model"],
        $year = $_POST["year"],
        $color = $_POST["color"],
        $vin = $_POST["vin"]
    );

    $stmt = $dbh->prepare("INSERT INTO vehicle (member_id, make, model, year, color, vin) 
        VALUES (?, ?, ?, ?, ?, ?)");

    for ($i = 1; $i <= 6; $i++)
        $stmt->bindParam($i, $elements[$i]);
    
    $stmt->execute();
    header("Location: account.php#insurance");
    exit;
?>