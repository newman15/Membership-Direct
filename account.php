<?php
    session_start();

    // Import Nav Bar
    require "includes/portal-nav.php";

    if(isset($_SESSION['sessionEmail'])){

        $userEmail = $_SESSION['sessionEmail'];

        // Variables: About Me
        $firstName = "";
        $lastName = "";
        $email = "";
        $phone_number = "";
        $address = "";
        $state = "";
        $zip_code = "";
        $member_type = "";
        $member_status = "";

        // Variables: Billing & Payment

        // Variables: Insurance
        $provider = "";
        $vehicle_make = "";
        $vehicle_model = "";
        $vehicle_year = "";
        $business_id = "";
        $number_of_claims = "";
        $policy_number = "";

        // DB Interaction
        try{
            // Connection to DB
            require "includes/db-info.php";
            $dbh = new PDO("mysql:host=$serverName; dbname=$dbName", $userName, $password);
            echo "<br/><br/>";
            
            // SQL Email Check
            $stmt = $dbh->prepare("SELECT * FROM member WHERE email=?");
            $stmt->execute([$userEmail]);
            $user = $stmt->fetch();

            if ($user){
                $firstName = $user['first_name'];
                $lastName = $user['last_name'];
                $email = $user['email'];
                $phone_number = $user['phone_number'];
                $address = $user['address'];
                $state = $user['state'];
                $zip_code = $user['zip_code'];
                $member_type = $user['member_type'];
                $member_status = $user['member_status'];

                if ($member_status == "0")
                    $member_status = "Inactive";
                else
                    $member_status = "Active";

                $provider = $user['car_insurance'];
                $vehicle_make = $user['vehicle_make'];
                $vehicle_model = $user['vehicle_model'];
                $vehicle_year = $user['vehicle_year'];
                $business_id = $user['business_id'];
                $number_of_claims = $user['number_of_claims'];
                $policy_number = $user['policy_number'];
            }

        } catch(PDOException $e){       // Need to set_exception_handler() to protect DB
            echo $stmt . "<br/>" . $e->getMessage();
            die();
        }

        echo <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <title>Portal - Account</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <style>
            .top-link{
                margin-left: 11%;
                font-family: 'Varela Round', sans-serif;
                font-weight: bold;
            }
            .nav-link{
                color: black;
            }
            .tab-body-text{
                font-size: 1.1em;
            }
            #more-info-tabs{
                font-size: 1.5em;
            }
            h1{
                text-align: center;
                font-size: 3em;
            }
            .flex-container {
                display: flex;
                flex-direction: row;
                
            }
            .left-col{
                font-weight: bold;
                width:150px;
                height:40px;
            }
        </style>
        </head>
        <body>
        <br />
            <br /><br />
            <center><h1>Account</h1></center> 
            <!--------------- More Info Tabs ------------------>
                <br/><br/><br/>
                <div class="container">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist" id="more-info-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" id="nav-link" data-toggle="tab" href="#about_me">About Me</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="nav-link" data-toggle="tab" href="#payment">Billing & Payment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="nav-link" data-toggle="tab" href="#insurance">Insurance</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- About Me tab -->
                        <div id="about_me" class="container tab-pane active"><br>
                            <h3>Contact </h3>	
                            <div class="flex-container">
                                <div class="left-col">Full Name:</div><div>$firstName $lastName</div>
                            </div>
                            
                            <div class="flex-container">
                                <div class="left-col">Phone Number:</div><div>$phone_number</div>
                            </div>
                            
                            <div class="flex-container">
                                <div class="left-col">Address:</div><div>$address</div>
                            </div>
                            
                            <div class="flex-container">
                                <div class="left-col">State:</div><div>$state</div>
                            </div>
                            
                            <div class="flex-container">
                                <div class="left-col">Zip Code:</div><div>$zip_code</div>
                            </div>
                            <a href="edit-contact.php">Edit</a>
                        </div> 
                        <!-- Billing & Payment tab -->
                        <div id="payment" class="container tab-pane fade"><br>
                            <h3>Payment Status</h3>
                            <div class="row">
                            <div class="column_left">
                                Current Standing:	<br/>
                                Payment Due: 	<br/>
                            </div>
                            
                            <div class="column_right">
                                Good				<br/>
                                $121.64 (December 31, 2021)	<br/>
                            </div>
                            </div>  
                            <!-- TODO: Pay Now button -->
                            <br/><br/>
                            <!-- TODO: Add Card button -->
                            <div class="row">
                            <div class="column_left">
                                John (primary):		<br/><br/>
                                <br/>
                                Jane:				<br/><br/>
                                <br/>
                            </div>
                            <div class="column_right">
                                VISA ending in 1234				<br/>
                                Exp: 3/2022				<br/>
                                <br/>
                                VISA ending in 5678		<br/>
                                Exp: 8/2021				<br/>
                                <br/>
                            </div>
                            </div>
                        </div>
                        <!-- Insurance tab -->
                        <div id="insurance" class="container tab-pane fade"><br>
                            <h3>Insurance</h3>
                            <div class="row">
                                <div class="column_left">
                                    Provider:		<br/>
                                    Policy Number:		<br/>
                                    Number of Claims:		<br/>
                                    Business ID:			<br/>
                                </div>
                                <div class="column_right">
                                    $provider				<br/>
                                    $policy_number				<br/>
                                    $number_of_claims				<br/>
                                    $business_id			<br/>
                                </div>
                            </div> 
                            <br/><br/>
                            <h3>Vehicle</h3>
                            <div class="row">
                            <div class="column_left">
                                Make:		<br/>
                                Model:		<br/>
                                Year:		<br/>
                            </div> 
                            <div class="column_right">
                                $vehicle_make				<br/>
                                $vehicle_model				<br/>
                                $vehicle_year				<br/>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
        </body>
        </html>
        HTML;
  
    }

    // Session Not Active
    else{
        //echo "Session Failed Check";
        header("Location: login-page.php");
    }
?>