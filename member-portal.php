<?php
    session_start();

    // Import Nav Bar
    require "includes/portal-nav.php";

    // If Session is active...
    if(isset($_SESSION['sessionEmail'])){

        // Declare Session Variables
        $userName = $_SESSION["sessionName"];

        // HTML Code
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <title>Portal - Home</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
            .payment-reminder, .claims-reminder {
            box-sizing: border-box;
            width: 450px;
            height: 550px;
            padding: 10px;  
            border: 10px solid black;
            }
            .flex-cards{
                margin-right: 24%;
                margin-left: 24%;
            }
        </style>
        </head>
        <body>
        <br />
        <!--Welcome Message-->
        <div id="welcome-message">
            <center><h1>Welcome $userName</h1></center><br /><br /><br />
        </div>
        <!-- Member Policy Table -->
        <center><h3>Account Overview</h3></center>
            <div class="policy-table">
                <table class="table table-bordered table-hover">
                        <tbody>
                            <tr>
                                <th>Account Number:</th>
                                <th>000001</th>
                            </tr>
                            <tr>
                                <th>Membership Type:</th>
                                <th>Gold &#128192;, Silver &#128191;</th>
                            </tr>
                            <tr>
                                <th># Of Vehicles:</th>
                                <th>2</th>
                            </tr>
                            <tr>
                                <th>Account Status:</th>
                                <th>Active &#9989;, Inactive &#10060;</th>
                            </tr>
                        </tbody>
                </table>
            </div>
            
        <!-- Flex Cards -->
        <br /><br /><br /><br />
        <div class="flex-cards">
            <div class="d-flex p-2 flex-wrap justify-content-around">
                <!-- Payment Reminder Card -->
                <div class="payment-reminder">
                    <center><h3>Next Payment</h3></center><br />
                    <div class="payment-card" style="width:400px">
                        <img class="card-img-top" src="img/payReminder.jpg" alt="image_unavail" style="width:100%">
                        <div class="card-body">
                            <center>
                            <h4 class="card-title">John Doe,</h4>
                            <p class="card-text">Your next payment is due:</p>
                            <p class="card-date"><strong>Jan 1, 2020</strong></p>
                            <a href="payment.php" class="btn btn-success">Make Payment Now</a>
                            </center>
                        </div>   
                    </div>
                </div>
                
                <!-- Claims Section -->
                <br /><br /><br />
                    <div class="claims-reminder">
                        <center><h3>Claims</h3></center><br />
                        <div class="claims-card" style="width:400px">
                            <img class="card-img-top" src="img/claims_image.jpg" alt="image_unavail" style="width:100%">
                            <div class="card-body"><br />
                                <p><strong>*Note: It can take up to 48 hours for a claim to appear in your portal.</strong></p>
                                <br />
                                <div class="d-flex p-2 text-white justify-content-around">  
                                    <a href="claims-submit.php" type="button" class="btn btn-primary btn-md">Submit New</a>
                                    <a href="claims-view.php" type="button" class="btn btn-primary btn-md">View Existing</a>
                                </div>
                            </div>
                        </div>
                    </div>        
                <!---->
            </div>
        </div>   
        <br /><br />
        </body>
        </html> 
        HTML;

    }

    // Session Not Active
    else{
        //echo "Session Failed Check";
        header("Location: login-page.html");
    }
?>

    

