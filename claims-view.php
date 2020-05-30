<?php
    session_start();

    // Import Nav Bar
    require "includes/portal-nav.php";

    if(isset($_SESSION['sessionEmail'])){

        // Declare Session Variables
        $userEmail =  $_SESSION['sessionEmail'];

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
            
            // SQL Email Check
            $stmt = $dbh->prepare("SELECT * FROM claims WHERE member_id=?");
            $stmt->execute([$memberId]);
            $user = $stmt->fetch();

            // Checks if DB returned any data at all
            // If so, store data to be shown on the webpage
            if($user){
                $make = $user['make'];
                $model = $user['model'];
                $year = $user['year'];
                $color = $user['color'];
                $vin = $user['vin'];
                $shopName = $user['shop_name'];
                $shopAddress = $user['shop_address'];
                $shopCity = $user['shop_city'];
                $shopState = $user['shop_state'];
                $shopZip = $user['shop_zip'];
                $dedAmount = $user['deductible_amount'];
                $status = $user['status'];

                if ($status == NULL){
                    $status = "No Status In DB (Set Status)";
                }

                // Show HTML
                echo <<<HTML
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <title>View Claims</title>
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
                    .flex-container{
                        display: flex;
                        flex-wrap: no-wrap;
                    }
                    #view-claims-list{
                        text-align: center;
                        justify-content: center;
                    }
                    h2{
                        text-align: center;
                    }
                </style>
                </head>
                <body>
                    <br /><br />
                    <h2>Your Claims</h2><br/><br/>
                    <div class="flex-container" id="view-claims-list">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Vehicle</strong></li>
                            <li class="list-group-item">$make</li>
                            <li class="list-group-item">$model</li>
                            <li class="list-group-item">$year</li>
                            <li class="list-group-item">$color</li>
                            <li class="list-group-item">$vin</li>
                        </ul>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Auto Shop</strong></li>
                            <li class="list-group-item">$shopName</li>
                            <li class="list-group-item">$shopAddress</li>
                            <li class="list-group-item">$shopCity</li>
                            <li class="list-group-item">$shopState</li>
                            <li class="list-group-item">$shopZip</li>
                            <li class="list-group-item">$dedAmount</li>
                            <li class="list-group-item">$status</li>
                        </ul>
                    </div>
                </body>
                </html>
                HTML;

            }
            else{
                echo "You have no existing claims at this time";
            }

            $dbh = null;
            $stmt = null;

        } catch(PDOException $e){       // Need to set_exception_handler() to protect DB
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
            //die();
        }   
        

    }

    else{
        header("Location: login-page.php");
    }