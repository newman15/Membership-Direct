<?php
    session_start();

    if (!isset($_SESSION['sessionEmail']))
    {
        header("location: login-page.php");
        die();
    }

    // Import Nav Bar
    require "includes/portal-nav.php";
    
    $userEmail = $_SESSION['sessionEmail'];

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
        
        // SQL Member
        $stmt = $dbh->prepare("SELECT * FROM member WHERE email=?");
        $stmt->execute([$userEmail]);
        $user = $stmt->fetch();

        // SQL Vehicle
        $getVehicles = $dbh->prepare("SELECT make, model, year, color, vin FROM vehicle WHERE member_id=?");
        $getVehicles->execute([$memberId]);
        $vehicles = $getVehicles->fetchAll();

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

            $provider = $user['insurance_provider'];
            $business_id = $user['business_id'];
            $number_of_claims = $user['number_of_claims'];
            $policy_number = $user['policy_number'];
        }

    } catch(PDOException $e){       // Need to set_exception_handler() to protect DB
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
        //die();
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
        line-height: 2;
        margin:25px;
    }
    .list-box{
        display: flex;
        flex-direction: row;
        line-height: 2;
        margin:25px;
        height: 200px;
        overflow: auto;
    }
    .left-col{
        font-weight: bold;
        width:15%;
    }
</style>
</head>
<body>
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
                    <a class="nav-link" id="nav-link" data-toggle="tab" href="#insurance">Insurance</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                
                <!-- About Me tab -->
                <div id="about_me" class="container tab-pane active"><br/>
                    <h3>Contact </h3>	
                    <div class="flex-container">
                        <div class="left-col">
                            Full Name:<br/>
                            Email:<br/>
                            Phone Number:<br/>
                            Address:<br/>
                            State:<br/>
                            Zip Code:<br/>
                            <a href="edit-contact.php">Edit</a>
                        </div>
                        <div>
                            <?php echo $firstName . " " . $lastName ?><br/>
                            <?php echo $email ?><br/>
                            <?php echo $phone_number ?><br/>
                            <?php echo $address ?><br/>
                            <?php echo $state ?><br/>
                            <?php echo $zip_code ?><br/>
                        </div>
                    </div>
                    
                    <br/><br/>
                    <h3>Membership</h3>	
                    <div class="flex-container">
                        <div class="left-col">
                            Type:<br/>
                            Status:<br/>
                        </div>
                        
                        <div>
                            <?php echo $member_type ?><br/>
                            <?php echo $member_status ?><br/>
                        </div>
                    </div>
                </div> <!--end About Me tab-->

                <!-- Insurance tab -->
                <div id="insurance" class="container tab-pane fade"><br>
                    <h3>Insurance</h3>
                    <div class="flex-container">
                        <div class="left-col">
                            Provider:<br/>
                            Policy Number:<br/>
                            Number of Claims:<br/>
                            Business ID:<br/>
                        </div>
                        
                        <div>
                            <?php echo $provider ?><br/>
                            <?php echo $policy_number ?><br/>
                            <?php echo $number_of_claims ?><br/>
                            <?php echo $business_id ?><br/>
                        </div>
                    </div>
                    <br/><br/>
                    
                    <h3>Vehicle(s)</h3>
                    <a class="btn btn-primary" href="add-vehicle.php">Add Vehicle</a>
                    <div class="list-box">
                        <?php
                            echo "<div class='left-col'>";
                            for ($i = 0; $i < count($vehicles); $i++)
                                echo "Make:<br/>Model:<br/>Year:<br/>Color:<br/>VIN:<br/><br/><br/>";
                                //"Make:<br/>Model:<br/>Year:<br/>Color:<br/>VIN:<br/><a href=''>Edit</a><br/><br/>";

                            echo "</div><div>";
                            
                            for ($i = 0; $i < count($vehicles); $i++)
                            {
                                echo $vehicles[$i][0]."<br/>".$vehicles[$i][1]."<br/>".$vehicles[$i][2];
                                echo "<br/>".$vehicles[$i][3]."<br/>".$vehicles[$i][4]."<br/><br/><br/>";
                            }
                            echo "</div>";
                        ?>
                    </div>
               
            </div>
        </div>
        <br/><br/>
</body>
</html>