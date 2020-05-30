<?php
    session_start();

    if(!isset($_SESSION['sessionEmail']))
    {
        header("location: index.html");
        die();
    }
    
    // Import Nav Bar
    require "includes/portal-nav.php";
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
                width:100px;
                height:40px;
            }
        </style>
    </head>

    <body>
        <br />
        <br /><br />
        <center><h1>Add Vehicle</h1></center> 
        <br/><br/><br/>
        <!-- About Me tab -->
        <div id="about_me" class="container tab-pane active"><br>
        <h3>Vehicle </h3>

        <form action='vehicle-submit.php' method='POST'>
            <div class="flex-container">
                <div class="left-col">Make:</div>
                <div><input type="text" name="make"></div>
            </div>
            
            <div class="flex-container">
                <div class="left-col">Model:</div>
                <div><input type="text" name="model"></div>
            </div>
            
            <div class="flex-container">
                <div class="left-col">Year:</div>
                <div><input type="text" name="year"></div>
            </div>
            
            <div class="flex-container">
                <div class="left-col">Color:</div>
                <div><input type="text" name="color"></div>
            </div>
            
            <div class="flex-container">
                <div class="left-col">VIN:</div>
                <div><input type="text" name="vin"></div>
            </div>
            <center>
                <button type="submit" class="btn btn-primary">
                    Submit
                </button><br/>
                
                <a href="account.php">Cancel</a>
            </center>
        </form>
        </div>
    </body>
</html>
