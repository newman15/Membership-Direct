<?php
    session_start();

    // If Session is active...
    if(isset($_SESSION['sessionEmail'])){
        
        // Import Nav Bar
        require "includes/portal-nav.php";

        // Declare Session Variables
        $userEmail =  $_SESSION['sessionEmail'];

        // Declare variables to be used in New Claim Options
        $userVehicle = array("", "", 0);

        // DB Interaction
        try{
            // Connection to DB
            require "includes/db-info.php";
            $dbh = new PDO("mysql:host=$serverName; dbname=$dbName", $userName, $password);
            $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            echo "<br/><br/>";

            // Get Member Id based off email
            $stmt = $dbh->prepare("SELECT member_id FROM member WHERE email=?");
            $stmt->execute([$userEmail]);
            $memberId = $stmt->fetchColumn();
            
            // Get Vehicle Info
            $stmt2 = $dbh->prepare("SELECT make, model, year FROM vehicle WHERE member_id=?");
            $stmt2->execute([$memberId]);
            $userVehicles = $stmt2->fetchAll();

            // Checks if DB returned any data at all
            // If so, then store vehicle info in user array
            if(!$userVehicles){
                echo "Error: No Vehicles Registered";
            }

            $dbh = null;
            $stmt = null;
            $stmt2 = null;

        } catch(PDOException $e){       // Need to set_exception_handler() to protect DB
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
            <script src="functions.js"></script>
        <style>
            a.nav-link:hover, a.nav-link:active{
                font-size: 150%;
            }
            #claim-form{
                text-align: center;
            }
        </style>
        </head>
        <body>
            <!-- New Claim Form -->
            <br /><br />
            <div class="container" id="claim-form">
                <h2>File a new claim</h2><br/>
                <form method="POST" action="claims-submit.php">
                    <!-- Choose Vehicle -->
                    <div class="form-group">
                        <label for="vehicle-choice">Choose Vehicle (select one):</label>
                        <select class="form-control" id="vehicle-choice" name="vehicle-choice">
                            <!-- <option>$userVehicle[2] $userVehicle[0] $userVehicle[1]</option> -->
        HTML;    
                            for ($i = 0; $i < count($userVehicles); $i++){ ?>
                                <option value="<?php echo $userVehicles[$i][2]." ".$userVehicles[$i][0]." ".$userVehicles[$i][1]; ?>"><?php echo $userVehicles[$i][2]." ".$userVehicles[$i][0]." ".$userVehicles[$i][1]; ?></option>
                            <?php 
                            }
        echo <<<HTML
                        </select>
                    </div><br /><br />
                    <!-- Auto Shop Info -->
                    <div class="form-group" id="auto-shop-info">
                        <label for="auto-shop-name">Auto Body Information</label>
                        <input type="text" class="form-control" placeholder="Enter Auto Shop Name" id="auto-shop-name" name="auto-shop-name" required>
                        <input type="text" class="form-control" placeholder="Enter Shop Address" id="shop-address" name="shop-address" required>
                        <input type="text" class="form-control" placeholder="Enter Shop City" id="shop-city" name="shop-city" required>
                        <select class="form-control" id="state" name="state" required>
                            <script>populateStates();</script>
                        </select>
                        <input type="text" class="form-control" placeholder="Enter Shop Zip" id="shop-zip" name="shop-zip" required>
                        <input type="number" class="form-control" placeholder="Enter Deductible Amount" id="ded-amount" name="ded-amount" step="0.01" required>
                    </div><br /><br />
                    <!-- Upload Insurance Doc
                    <div class="form-group" id="upload-claim">
                        <label for="upload-claim-document">Upload proof of insurance claim</label>
                        <input type="file" class="form-control-file border" id="insurance-claim-doc" name="insurance-claim-doc">
                    </div><br /><br /> -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </body>
        </html>
        HTML;
    }

    // Session Not Active
    else{
        header("Location: login-page.php");
    }
?>