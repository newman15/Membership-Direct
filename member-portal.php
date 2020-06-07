<?php
    session_start();

    // If Session is active...
    if(isset($_SESSION['sessionEmail'])){
        // Import Nav Bar
        require "portal-nav.php";

        // Declare Session Variables
        $userEmail =  $_SESSION['sessionEmail'];

        // Declare variables to be used in member portal tables
        $firstName = "";
        $lastName = "";
        $nextPayDate = "Jan 1, 2021";
        $accountNum = 0;
        $memberType = "";
        $accountStatus = false;

        // DB Interaction
        try{
            // Connection to DB
            require "db-info.php";
            $dbh = new PDO("mysql:host=$serverName; dbname=$dbName", $userName, $password);
            $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            echo "<br/><br/>";
            
            // Email Check
            $stmt = $dbh->prepare("SELECT * FROM member WHERE email=?");
            $stmt->execute([$userEmail]);
            $user = $stmt->fetch();

            // Checks if DB returned any data at all
            // If so, then compare passwords
            if($user){

                $firstName = $user['first_name'];
                $lastName = $user['last_name'];
                $accountNum = $user['member_id'];
                $memberType = $user['member_type'];
                $accountStatus = $user['member_status'];
                $memberSince = $user['member_since'];
                $typeStatus = array("", "");
                $actStatus = array("", "");

                // Number of Vehicles
                $getVehicleNum = $dbh->prepare("SELECT COUNT(*) FROM vehicle WHERE member_id=?");
                $getVehicleNum->execute([$accountNum]);
                $numVehicles = $getVehicleNum->fetchColumn();
                // $numVehicles = count($storeNum);
                $getVehicleNum = null;

                // Stores member type/status
                if ($memberType == "Silver"){
                    $typeStatus[0] = "Silver";
                    $typeStatus[1] = "&#128191;";
                }
                else if ($memberType == "Gold"){
                    $typeStatus[0] = "Gold";
                    $typeStatus[1] = "&#128192;";
                }

                // Stores account type/status
                if ($accountStatus == 0){
                    $actStatus[0] = "Inactive";
                    $actStatus[1] = "&#10060;";
                }
                else if ($accountStatus == 1){
                    $actStatus[0] = "Active";
                    $actStatus[1] = "&#9989;";
                }

            }
            else{
                echo "INVALID!";
            }

            $dbh = null;
            $stmt = null;

        } catch(PDOException $e){       // Need to set_exception_handler() to protect DB
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
            //die();
        }

        // HTML Code
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <title>Portal - Home</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <style>
            .policy-table{
                text-align: center;
                margin-right: 25%;
                margin-left: 25%;
            }
            a.nav-link:hover, a.nav-link:active{
                font-size: 150%;
            }
            img{
                max-width: 100%;
                height: auto;
            }
            #welcome-message, h3{
                text-align: center;
            }
        </style>
        </head>
        <body>
        <br />
        <!--Welcome Message-->
        <div id="welcome-message">
            <h1>Welcome $firstName $lastName</h1><br /><br /><br />
        </div>
        <!-- Member Policy Table -->
        <h3>Account Overview</h3>
        <div class="policy-table">
            <table class="table table-bordered table-hover">
                <tbody>
                    <tr>
                        <th>Account Number:</th>
                        <th>000$accountNum</th>
                    </tr>
                    <tr>
                        <th>Membership Type:</th>
                        <th>$typeStatus[0] $typeStatus[1]</th>
                    </tr>
                    <tr>
                        <th># Of Vehicles:</th>
                        <th>$numVehicles</th>
                    </tr>
                    <tr>
                        <th>Account Status:</th>
                        <th>$actStatus[0] $actStatus[1]</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Flex Cards -->
        <br /><br /><br /><br />
        <div class="container">
            <div class="card-deck">
                <!-- Payment Reminder Card -->
                <div class="card">
                    <div class="card-body text-center">
                        <h3>Next Payment</h3><br />
                        <img class="card-img-top" src="img/payReminder.jpg" alt="image_unavail">
                        <div class="card-body">
                            <h4 class="card-title">$firstName,</h4>
                            <p class="card-text">Your next payment is due:</p>
                            <p class="card-date"><strong>Jan 1, 2020</strong></p>
                            <a href="payment.php" class="btn btn-success">Make Payment Now</a>
                        </div>
                    </div>   
                </div>
                <!-- Claims Section -->
                <div class="card">
                    <div class="card-body text-center">
                        <h3>Claims</h3><br />
                        <img class="card-img-top" src="img/claims_image.jpg" alt="image_unavail">
                        <div class="card-body"><br />
                            <p><strong>*Note: It can take up to 48 hours for a claim to appear in your portal.</strong></p>
                            <br />
                            <div class="d-flex p-2 text-white justify-content-around">  
                                <a href="claims-create.php" type="button" class="btn btn-primary btn-md">Submit New</a>
                                <a href="claims-view.php" type="button" class="btn btn-primary btn-md">View Existing</a>
                            </div>
                        </div>
                    </div>
                </div>      
                <!---->
            </div>
        </div>   
        <br /><br />
        <!-- Bootstrap Dox Requires Code Placement Here -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        </body>
        </html> 
        HTML;

    }

    // Session Not Active
    else{
        header("Location: login-page.php");
    }
?>

    

