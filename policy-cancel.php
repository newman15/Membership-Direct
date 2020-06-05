<?php
    session_start();

    // Import Nav Bar
    require "portal-nav.php";

    if(!isset($_SESSION['sessionEmail']))
    {
        header("location: login-page.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Cancel Policy</title>
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
            .textbox{
                text-align: center;
            }
        </style>
    </head>

    <body>
        <h1>Cancel Policy?</h1>

        <div class="textbox">
            <form action='submit-policy-cancel.php' method='POST'>
                Are you sure you want to delete your account?<br/><br/>
                This cannot be undone, and you would need to sign up again to receive our services.<br/><br/>
                <button type="submit" class="btn btn-primary">Confirm</button><br/>
                <a href="account.php">Return to Account</a>
            </form>
        </div>
    </body>
</html>
