<?php
    session_start();

    if (!isset($_SESSION['sessionEmail']))
    {
        header("location: login-page.php");
        die();
    }

    // Import Nav Bar
    require "portal-nav.php";
    
    $userEmail = $_SESSION['sessionEmail'];

    // DB Interaction
    try{
        // Connection to DB
        require "db-info.php";
        $dbh = new PDO("mysql:host=$serverName; dbname=$dbName", $userName, $password);
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        // Get Member Id based off email
        $getId = $dbh->prepare("SELECT member_id FROM member WHERE email=?");
        $getId->execute([$userEmail]);
        $memberId = $getId->fetchColumn();
        
        // SQL Member
        $stmt = $dbh->prepare("SELECT * FROM member WHERE email=?");
        $stmt->execute([$userEmail]);
        $user = $stmt->fetch();

        // SQL Vehicle
        $getVehicles = $dbh->prepare("SELECT make, model, year, color, vin, vehicle_id FROM vehicle WHERE member_id=?");
        $getVehicles->execute([$memberId]);
        $vehicles = $getVehicles->fetchAll();
        $_SESSION["vehicles"] = $vehicles;

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
        margin: 2%;
        height: 25%;
        overflow: auto;
    }

    .tab-content h4 {
        padding:1%;
    }

    #test th{
        border-style: none;
        width:15%;
    }

    #test td{
        border-style: none;
        vertical-align: middle;
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
                <div id="about_me" class="container tab-pane active">
                    <table class="table" id="test">
                    <h4>Contact</h4>
                        <tbody>
                            <tr><th>Full Name:</th><td><?php echo $firstName . " " . $lastName ?></td></tr>
                            <tr><th>Email:</th><td><?php echo $email ?></td></tr>
                            <tr><th>Phone Number:</th><td><?php echo $phone_number ?></td></tr>
                            <tr><th>Address:</th><td><?php echo $address ?></td></tr>
                            <tr><th>State:</th><td><?php echo $state ?></td></tr>
                            <tr><th>Zip Code:</th><td><?php echo $zip_code ?></td></tr>
                            <tr><th><a href="edit-contact.php">Edit</a></th></tr>
                        </tbody>
                    </table>

                    <table class="table" id="test">
                    <h4>Membership</h4>
                        <tbody>
                            <tr><th>Type:</th><td><?php echo $member_type ?></td></tr>
                            <tr><th>Status:</th><td><?php echo $member_status ?></td></tr>
                            <tr><th><a href="policy-cancel.php">Cancel Policy</a></th></tr>
                        </tbody>
                    </table>
                </div> <!--end About Me tab-->

                <!-- Insurance tab -->
                <div id="insurance" class="container tab-pane fade">
                    <table class="table" id="test">
                    <h4>Insurance</h4>
                        <tbody>
                            <tr><th>Provider:</th><td><?php echo $provider ?></td></tr>
                            <tr><th>Policy Number:</th><td><?php echo $policy_number ?></td></tr>
                            <tr><th>Number of Claims:</th><td><?php echo $number_of_claims ?></td></tr>
                            <tr><th>Business ID:</th><td><?php echo $business_id ?></td></tr>
                        </tbody>
                    </table>

                    <h4>Vehicle(s)</h4>
                    <a class="btn btn-primary" href="add-vehicle.php">Add Vehicle</a>
                    <div class="list-box">
                        <?php
                            echo "<table class='table' id='test'>";

                            for ($i = 0; $i < count($vehicles); $i++)
                            {
                                echo "<tbody>";
                                echo "<tr><th>Make:</th><td>".$vehicles[$i][0]."</td></tr>";
                                echo "<tr><th>Model:</th><td>".$vehicles[$i][1]."</td></tr>";
                                echo "<tr><th>Year:</th><td>".$vehicles[$i][2]."</td></tr>";
                                echo "<tr><th>Color:</th><td>".$vehicles[$i][3]."</td></tr>";
                                echo "<tr><th>VIN:</th><td>".$vehicles[$i][4]."</td></tr>";
                                echo "<tr><th><a href='edit-vehicle.php?vehicle=".$i."'>Edit</a></th></tr>";
                                echo "<tr><th></th></tr>";
                            }
                            echo "</table>";
                        ?>
                    </div>
                </div> <!--end Insurance tab-->
        </div>
</body>
</html>