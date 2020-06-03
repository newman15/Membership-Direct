<?php
    session_start();    
    
    if (!isset($_SESSION['sessionEmail']))
    {
        header("location: login-page.php");
        die();
    }
        
    // Import Nav Bar
    require "includes/portal-nav.php";

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
        $stmt = $dbh->prepare("SELECT member_id FROM member WHERE email=?");
        $stmt->execute([$userEmail]);
        $memberId = $stmt->fetchColumn();

        $_SESSION = array();
        
        $stmt2 = $dbh->prepare("DELETE FROM member WHERE member_id=?");
        $stmt2->execute([$memberId]);     

        $stmt2 = $dbh->prepare("DELETE FROM claims WHERE member_id=?");
        $stmt2->execute([$memberId]);    

        $stmt2 = $dbh->prepare("DELETE FROM vehicle WHERE member_id=?");
        $stmt2->execute([$memberId]);      
        
        session_destroy();

    } catch(PDOException $e){       // Need to set_exception_handler() to protect DB
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
        //die();
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Policy Canceled</title>
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
            We're sorry to see you go. You're always welcome back if you wish to <a href="sign-up-page.php">sign up</a>.<br/><br/>
            <a href="index.html">Return to Home Page</a>
        </div>
    </body>
</html>