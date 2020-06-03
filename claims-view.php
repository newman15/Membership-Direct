<?php
    session_start();

    // Import Nav Bar
    require "includes/portal-nav.php";

    if(isset($_SESSION['sessionEmail'])){

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
            $getId = $dbh->prepare("SELECT member_id FROM member WHERE email=?");
            $getId->execute([$userEmail]);
            $memberId = $getId->fetchColumn();
            
            // SQL Email Check
            $stmt = $dbh->prepare("SELECT * FROM claims WHERE member_id=?");
            $stmt->execute([$memberId]);
            $user = $stmt->fetchAll();

            // Checks if DB returned any data at all
            // If so, store data to be shown on the webpage
            if($user){

                // Show HTML
                echo <<<HTML
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <title>View Claims</title>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
                <style>
                    a.nav-link:hover, a.nav-link:active{
                        font-size: 150%;
                    }
                    .flex-container{
                        display: flex;
                        flex-wrap: no-wrap;
                    }
                    #view-claims-list{
                        text-align: center;
                        justify-content: center;
                    }
                    h1, h2{
                        text-align: center;
                    }
                    .list-box{
                        display: block;
                        margin-top: 25px;
                        margin-left: auto;
                        margin-right: auto;
                        height: 65%;
                        width: 85%;
                        background-color: #ebedf7;
                        line-height: 2;
                        overflow: auto;
                    }
                </style>
                </head>
                <body>
                <div class="list-box">
                HTML;
                    for($i = 0; $i < count($user); $i++){ ?>
                            <div id="<?php echo $user[$i]['date_received'] ?>"><br/>
                                <h1>Vehicle: <?php echo $user[$i]['year']." ".$user[$i]['make']." ".$user[$i]['model'] ?></h1><br/>
                                <div class="flex-container" id="view-claims-list">
                                    <ul class="list-group">
                                        <li class="list-group-item"><strong>Vehicle</strong></li>
                                        <li class="list-group-item"><?php echo $user[$i]['make'] ?></strong></li>
                                        <li class="list-group-item"><?php echo $user[$i]['model'] ?></strong></li>
                                        <li class="list-group-item"><?php echo $user[$i]['year'] ?></strong></li>
                                        <li class="list-group-item"><?php echo $user[$i]['color'] ?></strong></li>
                                        <li class="list-group-item"><?php echo $user[$i]['vin'] ?></strong></li>
                                    </ul><br/>
                                    <ul class="list-group">
                                        <li class="list-group-item"><strong>Auto Shop</strong></li>
                                        <li class="list-group-item"><?php echo $user[$i]['shop_name'] ?></strong></li>
                                        <li class="list-group-item"><?php echo $user[$i]['shop_address'] ?></strong></li>
                                        <li class="list-group-item"><?php echo $user[$i]['shop_city'] ?></strong></li>
                                        <li class="list-group-item"><?php echo $user[$i]['shop_state'] ?></strong></li>
                                        <li class="list-group-item"><?php echo $user[$i]['shop_zip'] ?></strong></li>
                                        <li class="list-group-item"><?php echo $user[$i]['deductible_amount'] ?></strong></li>
                                        <li class="list-group-item"><?php echo $user[$i]['status'] ?></strong></li>
                                    </ul>
                                </div>
                            </div>
                    <?php
                    }
                echo <<<HTML
                </div>
                </body>
                </html>
                HTML;

            }
            else{
                echo <<<HTML
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <title>View Claims</title>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
                <style>
                    a.nav-link:hover, a.nav-link:active{
                        font-size: 150%;
                    }
                    h2{
                        text-align: center;
                    }
                </style>
                <h2>You have no existing claims at this time</h2>
                HTML;
            }

            $dbh = null;
            $stmt = null;

        } catch(PDOException $e){       // Need to set_exception_handler() to protect DB
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
            //die();
        }   
        

    }

    else{
        header("Location: login-page.php");
    }