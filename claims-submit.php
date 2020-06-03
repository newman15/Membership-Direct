<?php
    session_start();

    // If Session is active...
    if(isset($_SESSION['sessionEmail'])){
        
        // Import Nav Bar
        require "includes/portal-nav.php";

        // Declare Session Variables
        $userEmail =  $_SESSION['sessionEmail'];

        // User's vehicle selection
        $vehicleSelection = $_POST["vehicle-id"];

        // Array to store form elements
        $claimForm = array(
            $shopName = $_POST["auto-shop-name"],
            $shopAddress = $_POST["shop-address"],
            $shopCity = $_POST["shop-city"],
            $shopState = $_POST["state"],
            $shopZip = $_POST["shop-zip"],
            $deductibleAmount = $_POST["ded-amount"]
        );

        // Array to store Claim Details
        $completedClaim = array(
            // memberId, make, model, year, color, vin...
            0,0,"","","","",0,"","","","","","",0,0.00,"Received"
        );

        // DB Interaction
        try{
            // Connection to DB
            require "includes/db-info.php";
            $dbh = new PDO("mysql:host=$serverName; dbname=$dbName", $userName, $password);
            $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            echo "<br/><br/>";

            // Get Member Id based off email
            $getId = $dbh->prepare("SELECT member_id FROM member WHERE email=?");
            $getId->execute([$userEmail]);
            $memberId = $getId->fetchColumn();
            
            // Get Member Info
            $getName = $dbh->prepare("SELECT first_name, last_name FROM member WHERE member_id=?");
            $getName->execute([$memberId]);
            $userName = $getName->fetch();

            // Get Vehicle Info
            $stmt2 = $dbh->prepare("SELECT make, model, year, color, vin FROM vehicle WHERE vehicle_id=?");
            $stmt2->execute([$vehicleSelection]);
            $userVehicle = $stmt2->fetch();

            // Prepare Claim
            $submitClaim = $dbh->prepare("INSERT INTO claims (member_id, first_name, last_name, make, model, year,
                color, vin, shop_name, shop_address, shop_city, shop_state, shop_zip, deductible_amount, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            // Checks if DB returned any data at all
            // If so, then store claim info in completedClaim array
            if($memberId){
                $completedClaim[1] = $memberId;
                $completedClaim[2] = $userName[0];
                $completedClaim[3] = $userName[1];
                for($i = 4; $i < 9; $i++){
                    $completedClaim[$i] = $userVehicle[$i - 4];               
                }

                for($i = 9; $i < 15; $i++){
                    $completedClaim[$i] = $claimForm[$i - 9];               
                }

                for ($i = 1; $i < 16; $i++){
                    $submitClaim->bindParam($i, $completedClaim[$i]);
                }

                $submitClaim->execute();
            }

            else{
                echo "No Member ID Found";
            }

            $dbh = null;
            $stmt = null;
            $stmt2 = null;

        } catch(PDOException $e){
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
            //die();
        }

        echo <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <title>Portal - Payment</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <style>
            a.nav-link:hover, a.nav-link:active{
                font-size: 150%;
            }
            h1{
                text-align: center;
            }
        </style>
        </head>
        <body>
           <h1>Form Successfully Submitted</h1>
        </body>
        </html>
        HTML;
    }

    // Session Not Active
    else{
        header("Location: login-page.php");
    }
?>