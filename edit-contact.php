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

        // Connection to DB
        require "includes/db-info.php";
        $dbh = new PDO("mysql:host=$serverName; dbname=$dbName", $userName, $password);
        
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
        }
    }   
?>
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
        <br/><br/><br/>
        <!-- About Me tab -->
        <div id="about_me" class="container tab-pane active"><br>
        <h3>Contact </h3>

        <form action='contact-submit.php' method='POST'>
            <div class="flex-container">
                <div class="left-col">First Name:</div>
                <div><input type="text" name="first-name" value = "<?php echo $firstName ?>"></div>
            </div>

            <div class="flex-container">
                <div class="left-col">Last Name:</div>
                <div><input type="text" name="last-name" value = "<?php echo $lastName ?>"></div>
            </div>
            
            <div class="flex-container">
                <div class="left-col">Email:</div><div><?php echo $email ?></div>
            </div>

            <div class="flex-container">
                <div class="left-col">Phone Number:</div>
                <div><input type="text" name="phone-number" value = "<?php echo $phone_number ?>"></div>
            </div>

            <div class="flex-container">
                <div class="left-col">Address:</div>
                <div><input type="text" name="address" value = "<?php echo $address ?>"></div>
            </div>

            <div class="flex-container">
                <div class="left-col">State:</div>
                <div><input type="text" name="state" value ="<?php echo $state ?>"></div>
            </div>

            <div class="flex-container">
                <div class="left-col">Zip Code:</div>
                <div><input type="text" name="zip-code" value = "<?php echo $zip_code ?>"></div>
            </div>

            </div>
            <center>
            <button type="submit" class="btn btn-primary">
                Submit Changes
            </button><br/>
            
            <a href="account.php">Cancel</a>
            </center>
        </form>
    </body>
</html>
