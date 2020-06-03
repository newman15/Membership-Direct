<?php
    session_start();

    // Import Nav Bar
    require "includes/portal-nav.php";

    if(!isset($_SESSION['sessionEmail']))
    {
        header("location: login-page.php");
        die();
    }

    $userEmail = $_SESSION['sessionEmail'];

    // Variables: About Me
    $firstName = "";
    $lastName = "";
    $email = "";
    $phone_number = "";
    $address = "";
    $state = "";
    $zip_code = "";
    $vehicle_choice = "";

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
        $vehicle_choice = $_SESSION["vehicles"][$_GET["vehicle"]];
        $_SESSION["vehicle-choice"] = $vehicle_choice;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Edit Car</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="functions.js"></script>
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
        <center><h1>Edit Car</h1></center> 
        <br/><br/><br/>
        <!-- About Me tab -->
        <div id="edit-vehicle" class="container tab-pane active"><br>

        <form action='submit-edit-car.php' method='POST'>
            <div class="flex-container">
                <div class="left-col">Make:</div>
                <div><input type="text" name="make" value = "<?php echo $vehicle_choice[0] ?>" required></div>
            </div>

            <div class="flex-container">
                <div class="left-col">Model:</div>
                <div><input type="text" name="model" value = "<?php echo $vehicle_choice[1] ?>" required></div>
            </div>

            <div class="flex-container">
                <div class="left-col">Year:</div>
                <div><input type="text" name="year" value = "<?php echo $vehicle_choice[2] ?>" min="1900" max="2021" placeholder="1999" required></div>
            </div>

            <div class="flex-container">
                <div class="left-col">Color:</div>
                <div><input type="text" name="color" value = "<?php echo $vehicle_choice[3] ?>" required></div>
            </div>

            <div class="flex-container">
                <div class="left-col">VIN:</div>
                <div><input type="text" name="vin" value = "<?php echo $vehicle_choice[4] ?>" minlength="17" maxlength="17" required></div>
            </div>
            
            <center>
            <button type="submit" class="btn btn-primary">
                Submit Changes
            </button><br/>
            
            <a href="account.php">Cancel</a>
            </center>
        </form>
        </div>
    </body>
</html>
