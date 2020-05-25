<!DOCTYPE html>
<html lang="en">
<head>
  <title>Payment</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet"> <!-- Top Link -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> <!-- Google Icons -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <style>

    body{
        text-align: center;
    }
    
    #confirmationCard{
        width: 400px;
        text-align: center;
    }

  </style>

</head>

<body>

    <?php

    // Check if user has logged in using 'login' page btn
    // Protects against person entering via URL Manipulation
    if (!isset($_POST['sign-up-btn'])){
        header("Location: sign-up.html");
    }

    else{

        // Store Member Info From Form
        $formElements = array(
            0,
            $firstName = $_POST["first-name"],
            $lastName= $_POST["last-name"],
            $address = $_POST["address"],
            $city = $_POST["city"],
            $state = $_POST["state"],
            $zipCode = $_POST["zip"],
            $email = $_POST["email"],
            $password = $_POST["pswd"],
            $phoneNum = $_POST["contact-number"],
            $memberStatus = 0,
            $memberType = $_POST["member-selection"],
            $insuranceProvider = $_POST["insur-prov"],
            $policyNum = $_POST["pol-num"],
            $numClaims = 0,
            $businessId = $_POST["bus-id"]
        );

        // Store Vehicle Info From Form
        $vehicleElements = array(
            0,
            0,
            $vehicleMake = $_POST["vehicle-make"],
            $vehicleModel = $_POST["vehicle-model"],
            $vehicleYear = $_POST["vehicle-year"],
            $vehicleColor = $_POST["vehicle-color"],
            $vehicleVin = $_POST["vehicle-vin"],
        );

        // Obtains user's membership choice and price associated
        $memberChoice = $formElements[11]; //User's member choice (Gold or Silver)

        // Hashes User's Password
        $formElements[8] = password_hash($formElements[8], PASSWORD_DEFAULT);
        
        // Function that prepares values for price and picture to give to card object
        function adjustPrice($memberChoice){
            $priceArray = array(0,"");
            if($memberChoice == "Silver"){
                $priceArray[0] = 119.88;
                $priceArray[1] = "img/silver-coin.jpg";
            }
            else if($memberChoice == "Gold"){
                $priceArray[0] = 191.88;
                $priceArray[1] = "img/gold_coin.jpg";
            }

            return $priceArray;
        }
        
        $memberCost = adjustPrice($memberChoice); // Price of memberChoice

        // Create PayPal Connection
        // Uses Heredoc syntax
        $DisplayPayPal = <<<HTML
        <div id="paypal-button-container">
            <h1>To complete your $memberChoice membership account, select a payment method below</h1><br/><br/>
            <h2>Your Order Summary</h2><br/><br/>
            <div id="paypal-container" class="container">
            <center>
                <div class="card" id="confirmationCard">
                    <img class="card-img-1" src=$memberCost[1] style="width: 100%">
                    <div class="card-body">
                        <h5 style="color: #2b6f94;">$memberChoice Membership</h5><br />
                        <p class="card-text"><strong>$$memberCost[0]</strong></p>
                    </div>
                </div>
            </center>
            </div><br/><br/>
        </div>
        <script src="https://www.paypal.com/sdk/js?client-id=sb&currency=USD" data-sdk-integration-source="button-factory"></script>
        <script>
        var payPalPrice = "$memberCost[0]"; // Fills price on card based on user selection
        paypal.Buttons({
            style: {
                shape: 'pill',
                color: 'gold',
                layout: 'vertical',
                label: 'pay',
                
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: "119.88"
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Transaction completed by ' + details.payer.name.given_name + '!');
                });
            }
        }).render('#paypal-button-container');
        </script>
        <br/><br/><a href="sign-up.html">Return To Sign Up</a>
        HTML;

        // DB Interaction
        try{
            // Connection to DB
            require "includes/db-info.php";
            $dbh = new PDO("mysql:host=$serverName; dbname=$dbName", $userName, $password);
            $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

            echo "<br/><br/>";
            
            // Statement for Member Table
            $stmt = $dbh->prepare("INSERT INTO member (first_name, last_name, address, city, state, zip_code, email, password, phone_number, member_status, 
                member_type, insurance_provider, policy_number, number_of_claims, business_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            for ($i = 1; $i < 16; $i++){
                $stmt->bindParam($i, $formElements[$i]);
            }

            $stmt->execute();

            // Statement to retrieve Member ID
            // Grabs the member Id associated with account and assigns it to vehicle
            // This protects against possibility of deletions in DB
            $stmt2 = $dbh->prepare("SELECT member_id FROM member WHERE email = ?");
            $stmt2->execute([$email]);
            $memberId = $stmt2->fetchColumn();

            // Statement for Vehicle Table
            $stmt3 = $dbh->prepare("INSERT INTO vehicle (member_id, make, model, year, color, vin) 
                VALUES (?, ?, ?, ?, ?, ?)");

            $stmt3->bindParam(1, $memberId);
            for ($i = 2; $i < 7; $i++){
                $stmt3->bindParam($i, $vehicleElements[$i]);
            }

            $stmt3->execute();            

            echo "Your account has been created, see below for next steps!";
            echo $DisplayPayPal; //Display Paypal if DB successful
            
            $dbh = null;
            $stmt = null;
            $stmt2 = null;
            $stmt3 = null;

        } catch(PDOException $e){
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
            //die();
        }
    }
    ?>
    <br/><br/>

</body>
</html>